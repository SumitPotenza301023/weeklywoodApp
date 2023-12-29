<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ParticipantModel;
use App\Models\ContestModel;
use App\Models\NotificationModel;
use monken\TablesIgniter;
class Participant extends BaseController
{
	 
	
	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
        $view['content'] = "participant/index";
		$view['title'] = "participant";
        $contestModel = new ContestModel();
        $contests= $contestModel->get_all_contest(array());
        $activecontest = $contestModel->get_active_contest();
		$view['data'] = array('contests'=> $contests, 'active_contest' => $activecontest);
		return view('default', $view);
	}
    
    /**
     * contestparticipant
     *
     * @return void
     */
    public function contestparticipant(){
        $UserModel = new UserModel();
        $reviwers = $UserModel->getUserByRole('REVIEWER');
        $contest_id = $this->request->getVar("contest-id");
        $view['content'] = "participant/contestparticipant";
		$view['title'] = "contest participant";
        $view['data'] = array();
        $view['data']['reviwers'] = $reviwers;
        if(!empty($contest_id)){
            $ParticipantModel = new ParticipantModel();
            $participants = $ParticipantModel->get_contest_participants($contest_id);
            $view['data']['participants'] = $participants;
            
        }
        return view('default', $view);
    }
    
    /**
     * get_participant
     *
     * @return void
     */
    public function get_participant(){
        $contest_id = $this->request->getPost("contest_id");
        $ParticipantModel = new ParticipantModel();
		$table = new TablesIgniter($ParticipantModel->get_participant_details($contest_id));
    	return $table->getDatatable();
    }
    
    /**
     * participant_assign
     *
     * @return void
     */
    public function participant_assign(){
        $ParticipantModel = new ParticipantModel();
		$rules = $ParticipantModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"p_id"=> array(
				"label"=>"Participant ID",
				"rules"=> 'required|integer'
			),
			"reviewer"=> array(
				"label"=>"Reviewer",
				"rules"=> 'required|integer'
			)
		);
		if ($this->validate($validation)) {
           
			$is_updated = $ParticipantModel->assign_reviewer($p_id, $reviewer);
			if($is_updated){
				$error = false;
				$message = "ASSIGNED REVIEWER SUCCESSFULLY";
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
     * disqulaifyparticipant
     *
     * @return void
     */
    public function disqulaifyparticipant(){
        $ParticipantModel = new ParticipantModel();
		$rules = $ParticipantModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"p_id"=> array(
				"label"=>"Participant ID",
				"rules"=> 'required|integer'
			),
            "message" => array(
                "label" => "DisQualify Reason",
                "rules" => 'required'
            )
		);
        $messages = [
           'p_id' => [
               'required' => 'Participant Id is Required',
               'integer' => 'Please Enter Valid value'
           ],
           'message'=> [
               'required' => 'Please Enter Reason!',
              
           ]
       ];
		if ($this->validate($validation, $messages)) {
           
			$is_updated = $ParticipantModel->disqualifyparticipantwithreason($p_id, session()->get('ID'), $message);
			if($is_updated){
               
                $NotificationModel = new NotificationModel();
                $participantdetails = $ParticipantModel->get_contest_participantdetails($p_id);
                $message = 'You have been disqualified from contest '.$participantdetails['CONTEST_NAME'];
                $NotificationModel->create_notification($participantdetails['USER_ID'], 'DISQULIFIED', $message, 'SYSTEM' );
                $NotificationModel->create_notification($participantdetails['USER_ID'], 'DISQULIFIED', $message, 'PUSH', $this->get_device_tokonByid($participantdetails['USER_ID']) );
				$error = false;
				$message = "PARTICIPANT DISQUALIFIED SUCCESSFULLY!";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
			}else{
                $error = true;
                $message = "SOMETHING WENTWRONG!";
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error));
		}
    }
    
    /**
     * undisqualifyparticipant
     *
     * @return void
     */
    public function undisqualifyparticipant(){
         $ParticipantModel = new ParticipantModel();
		$rules = $ParticipantModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"p_id"=> array(
				"label"=>"Participant ID",
				"rules"=> 'required|integer'
			)
		);
        $messages = [
           'p_id' => [
               'required' => 'Participant Id is Required',
               'integer' => 'Please Enter Valid value'
           ]
       ];
		if ($this->validate($validation, $messages)) {
           
			$is_updated = $ParticipantModel->undisqualifyparticipant($p_id);
			if($is_updated){
				$error = false;
				$message = "PARTICIPANT UNDISQUALIFIED SUCCESSFULLY!";
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
     * update_score
     *
     * @return void
     */
    public function update_score(){
         $ParticipantModel = new ParticipantModel();
		$rules = $ParticipantModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		

        $rules = array(
            'participant_id' => 'required|integer|valid_participant_id[participant_id]',
            'score' => 'required|integer'
        );
        $message = array(
            'participant_id' => [
               'required' => 'Participant Id is Required',
               'integer' => 'Please Enter Valid value',
               'valid_participant_id' => 'Please Enter Valid value'
           ],
           'score' =>[
                'required' => 'Score is Required',
                'integer' => 'Please Enter Valid value',
           ]
        );
		if ($this->validate($rules, $message)) {
           
			$is_updated = $ParticipantModel->assign_score_supervisor($participant_id, $score, session()->get('ID'));
			if($is_updated){
				$error = false;
				$message = "SCORE UPDATED SCCUSSFULLY";
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
     * getParticipant
     *
     * @return void
     */
    public function getParticipant()
    {
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $ParticipantModel = new ParticipantModel();
       
        $rules = array(
            'participant_id' => 'required|integer|valid_participant_id[participant_id]'
        );
        $message = array(
            'participant_id' => [
               'required' => 'Participant Id is Required',
               'integer' => 'Please Enter Valid value',
               'valid_participant_id' => 'Please Enter Valid value'
           ],
        );
        if ($this->validate($rules, $message )) {
            $get_participant_details = $ParticipantModel->get_participant_detailsByidadmin($participant_id);

            if(!empty($get_participant_details)){
                $error  =  false;
                $message = array('success'=>"SUCCESSFULLY FATECHED PARTICIPANTS TO REVIEW");
                echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $get_participant_details, 'status' => 200));
            }
            $this->somethingwentwrong();
            
           
        }else{
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error , 'status'=> 422));    
        }
    }
    
    /**
     * change_status
     *
     * @return void
     */
    public function change_status(){
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $ParticipantModel = new ParticipantModel();
       
        $rules = array(
            'participant_id' => 'required|integer|valid_participant_id[participant_id]',
            'status' => 'required'
        );
        $message = array(
            'participant_id' => [
               'required' => 'Participant Id is Required',
               'integer' => 'Please Enter Valid value',
               'valid_participant_id' => 'Please Enter Valid value'
           ],
           'status' =>[
               'required' => 'Changed status in Required'
           ]
        );
        if ($this->validate($rules, $message )) {
            $get_participant_details = $ParticipantModel->change_status($participant_id, $status);

            if(!empty($get_participant_details)){
                $error  =  false;
                $message = "SUCCESSFULLY CHANGES STATUS TO ".$status;
                echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $get_participant_details, 'status' => 200));
            }
            $this->somethingwentwrong();
            
           
        }else{
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error , 'status'=> 422));    
        }
    }
    
    /**
     * get_selected_participant
     *
     * @return void
     */
    public function get_selected_participant(){
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $ParticipantModel = new ParticipantModel();
        $rules = array(
            'checks' => 'required'
        );
        $message = array(
            'checks' => [
               'required' => 'Please Select Checkbox for this action!'
           ],
          
        );
        if ($this->validate($rules, $message )) {

            $get_participant_details = array(); 
            foreach($checks as $participant_id){
                $participant= $ParticipantModel->get_participant_detailsByidadmin($participant_id);
                array_push($get_participant_details, $participant);
            }

            if(!empty($get_participant_details)){
                $error  =  false;
                $message = array('success'=>"SUCCESSFULLY FATECHED PARTICIPANTS TO REVIEW");
                echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $get_participant_details, 'status' => 200));
            }
            $this->somethingwentwrong();
            
           
        }else{
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error , 'status'=> 422));    
        }
    }
    
    /**
     * assign_bulk_reviewer
     *
     * @return void
     */
    public function assign_bulk_reviewer(){
        $ParticipantModel = new ParticipantModel();
		$rules = $ParticipantModel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"participant_id"=> array(
				"label"=>"Participant ID",
				"rules"=> 'required'
			),
			"reviewer"=> array(
				"label"=>"Reviewer",
				"rules"=> 'required|integer'
			)
		);
		if ($this->validate($validation)) {
            $is_updated = false;
            foreach($participant_id as $participant){
                $is_updated = $ParticipantModel->assign_reviewer($participant, $reviewer);
                if($is_updated){
                    $is_updated = true;
                }else{
                    $is_updated = false;
                    break;
                }
            }
			
			if($is_updated){
				$error = false;
				$message = "ASSIGNED REVIEWER SUCCESSFULLY";
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
