<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\BannerModel;
use monken\TablesIgniter;

class Banners extends BaseController
{
	 
	
	/**
	 * Load Dashboard function
	 *
	 * @return view
	 */
	public function index()
	{
        $view['content'] = "banner/index";
		$view['title'] = "banner";
		$view['data'] = array();
		return view('default', $view);
	}	
	/**
	 * upload_banner
	 *
	 * @return void
	 */
	public function upload_banner(){
		$banner_model = new BannerModel();
		$insert_id = $banner_model->next_id();
		$banners_images = $this->uploadMultipleFilefunc('file', 'image', '', 'banner');
		$images = explode(",", $banners_images );
		foreach($images as $key=>$image){
			if($key>0){
				$insert_id++;
			}
			$banners = array(
				"IMAGE_NAME" => $image,
				"ACTIVE_STATUS " => '0',
				"SLIDER_ORDER" => $insert_id
			);
			$banner_model->insert_banner($banners);
		}
		
		
	}	
	/**
	 * update_status
	 *
	 * @return void
	 */
	public function update_status(){
		$banner_model = new BannerModel();
		$status = $this->request->getPost('status_id');
		$banner_id = $this->request->getPost('b_id');
		$details = array(
			'ACTIVE_STATUS' => $status
		);
		
		$is_update = $banner_model->update_banner($details, array('B_ID'=>$banner_id));
		if($is_update){
				$error = false;
				$message = "SUCCESSFULLY ACTIVATED BANNER";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
		}else{
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}

	}
	
	/**
	 * delete_banner
	 *
	 * @return void
	 */
	public function delete_banner(){
		$banner_model = new BannerModel();
		$banner_id = $this->request->getPost('b_id');
		$is_update = $banner_model->delete_banner($banner_id);
		if($is_update){
				$error = false;
				$message = "SUCCESSFULLY DELETED BANNER";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error));
		}else{
				$error = true;
				$message = "SOMETHING WENTWRONG!";
				echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	}
	
	/**
	 * get_banner
	 *
	 * @return void
	 */
	public function get_banner(){
		$banner_model = new BannerModel();
		$table = new TablesIgniter($banner_model->get_banner_details());
    	return $table->getDatatable();
	}
	
	/**
	 * get_banner_slider
	 *
	 * @return void
	 */
	public function get_banner_slider(){
		$banner_model = new BannerModel();
		$banner_list=$banner_model->get_banner_sorted();
		if(!empty($banner_list)){
			foreach($banner_list as $key=>$list){
				$banner_list[$key]['IMAGE_NAME'] = base_url().BANNERFOLDERPATH.'/'.$list['IMAGE_NAME'];
			}
			$error = false;
			$message = "SUCCESSFULLY UPDATED BANNER";
			echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, "data"=> $banner_list));
		}else{
			$error = true;
			$message = "NO IMAGE FOUND IN SLIDER";
			echo $this->sendResponse(array('success' => false, 'message' => $message,'error'=>$error));
		}
	
	}
	
}
