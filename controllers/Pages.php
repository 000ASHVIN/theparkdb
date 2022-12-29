<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    
    function __construct()
	{
		parent::__construct();
        $this->load->helper(array('url'));
        $this->load->helper('security');
        $this->load->helper('form');
        $this->load->model('home_model');
        $this->load->library('session');
        if(!$this->session->userdata("user_ip_address")){
            $ip = $_SERVER['REMOTE_ADDR'];
            //$details = json_decode(file_get_contents("https://ipinfo.io/$ip/json"));
            $this->session->set_userdata('user_ip_address',@$details->country);
         }
    }
    
    function _remap($parameter){
        if($parameter == 'index')
        {
            $data['title'] = 'Page Not Found';
            $this->load->view('includes/header',$data);
            $this->load->view('error_404');
            $this->load->view('includes/footer',$data);
        }else{
            
            if($parameter=="contact_form"){
            $this->contact_form();
            die();
            }
            
            if($parameter=="services_form"){
            $this->services_form();
            die();
            }
            
             if($parameter == 'ImageuploadDzone')
            {
                $this->ImageuploadDzone();
                die;
            }
             if($parameter == 'getParksWithData')
            {
                $this->getParksWithData();
                die;
            }
            $this->index($parameter);

        }


    }
    
	public function index($parameter)
	{   
        if($parameter=='faq'){
            $data['title'] = 'Frequently Asked Questions | The Park Database';
            $this->load->view('includes/header',$data);
            $this->load->view('pages/faq',$data);
            $this->load->view('includes/footer_pages',$data);
        }
        elseif($parameter=='contact'){
            $data['title'] = 'Contact | The Park Database';
            $this->load->view('includes/header',$data);
            $this->load->view('pages/contact',$data);
            $this->load->view('includes/footer_pages',$data);
        }
        elseif($parameter=='feasibility'){
            $data['title'] = 'Feasibility | The Park Database';
            $this->load->view('includes/header',$data);
            $this->load->view('pages/feasibility',$data);
            $this->load->view('includes/footer_pages',$data);
        }
        elseif($parameter=='services'){
            $data['title'] = 'Services | The Park Database';
            $data['store_link_servicepage'] = $this->home_model->get_widget_by_name('store_link_servicepage');
            $data['image_path']=$this->config->item("image_path");
            $this->load->view('includes/header',$data);
            $this->load->view('pages/services',$data);
            $this->load->view('includes/footer_pages',$data);
        }
        else{
            

            $this->load->model('pages_model');
            $data["page"] = $this->pages_model->get_page($parameter);
            
            if(@$data["page"][0]->page_title)
            $data['title'] = ucfirst($data["page"][0]->page_title).' | The Park Database';
            else
            $data['title'] = ' The Park Database';
            //print_r($parameter);die;
            $this->load->view('includes/header',$data);
            $this->load->view('pages/about',$data);
            $this->load->view('includes/footer_pages',$data);
        }
        
	}
    
    public function contact_form()
    {
       
      $this->load->library('email');  
      $this->load->library('form_validation');
          
      $this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean');
      $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
     
       if ($this->form_validation->run()) {
        $details['email'] = $this->input->post('email');
        $details['message'] = $this->input->post('message');    
        $admin_email = $this->home_model->get_admin_email();

                $to = $admin_email->email;
                
                $this->email->from('dev@theparkdb.com','TheParkDB.com');
                
                if (!filter_var($details['email'], FILTER_VALIDATE_EMAIL) === false)
                $this->email->reply_to($details['email']);
                
                $this->email->subject('Received message from contact form of theparkdb.com ');
                $this->email->message($this->load->view('email/contact-html', $details, TRUE));
                $this->email->set_alt_message($this->load->view('email/contact-txt', $details, TRUE));
                $this->email->to($to);
                
                $send = $this->email->send();
                if($send)
                {
                    $result['status'] = '1';
                    $result['message']='Thanks for contacting us.<br /> We will reach you shortly!.';
                    $result['sent'] = $to;
                }else
                {
                    $result['status'] = '0';
                    $result['message']='Error email not sent.'; 
                }
                
                
        }//form validation
        else
        {
            $result['status'] = '0';
            $result['message']=validation_errors();
        }
       echo json_encode($result);
       die;           
   }
    
     public function services_form()
    {

     
      $this->load->library('email');  
      $this->load->library('form_validation');

        if($_POST['looking_for'] ==  '1')
        {
             $this->form_validation->set_rules('customized_servies_fullname', 'Full Name', 'trim|required|xss_clean');
             $this->form_validation->set_rules('customized_servies_email', 'E-mail', 'trim|required|xss_clean');
             $this->form_validation->set_rules('customized_servies_located', 'Country', 'trim|required|xss_clean');
             $this->form_validation->set_rules('customized_servies_project', 'Describe', 'trim|required|xss_clean');


             $email = $this->input->post('customized_servies_email');
            
        }elseif ($_POST['looking_for'] ==  '2') {
            $this->form_validation->set_rules('want_data_fullname', 'Full Name', 'trim|required|xss_clean');
             $this->form_validation->set_rules('want_data_email', 'E-mail', 'trim|required|xss_clean');
             $this->form_validation->set_rules('want_data_project', 'Project', 'trim|required|xss_clean');
             $this->form_validation->set_rules('want_data_describe', 'Describe', 'trim|required|xss_clean');

           
          $email = $this->input->post('want_data_email');
            
        }elseif ($_POST['looking_for'] ==  '3') {
            $this->form_validation->set_rules('plans_reports_fullname', 'Full Name', 'trim|required|xss_clean');
             $this->form_validation->set_rules('plans_reports_email', 'E-mail', 'trim|required|xss_clean');
             $this->form_validation->set_rules('plans_reports_located', 'Country', 'trim|required|xss_clean');
             $this->form_validation->set_rules('plans_reports_describe', 'Describe', 'trim|required|xss_clean');

             $email = $this->input->post('plans_reports_email');
          
        }else{
            $this->form_validation->set_rules('question_comment_fullname', 'Full Name', 'trim|required|xss_clean');
             $this->form_validation->set_rules('question_comment_email', 'E-mail', 'trim|required|xss_clean');
             $this->form_validation->set_rules('question_comment_message', 'Message', 'trim|required|xss_clean');

             $email = $this->input->post('question_comment_email');

             
        }
         if($this->form_validation->run()) {
            $details = $_POST;
             
            $admin_email = $this->home_model->get_admin_email();

                    $to = $admin_email->email;
                    //$to = 'him@justaddwater.in';
                    
                    $this->email->from('dev@theparkdb.com','TheParkDB.com');
                    
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
                    $this->email->reply_to($email);
                    
                    $this->email->subject('Received message from services quote form of theparkdb.com ');
                    $this->email->message($this->load->view('email/services-html', $details, TRUE));
                    $this->email->set_alt_message($this->load->view('email/services-txt', $details, TRUE));
                    $this->email->to($to);
                    if(@$_POST['file_name']){
                    foreach ($_POST['file_name'] as  $file_name) {
                        $this->email->attach(base_url('uploads')."/".$file_name);
                    }
                    }
                    
                    
                    $send = $this->email->send();
                    if($send)
                    {
                        $result['status'] = '1';
                        $result['message']='Thanks for contacting us.<br /> We will reach you shortly!.';
                        $result['sent'] = $to;
                    }else
                    {
                        $result['status'] = '0';
                        $result['message']='Error email not sent.'; 
                    }
                    
                    
            }//form validation
            else
            {
                $result['status'] = '0';
                $result['message']=validation_errors();
            }
         echo json_encode($result);
           die;    
   } 
    
    
    
    public function getParksWithData()
  {        
        $this->load->model('Pages_model');
        if($parks_list = $this->Pages_model->getParksWithData())
        {
          $result["status"] = "1";  
          $result["ParksWithData"] = $parks_list;  
        }
        else
        $result["status"] = "0";
        
        echo json_encode($result);
  }
     
    public function ImageuploadDzone()
    {
        $uploads_dir = 'uploads/';
        if (!empty($_FILES)) {
          $tempFile = $_FILES['file']['tmp_name'];          //3             
          $targetFile =  time().'-'.str_replace(' ','_',$_FILES['file']['name']);  //5
          move_uploaded_file($tempFile,$uploads_dir.$targetFile); //6
          echo $targetFile;
      }
    }
    
    
}
