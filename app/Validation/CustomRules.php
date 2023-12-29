<?php
namespace App\Validation;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\PromocodeModel;
use App\Models\ParticipantModel;

class CustomRules{

  // Rule is to validate mobile number digits
    function rolekey_exists(string $str, string $fields, array $data)
    {
        $role = new RoleModel();
        if($role->check_role_exists($data['user_role'])){
            return false;
        }
        return true;
    }    
    /**
     * user_exists
     *
     * @param  mixed $str
     * @param  mixed $fields
     * @param  mixed $data
     * @return void
     */
    function user_exists(string $str, string $fields, array $data)
    {
        $user = new UserModel();
        $condition = array(
            'BLOCK' => 'NO',
            'STATUS' => 1,
            'ID'    => $data['user_id'],
            'ROLE_ID'   => 4

        );
        if($user->is_valid_user($condition)){
            return true;
        }
        return false;
    }
    
    /**
     * valid_promocode
     *
     * @param  mixed $str
     * @param  mixed $fields
     * @param  mixed $data
     * @return void
     */
    function valid_promocode(string $str, string $fields, array $data)
    {
        $PromocodeModel = new PromocodeModel();
        if(empty($data['promocode_id'])){
            return true;
        }
        if($PromocodeModel->is_valid_promocode($data['promocode_id'])){
            return true;
        }
        return false;
    }    
    /**
     * valid_participant_id
     *
     * @param  mixed $str
     * @param  mixed $fields
     * @param  mixed $data
     * @return void
     */
    function valid_participant_id(string $str, string $fields, array $data){
        $ParticipantModel = new ParticipantModel();
        if($ParticipantModel->participant_exists($data['participant_id'])){
            return true;
        }
        return false;
    }
    
}
