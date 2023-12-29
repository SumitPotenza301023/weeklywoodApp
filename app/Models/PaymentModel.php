<?php
namespace App\Models;
use App\Models\PromocodeModel;

use CodeIgniter\Model;

/**
 * UserModel
 */
class PaymentModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_payment';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'PAY_ID';
    
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
    protected $allowedFields = ['USER_ID',  
                                'TRANSECTION_ID',    
                                'AMOUNT_PAID',
                                'POINTS',
                                'PROMOCODE_ID ',
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
                                    'USER_ID' => 'required|integer',  
                                    'TRANSECTION_ID'=> 'required',    
                                    'AMOUNT_PAID' => 'required',
                                    'POINTS' => 'required|integer'
                                    
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
    public function get_api_rules($promo){
        $validation = array(
			//"user_id"    => $this->validationRules['USER_ID'].'|user_exists[user_id]',
			"transection_id"  => $this->validationRules['TRANSECTION_ID'],
            "amount_paid" => $this->validationRules['AMOUNT_PAID'],
            'points' => $this->validationRules['POINTS']
		);
        if($promo == true){
            $validation['promocode_id'] = 'valid_promocode[promocode_id]';
        }
        return $validation;
    }
        
    /**
     * get_api_rules_payout
     *
     * @return void
     */
    public function get_api_rules_payout(){
        $validation = array(
			"transection_id"  => 'required',
            "amount_paid" => 'required',
            'points' => $this->validationRules['POINTS']
		);
      
        return $validation;
    }
    /**
     * get_api_message
     *
     * @return void
     */
    public function get_api_message_payout(){
         $messages = [
			
			"transection_id"  => [
                'required' => 'Transection id required'
            ],
            "amount_paid"  => [
                'required' => 'Amount is required'
            ],
            "points"  => [
                'required' => 'Points is required',
                'integer' => 'Please Enter Valid Points'
            ]
		];
        return $messages;
    }
    /**
     * get_api_message
     *
     * @return void
     */
    public function get_api_message(){
         $messages = [
			// "user_id" => [
            //     'required' => 'User id is Required',
            //     'user_exists' => 'Please Enter Valid User Id'
            // ],
			"transection_id"  => [
                'required' => 'Transection id required'
            ],
            "amount_paid"  => [
                'required' => 'Amount is required'
            ],
            "points"  => [
                'required' => 'Points is required',
                'integer' => 'Please Enter Valid Points'
            ],
			"promocode_id"   => [
                'valid_promocode' => 'Please Enter Valid Promocode'
            ]
		];
        return $messages;
    }
        
    /**
     * add_transaction
     *
     * @param  mixed $transaction
     * @return void
     */
    public function add_transaction($transaction){
        $this->db->table($this->table)->insert($transaction);
        return $this->db->insertID();
    }
    
    /**
     * add_payout_transaction
     *
     * @param  mixed $transaction
     * @return void
     */
    public function add_payout_transaction($transaction){
        $this->db->table('tbl_payout')->insert($transaction);
        return $this->db->insertID();
    }


    /**
     * update_payout_transaction
     *
     * @param  mixed $payout_id
     * @param  mixed $transaction
     * @return void
     */
    public function update_payout_transaction($payout_id, $transaction)
    {
        $confirm = $this->db->table('tbl_payout')
        ->set($transaction)
            ->where('PAYOUT_ID', $payout_id)
            ->update();
        return $confirm;
    }
    
    /**
     * update_wallet
     *
     * @param  mixed $user_id
     * @param  mixed $amount
     * @param  mixed $operation
     * @return void
     */
    public function update_wallet($user_id, $point, $operation){
        if($operation === false){
            $added=$this->db->table('tbl_user_points')
                        ->set('POINTS', 'POINTS+'.$point, false)
                        ->where('USER_ID', $user_id)
                        ->update();
            return $added;
        }
        $reduce=$this->db->table('tbl_user_points')
                    ->set('POINTS', 'POINTS-'.$point, false)
                    ->where('USER_ID', $user_id)
                     ->update();
        return $reduce;

    }
    
    /**
     * check_user_wallet
     *
     * @param  mixed $user_id
     * @param  mixed $points
     * @return void
     */
    public function check_user_wallet($user_id, $points){
        $result = $this->db->table('tbl_user_points')
                           ->where(array('USER_ID' => $user_id, 'POINTS>=' => $points));
        if($result->countAllResults() > 0){
            return true;
        }
        return false;
                           
    }
    
    /**
     * create_wallet
     *
     * @param  mixed $user_id
     * @param  mixed $point
     * @return void
     */
    public function create_wallet($user_id , $point){
        $this->db->table('tbl_user_points')->insert(array('USER_ID' => $user_id, "POINTS" => $point));
        return $this->db->insertID();
    }
    
    /**
     * get_payment_transactions
     *
     * @return void
     */
    public function get_payment_transactions(){
      
        $builder = $this->db->table($this->table)
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left');
                            
       
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                [$this->table.".UPDATED_AT","DESC"]
            ],
            "setSearch" => ["TRANSECTION_ID","AMOUNT_PAID","PROMOCODE_ID"],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "PAY_ID",
                "FIRST_NAME",
                "AMOUNT_PAID",
                "TRANSECTION_ID",
                function($row){
                    if($row['PROMOCODE_ID']!= ""){
                        $PromocodeModel = new PromocodeModel();
                        $promo = $PromocodeModel->get_promocode(array('PROMO_ID'=>$row['PROMOCODE_ID']));
                         return <<<EOF
                            <span class="mb-1" style="border-style: dashed solid;"><b>'{$promo['TITLE']}'</b></span>
                        EOF;
                    }
                    return <<<EOF
                           <div class="badge badge-pill badge-info mb-1">NOT APPLIED</div>
                    EOF;
                   
                }
            ]
        ];
        return $setting;

    }
    
    /**
     * get_point_transaction
     *
     * @return void
     */
    public function get_point_transaction(){
         $builder = $this->db->table($this->table)
                            ->join('tbl_user_master', 'tbl_user_master.ID = '.$this->table.'.USER_ID', 'left');
                            
       
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                [$this->table.".UPDATED_AT","DESC"]
            ],
            "setSearch" => ["TRANSECTION_ID","AMOUNT_PAID","PROMOCODE_ID"],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "PAY_ID",
                "FIRST_NAME",
                "POINTS",
                "CREATED_AT"
            ]
        ];
        return $setting;
    }
    
    public function last_query(){
        $query =  $this->db->getLastQuery();
        return $query->getQuery();
    }
    
    /**
     * promocodecount
     *
     * @param  mixed $promo_id
     * @return void
     */
    public function promocodecount($promo_id){
        return $this->db->table($this->table)->where('PROMOCODE_ID', $promo_id)->countAllResults();
    }

}
