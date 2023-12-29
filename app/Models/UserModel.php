<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 */
class UserModel extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table      = 'tbl_user_master';    
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
    protected $allowedFields = ['FIRST_NAME',  
                                'LAST_NAME',    
                                'USERNAME',
                                'EMAIL_ID',
                                'PASSWORD',
                                'PROFILE_IMAGE',
                                'DOB',
                                'STREET',
                                'CITY',
                                'ZIPCODE',
                                'STATE',
                                'PAYPAL_EMAIL_ID',
                                'ROLE_ID',
                                'STATUS',
                                'DEVICE_TOKON',
                                'DEVICE_TYPE',
                                'FORGOT_VERIFYCODE',
                                'LOGIN_KEY',
                                'EMAIL_VERIFICATION_CODE',
                                'GENDER'
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
                                    'FIRST_NAME'            => 'alpha_space',   
                                    'LAST_NAME'             => 'alpha_space',
                                    'USERNAME'              => 'required|min_length[3]|is_unique[tbl_user_master.USERNAME]',
                                    'EMAIL_ID'              => 'required|valid_email|is_unique[tbl_user_master.EMAIL_ID]',
                                    'PASSWORD'              => 'required|min_length[8]',
                                    //'PROFILE_IMAGE'         => '',
                                    'DOB'                   => 'valid_date',
                                    //'STREET'                => 'alpha_numeric_space',       
                                    //'CITY',                 
                                    // 'ZIPCODE',
                                    // 'STATE',
                                    'PAYPAL_EMAIL_ID'       => 'required|valid_email|is_unique[tbl_user_master.PAYPAL_EMAIL_ID]',
                                    // 'ROLE_ID',
                                    // 'STATUS',
                                    // 'DEVICE_TOKON',
                                    // 'DEVICE_TYPE',
                                    // 'FORGOT_VERIFYCODE',
                                    // 'LOGIN_KEY',
                                    // 'EMAIL_VERIFICATION_CODE',
                                    
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
			"first_name" => 'required|'.$this->validationRules['FIRST_NAME'],
			"last_name"  => $this->validationRules['LAST_NAME'],
			"username"   => $this->validationRules["USERNAME"],
			"email"      => $this->validationRules["EMAIL_ID"],
            'password'   => $this->validationRules["PASSWORD"],
            "dob"        => 'required|'.$this->validationRules["DOB"],
            "street"     => 'required',
            'city'       => 'required',
            'zipcode'    => 'required',
            'state'      => 'required',
            'paypalid'   => $this->validationRules['PAYPAL_EMAIL_ID'],
            'tax_id'     => 'required',
            'device_tokon' => 'required',
            'device_type'   => 'required|in_list[I,A]',
            'agree_terms'    => 'required|in_list[YES]',
            'agree_rule'     => 'required|in_list[YES]',
            'agree_liabilty' => 'required|in_list[YES]'
			
		);
        return $validation;
    }
        
    /**
     * get_api_rules_edit
     *
     * @return void
     */
    public function get_api_rules_edit($id){
        $validation = array(
			"first_name" => 'required|'.$this->validationRules['FIRST_NAME'],
			"username"   => 'required|min_length[3]|is_unique[tbl_user_master.USERNAME,tbl_user_master.ID,{user_edit_id}]',
			"email"      => 'required|valid_email|is_unique[tbl_user_master.EMAIL_ID,ID,{user_edit_id}]',
            "dob"        => 'required|'.$this->validationRules["DOB"],
            "street"     => 'required',
            'city'       => 'required',
            'zipcode'    => 'required',
            'state'      => 'required',
            'paypalid'   => 'required|valid_email|is_unique[tbl_user_master.PAYPAL_EMAIL_ID,ID,{user_edit_id}]',
            'tax_id'     => 'required'
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
			"first_name" => [
                'required' => 'Name is Required',
                'alpha_space' => 'Please Enter Valid Name'
            ],
            'full_name' => [
                'required' => 'Name is Required',
                'alpha_space' => 'Please Enter Valid Name'
            ],
            'login_type'=> [
                'required' => 'Login Type Is Required',
                'in_list' => 'The Login Type field must be one of: GOOGLE,FACEBOOK.'
            ],
            'social_key' =>[
                'required' => 'Social Key Is Required'
            ],
			"last_name"  => [
                'alpha_space' => 'Please Enter Valid Last Name'
            ],
			"username"   => [
                'required' => 'Username is Required',
                'alpha_numeric_space' => 'Please Enter Valid Username',
                'min_length' => 'Username Minimum length must be 3',
                'is_unique' => 'Username Already Exists'
            ],
			"email"      => [
                'required' => 'Email Id is Required',
                'valid_email' => 'Please Enter Valid Email',
                'is_unique' => 'Email Id Already Exists'
            ],
            "password"      => [
                'required' => 'Password is Required',
                'min_length' => 'Minimum length of password must be 8'
            ],
            "dob"        => [
                'required' => 'Date of Birth is Required',
                'valid_date' => 'Please Enter Valid Date'
            ],
            "street"     => [
                'required' => 'Street is Required'
            ],
            'city'       => [
                'required' => 'City is Required'
            ],
            'zipcode'    => [
                'required' => 'Zipcode is Required'
            ],
            'state'      => [
                'required' => 'State is Required'
            ],
            'tokon' =>[
                'required' => 'tokon is Required'
            ],
            'paypalid'   => [
                'required' => 'Paypal Id is Required',
                'valid_email' => 'Enter Valid Paypal Id',
                'is_unique' => 'Paypal Id Already Exists'
            ],
            'tax_id'     => [
                'required' => 'State is Required'
            ],
            'agree_terms'    => [
                'required' => 'Agree Terms to Register',
                'in_list'  =>  'Agree Terms to Register'
            ],
            'agree_rule'     => [
                'required' => 'Agree Rules to Register',
                'in_list'  =>  'Agree Rules to Register'
            ],
            'agree_liabilty' => [
                'required' => 'Agree Liability to Register',
                'in_list'  =>  'Agree Liability to Register'
            ],
            'device_tokon' => [
                'required' => 'device tokon is required'
            ],
            'device_type' => [
                'required' => 'device type is required',
                'in_list' => 'Only I and A is Allowed'
            ],
            'user_id' => [
                'required' => 'User ID is required',
            ],
            'following_user_id' => [
                'required' => 'Following User ID is required',
            ],
            'user_email' => [
                'required' => 'User EMAIL ID is required',
            ],
            
		];
        return $messages;
    }
    
      
    /**
     * authenticate
     *
     * @param  mixed $email
     * @param  mixed $password
     * @param  mixed $type
     * @return void
     */
    public function authenticate($email, $password, $type)
    {
		
		$whereclause = array(  $this->allowedFields[4] => $password, $this->allowedFields[12] => $type, $this->allowedFields[13] => '1');
        $query = $this->db->table($this->table)
                        ->groupStart()
                        ->where($this->allowedFields[3], $email)
                        ->orWhere($this->allowedFields[2], $email)
                        ->groupEnd()
                        ->where($whereclause);
						
		if ($query->countAllResults() > 0){
			
            $session = session();
			$data =  $this->db->table($this->table)
                        ->groupStart()
                        ->where($this->allowedFields[3], $email)
                        ->orWhere($this->allowedFields[2], $email)
                        ->groupEnd()
                        ->where($whereclause)
                        ->get()->getRowArray();
			$ses_data[$this->primaryKey] = $data[$this->primaryKey];
			$ses_data[$this->allowedFields[0]] = $data[$this->allowedFields[0]];
			$ses_data[$this->allowedFields[1]] = $data[$this->allowedFields[1]];
			$ses_data[$this->allowedFields[2]] = $data[$this->allowedFields[2]];
			$ses_data[$this->allowedFields[3]] = $data[$this->allowedFields[3]];
            $ses_data[$this->allowedFields[5]] = $data[$this->allowedFields[5]];
            $ses_data[$this->allowedFields[14]] = $data[$this->allowedFields[14]];
			$ses_data[$this->createdField] = $data[$this->createdField];
			$ses_data['logged_in'] = TRUE;
			$session->set($ses_data);
			return true;
        } else {
            return false;
        }
    }
    
      
    /**
     * user_login
     *
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $device_type
     * @param  mixed $device_tokon
     * @return void
     */
    public function user_login($username, $password, $device_type, $device_tokon){
        $whereclause = array(  $this->allowedFields[4] => md5($password), $this->allowedFields[13] => '1');
        $query = $this->db->table($this->table)
                        ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
                        ->groupStart()
                        ->where($this->allowedFields[3], $username)
                        ->orWhere($this->allowedFields[2], $username)
                        ->groupEnd()
                        ->where($whereclause);
        if ($query->countAllResults() > 0){
			$data =  $this->db->table($this->table)
                        ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
                        ->groupStart()
                        ->where($this->allowedFields[3], $username)
                        ->orWhere($this->allowedFields[2], $username)
                        ->groupEnd()
                        ->where($whereclause)
                        ->get()->getRowArray();
            if($data['BLOCK'] == 'YES'){
                return 403;
            }
            $login = array(
                'LOGIN_KEY' => $this->getLoginKey($data[$this->primaryKey]),
                'DEVICE_TOKON' => $device_tokon,
                'DEVICE_TYPE' => $device_type
            );
            $logged_in = $this->updateUserdetails($login, array('ID' => $data['ID']));
            if($logged_in){
                $ses_data = array();
                $ses_data[$this->primaryKey] = $data[$this->primaryKey];
                $ses_data[$this->allowedFields[0]] = $data[$this->allowedFields[0]];
                $ses_data['LOGIN_KEY'] = $login['LOGIN_KEY'];
                $ses_data['USER_ROLE'] = $data['NAME'];
                $ses_data['PROFILE_IMAGE'] = null;
                if (!empty($data['PROFILE_IMAGE'])) {
                    $ses_data['PROFILE_IMAGE'] = base_url() . USERPROFILEIMAGEPATH . '/' . $data['ID'] . '/' . $data['PROFILE_IMAGE'];
                }

                $ses_data['ALLOW_NOTIFICATION'] = $data['ALLOW_NOTIFICATION'];

                if($data['NAME'] == 'REVIEWER'){
                    $access = json_decode($data['ACCESS_ROLE'], true);
                    $ses_data['ACCESS_ROLE'] = $access;
                }
                $ses_data['LOGGED_IN'] = TRUE;
                return $ses_data;
            }
            return false;
           
			
        } else {
            return false;
        }
    }
    
    /**
     * social_login
     *
     * @param  mixed $username
     * @param  mixed $email
     * @param  mixed $full_name
     * @param  mixed $login_type
     * @param  mixed $social_key
     * @return void
     */
    // public function social_login($username, $email, $full_name, $login_type, $social_key, $device_type, $device_tokon){
    //     $whereclause = array(  $this->allowedFields[3] => $email, $this->allowedFields[13] => '1');
    //     $create_user = array(
    //         'LOGIN_TYPE'   => $login_type,
    //         'SOCIAL_KEY'   => $social_key,
    //         'DEVICE_TYPE'  => $device_type,
    //         'DEVICE_TOKON' => $device_tokon
    //     );
    //     $loginkey= false;
    //     if($this->if_email_exists($email)){

    //         $userlogin = $this->updateUserdetails($create_user, array('EMAIL_ID'=> $email));
    //         if($userlogin){
    //             $data =  $this->getUserbyEmail($email);
    //             $updated = $this->updateUserdetails(array('LOGIN_KEY' => $this->getLoginKey($data[$this->primaryKey])), array('EMAIL_ID'=> $email));
    //             if($updated){
    //                 $login_key = true;
    //             }
    //         }
            
    //     }else{
    //        $create_user['USERNAME'] = $username;
    //        $create_user['EMAIL_ID'] = $email;
    //        $create_user['FIRST_NAME'] = $full_name;
    //        $create_user['ROLE_ID'] = 4;
    //        $user = $this->create_user($create_user);
    //        if($user){
    //             $updated = $this->updateUserdetails(array('LOGIN_KEY' => $this->getLoginKey($user)), array('EMAIL_ID'=> $email));
    //             if($updated){
    //                 $login_key = true;
    //             }
    //        }else{
    //             return false;
    //        }
    //     }
    //     if($login_key){
    //         $data =  $this->db->table($this->table)
    //                     ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
    //                     ->where($whereclause)
    //                     ->get()->getRowArray();
    //         if(!$data){
    //             return false;
    //         }
    //         if($data['BLOCK'] == 'YES'){
    //             return 403;
    //         }
    //         $ses_data = array();
    //         $ses_data[$this->primaryKey] = $data[$this->primaryKey];
    //         $ses_data[$this->allowedFields[0]] = $data[$this->allowedFields[0]];
    //         $ses_data['LOGIN_KEY'] = $data['LOGIN_KEY'];
    //         $ses_data['USER_ROLE'] = $data['NAME'];
    //         $ses_data['ALLOW_NOTIFICATION'] = $data['ALLOW_NOTIFICATION'];
    //         $ses_data['IS_PROFILE_UPDATED_SOCIAL'] = $data['IS_PROFILE_UPDATED_SOCIAL'];
    //         if($data['NAME'] == 'REVIEWER'){
    //             $access = json_decode($data['ACCESS_ROLE'], true);
    //             $ses_data['ACCESS_ROLE'] = $access;
    //         }
    //         $ses_data['LOGGED_IN'] = TRUE;
    //         return $ses_data;
    //     }
    //     return false;

    // }

    /**
     * demo_social_login
     *
     * @param  mixed $username
     * @param  mixed $email
     * @param  mixed $mobile
     * @param  mixed $full_name
     * @param  mixed $login_type
     * @param  mixed $social_key
     * @return void
     */
    public function social_login($username, $email, $mobile, $full_name, $login_type, $social_key, $device_type, $device_tokon)
    {
        $whereclause = array($this->allowedFields[3] => $email, $this->allowedFields[14] => '1');
        if ($login_type === "APPLE" && !isset($email) || empty($email)) {
            $whereclause = array($this->allowedFields[4] => $mobile, $this->allowedFields[14] => '1');
        }
        $create_user = array(
            'LOGIN_TYPE'   => $login_type,
            'SOCIAL_KEY'   => $social_key,
            'DEVICE_TYPE'  => $device_type,
            'DEVICE_TOKON' => $device_tokon,
            'MOBILE'       => $mobile
        );
        $loginkey = false;

        if (isset($email) && !empty($email)) {


            if (isset($mobile) || !empty($mobile)) {
                $checkMobile = $this->if_mobile_exists($mobile);
                if ($checkMobile) {
                    return "MobileExists";
                }
            }

            if ($this->if_email_exists($email)) {
                $userlogin = $this->updateUserdetails($create_user, array('EMAIL_ID' => $email));
                if ($userlogin) {
                    $data =  $this->getUserbyEmail($email);
                    $updated = $this->updateUserdetails(array('LOGIN_KEY' => $this->getLoginKey($data[$this->primaryKey])), array('EMAIL_ID' => $email, 'ID' => $data[$this->primaryKey]));
                    if ($updated) {
                        $login_key = true;
                    }
                }
            } else {
                $create_user['USERNAME'] = $username;
                $create_user['EMAIL_ID'] = $email;
                $create_user['FIRST_NAME'] = $full_name;
                $create_user['ROLE_ID'] = 4;
                $user = $this->create_user($create_user);
                if ($user) {
                    $updated = $this->updateUserdetails(array('LOGIN_KEY' => $this->getLoginKey($user)), array('EMAIL_ID' => $email, 'ID' => $user));
                    if ($updated) {
                        $login_key = true;
                    }
                } else {
                    return false;
                }
            }
        } else {
            if (isset($mobile) && !empty($mobile)) {
                if ($this->if_mobile_exists($mobile)) {
                    $userlogin = $this->updateUserdetails($create_user, array('MOBILE' => $mobile));
                    if ($userlogin) {
                        $data =  $this->getUserbyMobile($mobile);
                        $updated = $this->updateUserdetails(array('LOGIN_KEY' => $this->getLoginKey($data[$this->primaryKey])), array('MOBILE' => $mobile, 'ID' => $data[$this->primaryKey]));
                        if ($updated) {
                            $login_key = true;
                        }
                    }
                } else {
                    $create_user['USERNAME'] = $username;
                    $create_user['EMAIL_ID'] = $email;
                    $create_user['FIRST_NAME'] = $full_name;
                    $create_user['ROLE_ID'] = 4;
                    $user = $this->create_user($create_user);
                    if ($user) {
                        $updated = $this->updateUserdetails(array('LOGIN_KEY' => $this->getLoginKey($user)), array('MOBILE' => $mobile, 'ID' => $user));
                        if ($updated) {
                            $login_key = true;
                        }
                    } else {
                        return false;
                    }
                }
            }
        }

        if ($login_key) {
            // print_r($whereclause); die;
            $data =  $this->db->table($this->table)
                ->join('tbl_role', 'tbl_role.R_ID = ' . $this->table . '.ROLE_ID', 'left')
                ->where($whereclause)
                ->get()->getRowArray();
            // echo "Login Key ". $login_key; die;
            if (!$data) {
                return false;
            }
            if ($data['BLOCK'] == 'YES') {
                return 403;
            }
            $ses_data = array();
            $ses_data[$this->primaryKey] = $data[$this->primaryKey];
            $ses_data[$this->allowedFields[0]] = $data[$this->allowedFields[0]];
            $ses_data['LOGIN_KEY'] = $data['LOGIN_KEY'];
            $ses_data['USER_ROLE'] = $data['NAME'];
            $ses_data['ALLOW_NOTIFICATION'] = $data['ALLOW_NOTIFICATION'];
            $ses_data['IS_PROFILE_UPDATED_SOCIAL'] = $data['IS_PROFILE_UPDATED_SOCIAL'];
            if ($data['NAME'] == 'REVIEWER') {
                $access = json_decode($data['ACCESS_ROLE'], true);
                $ses_data['ACCESS_ROLE'] = $access;
            }
            $ses_data['LOGGED_IN'] = TRUE;
            return $ses_data;
        }
        return false;
    }
    
    /**
     * check_user_loggedin
     *
     * @param  mixed $user_id
     * @return void
     */
    public function check_user_loggedin($login_key){
        $data = $this->db->table($this->table)
                         ->select('LOGIN_KEY')
                         ->where('LOGIN_KEY', $login_key)
                         ->countAllResults();
        if($data > 0){
            //User is not logged In
            return true;
        }             
        //User is already logged In
        return false;   
    }
    
    /**
     * getUserByloginKey
     *
     * @param  mixed $login_key
     * @return void
     */
    public function getUserByloginKey($login_key){
        $data = $this->db->table($this->table)
                         ->select('ID')
                         ->where('LOGIN_KEY', $login_key)
                         ->get()->getRowArray();
        return $data;
    }

    public function logout_user($user_id){
        return $this->updateUserdetails(array('LOGIN_KEY'=>''),array($this->allowedFields[0] => $user_id));
    }
    
    /**
     * genrate_loginkey
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getLoginKey($user_id){
        $salt = "23df$#%%^66sd$^%fg%^sjgdk90fdklndg099ndfg09LKJDJ*@##lkhlkhlsa#$%";
        $login_key = hash('sha1',$salt.$user_id.time());
        return $login_key;
    }
    
    /**
     * getUserDetailsById
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getUserDetailsById($user_id){
        $whereclause = array(
            $this->primaryKey => $user_id
        );
        $query = $this->db->table($this->table)
                        ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
                        ->where($whereclause);
                        
        return $query->get()->getRowArray();                
    }
    
    /**
     * getUserbyEmail
     *
     * @param  mixed $email
     * @return void
     */
    public function getUserbyEmail($email){
        $whereclause = array(
            'EMAIL_ID' => $email
        );
        $query = $this->db->table($this->table)
                        ->where($whereclause);
                        
        return $query->get()->getRowArray();
    }
    
    /**
     * updateUserdetails
     *
     * @param  mixed $details
     * @return void
     */
    public function updateUserdetails($details, $where){
       return $this->db->table($this->table)
                       ->set($details)
                       ->where($where)
                       ->update();
      
    }
    
    /**
     * create_user
     *
     * @param  mixed $userdetails
     * @return void
     */
    public function create_user($userdetails){
        $result = $this->db->table($this->table)->insert($userdetails);
        return  $this->db->insertID();
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
     * logout
     *
     * @return void
     */
    public function logout(){
      $session = session();
      return $session->destroy();
    }
    
    /**
     * reset_password
     *
     * @return void
     */
    public function reset_password($password, $where){
        return $this->db->table($this->table)
                       ->set($this->allowedFields[4], md5($password))
                       ->where($where)
                       ->update();
    }
    
    /**
     * is_valid_user
     *
     * @param  mixed $where
     * @return void
     */
    public function is_valid_user($where){
        $result = $this->db->table($this->table)
                 ->where($where)
                 ->countAllResults();
        if($result > 0){
            return true;
        }
        return false;
    }
    
    /**
     * get_user_details
     *
     * @return void
     */
    public function get_user_details(){
        $builder = $this->db->table($this->table)
                    ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
                    ->where('status','1');
        $setting = [
            "setTable" => $builder,
            "setDefaultOrder" => [
                ["tbl_user_master.UPDATED_AT","DESC"]
            ],
            "setSearch" => ["ID", "FIRST_NAME", "LAST_NAME", "USERNAME", "EMAIL_ID","tbl_role.Name" ],
            "setOrder"  => [null,null,"date"],
            "setOutput" => [
                "ID",
                 function($row){
                    return $row['FIRST_NAME'].' '.$row['LAST_NAME'];
                },
                "USERNAME",
                "EMAIL_ID",
                 function($row){
                    $class = 'info';
                    if($row['NAME'] == 'REVIEWER'){
                        $class = 'warning';
                    }
                    if($row['NAME'] == 'ADMIN'){
                         $class = 'success';
                    }
                     return <<<EOF
                             <div class="badge badge-{$class} badge-shadow">{$row['NAME']}</div>
                        EOF;
                   
                },
                function($row){
                    $access = array('ACCEPT-DECLINE' => 'Accept Decline Score', 'CHANGE-SCORE' => 'Change Score', 'DESQUALIFY' => 'Disqualify Participant', 'All-PARTICIPANT'=>'Access All Participant');
                    $check="";
                    $accessroles = json_decode($row['ACCESS_ROLE'], true);
                    if($row['NAME'] == 'REVIEWER'){
                        $check ='<div class="form-group">';
                        foreach($access as $key =>$value ){
                            $check.='<div class="form-check form-check-inline">';
                            if(is_array($accessroles) && in_array($key, $accessroles)){
                                $check.='<input class="access-check" data-id='.$row['ID'].' name="access_check'.$row['ID'].'[]" type="checkbox" id='.$row['ID'].' value='.$key.' checked>';

                            }else{
                                $check.='<input class="access-check" data-id='.$row['ID'].' name="access_check'.$row['ID'].'[]" type="checkbox" id='.$row['ID'].' value='.$key.'>';

                            }
                            $check.='<label class="form-check-label" id='.$row['ID'].'>'.$value.'</label>';
                            $check.= '</div>';
                        }
                        $check .='</div>';

                    }
                    return $check;
                   
                   
                },
                function($row){
                    $blockuser = "<button class='btn btn-info btnuserunblock' data-id='{$row["ID"]}' style='font-size: 10px;'>UNBLOCK USER</button>";
                    if($row['BLOCK']=="NO"){
                        $blockuser = "<button class='btn btn-danger btnuserblock' data-id='{$row["ID"]}' style='font-size: 10px;'>BLOCK USER</button>";
                    }
                    return <<<EOF
                        <button class="btn btn-primary btnuserdetails" data-id='{$row["ID"]}' data-toggle="modal" data-target=".bd-edit-user-modal-lg" >Edit</button>
                        <button class="btn btn-danger btnuserdelete" data-id='{$row["ID"]}' style="font-size: 20px;"><i class="ion-trash-a" data-pack="default"></i></button>
                        {$blockuser}
                        EOF;
                }
            ]
        ];
        return $setting;

    }
    
    /**
     * set_reset_token
     *
     * @param  mixed $email
     * @return void
     */
    public function set_reset_token($email, $tokon){
       if($this->if_email_exists($email)){
		$set_tokon = $this->updateUserdetails(array('FORGOT_VERIFYCODE'=> $tokon), array('EMAIL_ID'=> $email));
        if($set_tokon){
            return true;
        }
       }
       return 403;
    }
        
    /**
     * change_password_tokon
     *
     * @param  mixed $tokon
     * @param  mixed $password
     * @return void
     */
    public function change_password_tokon($tokon, $password){
        return $this->update_user(array('FORGOT_VERIFYCODE' => '', 'PASSWORD'=>md5($password)),array('FORGOT_VERIFYCODE'=> $tokon));
    }
    /**
     * if_email_exists
     *
     * @param  mixed $email
     * @return void
     */
    public function if_email_exists($email){
        $whereclause = array( 'EMAIL_ID' => $email, 'STATUS' => 1, 'BLOCK' => 'NO');
        $count = $this->db->table($this->table)
                        ->where($whereclause)
                        ->countAllResults();
        if($count>0){
            return true;
        }
        return false;
    }

    /**
     * if_mobile_exists
     *
     * @param  mixed $mobile
     * @return void
     */
    public function if_mobile_exists($mobile)
    {
        $whereclause = array('MOBILE' => $mobile, 'STATUS' => 1, 'BLOCK' => 'NO');
        $count = $this->db->table($this->table)
            ->where($whereclause)
            ->countAllResults();
        if ($count > 0) {
            return true;
        }
        return false;
    }

    /**
     * update_user
     *
     * @param  mixed $details
     * @param  mixed $where
     * @return void
     */
    public function update_user($details, $where){
        return $this->db->table($this->table)
                       ->set($details)
                       ->where($where)
                       ->update();
    }
    
    /**
     * api_auth
     *
     * @return void
     */
    public function api_auth(){
        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
			$query = $this->db->table('tbl_api_auth')
					->where(array('username'=> $_SERVER['PHP_AUTH_USER'], 'pass' =>$_SERVER['PHP_AUTH_PW']));
			if($query->countAllResults() > 0){
				return true;
			}
		}
		return false;
    }
        
    /**
     * get_user_balance_point
     *
     * @param  mixed $user_id
     * @return void
     */
    public function get_user_balance_point($user_id){
       $count = $this->db->table('tbl_user_points')->where('USER_ID', $user_id)->countAllResults();
       if($count>0){
           $points = $this->db->table('tbl_user_points')->where('USER_ID', $user_id)->get()->getRowArray();
           return $points['POINTS'];
       }
       return 0;
    }
    
    /**
     * is_wallet_created
     *
     * @param  mixed $user_id
     * @return void
     */
    public function is_wallet_created($user_id){
        $count = $this->db->table('tbl_user_points')->where('USER_ID', $user_id)->countAllResults();
       if($count>0){
           return true;
       }
       return false;
    }

    /**
     * get_user_by_id
     *
     * @param [int] $user_id
     * @return void
     */
    public function get_user_by_id( $user_id ){
        return $this->db->table($this->table)->where('ID', $user_id)->get()->getRowArray();
    }

    /**
     * get_admin_emails
     * 
     * @return array
     */
    public function get_admin_emails(){
        $emails = $this->db->table($this->table)->select('EMAIL_ID')->where('ROLE_ID', 1)->get()->getResultArray();
        if(empty($emails)){
            return NULL;
        }
        else
        {
            if(count($emails) == 1){
                return $emails[0]['EMAIL_ID'];
            }
            else{
                return implode(', ', array_column($emails,'EMAIL_ID'));
            }
        }
    }
    
    /**
     * getUserByRole
     *
     * @param  mixed $role
     * @return void
     */
    public function getUserByRole($role){
        $builder = $this->db->table($this->table)
                ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
                ->where(array('tbl_role.NAME'=> $role, 'status'=>'1', 'BLOCK' => 'NO'));
        return $builder->get()->getResultArray();
                
    }
    
    /**
     * check_user_role
     *
     * @param  mixed $id
     * @param  mixed $role
     * @return void
     */
    public function check_user_role($id, $role){
        $builder = $this->db->table($this->table)
                ->join('tbl_role', 'tbl_role.R_ID = '.$this->table.'.ROLE_ID', 'left')
                ->where(array('tbl_role.NAME'=> $role, 'status'=>'1', 'BLOCK' => 'NO', $this->table.'ID' => $id));
        if($builder->countAllResults() > 0){
            return true;
        }
        return false;
       
    }
    
    /**
     * get_users_count
     *
     * @return void
     */
    public function get_users_count(){
        return $this->db->table($this->table)->where('STATUS' , '1')->countAllResults();
    }
    
    /**
     * is_tokon_valid
     *
     * @return void
     */
    public function is_tokon_valid($tokon){
        return $this->db->table($this->table)->where(array('FORGOT_VERIFYCODE'=> $tokon, 'STATUS' => 1))->countAllResults();
    }    
    /**
     * check_user_access
     *
     * @param  mixed $user_id
     * @return void
     */
    public function check_user_access($user_id){
        return $this->db->table($this->table)->select('ACCESS_ROLE')->where(array('ID'=> $user_id, 'STATUS' => 1))->get()->getRowArray();
        
    }

    public  function  ContestWon($user_id){
        return $this->db->table($this->table)
            ->join('tbl_participant','tbl_participant.USER_ID = tbl_user_master.ID')
            ->join('tbl_contest_result','tbl_contest_result.P_ID=tbl_participant.p_id')
            ->where('ID',$user_id)
            ->countAllResults();
    }

    public function deleteUser($data){
        return $this->db->table($this->table)
        ->where(array('ID' => $data['id'], 'EMAIL_ID' => $data['email']))
        ->delete();
    }

}
