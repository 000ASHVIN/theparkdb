<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Generate_xml extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
        $this->load->model('Home_model');
	}

	function index()
	{
	    $parks = $this->Home_model->get_all_parks();
        $keywords = $this->Home_model->get_all_keywords();
       
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
                                <urlset 
                                xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"  
                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                                                    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
                                />');
        
        $node = $xml->addChild('url');
        $loc = 'http://www.theparkdb.com/';
        $node->addChild('loc', $loc);
        
        $node = $xml->addChild('url');
        $loc = 'http://www.theparkdb.com/ranking/parks_by_value';
        $node->addChild('loc', $loc);
        
        $node = $xml->addChild('url');
        $loc = 'http://www.theparkdb.com/ranking/parks_by_attendance';
        $node->addChild('loc', $loc);
        
        $node = $xml->addChild('url');
        $loc = 'http://www.theparkdb.com/pages/about';
        $node->addChild('loc', $loc);
        
        $node = $xml->addChild('url');
        $loc = 'http://www.theparkdb.com/pages/faq';
        $node->addChild('loc', $loc);
        
        $node = $xml->addChild('url');
        $loc = 'http://www.theparkdb.com/pages/contact';
        $node->addChild('loc', $loc);
        
        //generate for parks
        foreach($parks as $key=>$value)
		{
			$node = $xml->addChild('url');
			$loc = 'http://www.theparkdb.com/results/in/name/'.$value['park_id'].'/view_details';
			$node->addChild('loc', $loc);
		}
        
        //generate for keywords
        $data = array();
        foreach($keywords as $k=>$v)
        {
            $str = rawurlencode($v['keyword']);
            $str = str_replace('%2F', '-', $str);
            if($v['type'] == 'country_name')
            {
                $node = $xml->addChild('url');
                $loc = 'http://www.theparkdb.com/results/in/country/'.$str;
                $node->addChild('loc', $loc);
            }elseif($v['type'] == 'location')
            {
                $node = $xml->addChild('url');
                $loc = 'http://www.theparkdb.com/results/in/location/'.$str;
                $node->addChild('loc', $loc);
            }elseif($v['type'] == 'brand_name')
            {
                $node = $xml->addChild('url');
                $loc = 'http://www.theparkdb.com/results/in/brand/'.$str;
                $node->addChild('loc', $loc);
            }elseif($v['type'] == 'park_type_name')
            {
                $node = $xml->addChild('url');
                $loc = 'http://www.theparkdb.com/results/in/park_type/'.$str;
                $node->addChild('loc', $loc);
            }elseif($v['type'] == 'continent_name')
            {
                $node = $xml->addChild('url');
                $loc = 'http://www.theparkdb.com/results/in/continent/'.$str;
                $node->addChild('loc', $loc);
            }
            
        }
        Header('Content-type: text/xml');
        //print($xml->asXML());
        if($xml->saveXML('sitemap.xml')){
        
        $log_details = date('Y-m-d H:i:s').' : Success'; 
        $log_details .= "\n";  
        if(!file_exists('logxml.txt'))
        fopen('logxml.txt', "w");       
             
        $myfile = fopen('logxml.txt', "a");
        file_put_contents('logxml.txt',$log_details,FILE_APPEND);
        fclose($myfile);
        
        }else{
        $log_details = date('Y-m-d H:i:s').' : Failed'; 
        $log_details .= "\n";  
        if(!file_exists('logxml.txt'))
        fopen('logxml.txt', "w");   
               
        $myfile = fopen('logxml.txt', "a");
        file_put_contents('logxml.txt',$log_details,FILE_APPEND);
        fclose($myfile);
        }
        
        
    }
}