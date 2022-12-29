<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranking extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(array('url','form','security','common'));
        $this->load->model('Ranking_model');
        $this->load->library('session');
        //if(!$this->session->userdata("user_ip_address")){
        //    $ip = $_SERVER['REMOTE_ADDR'];
        //    $details = json_decode(file_get_contents("https://ipinfo.io/$ip/json"));
        //    $this->session->set_userdata('user_ip_address',@$details->country);
        // }
    }


    public function parks_by_value()
	{
        $data['title'] = 'Ranking by Value | TheParkDatabase';  
        $data["parks"] = $this->Ranking_model->get_parks_by_value();
        
        $this->load->view('includes/header',$data);
		$this->load->view('rankings');
        $this->load->view('includes/footer');
	}
    
    public function parks_by_attendance()
	{
        $data['title'] = 'Ranking by Attendance | TheParkDatabase';  
        $data["parks_att"] = $this->Ranking_model->get_parks_by_att();
        
        $this->load->view('includes/header',$data);
		$this->load->view('rankings_att');
        $this->load->view('includes/footer');
	}
    
     
	function generate_ranking_by_value_pdf()
    {
       
        $data["parks"] = $this->Ranking_model->get_parks_by_value();
       
        $tpl_path = 'PDFs/ranking_by_value-PDF.php';
        $tpl_data['site_title'] = 'Ranking By Value | The Park Database';
        
        if(!file_exists('temp'))
        mkdir('temp','775');
        $thefullpath =  "temp/'".uniqid('THEPARKDB')."'.pdf";
     
        require_once(APPPATH.'third_party/html2pdf-4.5.1/vendor/autoload.php');
        $this->load->library('parser');
       
        $content = $this->parser->parse($tpl_path, $data, TRUE);
        //echo $content;
        //die();
     
        
        $html2pdf = new HTML2PDF('L','A4','en', true, 'UTF-8');
        $html2pdf->setDefaultFont("helvetica");
        
        $html2pdf->pdf->SetAuthor($tpl_data['site_title']);
        $html2pdf->pdf->SetTitle($tpl_data['site_title']);
        $html2pdf->pdf->SetSubject($tpl_data['site_title']);
        $html2pdf->pdf->SetKeywords($tpl_data['site_title']);
        $html2pdf->pdf->SetProtection(array('print'), '');//allow only view/print
        $html2pdf->WriteHTML($content);
        $html2pdf->Output($thefullpath, 'O'); 
        
        unlink($thefullpath);
    }
    
    
     
	function generate_ranking_by_att_pdf()
    {
       
        $data["parks"] = $this->Ranking_model->get_parks_by_att();
       
        $tpl_path = 'PDFs/ranking_by_att-PDF.php';
        $tpl_data['site_title'] = 'Ranking By Value | The Park Database';
        
        if(!file_exists('temp'))
        mkdir('temp','775');
        $thefullpath =  "temp/'".uniqid('THEPARKDB')."'.pdf";
     
        require_once(APPPATH.'third_party/html2pdf-4.5.1/vendor/autoload.php');
        $this->load->library('parser');
       
        $content = $this->parser->parse($tpl_path, $data, TRUE);
        //echo $content;
        //die();
     
        
        $html2pdf = new HTML2PDF('L','A4','en', true, 'UTF-8');
        $html2pdf->setDefaultFont("helvetica");
        
        $html2pdf->pdf->SetAuthor($tpl_data['site_title']);
        $html2pdf->pdf->SetTitle($tpl_data['site_title']);
        $html2pdf->pdf->SetSubject($tpl_data['site_title']);
        $html2pdf->pdf->SetKeywords($tpl_data['site_title']);
        $html2pdf->pdf->SetProtection(array('print'), '');//allow only view/print
        $html2pdf->WriteHTML($content);
        $html2pdf->Output($thefullpath, 'O'); 
        
        unlink($thefullpath);
    }
}