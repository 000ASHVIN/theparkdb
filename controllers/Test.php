<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(array('url','form','security','common'));
        $this->load->model('Home_model');
    }


    public function index()
	{
 
        
	}
    
    public function map()
	{
        $data['title'] = 'TheParkDatabase';  
        //$this->load->view('includes/header',$data);
		$this->load->view('test_map_area_1');
        //$this->load->view('includes/footer');
	}

	
}