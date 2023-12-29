<?php
namespace App\Models;

use CodeIgniter\Model;



/**
 * PromocodeModel
 */
class ContactUsModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_contact_us';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
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
                                'id',
                                'user_id',  
                                'name',
                                'email',
                                'contact_number',
                                'message',
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
    protected $createdField  = 'created';    
    /**
     * updatedField
     *
     * @var string
     */
    protected $updatedField  = 'updated';
    
    /**
     * validationRules
     *
     * @var array
     */
    protected $validationRules = [
                                    'user_id' => 'required',  
                                    'name'=> 'required',
                                    'email'=> 'required',
                                    'message'=> 'required',
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
			"name"  => $this->validationRules['name'],
			"email"   => $this->validationRules["email"],
			"message"      => $this->validationRules["message"]
		);
        return $validation;
    }
        /**
     * get_api_message
     *
     * @return array
     */
    public function get_api_message(){
        $messages = [
           'name' => [
               'required' => 'Name is Required',
           ],
           'email'=> [
               'required' => 'Email Is Required',
           ],
           'message' =>[
               'required' => 'Message Key Is Required'
           ],
       ];
       return $messages;
   }
}  
