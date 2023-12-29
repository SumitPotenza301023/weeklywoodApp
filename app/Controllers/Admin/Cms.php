<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CmsModel;
use monken\TablesIgniter;

class Cms extends BaseController
{
	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
        $view['content'] = "cms/index";
		$view['title'] = "Cms Pages";
		$view['data'] = array();
		return view('default', $view);
	}
    
    /**
     * new_page
     *
     * @return void
     */
    public function new_page(){
        $view['content'] = "cms/new_page";
		$view['title'] = "Cms Pages";
		$view['data'] = array();
		return view('default', $view);
    }
    
    /**
     * add_page
     *
     * @return void
     */
    public function add_page(){
        $CmsModel = new CmsModel();
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"pagetitle"=> array(
				"label"=>"Page Title",
				"rules"=> 'required'
			),
			"pagecontent"=> array(
				"label"=>"Page Content",
				"rules"=> 'required'
			)
			
		);
       
		$pagedetails = array(
			'TYPE' => 1,    
			'TITLE'  => $pagetitle,
            'CONTENT' => $pagecontent,
            'SLUG'  => $this->slugify($pagetitle)
		);
		
		if ($this->validate($validation)) {
			$is_inserted = $CmsModel->insert_page($pagedetails);
			if($is_inserted){
				$error  =  false;
				$message = "SUCCESSFULLY PAGE CREATED";
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
     * get_pages
     *
     * @return void
     */
    public function get_pages(){
        $CmsModel = new CmsModel();
		$table = new TablesIgniter($CmsModel->get_all_pages());
    	return $table->getDatatable();
    }
    
    /**
     * delete_page
     *
     * @return void
     */
    public function delete_page(){
        $id = $this->request->getPost('p_id');
		$CmsModel = new CmsModel();
		if(!empty($id)){
			$deleted = $CmsModel->delete_page($id);
			if($deleted){
				$error = false;
				$message = "SUCCESSFULLY DELETED PAGE";
				echo $this->sendResponse(array('success' => true, 'message' => $message,'error'=>$error, 'data'=> $deleted ));
			}else {
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
	 * edit_page
	 *
	 * @return void
	 */
	public function edit_page(){
		$page_id = $this->request->getVar("page-id");
		$view['content'] = "cms/edit_page";
		$view['title'] = "Edit Page";
		$view['data'] = array();
		if(!empty($page_id)){
			$CmsModel = new CmsModel();
			$page = $CmsModel->getPageById($page_id);
			if(empty($page)){
				$view['content'] = "404";
				$view['title'] = "not found";
			}else{
			$view['data'] = array('page' => $page);
			}
			
		} else{
			$view['content'] = "404";
			$view['title'] = "not found";
		}
	
		return view('default', $view);
	}
	
	/**
	 * update_page
	 *
	 * @return void
	 */
	public function update_page(){
		$CmsModel = new CmsModel();
		$post = $this->request->getPost();
		foreach($post as $key => $value ){
			${$key} = $value;
		}
		$validation = array(
			
			"pagetitle"=> array(
				"label"=>"Page Title",
				"rules"=> 'required'
			),
			"pagecontent"=> array(
				"label"=>"Page Content",
				"rules"=> 'required'
			)
			
		);
       
		$pagedetails = array(
			'TYPE' => 1,    
			'TITLE'  => $pagetitle,
            'CONTENT' => $pagecontent,
		);
		
		if ($this->validate($validation)) {
			$is_update = $CmsModel->update_page($pagedetails, $page_id);
			if($is_update){
				$error  =  false;
				$message = "SUCCESSFULLY UPDATED PAGE";
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
		
}
