<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\ParticipantModel;
use App\Models\ContestModel;
use App\Models\PaymentModel;
use App\Models\NotificationModel;
use App\Models\ContestResultModel;
/**
 * API REFERENCE
 * https://documenter.getpostman.com/view/14423652/UVXqFD1Q#intro
 */



/**
 * ContestApi
 */
class ContestApi extends BaseController {
    
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
     * JoinContest
     *
     * @return void
     */
    public function JoinContest()
    {
        $post = $this->request->getPost();
        foreach ($post as $key => $value) {
            ${$key} = $value;
        }
        $ParticipantModel = new ParticipantModel();
        $PaymentModel = new PaymentModel();
        $ContestModel = new ContestModel();
        if ($this->validate($ParticipantModel->get_api_rules(), $ParticipantModel->get_api_message())) {
            if ($ParticipantModel->already_joined($this->user_id, $contest_id)) {
                $error = true;
                $message = array('error' => "User Is already Joined");
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 422));
            }
            $contest = $ContestModel->get_contest_points($contest_id);
            if ($contest) {
                if ($PaymentModel->check_user_wallet($this->user_id, $contest['CONTEST_POINTS'])) {

                    $join_contest = array(
                        'CONTEST_ID' => $contest_id,
                        'USER_ID' => $this->user_id,
                        'VIDEO_URL' => $video_url,
                        'SCORE' => $score
                    );
                    $join_contest = $ParticipantModel->join_contest($join_contest);
                    if ($join_contest) {
                        $result = $PaymentModel->update_wallet($this->user_id, $contest['CONTEST_POINTS'], true);
                        if ($result) {
                            $NotificationModel = new NotificationModel();
                            $message = 'Your Wallet has been Debited with ' . $contest['CONTEST_POINTS'] . ' Points';
                            $NotificationModel->create_notification($this->user_id, 'REGISTERED IN CONTEST', $message, 'SYSTEM');
                            $NotificationModel->create_notification($this->user_id, 'REGISTERED IN CONTEST', $message, 'PUSH', $this->get_device_tokon());

                            $error  =  false;
                            $message = array('success' => "REGISTERED IN CONTEST SUCCESSFULLY!");
                            echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'status' => 200));
                        } else {
                            $this->somethingwentwrong();
                        }
                    } else {
                        $this->somethingwentwrong();
                    }
                } else {
                    $error = true;
                    $message = array('error' => "Please Check Your Point Balance!");
                    echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 504));
                }
            } else {
                $this->somethingwentwrong();
            }
        } else {
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error, 'status' => 422));
        }
    }
    
    /**
     * contests
     *
     * @return void
     */
    public function contests(){
        $rank = array();
        $completedcontest = array();
        $ContestModel = new ContestModel();
        $contest = $ContestModel->get_active_contest();
        $ParticipantModel = new ParticipantModel();

        if(!empty($contest)){
            $contest['IS_REGISTERED']  = FALSE; 
            if($ParticipantModel->already_joined($this->user_id, $contest['C_ID'])){
                 $contest['IS_REGISTERED']  = TRUE;
            }
            $rank = $ParticipantModel->active_score($contest['C_ID']);
            $contest['DAYS_REMAINING'] = $this->date_diff($contest['END_DATE']);
            if (!empty($contest['CONTEST_BANNER'])) {
                $contest['CONTEST_BANNER'] = base_url() . CONTESTBANNERFOLDERPATH . '/' . $contest['C_ID'] . '/' . $contest['CONTEST_BANNER'];
            } else {
                $contest['CONTEST_BANNER'] = NULL;
            }
            if (!empty($contest['CONTEST_PDF'])) {
                $contest['CONTEST_PDF'] = base_url() . CONTESTPDFFOLDERPATH . '/' . $contest['C_ID'] . '/' . $contest['CONTEST_PDF'];
            } else {
                $contest['CONTEST_PDF'] = NULL;
            }
            
            $nextcontest = $ContestModel->getnextcontest($contest['END_DATE']);
            if(!empty($nextcontest)){
                $contest['COMINGSOON']= $nextcontest['START_DATE'];
            }
        }
        else{
            $contest = array('message' => 'No Contest Found');
        }
        
        $completedcontest = $ContestModel->get_completed_contest();
        foreach($completedcontest as $key=>$contestdata){
            
            $completedcontest[$key]['ENTRIES'] = $ParticipantModel->participant_count_in_contest($contestdata['C_ID']);
           // $completedcontest[$key]['CONTEST_BANNER'] =  base_url().CONTESTBANNERFOLDERPATH.'/'.$contestdata['C_ID'].'/'.$contestdata['CONTEST_BANNER'];
        }
        $contestresult['contest'] = $contest;
        $contestresult['rank'] = $rank;
        $contestresult['completedcontest'] = $completedcontest; 
        if(!empty($contestresult)){
            $error  =  false;
            $message = array('success'=>"CONTEST DETAILS FATCHED");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $contestresult, 'status' => 200));
        }else{
          $this->somethingwentwrong();
        }
        
    }
    
    /**
     * current_contest
     *
     * @return void
     */
    public function current_contest(){
        $rank = array();
        $completedcontest = array();
        $ContestModel = new ContestModel();
        $contest = $ContestModel->get_active_contest();
      
        if(!empty($contest)){
           
            $ParticipantModel = new ParticipantModel();
            $rank = $ParticipantModel->active_score_leaderboad($contest['C_ID']);
         
            if($rank){
                $contestresult = $rank;
            }else{
              
                $error  =  true;
                $message = array('error'=>"No Participant Found!");
                echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 404));


            }
        }
        else{
            $contest = array('message' => 'No Participant Found');
        }
        
        if(!empty($contestresult)){
            $error  =  false;
            $message = array('success'=>"LeaderBoard Details Fateched!");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $contestresult, 'status' => 200));
        }else{
          $this->somethingwentwrong();
        }
    }
    
    /**
     * contest_archive
     *
     * @return void
     */
    public function contest_archive(){
        $ContestModel = new ContestModel();
        $ContestResultModel = new ContestResultModel();
        $contests['contest_result'] = $ContestResultModel->get_contest_archive();
        if(!empty($contests)){
            $error  =  false;
            $message = array('success'=>"Contest Archive Fetched!");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $contests, 'status' => 200));
        }else{
          $this->somethingwentwrong();
        }

    }
    
    /**
     * current_submission
     *
     * @return void
     */
    public function current_submission(){
        $ContestModel = new ContestModel();
        $contest = $ContestModel->get_active_contest();
        
        if(empty($contest)){
            $error  =  true;
            $message = array('error'=>"No Active Contest Found!");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 404));
        }
        $ParticipantModel = new ParticipantModel();
        $user_submissions = $ParticipantModel->user_contest_submission($this->user_id, $contest['C_ID']);
        if(empty($user_submissions)){
            $error  =  true;
            $message = array('error'=>"No Submission Found For Active Contest Found!");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 404));
        }else{
            if (!empty($user_submissions['CONTEST_BANNER'])) {
                $user_submissions['CONTEST_BANNER'] = base_url() . CONTESTBANNERFOLDERPATH . '/' . $user_submissions['CONTEST_ID'] . '/' . $user_submissions['CONTEST_BANNER'];
            } else {
                $user_submissions['CONTEST_BANNER'] = null;
            }
            $error  =  false;
            $message = array('success'=>"Successfully Fateched Submission!");
            echo $this->sendResponse(array('success' => true, 'message' => $message, 'error'=>$error, 'data'=>$user_submissions, 'status' => 200));
        }

        
    }

    /**
     * getContest
     *
     * @return void
     */
    public function getContest()
    {
        $ContestModel = new ContestModel();
        $post = $this->request->getPost();
        foreach ($post as $key => $value) {
            ${$key} = $value;
        }
        $rules = array(
            'contest_id' => 'required|integer'
        );
        $message = array(
            'contest_id' => [
                'required' => 'Contest Id is Required',
                'integer' => 'Please Enter Valid value'
            ],
        );
        if ($this->validate($rules, $message)) {
            $contest_details = $ContestModel->get_contest_score_type(array('C_ID' => $contest_id));
            if (empty($contest_details)) {
                $error  =  true;
                $message = array('error' => "no contest found!");
                echo $this->sendResponse(array('success' => false, 'message' => $message, 'error' => $error, 'status' => 404));
            }
            if (!empty($contest_details['CONTEST_BANNER'])) {
                $contest_details['CONTEST_BANNER'] = base_url() . CONTESTBANNERFOLDERPATH . '/' . $contest_details['C_ID'] . '/' . $contest_details['CONTEST_BANNER'];
            } else {
                $contest_details['CONTEST_BANNER'] = null;
            }
            if (!empty($contest_details['CONTEST_PDF'])) {
                $contest_details['CONTEST_PDF'] = base_url() . CONTESTPDFFOLDERPATH . '/' . $contest_details['C_ID'] . '/' . $contest_details['CONTEST_PDF'];
            } else {
                $contest_details['CONTEST_PDF'] = null;
            }
            $error  =  false;
            $message = array('success' => "Successfully Fateched Contest!");
            echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'data' => $contest_details, 'status' => 200));
        } else {
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error, 'status' => 422));
        }
    }

    /**
     * editContest
     *
     * @return void
     */
    public function editContest()
    {
        $post = $this->request->getPost();
        foreach ($post as $key => $value) {
            ${$key} = $value;
        }
        $ParticipantModel = new ParticipantModel();

        if ($this->validate($ParticipantModel->get_api_rules_edit(), $ParticipantModel->get_api_message_edit())) {
            $join_contest = array(
                'VIDEO_URL' => $video_url,
                'SCORE' => $score
            );
            $join_contest = $ParticipantModel->editcontest($join_contest, $p_id);
            if ($join_contest) {
                $error  =  false;
                $message = array('success' => "CONTEST RESUBMITTED SUCCESSFULLY!");
                echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'status' => 200));
            } else {
                $this->somethingwentwrong();
            }
        } else {
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error, 'status' => 422));
        }
    }

    /**
     * deleteParticipant
     *
     * @return void
     */
    public function deleteParticipant()
    {
        $post = $this->request->getPost();
        foreach ($post as $key => $value) {
            ${$key} = $value;
        }
        $validation = array(
            "p_id"        => 'required|integer',
            "contest_id"   => 'required|integer'

        );
        $messages = [
            'p_id' => [
                'required' => 'Participant Id is Required',
                'integer' => 'Please Enter Valid value'
            ],
            'contest_id' => [
                'required' => 'Contest Id is Required',
                'integer' => 'Please Enter Valid value'
            ]
        ];
        $ParticipantModel = new ParticipantModel();
        $PaymentModel = new PaymentModel();
        $ContestModel = new ContestModel();

        if ($this->validate($validation, $messages)) {
            $contest = $ContestModel->get_contest_points($contest_id);
            if ($contest) {
                $join_contest = $ParticipantModel->deleteParticipant($p_id);
                if ($join_contest) {
                    $result = $PaymentModel->update_wallet($this->user_id, $contest['CONTEST_POINTS'], false);
                    $NotificationModel = new NotificationModel();
                    $message = 'Your Wallet has been Credited  with ' . $contest['CONTEST_POINTS'] . ' Points';
                    $NotificationModel->create_notification($this->user_id, 'REFUND FOR CONTEST', $message, 'SYSTEM');
                    $NotificationModel->create_notification($this->user_id, 'REFUND FOR CONTEST', $message, 'PUSH', $this->get_device_tokon());

                    $error  =  false;
                    $message = array('success' => "CONTEST ENTRY DELETED SUCCESSFULLY!");
                    echo $this->sendResponse(array('success' => true, 'message' => $message, 'error' => $error, 'status' => 200));
                } else {
                    $this->somethingwentwrong();
                }
            } else {
                $this->somethingwentwrong();
            }
        } else {
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error' => $error, 'status' => 422));
        }
    }
    

}