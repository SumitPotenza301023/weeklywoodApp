<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\PaymentModel;



/**
 * PromocodeModel
 */
class PromocodeModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_promocode';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'PROMO_ID';
    
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
                                'PROMO_ID',
                                'TITLE',  
                                'DESCRIPTION',    
                                'BANNER_IMAGE',
                                'PURCHASE_POINTS',
                                'MINIMUM_POINTS',
                                'EXPIRY_DATE',
                                'DELETE_STATUS'
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
                                    'BANNER_IMAGE'              => 'required|regex_match[/^[\w,\s-]+\.[A-Za-z]{3}$/]',   
                                    'TITLE'                     => 'required|alpha',
                                    'DESCRIPTION'               => 'required',
                                    'PURCHASE_POINTS'           => 'required|numeric',
                                    'MINIMUM_POINTS'            => 'required|numeric',
                                    'EXPIRY_DATE'               => 'required|valid_date',
                                    'DELETE_STATUS'             => 'in_list[0,1]'
                                    
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
     * create_promocode
     *
     * @param  mixed $promocodedetails
     * @return void
     */
    public function create_promocode($promocodedetails){
        $result = $this->db->table($this->table)->insert($promocodedetails);
        return  $this->db->insertID();
    }
    
        
    /**
     * update_promocode
     *
     * @param  mixed $promocode_details
     * @param  mixed $where
     * @return void
     */
    public function update_promocode($promocode_details, $where ){
        return $this->db->table($this->table)
                       ->set($promocode_details)
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
     * get_promocode_details
     *
     * @return void
     */
    public function get_promocode_details(){
        $builder = $this->db->table($this->table)->where('DELETE_STATUS','0');
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["PROMO_ID","DESC"],
                ["TITLE","DESC"],
                ["BANNER_IMAGE","DESC"],
                ["PURCHASE_POINTS","DESC"],
                ["EXPIRY_DATE","DESC"],
                ['USED_STATUS', "DESC"]
            ],
            "setSearch" => ["PROMO_ID","TITLE","BANNER_IMAGE","PURCHASE_POINTS","EXPIRY_DATE"],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "PROMO_ID",
                "TITLE",
                function($row){
                    $URL=base_url().PROMOCODEBANNERFOLDERPATH.'/'.$row['PROMO_ID'].'/'.$row['BANNER_IMAGE'];
                    return <<<EOF
                            <img src={$URL} width="200" />
                    EOF;
                },
                "PURCHASE_POINTS",
                "EXPIRY_DATE",
                function($row){
                    $PaymentModel = new PaymentModel();
                    $count = $PaymentModel->promocodecount($row['PROMO_ID']);
                    return <<<EOF
                    <button class="btn btn-primary btnpromocodedetails" disabled>{$count}</button>
                    EOF;
                    
                },
                function($row){
                    return <<<EOF
                        <button class="btn btn-primary btnpromocodedetails" data-id='{$row["PROMO_ID"]}' data-toggle="modal" data-target=".bd-create-edit-modal-lg" >Details</button>
                        <button class="btn btn-danger btnpromocodedelete" data-id='{$row["PROMO_ID"]}' style="font-size: 20px;"><i class="ion-trash-a" data-pack="default"></i></button>
                    EOF;
                }
            ]
        ];
        return $setting;

    }
        
    /**
     * is_valid_promocode
     *
     * @param  mixed $promo_id
     * @return void
     */
    public function is_valid_promocode($promo_id){
        $promo_count = $this->db->table($this->table)
                                ->where(array('DELETE_STATUS'=>'0', 'PROMO_ID'=> $promo_id))
                                ->countAllResults();
        if($promo_count>0){
            return true;
        }
        return false;
    }
      
    /**
     * get_promocode
     *
     * @param  mixed $where
     * @return void
     */
    public function get_promocode($where){
        $query = $this->db->table($this->table)
                        ->where($where);
                        
        return $query->get()->getRowArray();
    }
    
    /**
     * get_promocode_for_users
     *
     * @param  mixed $user_id
     * @return void
     */
    public function get_promocode_for_users($user_id){
        $promocodes = $this->db->query("SELECT PROMO_ID, TITLE, DESCRIPTION, BANNER_IMAGE, PURCHASE_POINTS, EXPIRY_DATE, MINIMUM_POINTS FROM `tbl_promocode` WHERE DELETE_STATUS = '0' AND NOT EXISTS (SELECT PROMOCODE_ID from tbl_payment WHERE tbl_promocode.PROMO_ID = tbl_payment.PROMOCODE_ID AND tbl_payment.USER_ID=".$user_id.")")
                               ->getResultArray();
                               
        return $promocodes;
    }
      
}
