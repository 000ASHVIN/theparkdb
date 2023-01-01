<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Login extends CI_Controller {  
      
    // public function index()  
    // {  
    //     $this->load->view('login_view');  
    // }

    public function process()  
    {  
        $user = $this->input->post('full_name');
        $email = $this->input->post('email');
        $company = $this->input->post('company');
        $password = $this->input->post('password');
        
        // $this->load->library('session');
        $data = [
            'user_id'=> 1,
            'full_name' => $user,
            'logged_in' => true
        ];
        $this->session->set_userdata('user', $data);  
        // $this->load->view('welcome_view');
        
        redirect($_SERVER['HTTP_REFERER']);
    }

    // public function logout()  
    // {  
    //     //removing session  
    //     $this->session->unset_userdata('user');  
    //     redirect("Login");  
    // }  
  
}  
?>  