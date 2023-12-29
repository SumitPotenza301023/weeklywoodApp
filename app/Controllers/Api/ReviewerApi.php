<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\ParticipantModel;
use App\Models\CommentsModel;
/**
 * API REFERENCE
 * https://documenter.getpostman.com/view/14423652/UVXqFD1Q#intro
 */

/**
 * UserApi
 */
class ReviewerApi extends BaseController {
    
    /**
     * __construct
     *
     * @return void
     */
    function __construct()
    {
       $this->api_access();
       $this->is_reviwer();
    }
    
    /**
     * get_user_score
     *
     * @return void
     */
    public function get_user_score(){
        $ParticipantModel = new ParticipantModel();
        $participants =  $ParticipantModel->get_users_to_review($this->user_id);
        if(!empty($participants)){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FATECHED PARTICIPANTS TO REVIEW");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $participants, 'status' => 200));
        }else{
            $error  =  true;
            $message = array('error'=>"NO PARTICIPANT FOUND TO REVIEW");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error,  'status' => 422));
        }
    }
    
    /**
     * get_participant_details
     *
     * @return void
     */
    public function get_participant_details(){
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $ParticipantModel = new ParticipantModel();
        $CommentsModel = new CommentsModel();
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
            $get_participant_details = $ParticipantModel->get_participant_detailsByid($participant_id);
            $comments = $CommentsModel->get_participant_comments($participant_id);
            $get_participant_details['COMMENTS']= $comments;
            if(!empty($get_participant_details)){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FATECHED PARTICIPANTS TO REVIEW");
            echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data' => $get_participant_details, 'status' => 200));
            }
            $this->somethingwentwrong();
            
           
        }else{
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));    
        }
    }
        
    /**
     * give_score
     *
     * @return void
     */
    public function give_score(){
        $post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
        $ParticipantModel = new ParticipantModel();
        $CommentsModel = new CommentsModel();
        $rules = array(
            'participant_id' => 'required|integer|valid_participant_id[participant_id]',
            'score' => 'required|numeric'
        );
        $message = array(
            'participant_id' => [
               'required' => 'Participant Id is Required',
               'integer' => 'Please Enter Valid value',
               'valid_participant_id' => 'Please Enter Valid value'
           ],
           'score' => [
               'required' => 'Score is Required',
               'numeric' => 'Please Enter Valid Value'
           ]
        );
        if ($this->validate($rules, $message )) {
            $assign_score = $ParticipantModel->assign_score($participant_id, $score);
            if(!empty($assign_score)){
                if(isset($comment) && !empty($comment)){
                    $CommentsModel = new CommentsModel();
                    $comment_post = array(
                        "COMMENT_PARTICIPANT_ID" => $participant_id,
                        'COMMENT_AUTHOR_ID' => $this->user_id,
                        'COMMENT_CONTENT' => $comment
                    );
                    if(isset($parent_comment) && !empty($parent_comment)){
                        $comment_post['PARENT_COMMENT_ID'] = $parent_comment;
                    }
                    $post_comment = $CommentsModel->post_comment($comment_post);
                }
                $error  =  false;
                $message = array('success'=>"SUCCESSFULLY SCORE ASSIGNED");
                echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'status' => 200));
            }
            $this->somethingwentwrong();
            
           
        }else{
            $error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validator->getErrors(), 'error'=> $error , 'status'=> 422));    
        }
    }
    

   
}