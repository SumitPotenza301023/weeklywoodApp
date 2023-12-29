<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\ParticipantModel;
use App\Models\ContestModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

	protected $login_key = '';

	protected $access_token ='';

	protected $user_id = '';
	
	#Number of winners per round, matrix
	protected $wr;

	protected $partcipants = array();

	protected $logging_required_api = array(
		'logout',
		'getuser',
		'edituser',
		'promocodelist',
		'get-payment-settings',
		'confirm-payment',
		'homeapi',
		'reset-password',
		'contact-us',
		'get-user-follower-and-following-info',
		'add-user-following',
		'join-contest',
		'get-user-score',
		'get-user-score-all',
		'reviewersupervisorapi',
		'getnotifications',
		'notificationaccess',
		'user-profile',
		'history'
	);

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['cookie', 'form', 'url'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->db= \Config\Database::connect();
		$this->email = \Config\Services::email();
		$this->validation =  \Config\Services::validation();
		$this->language = \Config\Services::language();
		$this->session = \Config\Services::session();
		$this->language->setLocale($this->session->lang);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
    
    /**
     * sendResponse
     *
     * @param  mixed $response
     * @return void
     */
    public function sendResponse($response) {
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }
  	
	/**
	 * uploadFilefunc
	 *
	 * @param  mixed $key
	 * @param  mixed $type
	 * @param  mixed $user_id
	 * @param  mixed $profile_images
	 * @param  mixed $profileimage
	 * @return void
	 */
	public function uploadFilefunc($key, $type, $user_id, $profile_images, $profileimage)
	{
		if( empty( $type ) ){
			$type = 'image';
		}

		if( empty( $profile_images ) ){
			$profile_images = 'profile_images';
		}

		if( empty( $profileimage ) ){
			$profileimage = 'profileimage';
		}
		
		if (!empty($_FILES[$key]["name"])) {

			$folder =  ROOTPATH . UPLOADPATH.$profile_images.'/' . $user_id;

			if (!is_dir($folder)) {
				mkdir($folder, 0777, TRUE);
			}

			// print_r($folder);
			// die;

			$uid = uniqid();
			$ext = pathinfo($_FILES[$key]["name"], PATHINFO_EXTENSION);

			$filename = $profileimage . $uid . '.' . $ext;

			if ($filedata = $this->request->getFiles()) {
				if ($file = $filedata[$key]) {

					if ($file->isValid() && !$file->hasMoved()) {
						//$newName = $file->getRandomName(); //This is if you want to change the file name to encrypted name
						$file->move($folder, $filename);

						// You can continue here to write a code to save the name to database
						// db_connect() or model format
						
						return $filename;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} 
		return false;
	}
	
	/**
	 * uploadMultipleFilefunc
	 *
	 * @param  mixed $key
	 * @param  mixed $type
	 * @param  mixed $user_id
	 * @param  mixed $prefix
	 * @return void
	 */
	public function uploadMultipleFilefunc($key, $type, $user_id, $prefix)
    {
		if(empty($type)){
			$type = 'image';
		}
		if(!empty($user_id)){
	        $folder = ROOTPATH . BANNERFOLDERPATH . '/'.$user_id;

		}
	    $folder = ROOTPATH . BANNERFOLDERPATH;
		

        if (!is_dir($folder)) {
            mkdir($folder, 0777, TRUE);
        }

        $all_doc_imgs = array();
        if ($this->request->getFileMultiple($key)) {

            foreach ($this->request->getFileMultiple($key) as $file) {

                if ($file->isValid() && !$file->hasMoved()) {
                    $fname = $file->getClientName(); 
					$uid = uniqid();
					$ext = pathinfo($fname, PATHINFO_EXTENSION);

					$filename = $prefix . $uid . '.' . $ext;
					if($prefix == "banner"){
						print_r($folder);
						
					}
					$file->move($folder, $filename);

					$all_doc_imgs[] = $filename;      
					
                } else {
                    return false;
                }
            }
			

        $allfiles = implode(',', $all_doc_imgs);
           return  $allfiles;
        } 
        return false;
    }
	
	/**
	 * random_key
	 *
	 * @param  mixed $length
	 * @return void
	 */
	public function random_key($length=10)
	{
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$email_token = '';
		for ($i = 0; $i < $length; $i++) {
			  $email_token .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $email_token;
	}
	
	/**
	 * send_mail
	 *
	 * @param  mixed $to
	 * @param  mixed $subject
	 * @param  mixed $message
	 * @return void
	 */
	public function send_mail($to, $subject, $message){
		$this->email->setFrom('ajay@weeklywodthrowdown.com', 'Weekly Throw Down');
		$this->email->setTo($to);
		$this->email->setSubject($subject);
		$this->email->setMessage($message);		
		$this->email->setMailtype('html');
		return $this->email->send();
	}
	
	/**
	 * slugify
	 *
	 * @param  mixed $text
	 * @param  mixed $divider
	 * @return void
	 */
	public function slugify($text, string $divider = '-'){
		// replace non letter or digits by divider
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		// trim
		$text = trim($text, $divider);
		// remove duplicate divider
		$text = preg_replace('~-+~', $divider, $text);
		// lowercase
		$text = strtolower($text);
		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}
	
	/**
	 * api_auth
	 *
	 * @param  mixed $username
	 * @param  mixed $password
	 * @return void
	 */
	public function api_auth(){
		$usermodel = new UserModel();
		return $usermodel->api_auth();
				 
	}	
	/**
	 * api_access
	 *
	 * @return void
	 */
	public function api_access(){
		 if($this->api_auth()){
            foreach (getallheaders() as $name => $value) {
                $headers[$name] = $value; 
            }
			$uri = service('uri', current_url(true));
			if(in_array( $uri->getSegment(3, 'segment'), $this->logging_required_api )  || in_array( $uri->getSegment(2, 'segment'), $this->logging_required_api )){
				if(!isset($headers['Login-Key']) || $headers['Login-Key']==""){
					$error = true;
					$message = array("error"=>"Please Provide login key!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 406));   
            	}
			}
            if(isset($headers['Login-Key']) && $headers['Login-Key']!=""){
				$usermodel =  new UserModel();
				if($usermodel->check_user_loggedin($headers['Login-Key']) == false){
                	$error = true;
					$message = array("error"=>"Seems like you are logged in another device or your account is inactived/deleted!");
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 406));   
            	}
				
                $this->login_key = $headers['Login-Key'];
				$user = $usermodel->getUserByloginKey($this->login_key);
				
				if(!empty($user)){
					$this->user_id = $user['ID'];
				}
            }
            if(isset($headers['Access-Token']) && $headers['Access-Token']!=""){
                    if($headers['Access-Token'] == ACCESS_TOKON){
                        $this->access_token = $headers['Access-Token'];
                    }else{
						$error = true;
						$message = array("error"=>"Invalid Access Tokon");
						echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));   
                    }   
            }
            else{
				$error = true;
				$message = array("error"=>"Access token is Required!");
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
            }
        }else{
				$error = true;
				$message = array("error"=>"Invalid Auth Cridentials!!");
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error, 'status' => 403));
        }
	}
	
	/**
	 * date_format_weekly
	 *
	 * @param  mixed $date
	 * @return void
	 */
	public function date_format_weekly($date){
		$date=date_create($date);
        return date_format($date,"Y-m-d");
	}
	
	/**
	 * datetime_format_weekly
	 *
	 * @param  mixed $date
	 * @return void
	 */
	public function datetime_format_weekly($date){
		$date=date_create($date);
        return date_format($date,"Y-m-d H:i:s");
	} 
	
	/**
	 * current_week_monday
	 *
	 * @return void
	 */
	public function current_week_monday(){
        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $this_week_sd = date("Y-m-d",$monday);
        return $this_week_sd;
    } 	
	/**
	 * next_week_monday
	 *
	 * @return void
	 */
	public function next_week_monday(){
        $monday = strtotime("next monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $this_week_sd = date("Y-m-d",$monday);
        return $this_week_sd;
    } 	
	/**
	 * next_week_sunday
	 *
	 * @return void
	 */
	public function next_week_sunday(){
        $monday = strtotime("next monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
        $this_week_ed = date("Y-m-d",$sunday);
        return $this_week_ed;
    }    
    /**
     * current_week_sunday
     *
     * @return void
     */
    public function current_week_sunday(){
        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
        $this_week_ed = date("Y-m-d",$sunday);
        return $this_week_ed;
    }
	
	/**
	 * date_diff
	 *
	 * @param  mixed $date
	 * @return void
	 */
	public function date_diff($date){
		$now = time(); // or your date as well
		$your_date = strtotime($date);
		$datediff = $your_date - $now ;

		return round($datediff / (60 * 60 * 24));
	}
	
	/**
	 * somethingwentwrong
	 *
	 * @return void
	 */
	public function somethingwentwrong(){
		$error = true;
		$message = array('error'=>"SOMETHING WENTWRONG!");
		echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 500));
	}
	
	/**
	 * is_reviwer
	 *
	 * @return void
	 */
	public function is_reviwer(){
		$usermodel = new UserModel();
		$users = $usermodel->get_user_by_id($this->user_id, 'REVIEWER');
		if($users){
			return true;
		}
		$error = true;
		$message = array('error'=>"ONLY REVIEWER CAN ACCESS THIS API'S");
		echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 422));
	}
	
	/**
	 * is_reviwersupervisour
	 *
	 * @return void
	 */
	public function is_reviwersupervisour(){
		$usermodel = new UserModel();
		$users = $usermodel->get_user_by_id($this->user_id, 'REVIEW-SUPERVISOR');
		if($users){
			return true;
		}
		$error = true;
		$message = array('error'=>"ONLY REVIEWER SUPERVISOR CAN ACCESS THIS API'S");
		echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error ,'status' => 422));
	}
	
	/**
	 * get_device_tokon
	 *
	 * @return void
	 */
	public function get_device_tokon(){
		$usermodel = new UserModel();
		$users = $usermodel->get_user_by_id($this->user_id);
		if(!empty($users)){
			return $users['DEVICE_TOKON'];
		}
		return false;
	}	
	/**
	 * __get_device_tokon
	 *
	 * @param  mixed $user_id
	 * @return void
	 */
	public function get_device_tokonByid($user_id){
		$usermodel = new UserModel();
		$users = $usermodel->get_user_by_id($user_id);
		if(!empty($users)){
			return $users['DEVICE_TOKON'];
		}
		return false;
	}
	
	/**
	 * firstplace
	 *
	 * @param  mixed $var
	 * @return void
	 */
	public function get_pricepool_distribution($contest_id)
	{
		try {
			$n = 0;
			$this->setparticipantranks($contest_id);
			
			$numberofparticipants = count($this->partcipants);
			
			$numberofwinners = $this->get_numberofwinners($numberofparticipants);

			#TIER 1
			$winners = floor($numberofwinners / 3);
			$wr[1] = array();
			$samescoretier1 = '';
			while ($n < $winners) {
				
				if(($n > 0) && ($this->partcipants[$n]['SCORE'] == $this->partcipants[$n-1]['SCORE'])){

					$wr[1][$n] = ["RANK" => $wr[1][$n - 1]['RANK'], "P_ID" => $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
				} else {
					$wr[1][$n] = ["RANK"=>$n+1,"P_ID"=> $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
				}
				$n++;
				if($this->partcipants[$n]['SCORE'] == $this->partcipants[$n-1]['SCORE']){



					$wr[1][$n] = ["RANK" => $wr[1][$n - 1]['RANK'], "P_ID" => $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
					if($this->partcipants[$n]['SCORE'] != $this->partcipants[$n+1]['SCORE']){
						if ($n == $winners) {

							$n++;
							break;
						}
					}
					if ($n == $winners) {
					$winners++;
					}
					
				}
				
			}
			
			#TIER 2
			$m = 0;
			
			$winners =  floor((2 * ($numberofwinners / 3)));
	
			while($n < $winners){
				
				if(($n > 0) && ($this->partcipants[$n]['SCORE'] == $this->partcipants[$n-1]['SCORE'])){

					// print_r($n);
					$wr[2][$m] = ["RANK" => $wr[2][$m - 1]['RANK'], "P_ID" => $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
				
				}else{
					// if ($n >= floor((2 * ($numberofwinners / 3)))) {
					// 	break;
					// }
				

					$wr[2][$m] = ["RANK"=>$n+1, "P_ID"=> $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
				
				}
				
				$n++;
				$m++;

				if ($this->partcipants[$n]['SCORE'] === $this->partcipants[$n - 1]['SCORE']) {

					if ($n == $winners) {

						$winners++;
						continue;
					}

				}
			}
			#TIER 3
			$o = 0;
			$samescoretier3 = '';
			$winners = floor((3 * ($numberofwinners / 3)));
			while($n < $winners){
				
				if(($n > 0) && ($this->partcipants[$n]['SCORE'] == $this->partcipants[$n-1]['SCORE'])){


					$wr[3][$o] = ["RANK" => $wr[3][$o - 1]['RANK'], "P_ID" => $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
				} else {

					$wr[3][$o] = ["RANK" => $n + 1, "P_ID" => $this->partcipants[$n]['P_ID'], "SCORE" => $this->partcipants[$n]['SCORE']];
				}
				$n++;
				$o++;

				if ($this->partcipants[$n]['SCORE'] === $this->partcipants[$n - 1]['SCORE']) {

					if ($n == $winners) {

						$winners++;
						continue;
					}
				}
			
			}
			$ContestModel = new ContestModel();
			$contest=$ContestModel->get_contest(array('C_ID'=> $contest_id));
			$entryfee = 0;
			if(!empty($contest)){
				$entryfee = $contest['CONTEST_POINTS'];
			}
			$PP = $this->get_pricepool($entryfee, $numberofparticipants);
			
			$PPT = .25 * $PP;
			$PPS = .3 * $PP;
			$PPF = .45 * $PP;
			$WF = count($wr[1]); #7
			$WS = count($wr[2]); #3
			$WT = count($wr[3]); #5
			$AF = $PPF / $WF;
			$AS = $PPS / $WS;
			$AT = $PPT / $WT;
			$W = floor($numberofwinners/3);
			$AFI = $PPF / round($numberofwinners / 3);
			$ASI = $PPS / round($numberofwinners / 3);
			if ($WS > round($numberofwinners / 3)) {
				$ATI = $PPT / ceil($numberofwinners / 3);
			} else {
				$ATI = $PPT / round($numberofwinners / 3);
			}
			

			#adjustment
			$PPF_Adj = $PPF + ($ASI * ($WF - $W)); #+2



			$PPS_Adj = $PPS - ($ASI * ($WF - $W)) + ($ATI * (($WS - $W) + ($WF - $W))); # 9 3

			$PPT_Adj = $PPT - (($ATI * (($WS - $W) + ($WF - $W)))); 
			
			$AF_Adj = $PPF_Adj / $WF;
			$AS_Adj = $PPS_Adj / $WS;
			$AT_Adj = $PPT_Adj / $WT;
			
			if($WF== $W && $WS == $W &&$WT > $W){
				$AF_Adj = $AF;
				$AS_Adj = $AS;
				$AT_Adj = $AT;
			}
		
			$AJ_TOTOL = ($AF_Adj * $WF) + ($AS_Adj * $WS) + ($AT_Adj * $WT);
	

			#set Rank
			$offical['TOTAL_ADJUSTMENT']=$AJ_TOTOL;
			$offical['TOTAL_TIER_1'] = round($PPF_Adj, 2);
			$offical['TOTAL_TIER_2'] = round($PPS_Adj, 2);
			$offical['TOTAL_TIER_3'] = round($PPT_Adj, 2);
			// round(4.123456, 3);
			$offical['TIER-1'] = round($AF_Adj, 2);
			$offical['TIER-2'] = round($AS_Adj, 2);
			$offical['TIER-3'] = round($AT_Adj, 2);
			$offical['RANKS'] = $wr;
			return $offical;
		}catch(exception $e){
			return false;
		}
	}
	
	/**
	 * get_pricepool
	 *
	 * @param  mixed $entryfee
	 * @param  mixed $numberofparticipants
	 * @return void
	 */
	public function get_pricepool(float $entryfee , int $numberofparticipants )
	{
		return ($entryfee * $numberofparticipants)/2;
	}
	
	/**
	 * get_numberofwinners
	 *
	 * @param  mixed $numberofparticipants
	 * @return void
	 */
	public function get_numberofwinners( int $numberofparticipants ){
		return floor($numberofparticipants * 0.3);
	}
	
	/**
	 * setparticipantranks
	 *
	 * @return void
	 */
	public function setparticipantranks($contest_id){
		#EXAMPLE 4
		// $this->partcipants= range(50, 1, -1) ;
		// $this->partcipants[10] = 40;
		// $this->partcipants[11] = 40;
		// $this->partcipants[12] = 38;
		// $this->partcipants[13] = 37;
		// $this->partcipants[14] = 36;
		// $this->partcipants[15] = 36;
		// $this->partcipants[16] = 36;
		// $this->partcipants[17] = 36;
		// $this->partcipants[18] = 36;
		#EXAMPLE 3
		// $this->partcipants =	array_fill(0,7,50);
		// $this->partcipants= array_merge($this->partcipants, array_fill(7,6,43));
		// $this->partcipants= array_merge($this->partcipants, range(37, 1, -1) );
		
		#Example 2
		// $this->partcipants =	array_fill(0,7,50);
		// $this->partcipants= array_merge($this->partcipants, range(43, 1, -1) );
	
		# example 1
		//$this->partcipants = range(50, 1, -1);

		$ParticipantModel = new ParticipantModel();
		$this->partcipants = $ParticipantModel->getcontestscores($contest_id);
	}

}
