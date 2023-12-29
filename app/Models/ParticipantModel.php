<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\UserModel;
use App\Models\ContestModel;



/**
 * PromocodeModel
 */
class ParticipantModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_participant';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'P_ID';
    
    /**
     * useAutoIncrement
     *
     * @var bool
     */
    protected $useAutoIncrement = true;
    
    /**
     * returnType
     *
     * @var string
     */
    protected $returnType     = 'array';    
    /**
     * useSoftDeletes
     *
     * @var bool
     */
    protected $useSoftDeletes = true;
    
    /**
     * allowedFields
     *
     * @var array
     */
    protected $allowedFields = [
                                'P_ID',
                                'CONTEST_ID',  
                                'USER_ID',
                                'VIDEO_URL',
                                'SCORE',
                                'DISQULIFID',
                                'APPROVED_REJECTED',
                                'REVIEWER_ID',
                                'LAST_UPDATED_BY'
                                ];
    
    /**
     * useTimestamps
     *
     * @var bool
     */
    protected $useTimestamps = false;    
    /**
     * createdField
     *
     * @var string
     */
    protected $createdField  = 'CREATED_AT';    
    /**
     * updatedField
     *
     * @var string
     */
    protected $updatedField  = 'UPDATED_AT';
    
    /**
     * validationRules
     *
     * @var array
     */
    protected $validationRules = [
                                'CONTEST_ID' => 'required|integer',  
                                'USER_ID' => 'required|integer',
                                'VIDEO_URL' =>  'required|valid_url',
                                'SCORE' => 'integer',
                                'DISQULIFID' => 'required|integer' ,
                                'APPROVED_REJECTED' => 'required|integer',
                                'REVIEWER_ID' => 'required|integer',
                                'LAST_UPDATED_BY' => 'required|integer'
                                ];    
    /**
     * validationMessages
     *
     * @var array
     */
    protected $validationMessages = [];    
    /**
     * skipValidation
     *
     * @var bool
     */
    protected $skipValidation     = false;

    /**
     * get_api_rules
     *
     * @return void
     */
    public function get_api_rules(){
        $validation = array(
			"contest_id"  => $this->validationRules['CONTEST_ID'],
			"video_url"   => $this->validationRules["VIDEO_URL"],
            "score"       => $this->validationRules["SCORE"]

        );
        return $validation;
    }
    /**
     * get_api_rules_edit
     *
     * @return void
     */
    public function get_api_rules_edit()
    {
        $validation = array(
            "p_id"        => 'required|integer',
            "video_url"   => $this->validationRules["VIDEO_URL"],
            "score"       => $this->validationRules["SCORE"]

        );
        return $validation;
    }
    /**
     * get_api_message_edit
     *
     * @return void
     */
    public function get_api_message_edit()
    {
        $messages = [
            'p_id' => [
                'required' => 'Participant Id is Required',
                'integer' => 'Please Enter Valid value'
            ],
            'video_url' => [
                'required' => 'Video Url Is Required',
                'valid_url' => 'Please Enter Valid Url'
            ],
            'score' => [
                'required' => 'Score is Required'
            ]
        ];
        return $messages;
    }
    /**
     * get_api_message
     *
     * @return array
     */
    public function get_api_message(){
        $messages = [
           'contest_id' => [
               'required' => 'Contest Id is Required',
               'integer' => 'Please Enter Valid value'
           ],
           'video_url'=> [
               'required' => 'Video Url Is Required',
               'valid_url' => 'Please Enter Valid Url'
            ],
            'score' => [
                'required' => 'Score is Required'
            ]
       ];
       return $messages;
    }
    
    /**
     * join_contest
     *
     * @param  mixed $contest
     * @return void
     */
    public function join_contest($contest ){
        $result = $this->db->table($this->table)->insert($contest);
        return  $this->db->insertID();
    }

    /**
     * editcontest
     *
     * @param  mixed $contest_details
     * @param  mixed $participant_id
     * @return void
     */
    public function editcontest($contest_details,  $participant_id)
    {
        return $this->db->table($this->table)
            ->set($contest_details)
            ->where(array('P_ID' => $participant_id))
            ->update();
    }

    /**
     * deleteParticipant
     *
     * @param  mixed $participant_id
     * @return void
     */
    public function deleteParticipant($participant_id)
    {
        return $this->db->table($this->table)
            ->where(array('P_ID' => $participant_id))
            ->delete();
    }
    
    /**
     * already_joined
     *
     * @param  mixed $user_id
     * @param  mixed $contest_id
     * @return void
     */
    public function already_joined($user_id, $contest_id){
        $result = $this->db->table($this->table)->where(array('CONTEST_ID'=> $contest_id, 'USER_ID'=>$user_id));
        if($result->countAllResults()>0){
            return true;
        }
        return false;
    }
    
    /**
     * get_contest_participants
     *
     * @param  mixed $contest_id
     * @return void
     */
    public function get_contest_participants($contest_id){
        $result = $this->db->table($this->table)->where(array('CONTEST_ID'=> $contest_id));
        return $result->get()->getResultArray();
    }
    
    /**
     * get_participant_details
     *
     * @param  mixed $contest_id
     * @return void
     */
    public function get_participant_details($contest_id){
      
        $builder = $this->db->table($this->table)
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left')
                            ->where(array('CONTEST_ID'=> $contest_id, 'BLOCK' => 'NO', 'tbl_user_master.status'=> '1'));
       
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["P_ID","DESC"],
                ["FIRST_NAME","DESC"],
                ["SCORE","DESC"],
                ["DISQULIFID","DESC"],
                ["VIDEO_URL","DESC"],
                ["APPROVED_REJECT","DESC"]
            ],
            "setSearch" => ["FIRST_NAME","SCORE","DISQULIFID","VIDEO_URL","APPROVED_REJECT"],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                 function($row){
                   
                    return <<<EOF
                           <div class="custom-checkbox custom-control">
                            <input type="checkbox" name='participant[]'  data-id={$row['P_ID']} data-checkboxes="mygroup" class="custom-control-input drp_checks_participant"
                              id="checkbox-{$row['P_ID']}" value='{$row['P_ID']}'>
                            <label for="checkbox-{$row['P_ID']}" class="custom-control-label">&nbsp;</label>
                          </div>
                    EOF;
                },
                "FIRST_NAME",
                function($row){
                    $score = "Not Yet Added";
                    if($row['SCORE']!=""){    
                        $score = $row['SCORE'];
                    }
                    return <<<EOF
                            <div style="font-size: 20px;" ><span class="score">{$score}<span></div>
                    EOF;
                },
                
                function($row){
                    return <<<EOF
                           <a href='{$row['VIDEO_URL']}'> View Video </a>
                    EOF;
                },
                function($row){
                    if($row['REVIEWER_ID'] == ""){
                        return <<<EOF
                        <button class="btn btn-primary btnassignreviewer" data-name='{$row["FIRST_NAME"]}' data-id='{$row["P_ID"]}' data-toggle="modal" data-target=".bd-assignreviewer-modal-lg" >ASSIGN</button>
                        EOF;
                    }
                    $user = $this->db->table('tbl_user_master')->select('FIRST_NAME, ID')->where(array('BLOCK' => 'NO', 'status'=> '1', 'ID' => $row['REVIEWER_ID']))->get()->getRowArray();
                    return <<<EOF
                             <div class="badge badge-primary badge-shadow">{$user['FIRST_NAME']}</div>
                    EOF;
                   
                },
                 function($row){
                    $status = array('PENDING', 'CHANGES', 'APPROVED', 'DECLINED');
                    $select =  "<select class='form-control drp_accept_reject' data-id='{$row["P_ID"]}'>";
                    if($row['APPROVED_REJECT'] == 'APPROVED'){
                        $select =  "<select class='form-control drp_accept_reject' data-id='{$row["P_ID"]}' disabled>";
                    }
                    foreach($status as $stat){
                        if($stat === $row['APPROVED_REJECT']){
                            $select .= '<option value='.$stat.' selected>'.$stat.'</option>';
                        }else{
                            $select .= '<option value='.$stat.'>'.$stat.'</option>';
                        } 
                    }
                    $select .=  "</select>";
                    return <<<EOF
                       {$select}
                    EOF;
                },
                function($row){
                   
                    $disqua = "<button class='btn btn-danger btnundisqualify' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='Vivamus
                    sagittis lacus vel augue laoreet rutrum faucibus.' data-id='{$row["P_ID"]}' style='font-size: 20px;'><i class='fas fa-check-circle'></i></button>";;
                     if($row['DISQULIFID'] == 0){
                        
                        $disqua ="<button class='btn btn-info btndisqualify' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='Vivamus
                    sagittis lacus vel augue laoreet rutrum faucibus.' data-id='{$row["P_ID"]}' style='font-size: 20px;'><i class='fas fa-ban'></i></button>";
                        
                    }
                    
                    return <<<EOF
                        <button class="btn btn-outline-primary btnparticipantdetails" data-id='{$row["P_ID"]}' data-toggle="modal" data-target=".bd-participantdetails-modal-lg" >Details</button>
                        {$disqua}
                      
                    EOF;
                }
            ]
        ];
        return $setting;

    }
    
    /**
     * assign_reviewer
     *
     * @param  mixed $p_id
     * @param  mixed $r_id
     * @return void
     */
    public function assign_reviewer($p_id, $r_id){
         return $this->db->table($this->table)
                       ->set(array('REVIEWER_ID' => $r_id))
                       ->where(array('P_ID'=> $p_id))
                       ->update();
    }
    
    /**
     * get_users_to_review
     *
     * @param  mixed $user_id
     * @return void
     */
    public function get_users_to_review($reviewer){
        $condition = array('REVIEWER_ID'=> $reviewer, 'tbl_user_master.status'=> '1', 'DISQULIFID' => '0');
        $ContestModel = new ContestModel();
        $active_contest = $ContestModel->get_active_contest();
        if(!empty($active_contest)){
            $condition['CONTEST_ID'] = $active_contest['C_ID'];
        }
        $builder = $this->db->table($this->table)
            ->select('P_ID, FIRST_NAME,PROFILE_IMAGE, tbl_user_master.ID AS USER_ID, SCORE, APPROVED_REJECT, REVIEWER_SCORE_STATUS')
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left')
                            ->where($condition);
        $result = $builder->get()->getResultArray();
        foreach ($result as $key => $user_details) {
            if ($user_details['PROFILE_IMAGE'] != '') {
                $result[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user_details['USER_ID'] . '/' . $user_details['PROFILE_IMAGE'];
            }
        }
        return $result;
    }
    /**
     * last_query
     *
     * @return void
     */
    public function last_query(){
        $query =  $this->db->getLastQuery();
        return $query->getQuery();
    }
        
    /**
     * get_users_to_review_all
     *
     * @return void
     */
    public function get_users_to_review_all(){
        $builder = $this->db->table($this->table)
            ->select('P_ID, FIRST_NAME, SCORE,PROFILE_IMAGE,tbl_user_master.ID AS USER_ID, APPROVED_REJECT, REVIEWER_SCORE_STATUS')
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left')
                            ->where(array('tbl_user_master.status'=> '1', 'DISQULIFID' => '0'));
        $result =  $builder->get()->getResultArray();
        foreach ($result as $key => $user_details) {
            if ($user_details['PROFILE_IMAGE'] != '') {
                $result[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user_details['USER_ID'] . '/' . $user_details['PROFILE_IMAGE'];
            }
        }
        return $result;
    }
    
    /**
     * get_participant_detailsByid
     *
     * @param  mixed $p_id
     * @return void
     */
    public function get_participant_detailsByid($p_id){
        $builder = $this->db->table($this->table)
            ->select('P_ID, FIRST_NAME, SCORE, APPROVED_REJECT, tbl_participant.VIDEO_URL, tbl_participant.CREATED_AT as SUBMITED_AT, tbl_participant.LAST_UPDATED_BY,tbl_participant.REVIEWER_ID,  tbl_score_type.NAME as SCORE_TYPE')
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left')
                            ->join('tbl_contest', 'tbl_contest.C_ID='.$this->table.'.CONTEST_ID', 'left')
                            ->join('tbl_score_type', 'tbl_score_type.ST_ID=tbl_contest.SCORE_TYPE', 'left')
                            ->where(array('P_ID'=> $p_id, 'tbl_user_master.status'=> '1', 'DISQULIFID' => '0'));
        $participant = $builder->get()->getRowArray();
        if(isset($participant['PROFILE_IMAGE']) && !empty($participant['PROFILE_IMAGE'])){
			$participant['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$participant['ID'].'/'.$participant['PROFILE_IMAGE'];
        }
       
        if (isset($participant['LAST_UPDATED_BY']) && !empty($participant['LAST_UPDATED_BY'])) {
            $UserModel = new UserModel();
            $participant['LAST_REVIEWER_NAME'] = null;
            $participant['LAST_REVIEWER_PROFILE_IMAGE'] = null;
            $get_reviewer_details = $UserModel->get_user_by_id($participant['LAST_UPDATED_BY']);
            if (!empty($get_reviewer_details)) {
                $participant['LAST_REVIEWER_NAME'] = $get_reviewer_details['FIRST_NAME'];
                $participant['LAST_REVIEWER_PROFILE_IMAGE'] = NULL;
                if(!empty($get_reviewer_details['PROFILE_IMAGE'])){
                     $participant['LAST_REVIEWER_PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $get_reviewer_details['ID'] . '/' . $get_reviewer_details['PROFILE_IMAGE'];
                }
            }
        } else {
            $UserModel = new UserModel();
            $participant['LAST_REVIEWER_NAME'] = null;
            $participant['LAST_REVIEWER_PROFILE_IMAGE'] = null;
            $get_reviewer_details = $UserModel->get_user_by_id($participant['REVIEWER_ID']);
            if (!empty($get_reviewer_details)) {
                $participant['LAST_REVIEWER_NAME'] = $get_reviewer_details['FIRST_NAME'];
                $participant['LAST_REVIEWER_PROFILE_IMAGE'] = NULL;
                if (!empty($get_reviewer_details['PROFILE_IMAGE'])) {
                    $participant['LAST_REVIEWER_PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $get_reviewer_details['ID'] . '/' . $get_reviewer_details['PROFILE_IMAGE'];
                }
            }
        }
       
        return $participant;
    }
    
    /**
     * get_participant_detailsByidSupervisour
     *
     * @param  mixed $p_id
     * @return void
     */
    public function get_participant_detailsByidSupervisour($p_id){
        $builder = $this->db->table($this->table)
                            ->select('P_ID, FIRST_NAME, SCORE, APPROVED_REJECT,REVIEWER_ID, tbl_participant.VIDEO_URL, tbl_participant.CREATED_AT as SUBMITED_AT ,tbl_participant.UPDATED_AT as SCORE_SUBMITTED_AT, tbl_score_type.NAME as SCORE_TYPE')
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left')
                            ->join('tbl_contest', 'tbl_contest.C_ID='.$this->table.'.CONTEST_ID', 'left')
                            ->join('tbl_score_type', 'tbl_score_type.ST_ID=tbl_contest.SCORE_TYPE', 'left')
                            ->where(array('P_ID'=> $p_id, 'tbl_user_master.status'=> '1', 'DISQULIFID' => '0'));
        $participant = $builder->get()->getRowArray();
        if(isset($participant['PROFILE_IMAGE']) && !empty($participant['PROFILE_IMAGE'])){
			$participant['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$participant['ID'].'/'.$participant['PROFILE_IMAGE'];
        }
        $UserModel = new UserModel();
        $get_reviewer_details = $UserModel->get_user_by_id($participant['REVIEWER_ID']);
        if(!empty($get_reviewer_details)){
            $participant['REVIEWER_NAME'] = $get_reviewer_details['FIRST_NAME'];
        }
        return $participant;
    }
    
    public function get_contest_participantdetails($p_id){
        return $this->db->table($this->table)->where('P_ID', $p_id)->join('tbl_contest', 'tbl_contest.C_ID='.$this->table.'.CONTEST_ID', 'left')->get()->getRowArray();
    }
    /**
     * get_participant_detailsByidadmin
     *
     * @param  mixed $p_id
     * @return void
     */
    public function get_participant_detailsByidadmin($p_id){
        $builder = $this->db->table($this->table)
                            ->select('P_ID, FIRST_NAME, SCORE, APPROVED_REJECT,REVIEWER_ID, tbl_participant.VIDEO_URL, tbl_participant.CREATED_AT as SUBMITED_AT ,tbl_participant.UPDATED_AT as SCORE_SUBMITTED_AT, tbl_score_type.NAME as SCORE_TYPE')
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left')
                            ->join('tbl_contest', 'tbl_contest.C_ID='.$this->table.'.CONTEST_ID', 'left')
                            ->join('tbl_score_type', 'tbl_score_type.ST_ID=tbl_contest.SCORE_TYPE', 'left')
                            ->where(array('P_ID'=> $p_id, 'tbl_user_master.status'=> '1'));
        $participant = $builder->get()->getRowArray();
        if(isset($participant['PROFILE_IMAGE']) && !empty($participant['PROFILE_IMAGE'])){
			$participant['PROFILE_IMAGE'] = base_url().USERPROFILEIMAGEPATH.'/'.$participant['ID'].'/'.$participant['PROFILE_IMAGE'];
        }
        if(isset($participant['VIDEO_URL']) && !empty($participant['VIDEO_URL'])){
            $hash = explode('?v=',$participant['VIDEO_URL']);
            if(!empty($hash[1])){
                $participant['VIDEO_URL']=$hash[1];
            }
        }
        $UserModel = new UserModel();
        $get_reviewer_details = $UserModel->get_user_by_id($participant['REVIEWER_ID']);
        if(!empty($get_reviewer_details)){
            $participant['REVIEWER_NAME'] = $get_reviewer_details['FIRST_NAME'];
        }
        return $participant;
    }

    
    /**
     * participant_exists
     *
     * @param  mixed $id
     * @return void
     */
    public function participant_exists($id){
        $builder = $this->db->table($this->table)->where('P_ID', $id);
        if($builder->countAllResults()>0){
            return true;
        }
        return false;
    }
    
    /**
     * assign_score
     *
     * @return void
     */
    public function assign_score($p_id, $score){
        return $this->db->table($this->table)
                    ->set(array('SCORE'=> $score, 'REVIEWER_SCORE_STATUS' => 'SUBMITTED'))
                    ->where('P_ID', $p_id)
                    ->update();
    }    
    /**
     * assign_score_supervisor
     *
     * @param  mixed $p_id
     * @param  mixed $score
     * @return void
     */
    public function assign_score_supervisor($p_id, $score, $supervisour_id){
        $status = "PENDING";
        $participant = $this->db->table($this->table)->where('P_ID', $p_id)->get()->getRowArray();
        if(!empty($participant)){
            if($participant['SCORE']!=""){
                $status = "CHANGES";
            }
        }
        $changes = $this->db->table($this->table)
                ->set(array('SCORE'=> $score, 'REVIEWER_SCORE_STATUS' => 'SUBMITTED', 'REVIEWER_ID'=> $supervisour_id, 'LAST_UPDATED_BY' => $participant['REVIEWER_ID'], 'APPROVED_REJECT' => $status))
                ->where('P_ID', $p_id)
                ->update();
        if($changes && $status = 'CHANGES'){
            $history = array(
                'CHANGED_SCORE' => $participant['SCORE'],
                'REVIEWER_ID' => $participant['REVIEWER_ID'],
                'CHANGED_REVIEWER_ID' => $supervisour_id
            );
            $recordhistory = $this->db->table('tbl_review_histroy')->insert($history);
            if($recordhistory){
                return true;
            }
            return false;
        }
        if($changes){
            return true;
        }
        return false;

    }
    
    /**
     * disqualifyparticipant
     *
     * @param  mixed $p_id
     * @return void
     */
    public function disqualifyparticipant($p_id, $user_id){
        $disqualifiedby= $this->db->table($this->table)
                    ->set(array('DISQULIFID'=> '1'))
                    ->where('P_ID', $p_id)
                    ->update();
        if(!empty($disqualifiedby)){
            $disqualified = array(
                'P_ID' => $p_id,
                'R_ID' => $user_id
            );
            $disqualifieduser=$this->db->table('tbl_disqualified')->insert($disqualified);
            if($disqualifieduser){
                return true;
            }
            return false;
        }
        return false;
    }
    
    /**
     * disqualifyparticipantwithreason
     *
     * @param  mixed $p_id
     * @param  mixed $user_id
     * @param  mixed $reason
     * @return void
     */
    public function disqualifyparticipantwithreason($p_id, $user_id, $reason){
        $disqualifiedby= $this->db->table($this->table)
                    ->set(array('DISQULIFID'=> '1'))
                    ->where('P_ID', $p_id)
                    ->update();
        if(!empty($disqualifiedby)){
            $disqualified = array(
                'P_ID' => $p_id,
                'R_ID' => $user_id,
                'REASON' => $reason
            );
            $disqualifieduser=$this->db->table('tbl_disqualified')->insert($disqualified);
            if($disqualifieduser){
                return true;
            }
            return false;
        }
        return false;
    }
    
    /**
     * undisqualifyparticipant
     *
     * @param  mixed $p_id
     * @param  mixed $user_id
     * @return void
     */
    public function undisqualifyparticipant($p_id){
        $disqualifiedby= $this->db->table($this->table)
                    ->set(array('DISQULIFID'=> '0'))
                    ->where('P_ID', $p_id)
                    ->update();
        if(!empty($disqualifiedby)){
                return true;
        }
        return false;
    }
    
    /**
     * change_status
     *
     * @param  mixed $p_id
     * @param  mixed $status
     * @return void
     */
    public function change_status($p_id, $status){
        $status_change= $this->db->table($this->table)
                    ->set(array('APPROVED_REJECT'=> $status))
                    ->where('P_ID', $p_id)
                    ->update();
        if(!empty($status_change)){
                return true;
        }
        return false;
    }
    
    /**
     * active_score
     *
     * @return void
     */
    public function active_score($contest_id){
        $participant = $this->db->table($this->table)->select('ID, FIRST_NAME, SCORE, PROFILE_IMAGE')->join('tbl_user_master', 'tbl_user_master.ID = ' . $this->table . '.USER_ID', 'left')->where(array('CONTEST_ID' => $contest_id, 'APPROVED_REJECT' => 'APPROVED'))->orderBy('SCORE', 'DESC')->limit(3)->get()->getResultArray();
        foreach ($participant as $key => $user) {
            if ($user['PROFILE_IMAGE'] != '') {
                $participant[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user['ID'] . '/' . $user['PROFILE_IMAGE'];
            }
        }
        if(!empty($participant)){
            return $participant;
        }
    }    
    /**
     * active_score_leaderboad
     *
     * @param  mixed $contest_id
     * @return void
     */
    public function active_score_leaderboad($contest_id){
        $participant = $this->db->table($this->table)->select('ID, FIRST_NAME, SCORE, PROFILE_IMAGE')->join('tbl_user_master', 'tbl_user_master.ID = ' . $this->table . '.USER_ID', 'left')->where(array('CONTEST_ID' => $contest_id, 'APPROVED_REJECT' => 'APPROVED'))->orderBy('SCORE', 'DESC')->get()->getResultArray();
        foreach ($participant as $key => $user) {
            if ($user['PROFILE_IMAGE'] != '') {
                $participant[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user['ID'] . '/' . $user['PROFILE_IMAGE'];
            }
        }
        if(!empty($participant)){
            return $participant;
        }
    }
    
    /**
     * participant_count
     *
     * @return void
     */
    public function participant_count(){
        return $this->db->table($this->table)->countAllResults();
    }
    
    /**
     * participant_count_in_contest
     *
     * @param  mixed $c_id
     * @return void
     */
    public function participant_count_in_contest($c_id){
        return $this->db->table($this->table)->where(array('CONTEST_ID' => $c_id))->countAllResults();

    }
    
    /**
     * user_entries
     *
     * @param  mixed $user_id
     * @return void
     */
    public function user_entries($user_id)
    {
        return $this->db->table($this->table)->where('USER_ID', $user_id)->countAllResults();
    }
    
    /**
     * getcontestscores
     *
     * @param  mixed $c_id
     * @return void
     */
    public function getcontestscores($c_id){
        return $this->db->table($this->table)->select('P_ID, SCORE')->join('tbl_user_master', 'tbl_user_master.ID = ' . $this->table . '.USER_ID', 'right')->where(array('CONTEST_ID' => $c_id, 'BLOCK' => 'NO', 'tbl_user_master.status' => '1'))->orderBy('SCORE', 'DESC')->get()->getResultArray();
    }
    
    /**
     * is_all_approved_decline
     *
     * @param  mixed $c_id
     * @return void
     */
    public function is_all_approved_decline($c_id){
        $all_approved = $this->db->table($this->table)
                                ->groupStart()
                                ->where('APPROVED_REJECT', 'APPROVED')
                                ->orWhere('APPROVED_REJECT', 'DECLINED')
                                ->groupEnd()
                                ->where('CONTEST_ID', $c_id)
                                ->countAllResults();
        $all = $this->db->table($this->table)
                                ->where('CONTEST_ID', $c_id)
                                ->countAllResults();
        if($all_approved === $all){
            return true;
        }
        return false;
    }
    
    /**
     * get_participantBypid
     *
     * @param  mixed $p_id
     * @return void
     */
    public function get_participantBypid($p_id){
        return $this->db->table($this->table)->select('USER_ID')->where('P_ID', $p_id)->get()->getRowArray();
    }

    /**
     * user_contest_submission
     *
     * @param  mixed $user_id
     * @param  mixed $contest_id
     * @return void
     */
    public function user_contest_submission(int $user_id, int $contest_id)
    {
        return $this->db->table($this->table)->join('tbl_contest', 'tbl_contest.C_ID = tbl_participant.CONTEST_ID')->join('tbl_score_type', 'tbl_score_type.ST_ID = tbl_contest.SCORE_TYPE')->select('tbl_participant.P_ID , CONTEST_ID, CONTEST_NAME, tbl_participant.VIDEO_URL, APPROVED_REJECT, CONTEST_BANNER , CONTEST_DESCRIPTION, SCORE , tbl_score_type.NAME as SCORE_TYPE')->where(array('CONTEST_ID' => $contest_id, 'USER_ID' => $user_id))->get()->getRowArray();
    }

}  
