<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Deleteuseraccount extends BaseController
{
    public function index()
    {
        return view('delete-account');
    }

    /**
	 * delete_user
	 *
	 * @return void
	 */
	public function delete_account()
	{
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		helper(['form', 'url']);
		$rules = array(
            'email' => 'required',
            'password' => 'required',
        );
		$userModel = new UserModel();
		if ($this->validate($rules, $userModel->get_api_message())) {
			if ($userModel->authenticate($email, md5($password), '4') == true) {				
				$userData = $userModel->getUserbyEmail($email);
				$data = [
					'id' => $userData['ID'],
					'email' => $email
				];

				$userDelete = $userModel->deleteUser($data);

				if ($userDelete) {
					$error  =  false;
					$message = "USER DELETED SUCCESSFULLY!";
					$session = \Config\Services::session();
					$session->setFlashdata('success', 'USER DELETED SUCCESSFULLY!');
					echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'status' => 200));
				} else {
					$this->somethingwentwrong();
				}
			} else {
				$error = true;
				$message = array('error' => "Please Enter Valid Cridentials!");
				echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 403));
			}
		}else{
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error));
		}
	}
}
