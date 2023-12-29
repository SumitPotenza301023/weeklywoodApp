<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\FollowingUserModel;
use App\Models\NotificationModel;
use App\Models\ParticipantModel;
use App\Models\ContestResultModel;

/**
 * API REFERENCE
 * https://documenter.getpostman.com/view/14423652/UVXqFD1Q#intro
 */

/**
 * UserApi
 */
class UserApi extends BaseController {
    
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
     * register_user
     *
     * @return void
     */
    public function register_user(){
        $UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
       
        if ($this->validate($UserModel->get_api_rules(), $UserModel->get_api_message() )) {
             $userdetails = array(
                'FIRST_NAME' => ucwords($first_name),      
                'USERNAME' => trim($username),
                'EMAIL_ID' => trim($email),
                'PASSWORD' => md5(trim($password)),
                'DOB' => $this->date_format_weekly($dob),
                'STREET' => $street,
                'CITY' => $city,
                'ZIPCODE' => $zipcode,
                'STATE' => $state,
                'PAYPAL_EMAIL_ID' => trim($paypalid),
                'TAX_ID' => $tax_id,
                'ROLE_ID' => 4,
                'STATUS' => 1,
                'DEVICE_TOKON' => $device_tokon,
                'DEVICE_TYPE'  => $device_type,
                //'GENDER'
            );
			$is_inserted = $UserModel->create_user($userdetails);
			if($is_inserted){
				$error  =  false;
				$message = array('success'=>"SUCCESSFULLY REGISTERED");
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
					$error = true;
					$message = array('error'=>"SOMETHING WENTWRONG!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * user_login
     *
     * @return void
     */
    public function user_login(){
        $UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $validation = $UserModel->get_api_rules();
        $rules = array(
            'username' => 'required',
            'password' => 'required',
            'device_tokon' => $validation['device_tokon'],
            'device_type' => $validation['device_type']
        );
        
        if ($this->validate($rules, $UserModel->get_api_message() )) {

			$is_logged_in = $UserModel->user_login($username, $password, $device_type, $device_tokon);
            if($is_logged_in === 403 ){
                $error = true;
                $message = array('error'=>"Please Contact to Administrator You are Blocked!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
            }
			if($is_logged_in){
				$error  =  false;
				$message = array('success'=>"SUCCESSFULLY LOGGED IN");
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $is_logged_in, 'status' => 200));
			}else{
					$error = true;
					$message = array('error'=>"Please Enter Valid Cridentials!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error));
		}
    }
    
    /**
     * logout_user
     *
     * @return void
     */
    public function logout_user(){
        $UserModel = new UserModel();
        if($UserModel->logout_user($this->user_id)){
            $error  =  false;
            $message =  array('success'=>"SUCCESSFULLY LOGGED OUT");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
        }else{
            $error = true;
            $message = array('error'=>"SOMETHING WENT WRONG");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));

        }
    }
    
    /**
     * get_user_details
     *
     * @return void
     */
    public function get_user_details(){
        $UserModel = new UserModel();
        $userdetails = $UserModel->getUserDetailsById($this->user_id);
        unset($userdetails['ROLE_ID']);
        unset($userdetails['STATUS']);
        unset($userdetails['AGREE_TERMS']);
        unset($userdetails['AGREE_RULE']);
        unset($userdetails['AGREE_LIABILITY']);
        unset($userdetails['DEVICE_TOKON']);
        unset($userdetails['FORGOT_VERIFYCODE']);
        unset($userdetails['LOGIN_KEY']);
        unset($userdetails['EMAIL_VERIFICATION_CODE']);
        unset($userdetails['BLOCK']);
        unset($userdetails['CREATED_AT']);
        unset($userdetails['UPDATED_AT']);
        unset($userdetails['R_ID']);
        unset($userdetails['PASSWORD']);
		if($userdetails['PROFILE_IMAGE']!=''){
			$userdetails['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$userdetails['ID'].'/'.$userdetails['PROFILE_IMAGE'];
		}

        if(!empty($userdetails)){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FATECHED YOUR DETAILS");
            echo $this->sendResponse(array('success' => true, 'message' => $message, 'data'=>$userdetails,  'error'=>$error, 'status' => 200));
        }else{
            $error = true;
            $message =  array('error'=>"SOMETHING WENT WRONG");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));

        }
    }
    
    /**
     * edit_user_details
     *
     * @return void
     */
    public function edit_user_details(){
        $UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        if ($this->validate($UserModel->get_api_rules_edit($this->user_id), $UserModel->get_api_message() )) {
            $userdetails = array(
                'FIRST_NAME' => ucwords($first_name),      
                'USERNAME' => trim($username),
                'EMAIL_ID' => trim($email),
                'DOB' => $this->date_format_weekly($dob),
                'STREET' => $street,
                'CITY' => $city,
                'ZIPCODE' => $zipcode,
                'STATE' => $state,
                'PAYPAL_EMAIL_ID' => trim($paypalid),
                'TAX_ID' => $tax_id
            );
            if (isset($IS_PROFILE_UPDATED_SOCIAL) && $IS_PROFILE_UPDATED_SOCIAL == 'YES') {
                $userdetails['AGREE_TERMS'] = $AGREE_TERMS;
                $userdetails['AGREE_RULE'] = $AGREE_RULE;
                $userdetails['AGREE_LIABILITY'] = $AGREE_LIABILITY;
                if (isset($userdetails['IS_PROFILE_UPDATED_SOCIAL'])) {
                $userdetails['IS_PROFILE_UPDATED_SOCIAL'] = $IS_PROFILE_UPDATED_SOCIAL;
                }

            }
            if(isset($_FILES['profile_image'])){
                $user_image = $this->uploadFilefunc('profile_image', 'image', $this->user_id, USERPROFILEFOLDER, 'userprofile');
                if($user_image){
                    $userdetails['PROFILE_IMAGE'] = $user_image;
                }
		    }
			$is_updated = $UserModel->updateUserdetails($userdetails, array('ID'=>$this->user_id));
			if($is_updated){
				$error  =  false;
				$message = array('success'=>"SUCCESSFULLY UPDATED USER");
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
					$error = true;
					$message =  array('error'=> "SOMETHING WENTWRONG!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * reset_password
     *
     * @return void
     */
    public function reset_password(){
        $UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $validation = array(
            'password'   => $UserModel->validationRules["PASSWORD"]
		);
        if ($this->validate($validation, $UserModel->get_api_message() )) {
			$is_updated = $UserModel->reset_password($password, array('ID'=>$this->user_id));
			if($is_updated){
				$error  =  false;
				$message = array('success'=>"RESET PASSWORD SUCCESSFULL");
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
					$error = true;
					$message =  array('error'=>"SOMETHING WENTWRONG!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * forgot_password
     *
     * @return void
     */
    public function forgot_password(){
        $UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $validation = array(
            'email'   => 'required|valid_email'
		);
        if ($this->validate($validation, $UserModel->get_api_message() )) {
            $tokon	=	$this->random_key(4);
			$is_updated = $UserModel->set_reset_token($email, $tokon);
			if($is_updated){
                $user = $UserModel->getUserbyEmail($email);
                $to = trim($email);
				$subject = 'WeeklyThrowDown:- User - Forgot Password';
				
				$message = 'Hello,'.$user['FIRST_NAME'].'<br/>';
				
				$message .= 'Welcome to WeeklyThrowDown, Your Request for Reset Password has been processed use this code to reset password '.$tokon;
				$message .= '<br/>Please use this tokon to reset !<br/>';
				$message .= 'Thank you<br/>';
				$message .= 'WeeklyThrowDown Team';
				$mail_sent = $this->send_mail($to,$subject,$message);
				if($mail_sent == 0){
					$error = true;
					$message = array('error'=>"SOMETHING WENTWRONG!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
				}
				$error  =  false;
				$message = array('success'=>"CHECK YOUR MAIL FOR RESET CODE");
                $data = array('tokon' => $tokon);
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $data, 'status' => 200));
			}else{
					$error = true;
					$message =  array('error'=>"SOMETHING WENTWRONG!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * change_password
     *
     * @return void
     */
    public function change_password(){
        $UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $validation = array(
            'tokon'   => 'required',
            'password' => $UserModel->validationRules["PASSWORD"]
		);
        if ($this->validate($validation, $UserModel->get_api_message() )) {
			$is_updated = $UserModel->change_password_tokon($tokon, $password);
			if($is_updated){
				$error  =  false;
				$message = array('success'=>"PASSWORD CHANGED SUCCESSFULLY");
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
                $error = true;
                $message =  array('error'=>"SOMETHING WENTWRONG!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));
		}
    }
    
    /**
     * social_login
     *
     * @return void
     */
    // public function social_login(){
    //     $UserModel = new UserModel();
	// 	$rules = $UserModel->validationRules;
	// 	$post = $this->request->getPost();
	// 	foreach($post as $key => $value ){
	// 		${$key} = $value;
	// 	}
    //     $validation = $UserModel->get_api_rules();
    //     $rules = array(
    //         // 'username'      => 'required',
    //         // 'email'         => 'required|valid_email',
    //         'full_name'     => $validation['first_name'],
    //         'login_type'    => 'required|in_list[GOOGLE,FACEBOOK,APPLE]',
    //         'social_key'    => 'required',
    //         'device_tokon' => $validation['device_tokon'],
    //         'device_type' => $validation['device_type']
    //     );


    //     if(!isset($email) || empty($emial)){
    //         $rules = array(
    //             'mobile' => 'required|numeric'
    //         );
    //     }else{
    //         $rules = array(
    //             'email' => 'required|valid_email',
    //         );
    //     }
    //     if ($this->validate($rules, $UserModel->get_api_message() )) {

	// 		$is_logged_in = $UserModel->social_login($username, $email, $full_name, $login_type, $social_key, $device_type, $device_tokon);
    //         if($is_logged_in === 403 ){
    //             $error = true;
    //             $message = array('error'=>"Please Contact to Administrator You are Blocked!");
    //             echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
    //         }
	// 		if($is_logged_in){
	// 			$error  =  false;
	// 			$message = array('success'=>"SUCCESSFULLY LOGGED IN");
	// 			echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $is_logged_in, 'status' => 200));
	// 		}else{
	// 				$error = true;
	// 				$message = array('error'=>"Please Enter Valid Cridentials!");
	// 				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
	// 		}
	// 	} else {
	// 		$error = true;
    //         echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error));
	// 	}

    // }

    /**
     * demo_social_login
     *
     * @return void
     */
    public function social_login()
    {        
        $UserModel = new UserModel();
        $rules = $UserModel->validationRules;
        $post = $this->request->getPost();
        
        foreach ($post as $key => $value) {
            ${$key} = $value;
        }

        if (!isset($email) || empty($email)) {
            $email = "";
        }

        if (!isset($mobile) || empty($mobile)) {
            $mobile = "";
        }

        $validation = $UserModel->get_api_rules();

        if(!isset($login_type) || empty($login_type)){
            $error = true;
            $message = array('error' => "PLEASE ENTER LOGIN TYPE");
            echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 403));
        }

        if ($login_type == "GOOGLE") {
            $rules = array(
                'username'      => 'required',
                'email'         => 'required|valid_email',
                'full_name'     => $validation['first_name'],
                'login_type'    => 'required|in_list[GOOGLE,FACEBOOK,APPLE]',
                'social_key'    => 'required',
                'device_tokon'  => $validation['device_tokon'],
                'device_type'   => $validation['device_type']
            );            
        } else if ($login_type === "APPLE") {
            if (!isset($email) || empty($email)) {                
                $rules = array(
                    'username'      => 'required',
                    'mobile'        => 'required|numeric',
                    'full_name'     => $validation['first_name'],
                    'login_type'    => 'required|in_list[GOOGLE,FACEBOOK,APPLE]',
                    'social_key'    => 'required',
                    'device_tokon'  => $validation['device_tokon'],
                    'device_type'   => $validation['device_type']
                );

            } else {
                $rules = array(
                    'username'      => 'required',
                    'email'         => 'required|valid_email',
                    'full_name'     => $validation['first_name'],
                    'login_type'    => 'required|in_list[GOOGLE,FACEBOOK,APPLE]',
                    'social_key'    => 'required',
                    'device_tokon'  => $validation['device_tokon'],
                    'device_type'   => $validation['device_type']
                );
            }            
        } else {
            $error = true;
            $message = array('error' => "Invalid login type");
            echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 403));
        }

        if ($this->validate($rules, $UserModel->get_api_message())) {
            $is_logged_in = $UserModel->social_login($username, $email, $mobile, $full_name, $login_type, $social_key, $device_type, $device_tokon);

            if ($is_logged_in === "MobileExists") {
                $error = true;
                $message = array('error' => "This Mobile is already used!");
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 403));
            }
            if ($is_logged_in === 403) {
                $error = true;
                $message = array('error' => "Please Contact to Administrator You are Blocked!");
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 403));
            }
            if ($is_logged_in) {
                $error  =  false;
                $message = array('success' => "SUCCESSFULLY LOGGED IN");
                echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'data' => $is_logged_in, 'status' => 200));
            } else {
                $error = true;
                $message = array('error' => "Please Enter Valid Cridentials!");
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 403));
            }
        } else {
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error));
        }
    }

    /**
     * add_user_following
     *
     * @return void
     */
    public function add_user_following(){
        $UserModel = new UserModel();
        $following_user_model = new FollowingUserModel();
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}

        $validation = $UserModel->get_api_rules();
        $rules = array(
            'following_user_id' => 'required',
        );
        
        if ($this->validate($rules, $UserModel->get_api_message() )) {

            $user = $UserModel->get_user_by_id( $this->user_id );
            if(empty($user)){
                $error = true;
                $message = array('error'=>"User Does Not Exist!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
            }

            $following_user = $UserModel->get_user_by_id( $following_user_id );
            if(empty($following_user)){
                $error = true;
                $message = array('error'=>"Following User Does Not Exist!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
            }

            if( $this->user_id == $following_user_id ){
                $error = true;
                $message = array('error'=>"You Can Not Follow Your Self!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
            }

            $result = $following_user_model->get_user_following($this->user_id, $following_user_id);
            
            if(empty($result)){
                $insert_res = $following_user_model->insert(array('user_id'=>$this->user_id, 'following_user_id'=> $following_user_id));
                $NotificationModel = new NotificationModel();
                $message = 'You Started Following '.$following_user['FIRST_NAME'];
                $NotificationModel->create_notification($this->user_id, 'FOLLOWING', $message, 'SYSTEM' );
                $message = $user['FIRST_NAME'].' Started Following You';
                $NotificationModel->create_notification($following_user_id, 'FOLLOWER', $message, 'SYSTEM' );
                if($insert_res){
                    $error  =  false;
                    $message = array('success'=>"STARTED FOLLOWING SUCCESSFULLY");
                    echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => array(), 'status' => 200));
                }
                else
                {
                    $error = true;
                    $message = array('error'=>"Something went wroing!");
                    echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
                }
            }
            else{
                $error = true;
                $message = array('error'=>"Your are already following this user!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
            }
        }
        else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error));
		}

    }

    /**
     * add_user_following
     *
     * @return void
     */
    public function get_followers_and_following_info(){
        $UserModel = new UserModel();
        $following_user_model = new FollowingUserModel();
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $following_user_data = $following_user_model->get_following_users( $this->user_id );
        $follower_user_data = $following_user_model->get_follower_users( $this->user_id );
        foreach($follower_user_data as $key=>$following_user){
            $is_following = $following_user_model->is_following($this->user_id, $following_user['ID'] );
            if($is_following > 0){
                $follower_user_data[$key]['is_following'] = true;
            }else{
                $follower_user_data[$key]['is_following'] = false;
            }
        }
         $data=array(
            'following_user_data'=> array(
                'count'=> count($following_user_data),
                'user_list'=> $following_user_data
            ),
            'followers_user_data'=> array(
                'count'=> count($follower_user_data),
                'user_list'=> $follower_user_data
            ),
        );
        if(!empty($data)){
            $error  =  false;
            $message = array('success'=>"FOLLOWING AND FOLLOWERS DATA RETRIEVED SUCCESSFULLY");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' =>  $data, 'status' => 200));
        }
        else {
			$error = true;
            $message = array('error'=>"Something went wroing!");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
		}
    }
    
    /**
     * notificationaccess
     *
     * @return void
     */
    public function notificationaccess()
	{
		$UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			"notification"=>  'required|in_list[YES,NO]'
			
		);
        $message = [
            'notification' => [
                'required' => 'Notification is required',
                'in_list' => 'Only Yes and No is Allowed'
            ]
        ];

		
		
		if ($this->validate($validation, $message)) {
						

				$userdetails = array(
					'ALLOW_NOTIFICATION ' => $notification
				);
			
			$is_updated = false;
			if(!empty($userdetails)){
				$is_updated = $UserModel->update_user($userdetails, array('ID' => $this->user_id ));
			}
			if($is_updated){
				$error  =  false;
				$message = array('success'=>"SUCCESSFULLY UPDATED NOTIFICATION");
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
				$error = true;
				$message =  array('error'=>"SOMETHING WENTWRONG!");
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' =>  $this->validator->getErrors(), 'error'=> $error, 'status' => 403));
		}
	}
    
    /**
     * user_profile
     *
     * @return void
     */
    public function user_profile()
    {
        $UserModel = new UserModel();
        $ContestResultModel = new ContestResultModel();
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        if(isset($user_id) && !empty($user_id)){
            
            $following_user_model = new FollowingUserModel();
            $userdetails = $UserModel->getUserDetailsById($user_id);
            if(empty($userdetails)){
                $error = true;
                $message =  array('error'=>"PLEASE PASS VALID USER ID");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));
            }
            unset($userdetails['ROLE_ID']);
            unset($userdetails['STATUS']);
            unset($userdetails['AGREE_TERMS']);
            unset($userdetails['AGREE_RULE']);
            unset($userdetails['AGREE_LIABILITY']);
            unset($userdetails['DEVICE_TOKON']);
            unset($userdetails['FORGOT_VERIFYCODE']);
            unset($userdetails['LOGIN_KEY']);
            unset($userdetails['EMAIL_VERIFICATION_CODE']);
            unset($userdetails['BLOCK']);
            unset($userdetails['LOGIN_TYPE']);
            unset($userdetails['SOCIAL_KEY']);
            unset($userdetails['UPDATED_AT']);
            unset($userdetails['R_ID']);
            unset($userdetails['PASSWORD']);
            unset($userdetails['ALLOW_NOTIFICATION']);
            unset($userdetails['DEVICE_TYPE']);
            unset($userdetails['ACCESS_ROLE']);
            unset($userdetails['TAX_ID']);
            $userdetails['is_following'] = false;
            $is_following = $following_user_model->is_following($this->user_id, $user_id );
            if($is_following > 0){
                $userdetails['is_following'] = true;
            }
            
            $ParticipantModel = new ParticipantModel();
            $userdetails['CONTEST_ENTRIES'] = $ParticipantModel->user_entries($user_id);
            $userdetails['CONTEST_WON'] = $UserModel->ContestWon($this->user_id);
            if($userdetails['PROFILE_IMAGE']!=''){
                $userdetails['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$userdetails['ID'].'/'.$userdetails['PROFILE_IMAGE'];
            }
            $following_user_data = $following_user_model->get_following_users( $user_id );
            $follower_user_data = $following_user_model->get_follower_users( $user_id );
            $data=array(
                'following_user_data'=> array(
                    'count'=> count($following_user_data),
                    'user_list'=> $following_user_data
                ),
                'followers_user_data'=> array(
                    'count'=> count($follower_user_data),
                    'user_list'=> $follower_user_data
                ),
            );
            $userdetails['follow'] = $data;
            //all contest user participant
            $userdetails['contests']= $ContestResultModel->user_participate_history($user_id);
            if(!empty($userdetails)){
                $error  =  false;
                $message = array('success'=>"SUCCESSFULLY FATECHED YOUR DETAILS");
                echo $this->sendResponse(array('success' => true, 'message' => $message, 'data'=>$userdetails,  'error'=>$error, 'status' => 200));
            }else{
                $error = true;
                $message =  array('error'=>"SOMETHING WENT WRONG");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));

            }
        }else{
            $following_user_model = new FollowingUserModel();
            $userdetails = $UserModel->getUserDetailsById($this->user_id);
            unset($userdetails['ROLE_ID']);
            unset($userdetails['STATUS']);
            unset($userdetails['AGREE_TERMS']);
            unset($userdetails['AGREE_RULE']);
            unset($userdetails['AGREE_LIABILITY']);
            unset($userdetails['DEVICE_TOKON']);
            unset($userdetails['FORGOT_VERIFYCODE']);
            unset($userdetails['LOGIN_KEY']);
            unset($userdetails['EMAIL_VERIFICATION_CODE']);
            unset($userdetails['BLOCK']);
            unset($userdetails['LOGIN_TYPE']);
            unset($userdetails['SOCIAL_KEY']);
            unset($userdetails['UPDATED_AT']);
            unset($userdetails['R_ID']);
            unset($userdetails['PASSWORD']);
            $ParticipantModel = new ParticipantModel();
            $userdetails['CONTEST_ENTRIES'] = $ParticipantModel->user_entries($this->user_id);
            $userdetails['CONTEST_WON'] =  $UserModel->ContestWon($this->user_id);;
            $userdetails['POINTS'] = $UserModel->get_user_balance_point($this->user_id);
            if($userdetails['PROFILE_IMAGE']!=''){
                $userdetails['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$userdetails['ID'].'/'.$userdetails['PROFILE_IMAGE'];
            }
            $following_user_data = $following_user_model->get_following_users( $this->user_id );
            $follower_user_data = $following_user_model->get_follower_users( $this->user_id );
            $data=array(
                'following_user_data'=> array(
                    'count'=> count($following_user_data),
                    'user_list'=> $following_user_data
                ),
                'followers_user_data'=> array(
                    'count'=> count($follower_user_data),
                    'user_list'=> $follower_user_data
                ),
            );
            $userdetails['follow'] = $data;
           
            //all contest user participant
            $userdetails['contests']= $ContestResultModel->user_participate_history($this->user_id);
            if(!empty($userdetails)){
                $error  =  false;
                $message = array('success'=>"SUCCESSFULLY FATECHED YOUR DETAILS");
                echo $this->sendResponse(array('success' => true, 'message' => $message, 'data'=>$userdetails,  'error'=>$error, 'status' => 200));
            }else{
                $error = true;
                $message =  array('error'=>"SOMETHING WENT WRONG");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));

            }
        }
    }

    /**
     * delete_user
     *
     * 
     */
    public function deleteUser()
    {
        $data = [
            'id' => $this->request->getPost('user_id'),
            'email' => $this->request->getPost('user_email')
        ];

        $rules = array(
            'user_id' => 'required',
            'user_email' => 'required',
        );
        $UserModel = new UserModel();
        if ($this->validate($rules, $UserModel->get_api_message())) {

            $query = $this->db->table('tbl_user_master')->where(['ID' => $data['id'], 'EMAIL_ID' => $data['email']]);
            $result = $query->get()->getRowArray();

            if ($result) {
                
                $deleteUser = $UserModel->deleteUser($data);

                if ($deleteUser) {
                    $error  =  false;
                    $message = "USER DELETED SUCCESSFULLY!";
                    echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'status' => 200));
                } else {
                    $this->somethingwentwrong();
                }
            } else {
                $error = true;
                $message =  "SOMETHING WENT WRONG";
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 500));
            }
        } else {
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error));
        }
    }
}