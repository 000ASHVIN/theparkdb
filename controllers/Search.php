<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(array('url','security','form'));
        //$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('search_model');
   	}
    public function index(){
        redirect('');
    }
    
    public function suggetions(){
       
	    $search_key = $this->clean($this->input->post('term'));
        $result = $this->search_model->search_keywords($search_key,true);
        if(is_null($result)){
          $result[0] = array('no_results'=>1,'message'=>'No Results Found!'); 
        }
       
        echo json_encode($result);
        die();
    }
    
    public function all_suggestions(){
        $result = $this->search_model->all_search_keywords();
        if(is_null($result)){
          $result[0] = array('no_results'=>1,'message'=>'No Results Found!'); 
        }
        
       
       header("Content-Type: application/javascript");
       header("Cache-Control: max-age=604800, public");
       ob_start("ob_gzhandler");
       echo "var suggestions = JSON.parse('".addcslashes(json_encode($final),"'")."');";
       die();
    }
    
    
    private function clean($string){
      $string = trim($string);
      $string = preg_replace('!\s+!', ' ', $string);//replace multiple whitespace with single
      return preg_replace('/[^A-Za-z0-9\-\s]/', '', $string); // Removes special chars.
    }
    
   /* public function searchTerm(){
        $this->form_validation->set_rules('search','search','trim|required|xss_clean');
        if($this->form_validation->run()){
           $result = $this->search_model->search_keywords($this->input->post('search'));
           if(is_null($result))
           $data['status'] = 0;
           else{
                $data['values'] = $this->setPriority($result);
                $data['status'] = 1;
           }
        }
        else{ 
            $data['status'] = 0;
        }
        
        echo json_encode($data);
    }
    
    private function setPriority($result){
        
        foreach($result as $row){
            if(strtolower($this->input->post('search')) == strtolower($row->keyword)){// best match
                $return = array('keyword'=>$row->keyword,'keywordType'=>$row->type);
                $flag = 0;
                break;
             }
            elseif($row->type == 'country_name' || $row->type=='location' || $row->type=='brand_name' || $row->type=='park_type_name'){
                $return = array('keyword'=>$row->keyword,'keywordType'=>$row->type);
                $flag = 0;
                break;
            }
             $flag = 1;
        }
        if($flag){
            $return = array('keyword'=>$this->input->post('search'),'keywordType'=>'parks');
        }
        
        return $return;  
    }*/
}