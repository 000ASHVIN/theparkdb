<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends CI_Controller {

       function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->model('Charts_model');
        $this->load->model('Results_model');
        $this->load->library('session');
        if(!$this->session->userdata("user_ip_address")){
            $ip = $_SERVER['REMOTE_ADDR'];
            $details = json_decode(file_get_contents("https://ipinfo.io/$ip/json"));
            $this->session->set_userdata('user_ip_address',@$details->country);
         }
	}


	public function index($filterType=0,$filterKeyword=0,$sw_lat=0,$sw_long=0,$ne_lat=0,$ne_long=0)
	{
        $data['title'] = 'TheParkDatabase';  
        
        $filterKeyword = urldecode($filterKeyword);
        $filterType = urldecode($filterType);
        
        
        //get suggestion info
        $data["keyword_data"]["filterKeyword"] = $filterKeyword ;
        $data["keyword_data"]["filterType"] = $filterType;
        $data["bounds"] = array($sw_lat,$sw_long,$ne_lat,$ne_long);
        if($keyword_data = $this->Results_model->get_keyword_info($filterKeyword,$filterType)){
          $data["keyword_data"][] = $keyword_data[0];
          $data["keyword_data"]["filterType"] = $keyword_data[0]["type"]; 
        }
       
        $this->load->view('includes/header',$data);
		$this->load->view('charts',$data);
        $this->load->view('includes/footer');
	}
    
    public function getParksWithData()
	{
        
        if($parks_list = $this->Charts_model->getParksWithData())
        {
          $result["status"] = "1";  
          $result["ParksWithData"] = $parks_list;  
        }
        else
        $result["status"] = "0";
        
        echo json_encode($result);
	}
   
    
}
