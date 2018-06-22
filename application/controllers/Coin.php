<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coin extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index()
	{
		$exchange = $this->common_mdl->get_table_by('pair',array('exchange_name' => $this->uri->segment(2)),'id');
		if(count($exchange) > 0) {
			$data['exchange_data'] = $this->common_mdl->select('pair',array('exchange_name' => $this->uri->segment(2)));
			$this->load->view('coin_view',$data);
		}
		else {
			redirect('home');
		}
	}
}
