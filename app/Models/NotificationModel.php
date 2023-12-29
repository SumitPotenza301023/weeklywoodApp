<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\SettingModel;


/**
 * ContestModel
 */
class NotificationModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_notification';    
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'ID';
    
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
                                'ID',
                                'USER_ID',  
                                'NOTIFICATION_TITLE',    
                                'NOTIFICATION_DISCRIPTION',
                                'TYPE',
                                'DEVICE_ID',
                                'DELETE_STATUS',
                                'CREATED_AT',
                                'UPDATED_AT '
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
     * create_notification
     *
     * @param  mixed $user_id
     * @param  mixed $title
     * @param  mixed $discription
     * @param  mixed $type
     * @param  mixed $device_id
     * @return void
     */
    public function create_notification( int $user_id, string $title, string $discription, string $type, string $device_id = null ){
        $notification = array(
            'USER_ID' => $user_id,
            'NOTIFICATION_TITLE' => $title,
            'NOTIFICATION_DISCRIPTION' => $discription,
            'TYPE' => $type,
            'DEVICE_ID' => $device_id,
            'DELETE_STATUS' => '1'
        );
        if($type == 'PUSH'){
            $result = $this->push_notification(array($device_id), $title, $discription );
        }
        $result = $this->db->table($this->table)->insert($notification);
        return  $this->db->insertID();
    }
    
    /**
     * get_user_notification
     *
     * @param  mixed $user_id
     * @return void
     */
    public function get_user_notification(int $user_id){
        return $this->db->table($this->table)->where(array('USER_ID' => $user_id, 'TYPE' => 'SYSTEM'))->orderBy('CREATED_AT', 'DESC')->get()->getResultArray();
    }
        
    /**
     * push_notification
     *
     * @param  mixed $device_id
     * @param  mixed $title
     * @param  mixed $discription
     * @param  mixed $type
     * @return void
     */
    public function push_notification(Array $device_id, string $title, string $discription, string $type = "" ){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
        'registration_ids' => $device_id,
        'collapse_key' => 'type_a',
        'notification' => array (
                'title' =>$title,
                'body' => $discription,
            )
        );
        $SettingModel = new SettingModel();
        $firebase_setting = $SettingModel->get_setting(FIREBASE_SERVER_KEY);
        $headers = array('Authorization:key='.$firebase_setting['SETTING_VALUE'],'Content-Type:application/json');
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
      
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;

    }
  
}
