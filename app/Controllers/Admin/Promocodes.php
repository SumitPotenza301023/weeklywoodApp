<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PromocodeModel;
use monken\TablesIgniter;

class Promocodes extends BaseController
{
	 
	
	/**
	 * Load Dashboard function
	 *
	 * @return view
	 */
	public function index()
	{
        $view['content'] = "promocodes/index";
		$view['title'] = "promocodes";
		$view['data'] = array();
		return view('default', $view);
	}
		
		
	/**
	 * add_promocode
	 *
	 * @return void
	 */
	public function add_promocode(){
		$promocode = new PromocodeModel();
		$rules = $promocode->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"promocode_title"=> array(
				"label"=>"PromoCode Title",
				"rules"=> $rules['TITLE'].'|is_unique[tbl_promocode.TITLE]'
			),
			"promocode_description"=> array(
				"label"=>"PromoCode Description",
				"rules"=> $rules['DESCRIPTION']
			),
			"promocode_points" =>array(
				"label" => "Purchase Points",
				"rules" => $rules["PURCHASE_POINTS"]
			),
		
			"expiry_date" =>array(
				"label" => "Expiry Date",
				"rules" => $rules["EXPIRY_DATE"]
			),
			"minimum_promocode_points" =>array(
				"label" => "Minimum Promocode Points",
				"rules" => $rules["MINIMUM_POINTS"]
			)
		);

		$promocodedetails = array(
			'TITLE' => strtoupper($promocode_title),    
			'DESCRIPTION'=> $promocode_description,
			'PURCHASE_POINTS'=> $promocode_points,
			'EXPIRY_DATE' => $expiry_date,
			'MINIMUM_POINTS'=> $minimum_promocode_points,
			'DELETE_STATUS' => '0'
		);
		

		if ($this->validate($validation)) {
			$is_inserted = $promocode->create_promocode($promocodedetails);
			if($is_inserted){

				$update_files = array();
				if(isset($_FILES['filebannerpromocode'] )){
					$promocode_banner = $this->uploadFilefunc('filebannerpromocode', 'image', $is_inserted, PROMOCODEBANNERFOLDER, 'promocode');
					if($promocode_banner){
						$update_files['BANNER_IMAGE'] = $promocode_banner;
					}
				}
				if(!empty($update_files)){
					$is_update=$promocode->update_promocode($update_files,array('PROMO_ID'=>$is_inserted));
				
					$error = false;
					if($is_update){
						$message = "SUCCESSFULLY PROMOCODE CREATED";
						echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
					}else{
						$error = true;
						$message = "SOMETHING WENTWRONG!";
						echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
					}
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
	public function promocode_details(){
		$promocode = new PromocodeModel();
	
		$table = new TablesIgniter($promocode->get_promocode_details());
    	return $table->getDatatable();
		
	}
	
		
	/**
	 * get_promocode
	 *
	 * @return void
	 */
	public function get_promocode(){
		$promocode = new PromocodeModel();
		$p_id = $this->request->getPost('p_id');
		if(!empty($p_id)){
			$where = array(
				"PROMO_ID" => $p_id
			);
			$promocode_details = $promocode->get_promocode($where);
			$promocode_details['BANNER_IMAGE']= base_url().PROMOCODEBANNERFOLDERPATH.'/'.$promocode_details['PROMO_ID'].'/'.$promocode_details['BANNER_IMAGE'];
			if(!empty($promocode_details)){
				$error = false;
				$message = "SUCCESSFULLY CONTEST RECIEVED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $promocode_details ));
					
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
	 * edit_promocode
	 *
	 * @return void
	 */
	public function edit_promocode(){
		$promocode = new PromocodeModel();
		$rules = $promocode->validationRules;
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"promocode_title"=> array(
				"label"=>"PromoCode Title",
				"rules"=> $rules['TITLE'].'|is_unique[tbl_promocode.TITLE,PROMO_ID,{promo_id}]'
			),
			"promocode_description"=> array(
				"label"=>"PromoCode Description",
				"rules"=> $rules['DESCRIPTION']
			),
			"promocode_points" =>array(
				"label" => "Purchase Points",
				"rules" => $rules["PURCHASE_POINTS"]
			),
		
			"expiry_date" =>array(
				"label" => "Expiry Date",
				"rules" => $rules["EXPIRY_DATE"]
			),
			"minimum_promocode_points" =>array(
				"label" => "Minimum Promocode Points",
				"rules" => $rules["MINIMUM_POINTS"]
			)
			
		);

		$promocodedetails = array(
			'TITLE' => strtoupper($promocode_title),    
			'DESCRIPTION'=> $promocode_description,
			'PURCHASE_POINTS'=> $promocode_points,
			'EXPIRY_DATE' => $expiry_date,
			'MINIMUM_POINTS'=> $minimum_promocode_points,
			'DELETE_STATUS' => '0'
		);
		

		if ($this->validate($validation)) {
			$is_inserted = $promocode->update_promocode($promocodedetails, array('PROMO_ID'=>$promo_id));
			if($is_inserted){

				if(isset($_FILES['filebannerpromocode']['name'] ) ){
					$promocode_banner = $this->uploadFilefunc('filebannerpromocode', 'image', $is_inserted, PROMOCODEBANNERFOLDER, 'promocode');
					if($promocode_banner){
						$update_files['BANNER_IMAGE'] = $promocode_banner;
					}
				}
				if(!empty($update_files)){
					$is_update = $promocode->update_promocode($promocodedetails, array('PROMO_ID'=>$promo_id));
				
					$error = false;
					if($is_update){
						$message = "SUCCESSFULLY PROMOCODE UPDATED";
						echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
					}else{
						$error = true;
						$message = "SOMETHING WENTWRONG!";
						echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
					}
				}
				$error = false;
				$message = "SUCCESSFULLY PROMOCODE UPDATED";
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
	 * delete_promocode
	 *
	 * @return void
	 */
	public function delete_promocode(){
		$promocode = new PromocodeModel();
		$p_id = $this->request->getPost('p_id');
		if(!empty($p_id)){

			$delete=array(
				"DELETE_STATUS"=>'1'
			);
			$promocode = $promocode->update_promocode($delete, array('PROMO_ID'=>$p_id));
			
			if(!empty($promocode)){
				$error = false;
				$message = "SUCCESSFULLY CONTEST RECIEVED";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $promocode ));
					
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
}
