<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ContestModel;
use App\Models\ScoreTypeModel;
use App\Models\ContestResultModel;
use App\Models\PaymentModel;
use App\Models\ParticipantModel;
use App\Models\NotificationModel;
use monken\TablesIgniter;

class Contests extends BaseController
{
	 
	
	/**
	 * Load Dashboard function
	 *
	 * @return view
	 */
	public function index()
	{
        $view['content'] = "contest/index";
		$view['title'] = "contest";
		$ScoreTypeModel = new ScoreTypeModel();
		$score_type = $ScoreTypeModel->getScoreType();
		$view['data'] = array('score_type' => $score_type);
		return view('default', $view);
	}
		
	/**
	 * create_contest
	 *
	 * @return void
	 */
	public function create_contest(){
		$contestmodel = new ContestModel();
		$rules = $contestmodel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"contest_name"=> array(
				"label"=>"Contest Name",
				"rules"=> $rules['CONTEST_NAME']
			),
			"contest_description"=> array(
				"label"=>"Contest Description",
				"rules"=> $rules['CONTEST_DESCRIPTION']
			),
			// "contest_pdf_title" => array(
			// 	"label" => "Contest PDF Title",
			// 	"rules" => 'alpha_numeric_space'
			// ),
			"contest_points" =>array(
				"label" => "Contest Points",
				"rules" => $rules["CONTEST_POINTS"]
			),
			"start_date" =>array(
				"label" => "Start Date",
				"rules" => 'required'
			),
			"end_date" =>array(
				"label" => "End Date",
				"rules" => 'required'
			),
			'videourl' => array(
				"label" => "Video Url",
				"rules" => "required|valid_url"
			)

		);
		// $daterange = explode(' - ',$weekpicker);
		$start_date =   $this->datetime_format_weekly($start_date);
		$end_date =   $this->datetime_format_weekly($end_date);
		if($contestmodel->valid_start_end_date($start_date)){
			$error = true;
			$message = "CONTEST IS SCHEDULED AT THIS DATE!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
		if($contestmodel->valid_start_end_date($end_date)){
			$error = true;
			$message = "CONTEST IS SCHEDULED AT THIS DATE!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	

		$contestdetails = array(
			'CONTEST_NAME' => ucwords($contest_name),    
			'CONTEST_DESCRIPTION'=> $contest_description,
			'CONTEST_POINTS'=> $contest_points,
			'CONTEST_PDF_TITLE' => $contest_pdf_title,
			'START_DATE' => $start_date,
			'END_DATE' => $end_date,
			'SCORE_TYPE' => $score_type,
			'STATUS'=> '1',
			'VIDEO_URL'=> $videourl
		);

	
		if ($this->validate($validation)) {
			$is_inserted = $contestmodel->create_contest($contestdetails);
			if($is_inserted){

				$update_files = array();
				if(isset($_FILES['filebanner'] ) && isset($_FILES['contestpdf'])){
					$contest_banner = $this->uploadFilefunc('filebanner', 'image', $is_inserted, CONTESTBANNERFOLDER, 'contestbanner');
					$contest_pdf = $this->uploadFilefunc('contestpdf', 'pdf', $is_inserted, CONTESTPDFFOLDER, 'contestpdf');
					if($contest_banner){
						$update_files['CONTEST_BANNER'] = $contest_banner;
					}
					if($contest_pdf){
						$update_files['CONTEST_PDF'] = $contest_pdf;
					}
				}
				if(!empty($update_files)){
				
					$is_update=$contestmodel->update_contest($update_files,array('C_ID'=>$is_inserted));
				
					$error = false;
					if($is_update){
						$message = "SUCCESSFULLY CONTEST CREATED";
						echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
					}else{

						$error = true;
						$message = "SOMETHING WENTWRONG!";
						echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
					}
				}
				
			}else{
					$error = true;
					$message = "SOMETHING WENTWRONG!";
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error));
		}
	}
	
	/**
	 * contest_details
	 *
	 * @return void
	 */
	public function contest_details(){
		$contestmodel = new ContestModel();
	
		$table = new TablesIgniter($contestmodel->get_contest_details());
    	return $table->getDatatable();
		
	}
	
