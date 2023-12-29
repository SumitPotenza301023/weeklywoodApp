<?php
namespace App\Models;

use CodeIgniter\Model;



/**
 * PromocodeModel
 */
class RoleModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_role';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'R_ID';
    
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
                                'R_ID',
                                'ACCESS_MODULE',  
                                'NAME'
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
    protected $validationRules = [];    
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
     * get_user_roles
     *
     * @return void
     */
    public function get_user_roles(){
       return $this->db->table($this->table)
                ->select('R_ID, NAME')
                ->get()->getResultArray();
    }
    
    /**
     * check_role_exists
     *
     * @param  mixed $role_id
     * @return void
     */
    public function check_role_exists($role_id){
        $query = $this->db->table($this->table)
                      ->where('R_ID', $role_id);
        if ($query->countAllResults() > 0){
            return false;
        }
        return true;
                      
    }
       
  
      
}
