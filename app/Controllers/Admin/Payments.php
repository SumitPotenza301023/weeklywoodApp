<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PaymentModel;
use monken\TablesIgniter;
class Payments extends BaseController
{
	 
	
	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
        $view['content'] = "payments/index";
		$view['title'] = "Payment";
		$view['data'] = array();
		return view('default', $view);
	}    
    /**
     * get_transactions
     *
     * @return void
     */
    public function get_transactions(){
        $PaymentModel = new PaymentModel();
		$table = new TablesIgniter($PaymentModel->get_payment_transactions());
    	return $table->getDatatable();
    }
    	
	/**
	 * point_transaction
	 *
	 * @return void
	 */
	public function point_transaction()
	{
        $view['content'] = "payments/pointtransaction";
		$view['title'] = "Payment";
		$view['data'] = array();
		return view('default', $view);
	}
		
	/**
	 * get_point_transactions
	 *
	 * @return void
	 */
	public function get_point_transactions(){
		$PaymentModel = new PaymentModel();
		$table = new TablesIgniter($PaymentModel->get_point_transaction());
    	return $table->getDatatable();
	}

}
