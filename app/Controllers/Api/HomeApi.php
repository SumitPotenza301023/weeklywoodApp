<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\ContestModel;
use App\Models\BannerModel;
use App\Models\CmsModel;
use App\Models\ContactUsModel;
use App\Models\UserModel;
use App\Models\ParticipantModel;
use App\Models\NotificationModel;
/**
 * API REFERENCE
 * https://documenter.getpostman.com/view/14423652/UVXqFD1Q#intro
 */


/**
 * HomeApi
 */
class HomeApi extends BaseController {
    
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
     * homeApi
     *
     * @return void
     */
    public function homeApi(){
        $banner = new BannerModel();
        $ContestModel = new ContestModel();
        $homeresult = array();
        $banners = $banner->get_banner_sorted();
        foreach($banners as $key=>$bannerimage){
            $banners[$key]['IMAGE_NAME'] = base_url().BANNERFOLDERPATH.'/'.$bannerimage['IMAGE_NAME'];
        }
       
        $contest = $ContestModel->get_active_contest();
        if(!empty($contest)){
             $contest['IS_REGISTERED']  = FALSE;
            $ParticipantModel = new ParticipantModel();
            if($ParticipantModel->already_joined($this->user_id, $contest['C_ID'])){
                 $contest['IS_REGISTERED']  = TRUE;
            }
            $contest['DAYS_REMAINING'] = $this->date_diff($contest['END_DATE']);
            $contest['CONTEST_BANNER'] = base_url().CONTESTBANNERFOLDERPATH.'/'.$contest['C_ID'].'/'.$contest['CONTEST_BANNER'];
            $contest['CONTEST_PDF']= base_url().CONTESTPDFFOLDERPATH.'/'.$contest['C_ID'].'/'.$contest['CONTEST_PDF'];
        }
        else{
            $contest = array('message' => 'No Contest Found');
        }
        $user_model = new UserModel();
        $homeresult['banners'] = $banners;
        $homeresult['contest'] = $contest;
        $homeresult['userpoints'] = $user_model->get_user_balance_point($this->user_id);
        $homeresult['paypal_mode'] = PAYPALMODE;
        if(!empty($homeresult)){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY HOME SCREEN");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $homeresult, 'status' => 200));
        }else{
            $error  =  true;
            $message = array('success'=>"SOMETHING WENT WRONG");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 500));
        }

    }

    /**
     * cms_api
     *
     * @return void
     */
    public function cms_api(){
        $cms_model = new CmsModel();
        $cms_pages = $cms_model->get_all_pages_api();
    
        if(!empty( $cms_pages )){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY RETRIEVED CONTENT PAGES");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $cms_pages, 'status' => 200));
        }
        else
        {
            $error  =  true;
            $message = array('error'=>"SOMETHING WENT WRONG");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 404));
        }
    }
    
    /**
     * contact_us 
     *
     * @return void
     */
    public function contact_us(){
        $contact_us_model = new ContactUsModel();
        $user_model = new UserModel();
		$rules = $contact_us_model->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
       
        if ($this->validate($contact_us_model->get_api_rules(), $contact_us_model->get_api_message() )) {
            if(!isset($contact_number) && empty($contact_number))
            {
                $contact_number = '';
            }
            $contact_us_data=array(
                'user_id'=>$this->user_id,
                'name'=>$name,
                'contact_number'=>$contact_number,
                'email'=>$email,
                'message'=> $message
            );
            $insert_res= $contact_us_model->insert($contact_us_data);
            
            $to_emails = $user_model->get_admin_emails();
  
            $subject = 'New Contect Us Message';

            $composed_message = 'Name: '.$name.'<br/><br/>';

            if(!empty($contact_number)){
                $composed_message .= 'contact_number: '.$contact_number.'<br/><br/>';
            }

            $composed_message .= 'Email: '.$email.'<br/><br/>';

            $composed_message .= 'Message: '.$message;

            $sent = $this->send_mail($to_emails, $subject, $composed_message);
           
            if($sent){
                $error  =  false;
                $message = array('success'=>"MAIL SENT SUCCESSFULLY!");
                echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
            }else{
                $error  =  true;
                $message = array('error'=>"SOMETHING WENT WRONG");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 500));
            }
        } else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * getnotifications
     *
     * @return void
     */
    public function getnotifications(){
        $NotificationModel = new NotificationModel();
        $notifications = $NotificationModel->get_user_notification($this->user_id);
    
        if(!empty( $notifications )){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FATECHED NOTIFICATION");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $notifications, 'status' => 200));
        }
        else
        {
            $error  =  true;
            $message = array('error'=>"NO NOTIFICATION FOUND");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 404));
        }
    }
    
}