	/**
	 * get_contest_details
	 *
	 * @return void
	 */
	public function get_contest_details(){
		$contestmodel = new ContestModel();
		$c_id = $this->request->getPost('c_id');
		if(!empty($c_id)){
			$where = array(
				"C_ID" => $c_id
			);
			$contest = $contestmodel->get_contest($where);
			
			$contest['CONTEST_BANNER']= base_url().CONTESTBANNERFOLDERPATH.'/'.$contest['C_ID'].'/'.$contest['CONTEST_BANNER'];
			$contest['CONTEST_PDF']= base_url().CONTESTPDFFOLDERPATH.'/'.$contest['C_ID'].'/'.$contest['CONTEST_PDF'];
			if(!empty($contest)){
				$error = false;
				$message = "SUCCESSFULLY CONTEST RECIEVED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $contest ));
					
			}
			else{
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}else{
			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	}
		
	/**
	 * edit_contest_details
	 *
	 * @return void
	 */
	public function edit_contest_details(){
		$contestmodel = new ContestModel();
		$rules = $contestmodel->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"contest_name"=> array(
				"label"=>"Contest Name",
				"rules"=> $rules['CONTEST_NAME']
			),
			"contest_description"=> array(
				"label"=>"Contest Description",
				"rules"=> $rules['CONTEST_DESCRIPTION']
			),
			"contest_points" =>array(
				"label" => "Contest Points",
				"rules" => $rules["CONTEST_POINTS"]
			),
			// "contest_pdf_title" => array(
			// 	"label" => "Contest PDF Title",
			// 	"rules" => 'alpha_numeric_space'
			// ),
			"start_date" =>array(
				"label" => "Start Date",
				"rules" => 'required'
			),
			"end_date" =>array(
				"label" => "End Date",
				"rules" => 'required'
			),
			'videourl' => array(
				"label" => "Video Url",
				"rules" => "required|valid_url"
			)

			

		);
		
		$start_date =   $this->datetime_format_weekly($start_date);
		$end_date =   $this->datetime_format_weekly($end_date);
		if($contestmodel->valid_start_end_date_exculde($start_date, $contest_id)){
			$error = true;
			$message = "CONTEST IS SCHEDULED AT THIS DATE!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
		if($contestmodel->valid_start_end_date_exculde($end_date, $contest_id)){
			$error = true;
			$message = "CONTEST IS SCHEDULED AT THIS DATE!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
		$contestdetails = array(
			'CONTEST_NAME' => ucwords($contest_name),    
			'CONTEST_DESCRIPTION'=> $contest_description,
			'CONTEST_POINTS'=> $contest_points,
			'CONTEST_PDF_TITLE' => $contest_pdf_title,
			'START_DATE' => $start_date,
			'END_DATE' => $end_date,
			'STATUS'=> '1',
			'VIDEO_URL'=> $videourl
		);
		

		if ($this->validate($validation)) {
			$is_inserted = $contestmodel->update_contest($contestdetails, array('C_ID'=>$contest_id));
			if($is_inserted){

				if(isset($_FILES['filebanner']['name'] ) && isset($_FILES['contestpdf']['name'])){
					$contest_banner = $this->uploadFilefunc('filebanner', 'image', $contest_id, CONTESTBANNERFOLDER, 'contestbanner');
					$contest_pdf = $this->uploadFilefunc('contestpdf', 'pdf', $contest_id, CONTESTPDFFOLDER, 'contestpdf');
					if($contest_banner){
						$update_files['CONTEST_BANNER'] = $contest_banner;
					}
					if($contest_pdf){
						$update_files['CONTEST_PDF'] = $contest_pdf;
					}
				}
				if(!empty($update_files)){
					$is_update=$contestmodel->update_contest($update_files,array('C_ID'=>$contest_id));
				
					$error = false;
					if($is_update){
						$message = "SUCCESSFULLY CONTEST UPDATED";
						echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
					}else{
						$error = true;
						$message = "SOMETHING WENTWRONG!";
						echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
					}
				}
				$error = false;
				$message = "SUCCESSFULLY CONTEST UPDATED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
			}else{
					$error = true;
					$message = "SOMETHING WENTWRONG!";
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		} else {
			$error = true;
            echo $this->sendResponse(array('success' => false, 'message' => $this->validation->listErrors(), 'error'=> $error));
		}
	}
	
	/**
	 * delete_contest
	 *
	 * @return void
	 */
	public function delete_contest(){
		$contestmodel = new ContestModel();
		$c_id = $this->request->getPost('c_id');
		if(!empty($c_id)){
			$where = array(
				"C_ID" => $c_id
			);
			$delete=array(
				"status"=>'0'
			);
			$contest = $contestmodel->update_contest($delete , $where);
			
			if(!empty($contest)){
				$error = false;
				$message = "SUCCESSFULLY CONTEST RECIEVED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $contest ));
					
			}
			else{
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}else{
			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	}
	
	/**
	 * make_contest_official
	 *
	 * @return void
	 */
	public function make_contest_official(){
		$contest_id = $this->request->getPost('contest_id');
		try {

    		$result = $this->get_pricepool_distribution($contest_id);
		}
		catch (exception $e) {
			$error = true;
			$message = "SOMETHING WENTWRONG!";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
		finally {
			//optional code that always runs
			if(isset($result)){
				$tier1price =  $result['TIER-1'];
				$tier2price =  $result['TIER-2'];
				$tier3price =  $result['TIER-3'];
				$total_adjustment = $result['TOTAL_ADJUSTMENT'];
				$total_tier1 = $result['TOTAL_TIER_1'];
				$total_tier2 = $result['TOTAL_TIER_2'];
				$total_tier3 = $result['TOTAL_TIER_3'];
				$ContestResultModel = new ContestResultModel();
				$ParticipantModel = new ParticipantModel();
				$PaymentModel = new PaymentModel();
				$NotificationModel = new NotificationModel();
				foreach($result['RANKS'] as $key=>$teirs){
					foreach($teirs as $tier){
						$prizepool = 0;
						if($key == 1){
							$prizepool = $tier1price;
						}
						elseif($key == 2){
							$prizepool = $tier2price;
						}
						elseif($key == 3){
							$prizepool = $tier3price;
						}
						$result = array(
							"C_ID" => $contest_id,
							"P_ID" => $tier['P_ID'],
							'SCORE' => $tier['SCORE'],
							"PRICE_POOL" => $prizepool,
							"RANK" => $tier['RANK'],
							'TIER' => $key
						);
						$contest_result = $ContestResultModel->create_result($result);
						if(!empty($contest_result)){
							$participant = $ParticipantModel->get_participantBypid($tier['P_ID']);
							if(!empty($participant)){
								$PaymentModel->update_wallet($participant['USER_ID'], $prizepool, false);
								$message = 'Your Wallet has been credited with '.$prizepool.' Points';
								$NotificationModel->create_notification($participant['USER_ID'], 'WINNER IN CONTEST', $message, 'SYSTEM' );
								$NotificationModel->create_notification($participant['USER_ID'], 'WINNER IN CONTEST', $message, 'PUSH', $this->get_device_tokonByid($participant['USER_ID']) );

							}else{
								$error = true;
								$message = "SOMETHING WENTWRONG!";
								echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
							}
						}else{
							$error = true;
							$message = "SOMETHING WENTWRONG!";
							echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
						} 

					}
				}
				$ContestModel = new ContestModel();
				$make_official = array(
					'IS_OFFICIAL' => 'YES',
					'TOTAL_PRICE_POOL' => $total_adjustment,
					'TOTAL_TIER_1' => $total_tier1,
					'TOTAL_TIER_2' => $total_tier2,
					'TOTAL_TIER_3' => $total_tier3,
					'TIER_1_EACH' => $tier1price,
					'TIER_2_EACH' => $tier2price,
					'TIER_3_EACH' => $tier3price,
					'OFFICIAL_ON' => date('Y-m-d H:i:s',time())

				);
				$is_official = $ContestModel->update_contest($make_official,array('C_ID'=>$contest_id));
				if($is_official){
					$error = false;
					$message = "SUCCESSFULLY CONTEST MADE OFFICIAL";
					echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
				}else{
					$error = true;
					$message = "SOMETHING WENTWRONG!";
					echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
				}

			}else{
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
			}
		}
		
		die;
	}
	
	/**
	 * contest_result
	 *
	 * @return void
	 */
	public function contest_result(){
		$view['content'] = "contest/contestresult";
		$view['title'] = "Contest Result";
		$contestmodel = new ContestModel();
		$contest_id = $this->request->getVar("c_id");
		$contests = $contestmodel->get_contest(array('C_ID' => $contest_id));
		if(!empty($contests)){
			$contests['CONTEST_BANNER']= base_url().CONTESTBANNERFOLDERPATH.'/'.$contests['C_ID'].'/'.$contests['CONTEST_BANNER'];
			$contests['CONTEST_PDF']= base_url().CONTESTPDFFOLDERPATH.'/'.$contests['C_ID'].'/'.$contests['CONTEST_PDF'];
			$ScoreTypeModel = new ScoreTypeModel();
			$score_type = $ScoreTypeModel->getScoreTypeById($contests['SCORE_TYPE']);
			$contests['SCORE_TYPE'] = $score_type['NAME'];
		}
		$view['data'] = array('contests'=> $contests);
		return view('default', $view);
	}
	
	/**
	 * get_contest_result
	 *
	 * @return void
	 */
	public function get_contest_result(){
		$contest_id = $this->request->getPost('c_id');

		$ContestResultModel = new ContestResultModel();
		$table = new TablesIgniter($ContestResultModel->get_contest_result_details($contest_id));
    	return $table->getDatatable();
	}
	

}
