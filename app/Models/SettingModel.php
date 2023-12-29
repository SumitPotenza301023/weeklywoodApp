<?php
namespace App\Models;

use CodeIgniter\Model;



/**
 * PromocodeModel
 */
class SettingModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_settings';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'SETTING_ID';
    
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
                                'SETTING_ID',
                                'SETTING_KEY',  
                                'SETTING_VALUE'
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
                                    'SETTING_KEY' => 'required|is_unique[tbl_settings.SETTING_KEY]',  
                                    'SETTING_VALUE' => 'required'
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
     * update_settings
     *
     * @param  mixed $details
     * @param  mixed $where
     * @return void
     */
    public function update_settings($details, $key){

       return $this->db->table($this->table)
                       ->set($details)
                       ->where($this->allowedFields[1] , $key)
                       ->update();
      
    }
    
    /**
     * get_setting
     *
     * @param  mixed $key
     * @return void
     */
    public function get_setting($key){
        $whereclause = array(
            $this->allowedFields[1] => $key
        );
        $query = $this->db->table($this->table)
                        ->where($whereclause);
                        
        return $query->get()->getRowArray();                
    }
}
