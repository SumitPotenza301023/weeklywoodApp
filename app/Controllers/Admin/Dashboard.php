<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ContestModel;
use App\Models\ParticipantModel;
class Dashboard extends BaseController
{
	 
	
	/**
	 * Load Dashboard function
	 *
	 * @return view
	 */
	public function index()
	{
        $view['content'] = "dashboard/index";
		$view['title'] = "dashboard"; 
		$user_model = new UserModel();
		$ContestModel = new ContestModel();
		$ParticipantModel = new ParticipantModel();
		$view['data'] = array('usercount' => $user_model->get_users_count(), 'contestcount' => $ContestModel->get_contest_count(), 'participantcount'=> $ParticipantModel->participant_count());
		return view('default', $view);
	}
		
	/**
	 * profile
	 *
	 * @return void
	 */
	public function profile()
	{	
		$user_model = new UserModel();
		$id = session()->get('ID');
		$admin_data = $user_model->getUserDetailsById($id);
		$view['title'] = "Admin Profile";
		$view['view'] = array('title'=>'team Details');
        $view['content'] = '/admin/profile';
		$view['data'] = array('admin_data' => $admin_data);
		return view('default', $view);
	}	
	
	/**
	 * edit_profile
	 *
	 * @return void
	 */
	public function edit_profile()
	{
		$first_name = $this->request->getPost('first_name');
        $last_name  = $this->request->getPost('last_name');
		$dob		= $this->request->getPost('dob');
		$username	= $this->request->getPost('username');
		$gender 	= $this->request->getPost('gender');
		$image 	= $this->request->getPost('image');
		$id = session()->get('ID');
	
		$image = '';
		$image_input_feild_name = 'image';

		$user_model = new UserModel();

		$rules = $user_model->validationRules;
	
		$validation = array(
			
			"first_name"=> array(
				"label"=>"FIRST NAME",
				"rules"=>$rules['FIRST_NAME']
			),
			"last_name"=> array(
				"label"=>"LAST NAME",
				"rules"=>$rules['LAST_NAME']
			),
			"username"=> array(
				"label"=>"USERNAME",
				"rules"=>'required|min_length[3]'
			),
			"dob" =>array(
				"label" => "D.O.B",
				"rules" => $rules["DOB"]
			)

		);

		$userdetails = array(
			"FIRST_NAME"   => ucwords($first_name),
			"LAST_NAME"	   => ucwords($last_name),
			"DOB"		   => $dob,
			"USERNAME"	   => $username,
			"GENDER"	   => $gender
		);
		
		if(isset($_FILES['image'])){
			$admin_image = $this->uploadFilefunc($image_input_feild_name, 'image', $id, ADMINPROFILEFOLDER, 'adminprofile');
			if($admin_image){
				$userdetails['PROFILE_IMAGE'] = $admin_image;
			}
		}
		if ($this->validate($validation)) {
			$is_update = $user_model->updateUserdetails($userdetails, array('ID'=> $id));
			$error = false;
			if($is_update){
				$message = "SUCCESSFULLY UPDATED PROFILE";
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
	 * reset_password
	 *
	 * @return void
	 */
	public function reset_password(){
		$view['title'] = "RESET PASSWORD";
		$view['view'] = array('title'=>'team Details');
        $view['content'] = '/admin/reset-password';
		$view['data'] = array();
		return view('default', $view);
		
	}
	
	/**
	 * update_password
	 *
	 * @return void
	 */
	public function update_password(){
		$password = $this->request->getPost('password');
        $confirmpass  = $this->request->getPost('confirmpass');
		$user_model = new UserModel();
		$rules = $user_model->validationRules;
		$validation = array(
			
			"password"=> array(
				"label"=>"PASSWORD",
				"rules"=>$rules['PASSWORD']
			),
			"confirmpass"=> array(
				"label"=>"CONFIRM PASSWORD",
				"rules"=>'required|matches[password]'
			),
			

		);
		$id = session()->get('ID');
		if ($this->validate($validation)) {
			$is_update = $user_model->reset_password($password, array('ID'=> $id));
			$error = false;
			if($is_update){
				$message = "SUCCESSFULLY UPDATED PASSWORD";
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
