<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(array('url','form','security','common'));
        $this->load->model('Home_model');
        
        $this->load->library('session');
        if(!$this->session->userdata("user_ip_address")){
            $ip = $_SERVER['REMOTE_ADDR'];
            //$details = json_decode(file_get_contents("https://ipinfo.io/$ip/json"));
            $this->session->set_userdata('user_ip_address',@$details->country);
         }
    }


    public function index()
	{
        
       // header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
       // header('Cache-Control: no-store, no-cache, must-revalidate');
       // header('Cache-Control: post-check=0, pre-check=0', FALSE);
       // header('Pragma: no-cache');

        $data['title'] = 'TheParkDatabase';  
        
        $counts = file_get_contents('cache/count.json');
        $data['counts'] = (array)json_decode($counts);
        
        $fives = file_get_contents('cache/fives.json');
        $fives = json_decode($fives);
        $data["fives"] = json_decode(json_encode($fives), True);
        
        $country_counts = file_get_contents('cache/country_counts.json');
        $data["country_counts"] = (array)json_decode($country_counts);
        
        $countries = file_get_contents('cache/countries.json');
        $countries = json_decode($countries);
        $data["countries"] = json_decode(json_encode($countries), True);
        
        $data['news'] = $this->Home_model->get_news();
        $data['store_link_homepage'] = $this->Home_model->get_widget_by_name('store_link_homepage');
        $data['image_path']=$this->config->item("image_path");
        
    	$this->load->view('includes/header',$data);
    	$this->load->view('home');
        $this->load->view('includes/footer');
        
	}
    
    public function map()
	{
        $data['title'] = 'TheParkDatabase';  
        $this->load->view('includes/header',$data);
		$this->load->view('map_area');
        $this->load->view('includes/footer');
	}

    public function home_cron(){

        $result = $this->Home_model->all_search_keywords();
        if(is_null($result)){
            $result[0] = array('no_results'=>1,'message'=>'No Results Found!'); 
        }else{
            $content = "var suggestions = JSON.parse('".addcslashes(json_encode($result),"'")."');";
            $filename = "assets/js/all_suggestions.js";
            $file = fopen($filename,"w");
            fwrite($file,$content);
            fclose($file);
        }
        
        $parksCount = $this->Home_model->getParksCount();
        if($parksCount){
            $filename = "cache/count.json";
            $file = fopen($filename, 'w');
            fwrite($file,json_encode($parksCount));
            fclose($file);
        }

        $fives = $this->Home_model->getLastUpdated();
        if($fives){
            $filename = "cache/fives.json";
            $file = fopen($filename, 'w');
            fwrite($file,json_encode($fives));
            fclose($file);
        }

        $country_counts = $this->Home_model->getParkCountByCountry();
        if($country_counts){
            $filename = "cache/country_counts.json";
            $file = fopen($filename, 'w');
            fwrite($file,json_encode($country_counts));
            fclose($file);
        }

        $countries = $this->Home_model->get_countries();
        if($countries){
            $filename = "cache/countries.json";
            $file = fopen($filename, 'w');
            fwrite($file,json_encode($countries));
            fclose($file);
        }
    }
    
    public function get_image($imagepath="",$filename=""){
        $uploadpath='../../admin/App/uploads'; 
        if($imagepath){
        $path = $uploadpath.'/'.$imagepath.'/'.$filename;
        }
        else{
        $path = $uploadpath.'/'.$filename;
        }
    
        header('Content-type: image');
        readfile($path);
    }

	
}
