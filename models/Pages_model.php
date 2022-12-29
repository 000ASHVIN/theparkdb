<?php
class Pages_model extends CI_Model
{
    public function __construct()
	{
	    $this->load->database(); //LOADS THE DATABASE AND CREATES DATABASE OBJECT
	}
    
   
    
    
    public function get_page($page_name)
    {
      $this->db->where('page_name',$page_name);
      $query = $this->db->get('pages');
      if($query->num_rows()>0)
      return $query->result();
      else
      return false;

        
    }
    
  
    
    public function getParksWithData()
    {
      
       $min_year = $this->config->item("min_year");
       $max_year = $this->config->item("max_year");
       $tkt_min_year = $this->config->item("tkt_min_year");
       $tkt_max_year = $this->config->item("tkt_max_year");
       
       
       $att_str = " CAST( COALESCE( "; 
       for($i = $max_year; $i >= $min_year; $i--)
       $att_str .= " NULLIF( `attendance`.`$i`, 0 ), ";
       $att_str .= " 'a substitute for zero' ) AS UNSIGNED ) as att ";  
       
       $tkt_str = " CAST( COALESCE( "; 
       for($i = $tkt_max_year; $i >= $tkt_min_year; $i--)
       $tkt_str .= " NULLIF( `tickets_spot`.`$i`, 0 ), ";
       $tkt_str .= " 'a substitute for zero' ) AS UNSIGNED ) as tkt ";  
       
       $tkt_str2 = " CAST( COALESCE( "; 
       for($i = $tkt_max_year; $i >= $tkt_min_year; $i--)
       $tkt_str2 .= " NULLIF( `tickets`.`$i`, 0 ), ";
       $tkt_str2 .= " 'a substitute for zero' ) AS UNSIGNED ) as tkt_native ";  
       
        
       $str =' parks.is_deleted = 0 AND parks.is_disabled =0 AND parks.is_approved = 1  ' ;
       
       $this->db->select('parks.park_id,parks.location,parks.size,parks.name,est_value_usd as est_value, brands.brand_name, parks.park_code,'.$att_str.' , '.$tkt_str.' , '.$tkt_str2.' ,
                         SUM(hourly_capacity) as capacity' );
       $this->db->join('brands','brands.brand_id = parks.brand_id','left');
       $this->db->join('attendance','attendance.park_id = parks.park_id AND attendance.is_deleted <> 1 AND attendance.is_disabled = 0  AND attendance.is_approved = 1  ','left');
       $this->db->join('tickets_spot','tickets_spot.park_id = parks.park_id  AND  tickets_spot.tkt_code = CONCAT(`parks`.`park_code`,\'_Adult\')  AND tickets_spot.is_deleted <> 1  AND tickets_spot.is_disabled = 0 ','left');
       $this->db->join('tickets','tickets.park_id = parks.park_id  AND  tickets.tkt_code = CONCAT(`parks`.`park_code`,\'_Adult\')  AND tickets.is_deleted <> 1  AND tickets.is_disabled = 0 AND tickets.is_approved = 1  ','left');
       $this->db->join('rides','rides.park_id = parks.park_id AND rides.is_disabled = 0 AND rides.is_deleted = 0  AND rides.is_approved = 1 ','left');
       $this->db->join('countries','countries.country_id = parks.country_id','LEFT'); 
       $this->db->join('park_types','park_types.park_type_id = parks.park_type_id','LEFT');
       
       $this->db->group_by('parks.park_id');
       $this->db->order_by('att, tkt','DESC'); 
       
       
      
       $this->db->where($str);
       $query = $this->db->get('parks');
      
       if($query){        
        $data = $query->result_array();        
        return $data;
       }
       else
       return null;
    }
}
?>