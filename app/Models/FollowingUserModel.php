<?php
namespace App\Models;

use CodeIgniter\Model;



/**
 * PromocodeModel
 */
class FollowingUserModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_user_following';    
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
                                'following_user_id'
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
                                    'following_user_id' => 'required'
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
     * get_user_following
     *
     * @param [int] $user_id
     * @param [int] $following_iser_id
     * @return array
     */
    public function get_user_following( $user_id, $following_iser_id){
        return $this->db->table($this->table)->where(array('user_id'=>$user_id,'following_user_id'=>$following_iser_id))->get()->getRowArray();
    }

    /**
     * get_following_users
     *
     * @param [int] $user_id
     * @return array
     */
    public function get_following_users($user_id){
        $users =  $this->db->table($this->table)
            ->select('tbl_user_master.ID,USERNAME, PROFILE_IMAGE')
        ->join('tbl_user_master','tbl_user_master.ID='.$this->table.'.following_user_id')
        ->where($this->table.'.user_id',$user_id)
        ->get()->getResultArray();
        foreach ($users as $key => $user) {
            if ($user['PROFILE_IMAGE'] != '') {
                $users[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user['ID'] . '/' . $user['PROFILE_IMAGE'];
            }
        }

        return $users;
    }

    /**
     * get_follower_users
     *
     * @param [int] $user_id
     * @return array
     */
    public function get_follower_users($user_id){
        $users =  $this->db->table($this->table)
            ->select('tbl_user_master.ID,USERNAME, PROFILE_IMAGE')
        ->join('tbl_user_master','tbl_user_master.ID='.$this->table.'.user_id')
        ->where($this->table.'.following_user_id',$user_id)
        ->get()->getResultArray();

        foreach ($users as $key => $user) {
            if ($user['PROFILE_IMAGE'] != '') {
                $users[$key]['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $user['ID'] . '/' . $user['PROFILE_IMAGE'];
            }
        }

        return $users;
    }
    
    /**
     * is_following
     *
     * @param  mixed $user_id
     * @param  mixed $following_user_id
     * @return void
     */
    public function is_following($user_id, $following_user_id){
        return $this->db->table($this->table)->where(array('user_id' => $user_id, 'following_user_id'=>$following_user_id))->countAllResults();
    }
 
}  
