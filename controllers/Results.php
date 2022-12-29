<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(array('url','form','security','common'));
        $this->load->library('session');
        $this->load->model('Results_model');
        $this->load->config('api_keys',TRUE);
        
        if(!$this->session->userdata("user_ip_address")){
            $ip = $_SERVER['REMOTE_ADDR'];
            //$ip = '183.151.42.52';
            $details = json_decode(@file_get_contents("https://ipinfo.io/$ip/json"));
            $this->session->set_userdata('user_ip_address',@$details->country);
        
            //print_r($details);
        }
           
    }

    public function in($filterType=0,$filterKeyword=0)
	{
        $data['title'] = 'TheParkDatabase';  
        //handling happy valley OST
        if($filterType==='brand' && $filterKeyword==='HappyValley')  $filterKeyword='Happy Valley / OCT'; 
                
        //get suggestion info
        $filterKeyword = urldecode($filterKeyword);
        $filterKeyword = str_replace('-', '/', $filterKeyword);
        
        $data["keyword_data"]["filterKeyword"] = $filterKeyword ;
        $data["keyword_data"]["filterType"] = $filterType;
        if($keyword_data = $this->Results_model->get_keyword_info($filterKeyword,$filterType)){
          $data["keyword_data"][] = $keyword_data[0];
          $data["keyword_data"]["filterType"] = $keyword_data[0]["type"]; 
        }
       
        //in case of park code we need to set lat long of park isntaed of search keyword table.
        $data["park_id"] =  0;
        if($filterType==='name')
        {
            if($parks_data = $this->Results_model->get_park_by_code($filterKeyword)){
                $data["keyword_data"][0]["latitude"]= $parks_data[0]["latitude"];
                $data["keyword_data"][0]["longitude"]=$parks_data[0]["longitude"];
                $data["park_id"] =  $parks_data[0]["park_id"];
            }
        }
        
       
        
        $this->load->view('includes/header',$data);
		$this->load->view('results',$data);
        $this->load->view('includes/footer');
	}
    
    
    public function getParks()
	{
        $filterKeyword = ($this->input->post('filter_keyword')) ? $this->input->post('filter_keyword') : 0;
        $filterType = ($this->input->post('filter_type')) ? $this->input->post('filter_type') : 0;
        
        if($keyword_data = $this->Results_model->get_keyword_info($filterKeyword,$filterType)){
          
           if($keyword_data[0]["type"] == 'brand_name') $filterType = 'brand';
           if($keyword_data[0]["type"] == 'country_name') $filterType = 'country';
           if($keyword_data[0]["type"] == 'park_type_name') $filterType = 'park_type';
           if($keyword_data[0]["type"] == 'continent_name') $filterType = 'continent';  
           if($keyword_data[0]["type"] == 'name') $filterType = 'name';  
           
           $result["keyword_data"][] = $keyword_data[0];
         }
        
        
        if($parks_data = $this->Results_model->get_parks($filterKeyword,$filterType)){
          $result["parks"]= $parks_data["parks"]; 
            
          $result["park_count"]= count($parks_data["parks"]); 
          $result["status"] = "1";
          
        }
        else{
        $result["parks"]= array();   
        $result["park_count"]= count($result["parks"]);     
        $result["status"] = "0";
        }
        
       echo json_encode($result);
	}
    
    /**
      * Lists::get_info()
      * 
      * @param mixed $park_id
      * @return void
      */
     public function view_park($park_id)
     {
        $data['details'] = $this->Results_model->view_park($park_id);
        $data['rides'] = $this->Results_model->get_rides($park_id);
        $data['tickets'] = $this->Results_model->get_tickets($park_id);
        $data['atts'] = $this->Results_model->get_att($park_id);
        $data['misc'] = $this->Results_model->get_misc_info($park_id, $data['details'][0]["brand_id"]);
        $data["ppp"] = $this->Results_model->get_ppp_rates($data['details'][0]["country_id"]);
        if(@$data['details'][0]["park_code"])
        $data["related"] = $this->Results_model->get_related_articles($data['details'][0]["park_code"]);
        
        if(strlen($data["details"][0]["wikipedia_name"])>0)
        $data["wiki_name"] = $data["details"][0]["wikipedia_name"];
        else
        $data["wiki_name"] = str_replace(' ','_',$data['details'][0]["name"]);
         
        $this->load->view('view_park',$data);
     }
     
     public function get_map_for_view($park_id)
     {        
       
        $data['details'] = $this->Results_model->view_park($park_id);
        $this->load->view('map_for_view',$data);
        
     }
   
   
    public function taWidget($location_id=0){
        if($location_id){
              echo ' <div id="TA_cdsratingsonlynarrow873" class="TA_cdsratingsonlynarrow">
                            <ul id="YRFqjTJrph" class="TA_links BMWEs3Q03RQ">
                            <li id="4Mhmf5" class="91CRPhZXr">
                            <a target="_blank" href="https://www.tripadvisor.com/">
                            <img src="https://www.tripadvisor.com/img/cdsi/img2/branding/tripadvisor_logo_transp_340x80-18034-2.png" alt="TripAdvisor"/></a>
                            </li>
                            </ul>
                            </div>
                            <script src="https://www.jscache.com/wejs?wtype=cdsratingsonlynarrow&amp;uniq=873&amp;locationId='.$location_id.'&amp;lang=en_US&amp;border=true&amp;display_version=2"></script>
    
            ';
         }    
    }
   
        
    public function getFeeds(){
        
        $park = $this->input->post('park');
        /*bing feeds*/
        if(!$park){
           $data['bingFeeds'] = false;
        }
        else{
            $query = urlencode("'$park'");
            $acctKey = '2da4a0f98c6c4b43a492034b20260303';
            $acctKey = '2db3c534235b41e98d9f808ef643d187';
            $rootUri = 'https://api.cognitive.microsoft.com/bing/v5.0/images/search';
            $rootUri = 'https://api.cognitive.microsoft.com/bing/v7.0/images/search';
            $requestUri = "$rootUri?q=$query&count=20";
       
            $headr = array();
            $headr[] = 'Ocp-Apim-Subscription-Key: '.$acctKey;
            $headr[] = 'Content-type: multipart/form-data';
           
       
                $request = curl_init($requestUri); // initiate curl object
                curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
                curl_setopt($request, CURLOPT_HTTPHEADER,$headr);
                $response = curl_exec($request); // execute curl post and store results in $ac_response
         }
         
        $response = json_decode($response);
        //echo "<pre>";
        //print_r($response);
        //echo "</pre>";
        
        $items = @$response->value;
        
        if($items){
            foreach($items as $item){
                $data['bingFeeds'][] = $item->thumbnailUrl; 
            }
        }
        $data["q"] =$query; 
        $this->load->view('feeds',$data);
        
     }
   
   
   
    private function bd_nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));
        
        // is this a number?
        if(!is_numeric($n)) return false;
        
        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),1).' trillion';
        else if($n>1000000000) return round(($n/1000000000),1);
        else if($n>1000000) return round(($n/1000000),1);
        else if($n>1000) return round(($n/1000),1);
        
        return number_format($n);
    }
   
   
   public function save_email()
   {
        $email = $this->input->post('email');
        $check_email = $this->Results_model->check_email($email);
        if(!$check_email){
        $insert = $this->Results_model->save_email();
            
            if($insert)
            {
            $result["status"] = 1;
            $result["message"] = 'Successfully Subscribed!';
            }
            else
            {
            $result["status"] = 0;
            $result["message"] = 'Error occured at this time. Please try again later.';
            } 
         }
         else{
            $result["status"] = 0;
            $result["message"] = 'Subscription already exists';  
         }
         echo json_encode($result);
         die();   

   }
   
   public function download_misc_file($filename){
    $misc_info_path = $this->config->item("misc_info");
  
        
         
        $file_path  = $misc_info_path."/".$filename;
        $path_parts = pathinfo($file_path);
        $file_name  = $path_parts['basename'];
        $file_ext   = $path_parts['extension'];
        //$file_path  = './myfiles/' . $file_name;
         
         
        // make sure the file exists
        if (is_file($file_path))
        {
        
    	    header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        }
        else
        {
        	// file does not exist
        	header("HTTP/1.0 404 Not Found");
        	exit;
        }
   }
   
   public function getRelated(){
      
      $res["status"] = 0;
      if($this->input->post('filter_type')=='name'){
         $park_id = $this->input->post('filter_keyword');
         if($posts = $this->Results_model->get_related_articles($park_id,'park')){
           $res["status"] = 1;
           $res["data"] = $posts;
         }
      }
      elseif($this->input->post('filter_type')=='location' )
      {
         $location = $this->input->post('filter_keyword');
         if($posts = $this->Results_model->get_related_articles($location,'location')){
           $res["status"] = 1;
           $res["data"] = $posts;
         }
      }
      elseif($this->input->post('filter_type')=='country')
      {
         $country = $this->input->post('filter_keyword');
         if($posts = $this->Results_model->get_related_articles($country,'country')){
           $res["status"] = 1;
           $res["data"] = $posts;
         }
      }
      elseif($this->input->post('filter_type')=='park_type')
      {
         $park_type = $this->input->post('filter_keyword');
         if($posts = $this->Results_model->get_related_articles($park_type,'park_type')){
           $res["status"] = 1;
           $res["data"] = $posts;
         }
      }
      echo json_encode($res);
   }
}
