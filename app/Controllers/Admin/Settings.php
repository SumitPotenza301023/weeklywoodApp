<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\SettingModel;
use monken\TablesIgniter;

/**
 * Users
 */
class Settings extends BaseController
{
	 
		
	/**
	 * points_management
	 *
	 * @return void
	 */
	public function points_setting()
	{
        $view['content'] = "settings/points";
		$view['title'] = "Points";
        $SettingModel = new SettingModel();
        $price_setting = $SettingModel->get_setting(POINT_PRICE);
		$view['data'] = array( 'price_setting'=> $price_setting);
		return view('default', $view);
	}
    
    /**
     * update_point
     *
     * @return void
     */
    public function update_point(){
        $SettingModel = new SettingModel();
		$rules = $SettingModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			"point_price"=> array(
				"label"=>"POINT PRICE",
				"rules"=> 'required|is_natural_no_zero'
			)
		);
		$point = 1;
		if ($this->validate($validation)) {
            $point_setting = array(
                POINT => $point,
                POINT_PRICE_VALUE => $point_price
            );
            $point_update = array(
                'SETTING_VALUE'=> json_encode($point_setting),
		    );
			$is_updated = $SettingModel->update_settings($point_update, POINT_PRICE);
			if($is_updated){
				$error = false;
				$message = "SUCCESSFULLY POINT SETTING UPDATED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
			}else{
                $error = true;
                $message = "SOMETHING WENTWRONG!";
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error));
		}
    }
	
	/**
	 * payment_settings
	 *
	 * @return void
	 */
	public function payment_settings(){
		$view['content'] = "settings/payment";
		$view['title'] = "payment";
        $SettingModel = new SettingModel();
        $paypal_setting = $SettingModel->get_setting(PAYPAL_SETTING);
		$view['data'] = array( 'paypal_setting'=> $paypal_setting);
		return view('default', $view);
	}	
	/**
	 * update_payment
	 *
	 * @return void
	 */
	public function update_payment(){
        $SettingModel = new SettingModel();
		$rules = $SettingModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"client_key"=> array(
				"label"=>"Client Key",
				"rules"=> 'required'
			),
			"secret_key"=> array(
				"label"=>"Secret Key",
				"rules"=> 'required'
			)
		);
		if ($this->validate($validation)) {
            $payment_setting = array(
                PAYPAL_CLIENT_KEY => $client_key,
                PAYPAL_SECRET_KEY => $secret_key
            );
            $setting_update = array(
                'SETTING_VALUE'=> json_encode($payment_setting),
		    );
			$is_updated = $SettingModel->update_settings($setting_update, PAYPAL_SETTING);
			if($is_updated){
				$error = false;
				$message = "SUCCESSFULLY PAYPAL SETTING UPDATED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
			}else{
                $error = true;
                $message = "SOMETHING WENTWRONG!";
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error));
		}
    }
	
	/**
	 * firebase_settings
	 *
	 * @return void
	 */
	public function firebase_settings(){
		$view['content'] = "settings/pushnotification";
		$view['title'] = "FireBase Setting";
        $SettingModel = new SettingModel();
        $firebase_setting = $SettingModel->get_setting(FIREBASE_SERVER_KEY);
		$view['data'] = array( 'firebase_setting'=> $firebase_setting);
		return view('default', $view);
	}
	
	/**
	 * update_firebase_setting
	 *
	 * @return void
	 */
	public function update_firebase_setting(){
		$SettingModel = new SettingModel();
		$rules = $SettingModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"firebasekey"=> array(
				"label"=>"FireBase",
				"rules"=> 'required'
			)
		);
		if ($this->validate($validation)) {
           
            $setting_update = array(
                'SETTING_VALUE'=> $firebasekey,
		    );
			$is_updated = $SettingModel->update_settings($setting_update, FIREBASE_SERVER_KEY);
			if($is_updated){
				$error = false;
				$message = "SUCCESSFULLY FIREBASE SETTING UPDATED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
			}else{
                $error = true;
                $message = "SOMETHING WENTWRONG!";
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error));
		}
	}
}
