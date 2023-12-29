<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\ContestResultModel;

/**
 * API REFERENCE
 * https://documenter.getpostman.com/view/14423652/UVXqFD1Q#intro
 */

class ParticipantHistory extends BaseController {
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
       $this->api_access();
    }
    
    /**
     * participanthistory
     *
     * @return void
     */
    public function participanthistory()
    {
        $ContestResultModel = new ContestResultModel();
        $result = array();
        $rank1 = $ContestResultModel->get_user_rank($this->user_id, 1);
        $rank2 = $ContestResultModel->get_user_rank($this->user_id, 2);
        $rank3 = $ContestResultModel->get_user_rank($this->user_id, 3);
        $result['rank1_count'] = count($rank1);
        $result['rank2_count'] = count($rank2);
        $result['rank3_count'] = count($rank3);
        $result['rank1'] = $rank1;
        $result['rank2'] = $rank2;
        $result['rank3'] = $rank3;
        $result['participated'] = $ContestResultModel->participated($this->user_id);
      
        if(!empty($result)){
            $error  =  false;
            $message = array('success'=>"SUCCESSFULLY FATECHED YOUR DETAILS");
            echo $this->sendResponse(array('success' => true, 'message' => $message, 'data'=>$result,  'error'=>$error, 'status' => 200));
        }else{
            $error = true;
            $message =  array('error'=>"SOMETHING WENT WRONG");
            echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 500));

        }
        
        
    }

}

?>