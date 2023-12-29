<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\UserModel;
use monken\TablesIgniter;

/**
 * Users
 */
class Users extends BaseController
{
	 
	
	/**
	 * Load Dashboard function
	 *
	 * @return view
	 */
	public function index()
	{
        $view['content'] = "users/index";
		$view['title'] = "users";
        $role =  new RoleModel();
        $roles = $role->get_user_roles();
		$view['data'] = array( 'role'=> $roles);
		return view('default', $view);
	}
	
	/**
	 * add_user
	 *
	 * @return void
	 */
	public function add_user(){
		$UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"first_name"=> array(
				"label"=>"First Name",
				"rules"=> $rules['FIRST_NAME']
			),
			"last_name"=> array(
				"label"=>"Contest Description",
				"rules"=> $rules['LAST_NAME']
			),
			"username" =>array(
				"label" => "Username",
				"rules" => $rules["USERNAME"]
			),
			"email" =>array(
				"label" => "Email Id",
				"rules" => $rules["EMAIL_ID"]
			),
			"user_role" =>array(
				"label" => "User Role",
				"rules" => 'required|rolekey_exists[user_role]'
			),
			
		);
		$password	=	$this->random_key(8);
		$userdetails = array(
			'FIRST_NAME' => ucwords($first_name),    
			'LAST_NAME'  => ucwords($last_name),
			'USERNAME'   => $username,
			'EMAIL_ID'   => $email,
			'PASSWORD'   => md5($password),
			'ROLE_ID'    => $user_role
		);
		if($user_role == '1'){
			$userdetails['DEVICE_TYPE'] = "ADMIN";
		}
		
		if ($this->validate($validation)) {
			$is_inserted = $UserModel->create_user($userdetails);
			if($is_inserted){

				$to = trim($email);
				$subject = 'User - Login Details';
				
				$message = 'Hello,'.$first_name.' '.$last_name.'<br/>';
				
				$message .= 'Welcome to WeeklyThrowDown, Your login details for vendor panel are following as :<br/> Email Id. : '.$email.'<br/>Password : '.$password;
				$message .= '<br/>Please use all above credentials to login!<br/>';
				$message .= 'Thank you<br/>';
				$message .= 'WeeklyThrowDown Team';
				$mail_sent = $this->send_mail($to,$subject,$message);
				if($mail_sent == 0){
					$error = true;
					$message = "SOMETHING WENTWRONG!";
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
				}
				$error  =  false;
				$message = "SUCCESSFULLY USER CREATED CREATED";
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
	 * getusers
	 *
	 * @return void
	 */
	public function getusers(){
		$UserModel = new UserModel();
		$table = new TablesIgniter($UserModel->get_user_details());
    	return $table->getDatatable();
	}
	
	/**
	 * delete_user
	 *
	 * @return void
	 */
	public function delete_user(){
		$id = $this->request->getPost('u_id');
		$UserModel = new UserModel();
		if(!empty($id)){
			$deleted = $UserModel->update_user(array('status'=> '0'), array('ID'=>$id));
			if($deleted){
				$error = false;
				$message = "SUCCESSFULLY CONTEST RECIEVED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $deleted ));
			}else {
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}else{

			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}		
	}
	
	/**
	 * block_user
	 *
	 * @return void
	 */
	public function block_user(){
		$id = $this->request->getPost('u_id');
		$UserModel = new UserModel();
		if(!empty($id)){
			$blocked = $UserModel->update_user(array('BLOCK'=> 'YES'), array('ID'=>$id));
			if($blocked){
				$error = false;
				$message = "SUCCESSFULLY BLOCKED USER";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error ));
			}else {
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}else{

			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	}
	
	/**
	 * unblock_user
	 *
	 * @return void
	 */
	public function unblock_user(){
		$id = $this->request->getPost('u_id');
		$UserModel = new UserModel();
		if(!empty($id)){
			$blocked = $UserModel->update_user(array('BLOCK'=> 'NO'), array('ID'=>$id));
			if($blocked){
				$error = false;
				$message = "SUCCESSFULLY UNBLOCKED USER";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error ));
			}else {
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}else{

			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	}
		
	/**
	 * get_userdetails
	 *
	 * @return void
	 */
	public function get_userdetails(){
		$id = $this->request->getPost('u_id');
		$UserModel = new UserModel();
		if(!empty($id)){
			$userdetails = $UserModel->getUserDetailsById($id);
			foreach($userdetails as $key => $value){
				if($key == 'PROFILE_IMAGE' && $value!=''){
					$userdetails['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$userdetails['ID'].'/'.$value;
				}
				if($value == ''){
					$userdetails[$key] = "NOT ADDED";
				}
			}
			if($userdetails){
				$error = false;
				$message = "SUCCESSFULLY USER RECIEVED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $userdetails ));
			}else {
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}else{

			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	}	
	/**
	 * edit_user
	 *
	 * @return void
	 */
	public function edit_user(){
		$UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"first_name"=> array(
				"label"=>"First Name",
				"rules"=> $rules['FIRST_NAME']
			),
			"last_name"=> array(
				"label"=>"Contest Description",
				"rules"=> $rules['LAST_NAME']
			),
			"username" =>array(
				"label" => "Username",
				"rules" => 'required|alpha_numeric_space|min_length[3]|is_unique[tbl_user_master.USERNAME,ID,{user_id}]'
			),
			"email" =>array(
				"label" => "Email Id",
				"rules" => 'required|valid_email|is_unique[tbl_user_master.EMAIL_ID,ID,{user_id}]'
			),
			"user_role" =>array(
				"label" => "User Role",
				"rules" => 'required|rolekey_exists[user_role]'
			),
			
		);
		$userdetails = array(
			'FIRST_NAME' => ucwords($first_name),    
			'LAST_NAME'  => ucwords($last_name),
			'USERNAME'   => $username,
			'EMAIL_ID'   => $email,
			'ROLE_ID'    => $user_role
		);
		if($user_role == '1'){
			$userdetails['DEVICE_TYPE'] = "ADMIN";
		}
		if ($this->validate($validation)) {
			$is_updated = $UserModel->update_user($userdetails, array('ID' => $user_id ));
			if($is_updated){
				$error  =  false;
				$message = "SUCCESSFULLY USER UPDATED";
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
	 * access_control
	 *
	 * @return void
	 */
	public function access_control(){
		$UserModel = new UserModel();
		$rules = $UserModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"user_id"=> array(
				"label"=>"User id",
				"rules"=> 'required'
			),
			"access"=> array(
				"label"=>"Access",
				"rules"=> 'required'
			)
			
		);

		
		
		if ($this->validate($validation)) {
			$userdetails = array();
			if(is_array($access)){
				$accessroles = json_encode($access, true);
				$userdetails = array(
					'ACCESS_ROLE ' => $accessroles
				);
			}
			$is_updated = false;
			if(!empty($userdetails)){
				$is_updated = $UserModel->update_user($userdetails, array('ID' => $user_id ));
			}
			if($is_updated){
				$error  =  false;
				$message = "SUCCESSFULLY USER UPDATED";
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
