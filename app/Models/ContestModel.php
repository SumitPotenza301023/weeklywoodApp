<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\ParticipantModel;


/**
 * ContestModel
 */
class ContestModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_contest';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'C_ID';
    
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
                                'CONTEST_BANNER',  
                                'CONTEST_NAME',    
                                'CONTEST_DESCRIPTION',
                                'CONTEST_POINTS',
                                'CONTEST_PDF',
                                'START_DATE',
                                'END_DATE',
                                'STATUS '
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
                                    'CONTEST_BANNER'            => 'required|regex_match[/^[\w,\s-]+\.[A-Za-z]{3}$/]',   
                                    'CONTEST_NAME'              => 'required|alpha_space',
                                    'CONTEST_DESCRIPTION'       => 'required',
                                    'CONTEST_POINTS'            => 'required|numeric',
                                    'CONTEST_PDF'               => 'required|regex_match[/^[\w,\s-]+\.[A-Za-z]{3}$/]',
                                    'START_DATE'                => 'valid_date',
                                    'END_DATE'                  => 'valid_date',
                                    'STATUS'                    => 'in_list[0,1]'
                                    
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
    public function create_contest($contestedetails){
        $result = $this->db->table($this->table)->insert($contestedetails);
        return  $this->db->insertID();
    }
    
    /**
     * update_contest
     *
     * @param  mixed $contest_details
     * @param  mixed $where
     * @return void
     */
    public function update_contest($contest_details, $where ){
        return $this->db->table($this->table)
                       ->set($contest_details)
                       ->where($where)
                       ->update();
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
     * get_contest_details
     *
     * @return void
     */
    public function get_contest_details(){
        $builder = $this->db->table($this->table)
                            ->join('tbl_score_type', 'tbl_score_type.ST_ID = '.$this->table.'.SCORE_TYPE', 'left')
                            ->where('status','1');
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["C_ID","DESC"],
                ["CONTEST_NAME","DESC"],
                ["START_DATE","DESC"],
                ["END_DATE","DESC"],
                ["CONTEST_POINTS","DESC"]
            ],
            "setSearch" => ["C_ID","CONTEST_NAME","START_DATE","END_DATE","CONTEST_POINTS"],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "C_ID",
                "CONTEST_NAME",
                "START_DATE",
                "END_DATE",
                function($row){
                    return <<<EOF
                            <div style="font-size: 20px;" ><span style="margin-right: 10px;"><i class="ion-cash"></i></span><span class="points">{$row["CONTEST_POINTS"]}<span></div>
                    EOF;
                },
                function($row){
                    $class = 'info';
                    if($row['NAME'] == 'MILES'){
                        $class = 'warning';
                    }
                    if($row['NAME'] == 'CALORIES'){
                         $class = 'success';
                    }
                     return <<<EOF
                             <div class="badge badge-{$class} badge-shadow">{$row['NAME']}</div>
                        EOF;
                   
                },
                function($row){
                    $ParticipantModel = new ParticipantModel();
                    $result = $ParticipantModel->is_all_approved_decline($row['C_ID']);
                    $all = $ParticipantModel->getcontestscores($row['C_ID']);
                    if($row['IS_OFFICIAL'] == 'YES'){
                         return <<<EOF
                            <span class="badge badge-primary">CONTEST IS OFFICIAL</span>
                        EOF;
                    }
                    $participant_count = $ParticipantModel->participant_count_in_contest($row['C_ID']);
                     if($participant_count * 0.3 == 0){
                        
                      return <<<EOF
                       <span class="badge badge-info">NO PARTICIPANT JOINED</span>
                    EOF;
                    
                    }
                    if($ParticipantModel->is_all_approved_decline($row['C_ID'])){
                        return <<<EOF
                            <button class="btn btn-icon icon-left btn-success makecontestofficial" data-id='{$row["C_ID"]}' ><i class='fas fa-check'></i> Make Contest Official</button>

                        EOF;
                    }
                        return <<<EOF
                        <span class="badge badge-warning">PLEASE APPROVE SCORES</span>
                        EOF;
                },
                function($row){
                    $result = "";
                     if($row['IS_OFFICIAL'] == 'YES'){
                        
                           $result ='<a  href="'. base_url().ADMIN.'/contests/contest-result?c_id='.$row['C_ID'].'" class="btn btn-success btncontestresult">Result</a>';
                        
                    }
                    return <<<EOF
                        {$result}
                        <button class="btn btn-primary btncontestdetails" data-id='{$row["C_ID"]}' data-toggle="modal" data-target=".bd-edit-contest-modal-lg" >Details</button>
                        <button class="btn btn-danger btncontestdelete" data-id='{$row["C_ID"]}' style="font-size: 20px;"><i class="ion-trash-a" data-pack="default"></i></button>
                    EOF;
                }
            ]
        ];
        return $setting;

    }
    
    /**
     * get_contest
     *
     * @param  mixed $where
     * @return void
     */
    public function get_contest($where){
        $query = $this->db->table($this->table)
                        ->where($where);
                        
        return $query->get()->getRowArray();
    }

   
    
    /**
     * get_all_contest
     *
     * @param  mixed $where
     * @return void
     */
    public function get_all_contest($where){
         $query = $this->db->table($this->table)
                         ->select('C_ID, CONTEST_BANNER, CONTEST_NAME, CONTEST_DESCRIPTION, CONTEST_POINTS, CONTEST_PDF, START_DATE, END_DATE, NAME as SCORE_TYPE')
                         ->join('tbl_score_type', 'tbl_score_type.ST_ID = '.$this->table.'.SCORE_TYPE', 'left')
                         ->where('status','1')
                         ->orderBy('START_DATE','DESC')
                         ->where($where);
                        
        $result= $query->get()->getResultArray();
        if(!empty($result)){
            foreach($result as $key=>$contest){
                $result[$key]['CONTEST_BANNER']= base_url().CONTESTBANNERFOLDERPATH.'/'.$contest['C_ID'].'/'.$contest['CONTEST_BANNER'];
                $result[$key]['CONTEST_PDF']= base_url().CONTESTPDFFOLDERPATH.'/'.$contest['C_ID'].'/'.$contest['CONTEST_PDF'];
            }
        }
        
        return $result;
    }
    

    /**
     * get_contest_score_type
     *
     * @param  mixed $where
     * @return void
     */
    public function get_contest_score_type($where){
        $query = $this->db->table($this->table)
            ->select('C_ID, CONTEST_BANNER, CONTEST_NAME, CONTEST_DESCRIPTION, CONTEST_POINTS, CONTEST_PDF, START_DATE,VIDEO_URL,CONTEST_PDF_TITLE, END_DATE, NAME as SCORE_TYPE')
                         ->join('tbl_score_type', 'tbl_score_type.ST_ID = '.$this->table.'.SCORE_TYPE', 'left')
                         ->where('status','1')
                         ->where($where);
                        
        return $query->get()->getRowArray();
    }
    
    /**
     * valid_start_date
     *
     * @param  mixed $date
     * @return void
     */
    public function valid_start_end_date($date){
       
        $query = $this->db->query("SELECT COUNT(*) as Count FROM `tbl_contest` LEFT JOIN `tbl_score_type` ON `tbl_score_type`.`ST_ID` = `tbl_contest`.`SCORE_TYPE` WHERE `status` = '1' AND '".$date."' BETWEEN START_DATE AND END_DATE");
        $result = $query->getRowArray();
        if($result){
            if($result['Count'] > 0){
                return true;
            }
            
        }
        return false;
    }
        
    /**
     * valid_start_end_date_exculde
     *
     * @param  mixed $date
     * @param  mixed $contest_id
     * @return void
     */
    public function valid_start_end_date_exculde($date, $contest_id){
       
        $query = $this->db->query("SELECT COUNT(*) as Count FROM `tbl_contest` LEFT JOIN `tbl_score_type` ON `tbl_score_type`.`ST_ID` = `tbl_contest`.`SCORE_TYPE` WHERE C_ID<>".$contest_id." AND `status` = '1' AND '".$date."' BETWEEN START_DATE AND END_DATE");
        $result = $query->getRowArray();
        if($result){
            if($result['Count'] > 0){
                return true;
            }
            
        }
        return false;
    }
     
    
    /**
     * get_active_contest
     *
     * @return void
     */
    public function get_active_contest(){
        $query = $this->db->query("SELECT `C_ID`, `CONTEST_BANNER`, `CONTEST_NAME`, `CONTEST_DESCRIPTION`, `CONTEST_POINTS`,`CONTEST_PDF_TITLE`, `CONTEST_PDF`,`VIDEO_URL`, `START_DATE`, `END_DATE`, `NAME` as `SCORE_TYPE` FROM `tbl_contest` LEFT JOIN `tbl_score_type` ON `tbl_score_type`.`ST_ID` = `tbl_contest`.`SCORE_TYPE` WHERE `status` = '1' AND CURRENT_TIMESTAMP BETWEEN START_DATE AND END_DATE");
        return $query->getRowArray();
    }

    
    /**
	 * get_contest_points
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function get_contest_points($id){
		$result =  $this->db->table($this->table)->select('CONTEST_POINTS')->where('C_ID', $id)->get()->getRowArray();
        if(!empty($result)){
            return $result;
        }
        return false;
	}
    
    /**
     * getnextcontest
     *
     * @param  mixed $end_date
     * @return void
     */
    public function getnextcontest($end_date){
        $result =  $this->db->table($this->table)->select('START_DATE')->where(array('START_DATE >'=> $end_date, 'status'=>'1'))->orderBy('START_DATE', 'DESC')->limit(1);
        return $result->get()->getRowArray();
    }
    
    /**
     * get_contest_count
     *
     * @return void
     */
    public function get_contest_count(){
        return $this->db->table($this->table)->where('STATUS' , '1')->countAllResults();
    }
    
    /**
     * get_completed_contest
     *
     * @return void
     */
    public function get_completed_contest(){
        $result =  $this->db->table($this->table)->select('C_ID, CONTEST_BANNER, CONTEST_NAME, CONTEST_DESCRIPTION, CONTEST_POINTS as ENTRYPOINT, IS_OFFICIAL as COMPLETED, TOTAL_PRICE_POOL as WINPRIZE')->where(array('STATUS' => 1, 'IS_OFFICIAL' => 'YES'))->orderBy('OFFICIAL_ON', 'DESC')->get()->getResultArray();
        foreach ($result as $key => $contest) {
            $result[$key]['CONTEST_BANNER'] = base_url() . CONTESTBANNERFOLDERPATH . '/' . $contest['C_ID'] . '/' . $contest['CONTEST_BANNER'];
        }
        return $result;
    }
    
    
  
}
