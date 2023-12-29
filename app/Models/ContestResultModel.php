<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\ContestModel;
/**
 * ContestModel
 */
class ContestResultModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_contest_result';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'CR_ID';
    
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
                                'C_ID',
                                'P_ID',  
                                'SCORE',    
                                'RANK',
                                'TIER'
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
     * create_contest
     *
     * @param  mixed $contestedetails
     * @return void
     */
    public function create_result($resultdetails){
        $result = $this->db->table($this->table)->insert($resultdetails);
        return  $this->db->insertID();
    }
    
    /**
     * get_contest_result_details
     *
     * @param  mixed $contest_id
     * @return void
     */
    public function get_contest_result_details($contest_id){
         $builder = $this->db->table($this->table)
                            ->select('CR_ID, FIRST_NAME, '.$this->table.'.SCORE, PRICE_POOL, RANK, TIER')
                            ->join('tbl_participant', 'tbl_participant.P_ID = '.$this->table.'.P_ID', 'left')
                            ->join('tbl_user_master', 'tbl_user_master.ID = tbl_participant.USER_ID', 'left')
                            ->orderBy('RANK', 'ASE')
                            ->where('C_ID',$contest_id);
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["CR_ID","DESC"],
                ["FIRST_NAME","DESC"],
                ["SCORE","DESC"],
                ["PRICE_POOL","DESC"],
                ["RANK","DESC"],
                ["TIER","DESC"]

            ],
            "setSearch" => ["CR_ID", "tbl_user_master.FIRST_NAME", $this->table.".SCORE", $this->table . ".PRICE_POOL", $this->table . ".RANK", $this->table . ".TIER"],
            "setOrder"  => [null,null,null],
            "setOutput" => [
                "CR_ID",
                "FIRST_NAME",
                "RANK",
                "SCORE",
                "TIER",
                "PRICE_POOL"
            ]
        ];
        return $setting;
    }
    
    /**
     * get_user_rank
     *
     * @param  mixed $user_id
     * @param  mixed $rank
     * @return void
     */
    public function get_user_rank(int $user_id, int $rank)
    {
        $result = $this->db->table($this->table)
                        ->select('PRICE_POOL, '.$this->table.'.SCORE, tbl_contest.C_ID,  CONTEST_BANNER,  CONTEST_NAME, CONTEST_POINTS as ENTRY_POINT')
                        ->join('tbl_participant', 'tbl_participant.P_ID = '.$this->table.'.P_ID', 'left')
                        ->join('tbl_contest', 'tbl_contest.C_ID = '.$this->table.'.C_ID', 'left')
                        ->where(array('tbl_participant.USER_ID'=> $user_id, $this->table.'.TIER' => $rank, 'tbl_contest.IS_OFFICIAL' =>'YES'))
                        ->get()->getResultArray();
        foreach($result as $key=>$ranks){
            $result[$key]['CONTEST_BANNER'] = base_url().CONTESTBANNERFOLDERPATH.'/'.$ranks['C_ID'].'/'.$ranks['CONTEST_BANNER'];
        }
        return $result;

    }
    
    /**
     * participated
     *
     * @param  mixed $user_id
     * @return void
     */
    public function participated(int $user_id){
        $result = $this->db->table('tbl_participant')->select('P_ID, tbl_participant.SCORE, IS_OFFICIAL, REVIEWER_SCORE_STATUS, CONTEST_ID,  CONTEST_BANNER,  CONTEST_NAME, CONTEST_POINTS as ENTRY_POINT')->join('tbl_contest', 'tbl_contest.C_ID = tbl_participant.CONTEST_ID', 'left')->where('USER_ID', $user_id)->get()->getResultArray();
        $notwin = array();
        foreach($result as $participated_contest){
            $is_not_winner =  $this->db->table($this->table)->where(array('C_ID'=> $participated_contest['CONTEST_ID'], 'P_ID' => $participated_contest['P_ID']))->countAllResults();
            if($is_not_winner == 0 ){
                array_push($notwin, $participated_contest);
            }
        }
        foreach($notwin as $key=>$ranks){
            $notwin[$key]['CONTEST_BANNER'] = base_url().CONTESTBANNERFOLDERPATH.'/'.$ranks['CONTEST_ID'].'/'.$ranks['CONTEST_BANNER'];
        }
        return $notwin;
    }
    
    /**
     * get_contest_archive
     *
     * @return void
     */
    public function get_contest_archive(){
        $contestresult = array();
        $ContestModel = new ContestModel();
        $contests = $ContestModel->get_completed_contest();
        foreach($contests as $key=>$contest){
        
            $contests[$key]['result'] = $this->get_contest_result_details_all($contest['C_ID']);
        }
        return  $contests;
    }
    
    /**
     * get_contest_result_details_all
     *
     * @param  mixed $contest_id
     * @return void
     */
    public function get_contest_result_details_all($contest_id){
         $builder = $this->db->table($this->table)
            ->select('CR_ID, FIRST_NAME, ' . $this->table . '.SCORE, PRICE_POOL,PROFILE_IMAGE,tbl_user_master.ID AS USER_ID, RANK, TIER')
                            ->join('tbl_participant', 'tbl_participant.P_ID = '.$this->table.'.P_ID', 'left')
                            ->join('tbl_user_master', 'tbl_user_master.ID = tbl_participant.USER_ID', 'left')
                            ->orderBy('RANK', 'ASE')
                            ->where('C_ID',$contest_id)
                            ->get()->getResultArray();

        foreach ($builder as $key => $user_details) {
            if ($user_details['PROFILE_IMAGE'] != '') {
                $builder[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user_details['USER_ID'] . '/' . $user_details['PROFILE_IMAGE'];
            }
        }
        return $builder;
    }
    
    /**
     * user_participate_history
     *
     * @param  mixed $user_id
     * @return void
     */
    public function user_participate_history(int $user_id){
        $participated_contest = $this->db->table('tbl_participant')
                                        ->select('P_ID, CONTEST_ID, tbl_participant.VIDEO_URL, APPROVED_REJECT, SCORE, IS_OFFICIAL, CONTEST_NAME, CONTEST_BANNER, START_DATE, END_DATE')
                                        ->join('tbl_contest', 'tbl_contest.C_ID = tbl_participant.CONTEST_ID', 'left')
                                        ->where('USER_ID', $user_id)->get()->getResultArray();
        foreach($participated_contest as $key=>$contest){
            $participated_contest[$key]['CONTEST_BANNER'] = base_url().CONTESTBANNERFOLDERPATH.'/'.$contest['CONTEST_ID'].'/'.$contest['CONTEST_BANNER'];
            if($contest['IS_OFFICIAL'] == 'YES'){
                $participated_contest[$key]['RESULT'] = $this->db->table($this->table)->select('SCORE, PRICE_POOL, RANK')->where('P_ID', $contest['P_ID'])->get()->getRowArray();
            }
        }
        return $participated_contest;

    }
  
}
