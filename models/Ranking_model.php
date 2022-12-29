<?php
class Ranking_model extends CI_Model
{
    public function __construct()
	{
	    $this->load->database(); //LOADS THE DATABASE AND CREATES DATABASE OBJECT
	}
    
   
    public function get_parks_by_value()
    {
        $this->db->select('park_id, name, est_value_usd, year_built, brand_name, country_name, parks.park_code');
        $this->db->join('brands','parks.brand_id = brands.brand_id');
        $this->db->join('countries','parks.country_id = countries.country_id');
        $this->db->where('parks.is_deleted',0);
        $this->db->where('parks.is_disabled',0);
        $this->db->order_by('est_value_usd','DESC');
        $this->db->limit(50);
        $query = $this->db->get('parks'); 
        
           
        if($query->num_rows()>0)
        return $query->result_array();
        return false;
        
    }
    
    public function get_parks_by_att()
    {
       $min_year = $this->config->item("min_year");
       $max_year = $this->config->item("max_year");
      
       
       $att_str = " CAST( COALESCE( "; 
       for($i = $max_year; $i >= $min_year; $i--)
       $att_str .= " NULLIF( `attendance`.`$i`, 0 ), ";
       $att_str .= " 'a substitute for zero' ) AS UNSIGNED ) as att ";  
        
        $this->db->select('parks.park_id, name, year_built, brand_name, country_name, parks.park_code, '.$att_str);
        $this->db->join('brands','parks.brand_id = brands.brand_id');
        $this->db->join('countries','parks.country_id = countries.country_id');
        $this->db->join('attendance','attendance.park_id = parks.park_id AND attendance.is_deleted <> 1 AND attendance.is_approved = 1 ','left');
      
        $this->db->where('parks.is_deleted',0);
        $this->db->where('parks.is_disabled',0);
        $this->db->order_by('att','DESC');
        $this->db->limit(50);
        $query = $this->db->get('parks'); 
        
           
        if($query->num_rows()>0)
        return $query->result_array();
        return false;
        
    }
    
  
   
}
?>