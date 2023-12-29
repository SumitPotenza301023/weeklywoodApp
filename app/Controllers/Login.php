<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{ 
	   
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
		//header('Access-Control-Allow-Origin: *');
        return view('login');
    }
   	
	
	/**
	 * autenticate
	 *
	 * @return void
	 */
	public function autenticate()
	{

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
		$remember = $this->request->getPost('remember');
		
    
        helper(['form', 'url']);
		$validation=array(
			
			"email"=>array(
				"label"=>"EMAIL ID / USERNAME",
				"rules"=>'required'
			),
			"password"=>array(
				"label"=>"PASSWORD",
				"rules"=>'required'
			)

		);
		$error = false;
        if ($this->validate($validation)) {
            
			$user_model = new UserModel();
            if($user_model->authenticate($email, md5($password), '1') == true) {
				$message = "SUCCESSFULLY LOGGED IN";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
			}
			else{
				$error = true;
				$message = "PLEASE INPUT VALID CRIDENTIALS!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
           
        }else{
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error));
        }
		
	}
	
	/**
	 * logout
	 *
	 * @return void
	 */
	public function logout(){
		$user_model = new UserModel();
		$result = $user_model->logout();
		$url = base_url();
		return redirect()->to($url);
		
	}
	
	/**
	 * forgot_password
	 *
	 * @return void
	 */
	public function forgot_password(){
		return view('forgot-password');
	}
	/**
	 * Pending
	 */
	/**
	 * forgot_password_mail
	 *
	 * @return void
	 */
	public function forgot_password_mail()
	{
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
				if(empty($user)){
					$error = true;
					
					$message = "PLEASE ENTER VALID MAIL ID!";
					echo $this->sendResponse(array('success' => false, 'message' => $message ,'error'=>$error));
				}
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
					$message = "SOMETHING WENTWRONG!";
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
				}
				$error  =  false;
				$message = "CHECK YOUR MAIL FOR RESET CODE";
                $data = array('tokon' => $tokon);
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $data, 'status' => 200));
			}else{
					$error = true;
					$message =  "SOMETHING WENTWRONG!";
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error , 'status'=> 422));
		}
	}	
	/**
	 * change_password
	 *
	 * @return void
	 */
	public function change_password(){
		$tokon = session()->get('resettokon');
		if(isset($tokon) && !empty($tokon)){
			return view('change-password');
		}
		die;
	}
		
	/**
	 * reset_form
	 *
	 * @return void
	 */
	public function reset_form(){
		$UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $validation = array(
            'password'   => 'required|min_length[8]',
			'confirmpassword' => 'required|matches[password]'

		);
		$message = array(
			"password" => [
                'required' => 'Password is Required',
                'min_length' => 'Minimum Length Of password must be 8'
            ],
			"confirmpassword" => [
                'required' => 'Condirm Password is Required',
                'matches' => 'Password and Confim Password Must Be Same!'
            ] 
			);
        if ($this->validate($validation, $message )) {
			$tokon = session()->get('resettokon');
			$is_updated = $UserModel->change_password_tokon($tokon, $password);
			if($is_updated){
				$error  =  false;
				$message = "PASSWORD CHANGED SUCCESSFULLY";
				$session = session();
				$session->remove('resettokon');
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
                $error = true;
                $message = "SOMETHINK WENT WRONG";
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error , 'status'=> 422));
		}
	}
	/**
	 * check_reset_tokon
	 *
	 * @return void
	 */
	public function check_reset_tokon(){
		return view('check-reset-tokon');
	}
	
	/**
	 * verify_code
	 *
	 * @return void
	 */
	public function verify_code(){
		$UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $validation = array(
            'code'   => 'required'
		);
        if ($this->validate($validation, $UserModel->get_api_message() )) {
			$is_updated = $UserModel->is_tokon_valid($code);
			if($is_updated > 0){
				$error  =  false;
				$message = "TOKON VERIFIED SUCCESSFULLY";
				$session = session();
				$session->set(array('resettokon' => $code));
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
			}else{
                $error = true;
                $message = "TOKON PROVIDED IS NOT VALID!";
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error , 'status'=> 422));
		}
	}

	public function deleteAccountTo(){
		die("Hello");
        return view('delete-account');
	}
}
