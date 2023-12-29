<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\PromocodeModel;
use App\Models\UserModel;
use App\Models\SettingModel;
use App\Models\PaymentModel;
use App\Models\NotificationModel;
require_once './vendor/autoload.php';

use PaypalPayoutsSDK\Core\PayPalHttpClient;
use PaypalPayoutsSDK\Core\SandboxEnvironment;
use PaypalPayoutsSDK\Payouts\PayoutsPostRequest;

/**
 * API REFERENCE
 * https://documenter.getpostman.com/view/14423652/UVXqFD1Q#intro
 */

/**
 * UserApi
 */
class PaymentApi extends BaseController {
    
    /**
     * __construct
     *
     * @return void
     */
    function __construct()
    {
       $this->api_access();
    }
        
    /**
     * get_promocodes
     *
     * @return void
     */
    public function get_promocodes(){
        $PromocodeModel = new PromocodeModel();
        $promos = $PromocodeModel->get_promocode_for_users($this->user_id);
        
        if(!empty($promos)){
            foreach ($promos as $key =>  $promocode) {
                $promos[$key]['BANNER_IMAGE'] =  base_url() . PROMOCODEBANNERFOLDERPATH . '/' . $promocode['PROMO_ID'] . '/' . $promocode['BANNER_IMAGE'];
            }
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FETCHED PROMOCODE");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=>$promos, 'status' => 200));

        }else{
            $error  =  true;
            $message = array('success'=>"NO PROMOCODE FATECHED");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 404));
        }
    }
    
    /**
     * get_payment_settings
     *
     * @return void
     */
    public function get_payment_settings(){
        $SettingModel = new SettingModel();
        $UserModel = new UserModel();
        $point_setting=$SettingModel->get_setting(POINT_PRICE);
        $payment_setting=$SettingModel->get_setting(PAYPAL_SETTING);
        $point_setting_array = array(
            'TOTAL_BALANCE' => $UserModel->get_user_balance_point($this->user_id),
            $point_setting['SETTING_KEY'] => json_decode($point_setting['SETTING_VALUE'],true),
            $payment_setting['SETTING_KEY'] => json_decode($payment_setting['SETTING_VALUE'],true)
        );
       
        if(!empty($point_setting_array)){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FETCHED SETTINGS");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=>$point_setting_array, 'status' => 200));

        }
        $error  =  true;
        $message = array('success'=>"SOMETHING WENT WRONG");
        echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 500));
        die;
    }
       
    /**
     * confirm_payment
     *
     * @return void
     */
    public function confirm_payment(){
        $PaymentModel = new PaymentModel();
        $UserModel = new UserModel();
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $promos = false;
        if(isset($promocode_id)){
            $promos = true;
        }
        if ($this->validate($PaymentModel->get_api_rules($promos), $PaymentModel->get_api_message() )) {
             $add_transaction = array(
                'USER_ID' => $this->user_id,  
                'TRANSECTION_ID'=> $transection_id,    
                'AMOUNT_PAID' => $amount_paid,
                'POINTS' => $points
            );
            if(isset($promocode_id) && !empty($promocode_id)){
                $add_transaction['PROMOCODE_ID'] = $promocode_id;
            }
           $transaction = $PaymentModel->add_transaction($add_transaction);
           if($transaction){
                if($UserModel->is_wallet_created($this->user_id)){
                    $wallet_update = $PaymentModel->update_wallet($this->user_id, $points, false);
                    $NotificationModel = new NotificationModel();
                    $message = 'Your Wallet has been Credited with '.$points.' Points';
                    $NotificationModel->create_notification($this->user_id, 'POINTS ADDED', $message, 'SYSTEM' );
                    $NotificationModel->create_notification($this->user_id, 'POINTS ADDED', $message, 'PUSH', $this->get_device_tokon() );
                    if($wallet_update){
                        $error  =  false;
                        $message = array('success'=>"WALLET UPDATED SUCCESSFULLY");
                        echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
                    }
                }else{
                    $wallet_created = $PaymentModel->create_wallet($this->user_id, $points);
                    if($wallet_created){
                        $error  =  false;
                        $message = array('success'=>"WALLET UPDATED SUCCESSFULLY");
                        echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
                    }
                    
                }
           }
			$error = true;
            $message = array('error'=>"SOMETHING WENTWRONG!");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * redeem_points
     *
     * @return void
     */
    public function redeem_points(){
        
        $PaymentModel = new PaymentModel();
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
       
        if ($this->validate($PaymentModel->get_api_rules_payout(), $PaymentModel->get_api_message_payout() )) {
             $add_transaction = array(
                'USER_ID' => $this->user_id,  
                'TRANSECTION_ID'=> $transection_id,    
                'AMOUNT_REDEEM' => $amount_paid,
                'POINTS' => $points
            );
            if (!$PaymentModel->check_user_wallet($this->user_id, $points)) {
                $error = true;
                $message = array('error'=>"Please Check Your Point Balance!");
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error'=> $error , 'status'=> 504));
           }
           
           $transaction = $PaymentModel->add_payout_transaction($add_transaction);
           if($transaction){
                $payout_status = $this->payout($transaction, $amount_paid);
                if ($payout_status == true) {
                    $wallet_update = $PaymentModel->update_wallet($this->user_id, $points, true);
                    $NotificationModel = new NotificationModel();
                    $message = 'Your Wallet has been Debited with ' . $points . ' Points';
                    $NotificationModel->create_notification($this->user_id, 'POINTS DEBITED', $message, 'SYSTEM');
                    $NotificationModel->create_notification($this->user_id, 'POINTS DEBITED', $message, 'PUSH', $this->get_device_tokon());
                    if ($wallet_update) {
                        $error  =  false;
                        $message = array('success' => "WALLET UPDATED SUCCESSFULLY");
                        echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'status' => 200));
                    }
                } else {
                    $error = true;
                    $message = array('error' => $payout_status);
                    echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 500));
                }
                
           }
			$error = true;
            $message = array('error'=>"SOMETHING WENTWRONG!");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }

    /**
     * payout
     *
     * @param  mixed $payout_id
     * @param  mixed $amount_paid
     * @return void
     */
    public function payout($payout_id, $amount_paid)
    {
        
        $SettingModel = new SettingModel();
        $payment_setting = $SettingModel->get_setting(PAYPAL_SETTING);
        $paypal = json_decode($payment_setting['SETTING_VALUE'], true);
        $year = date("Y");
        $month =  date("m");
        $day = date("d");
        $payidcreate     =   'Payouts_' . $year . '_' . $month . '_' . $day . '_' . $payout_id;
        $clientId = $paypal['PAYPAL_CLIENT_KEY'];
        $clientSecret = $paypal['PAYPAL_SECRET_KEY'];

        $ch = curl_init();
        $base_url = 'https://api-m.paypal.com';
        if (PAYPALMODE == 'SANDBOX') {
            $base_url = 'https://api-m.sandbox.paypal.com';
        }
        if (PAYPALMODE == 'PRODUCTION') {
            $base_url = 'https://api-m.paypal.com';
        }
        $url = $base_url . '/v1/oauth2/token';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $clientSecret);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($result, true);
        $sender_batch_header = new \stdClass();
        $sender_batch_header->sender_batch_id = $payidcreate;
        $sender_batch_header->email_subject = 'You have a payout!';
        $sender_batch_header->email_message = 'You have received a payout! Thanks for using our service!';
        $amount = new \stdClass();
        $amount->value = $amount_paid;
        $amount->currency = 'USD';
        $UserModel = new UserModel();
        $receiver_id = $UserModel->get_user_by_id($this->user_id);
        $receiver_id = $receiver_id['PAYPAL_EMAIL_ID'];
        $items = array();
        $tempArr = array();
        $tempArr['recipient_type'] = 'EMAIL';
        $tempArr['amount'] = $amount;
        $tempArr['note'] = 'Thanks for your patronage!';
        $tempArr['sender_item_id'] = '2014031401';
        $tempArr['receiver'] = $receiver_id;
        $tempArr['notification_language'] = 'en-EN';

        $items[] = $tempArr;

        $request = new \stdClass();
        $request->sender_batch_header = $sender_batch_header;
        $request->items = $items;
        $request = json_encode($request);

        $ch = curl_init();
        $url = $base_url . '/v1/payments/payouts';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $result['access_token'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }


        curl_close($ch);

        $new_result =   json_decode($result);

        if (isset($new_result->batch_header)) {
            $PaymentModel = new PaymentModel();
            $payout_batch_id =    $new_result->batch_header->payout_batch_id;
            $sender_batch_id =    $new_result->batch_header->sender_batch_header->sender_batch_id;

            $update_array = array();
            $update_array['PAYMENT_STATUS'] = 'COMPLETE';
            $update_array['PAYOUT_BATCH_ID'] = $payout_batch_id;
            $update_array['SENDER_BATCH_ID'] = $sender_batch_id;

            return  $PaymentModel->update_payout_transaction($payout_id, $update_array);
        } else {
            return false;
        }
    }
}