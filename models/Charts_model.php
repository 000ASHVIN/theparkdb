<?php
class Charts_model extends CI_Model
{
    public function __construct()
	{
	    $this->load->database(); //LOADS THE DATABASE AND CREATES DATABASE OBJECT
	}
    
    public function get_country()
    {
        $this->db->select('countries.country_id,countries.country_name');
        $this->db->join('countries', 'countries.country_id  = parks.country_id');
        $this->db->group_by("countries.country_id"); 
        $countries = $this->db->get('parks');

        return $countries = $countries->result_array();
    }
    
    public function get_brands()
    {
        $this->db->select('brands.brand_id,brands.brand_name');
        $this->db->join('brands', 'brands.brand_id  = parks.brand_id');
        $this->db->group_by("brands.brand_id"); 
        $brands = $this->db->get('parks');

        return $brands = $brands->result_array();
    }
    
    public function get_park_types()
    {
        $this->db->where('is_deleted',0);
        $q = $this->db->get('park_types');
        if($q->num_rows()>0)
        return $q->result_array();
        return false;
    }
    
    
    public function get_park_lists($countries=0,$park_type=0, $brands=0)
    {
       $str =' parks.is_deleted = 0 AND parks.is_disabled =0  AND parks.is_approved = 1  ' ;
       $this->db->select('parks.park_id,parks.name');
       
       if($brands) {
        $str.= " AND ( ";
            $i=0;
            foreach($brands as $value){
            $str.=" parks.brand_id = $value " ;
            if($i != count($brands)-1) $str.= ' OR '; $i++;
            }
         $str.= " ) ";    
       } 
       
       if($park_type) {
        $str.= " AND ( ";
            $i=0;
            foreach($park_type as $value){
            $str.=" parks.park_type_id = $value " ;
            if($i != count($park_type)-1) $str.= ' OR '; $i++;
            }
         $str.= " ) ";    
       } 
       
       
       if($countries) {
        $str.= " AND ( ";
            $i=0;
            foreach($countries as $value){
            $str.=" parks.country_id = $value " ;
            if($i != count($countries)-1) $str.= ' OR '; $i++;
            }
         $str.= " ) ";    
       } 
        
       $this->db->where($str);
       $this->db->order_by('name','ASC');
       $query = $this->db->get('parks');
      
       if($query)
        return $query = $query->result_array();
       else
        return null;
    }
    
    
    public function getParksWithData()
    {
       $filterKeyword = $this->input->post('filterKeyword');
       $filterType = $this->input->post('filterType');
      
       $lat = ($this->input->post('lat')) ? $this->input->post('lat') : 0; 
       $long = ($this->input->post('long')) ? $this->input->post('long') : 0; 
        $bounds = ($this->input->post('bounds')) ? $this->input->post('bounds') : 0; 
       $a = $bounds['sw'][0];
       $b = $bounds['sw'][1];
       $c = $bounds['ne'][0];
       $d = $bounds['ne'][1];

       if($filterType=='all'){
             
            if($keyword_data = $this->Results_model->get_keyword_info($filterKeyword,$filterType)){
            $filterType = $keyword_data[0]["type"]; 
            $lat = $keyword_data[0]["latitude"]; 
            $long = $keyword_data[0]["longitude"]; 
           }   
        }
      
      
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
                         SUM(hourly_capacity) as capacity,
                         111.045* DEGREES(ACOS(COS(RADIANS('.$lat.'))
                         * COS(RADIANS(latitude))
                         * COS(RADIANS('.$long.') - RADIANS(longitude))
                         + SIN(RADIANS('.$lat.'))
                         * SIN(RADIANS(latitude)))) AS distance_in_km ' );
       $this->db->join('brands','brands.brand_id = parks.brand_id','left');
       $this->db->join('attendance','attendance.park_id = parks.park_id AND attendance.is_deleted <> 1 AND attendance.is_disabled = 0  AND attendance.is_approved = 1  ','left');
       $this->db->join('tickets_spot','tickets_spot.park_id = parks.park_id  AND  tickets_spot.tkt_code = CONCAT(`parks`.`park_code`,\'_Adult\')  AND tickets_spot.is_deleted <> 1  AND tickets_spot.is_disabled = 0 ','left');
       $this->db->join('tickets','tickets.park_id = parks.park_id  AND  tickets.tkt_code = CONCAT(`parks`.`park_code`,\'_Adult\')  AND tickets.is_deleted <> 1  AND tickets.is_disabled = 0 AND tickets.is_approved = 1  ','left');
       $this->db->join('rides','rides.park_id = parks.park_id AND rides.is_disabled = 0 AND rides.is_deleted = 0  AND rides.is_approved = 1 ','left');
       $this->db->join('countries','countries.country_id = parks.country_id','LEFT'); 
       $this->db->join('park_types','park_types.park_type_id = parks.park_type_id','LEFT');
       
       $this->db->group_by('parks.park_id');
       $this->db->order_by('att, tkt','ASC'); 
       
       if($filterKeyword){
        
        if($filterType == 'name'){
          if($bounds){
             $locationWhere = "  parks.latitude BETWEEN $a AND $c AND  parks.longitude BETWEEN $b AND  $d " ;
             $this->db->where($locationWhere,null,false);
          }
          else
          $this->db->where(" parks.park_code = '$filterKeyword' OR parks.name = '$filterKeyword'  ",NULL,false);
        }
        elseif($filterType == 'location')
        { 
           if($bounds){
             $locationWhere = "  parks.latitude BETWEEN $a AND $c AND  parks.longitude BETWEEN $b AND  $d " ;
             $this->db->where($locationWhere,null,false);
         }
         else{
          //$this->db->like('parks.location',$filterKeyword);
         $this->db->having('distance_in_km < 300');
         $locationWhere ='  parks.latitude
                 BETWEEN '.$lat.'  - (300 / 111.045)
                     AND '.$lat.'  + (300 / 111.045)
                AND parks.longitude
                 BETWEEN '.$long.' - (300 / (111.045 * COS(RADIANS('.$lat.'))))
                 AND '.$long.' + (300 / (111.045 * COS(RADIANS('.$lat.'))))
                 ';
         $this->db->where($locationWhere);
         }        
        }
        elseif($filterType == 'brand'){
            $this->db->where('brands.brand_name',$filterKeyword);
            if($bounds){
              $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
              $this->db->where($locationWhere,null,false);
            }
        }
        elseif($filterType == 'country'){
          if($bounds){
               $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
               $this->db->where($locationWhere,null,false);  
            }
            else
            $this->db->where('countries.country_name',$filterKeyword);
        }
        elseif($filterType == 'park_type'){
            $this->db->where('park_types.park_type_name',$filterKeyword);
              if($bounds){
            $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
            $this->db->where($locationWhere,null,false);
            }
        }
        elseif($filterType == 'continent'){
          if($bounds){
               $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
               $this->db->where($locationWhere,null,false);  
            }
            else{
            $filterKeyword = $this->getContinentCode($filterKeyword);
            $this->db->where('countries.continent_code',$filterKeyword);
            }
        }
       elseif($filterType == 'all'){
           $str.= " AND ( parks.name LIKE  '%$filterKeyword%' 
                           OR parks.location LIKE  '%$filterKeyword%' 
                           OR countries.country_name LIKE  '%$filterKeyword%' 
                           OR brands.brand_name LIKE  '%$filterKeyword%' 
                           OR park_types.park_type_name LIKE  '%$filterKeyword%'
                            ) ";
           }
       elseif($filterType == 'countries'){
        if($bounds){
               $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
               $this->db->where($locationWhere,null,false);  
            }
            else
            $this->db->where_in('countries.country_code',explode(',', $filterKeyword));
        }       
       }
       
       
      
       $this->db->where($str);
       $query = $this->db->get('parks');
      
       
       
       $this->db->select('parks.park_id,parks.name, est_value_usd as est_value, brands.brand_name, parks.park_code,'.$att_str.' , '.$tkt_str.',
                          SUM(hourly_capacity) as capacity,
                         111.045* DEGREES(ACOS(COS(RADIANS('.$lat.'))
                         * COS(RADIANS(latitude))
                         * COS(RADIANS('.$long.') - RADIANS(longitude))
                         + SIN(RADIANS('.$lat.'))
                         * SIN(RADIANS(latitude)))) AS distance_in_km' );
                         
       $this->db->join('brands','brands.brand_id = parks.brand_id','left');
       $this->db->join('attendance','attendance.park_id = parks.park_id AND attendance.is_deleted <> 1 AND attendance.is_disabled = 0 ','left');
       $this->db->join('tickets_spot','tickets_spot.park_id = parks.park_id  AND  tickets_spot.tkt_code = CONCAT(`parks`.`park_code`,\'_Adult\')  AND tickets_spot.is_deleted <> 1  AND tickets_spot.is_disabled = 0 ','left');
       $this->db->join('rides','rides.park_id = parks.park_id AND rides.is_disabled = 0 AND rides.is_deleted = 0 ','left');
       $this->db->join('countries','countries.country_id = parks.country_id','LEFT'); 
       $this->db->join('park_types','park_types.park_type_id = parks.park_type_id','LEFT');
       $this->db->group_by('parks.park_id');
       $this->db->order_by('capacity','ASC'); 
       
      if($filterKeyword){
        
        if($filterType == 'name'){
          if($bounds){
             $locationWhere = "  parks.latitude BETWEEN $a AND $c AND  parks.longitude BETWEEN $b AND  $d " ;
             $this->db->where($locationWhere,null,false);
          }
          else
            $this->db->where('parks.park_code',$filterKeyword);
        }
            
        elseif($filterType == 'location')
        { 
          if($bounds){
             $locationWhere = "  parks.latitude BETWEEN $a AND $c AND  parks.longitude BETWEEN $b AND  $d " ;
             $this->db->where($locationWhere,null,false);
         }
         else{
         //$this->db->like('parks.location',$filterKeyword);
         $this->db->having('distance_in_km < 300');
         $locationWhere ='  parks.latitude
                 BETWEEN '.$lat.'  - (300 / 111.045)
                     AND '.$lat.'  + (300 / 111.045)
                AND parks.longitude
                 BETWEEN '.$long.' - (300 / (111.045 * COS(RADIANS('.$lat.'))))
                 AND '.$long.' + (300 / (111.045 * COS(RADIANS('.$lat.'))))
                 ';
         $this->db->where($locationWhere);
        }
                 
        }
        elseif($filterType == 'brand'){
            $this->db->where('brands.brand_name',$filterKeyword);
            if($bounds){
              $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
              $this->db->where($locationWhere,null,false);
            }
        }
        elseif($filterType == 'country'){
          if($bounds){
               $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
               $this->db->where($locationWhere,null,false);  
            }
            else
            $this->db->where('countries.country_name',$filterKeyword);
        }
        elseif($filterType == 'park_type'){
            $this->db->where('park_types.park_type_name',$filterKeyword);
            if($bounds){
            $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
            $this->db->where($locationWhere,null,false);
            }
        }
        elseif($filterType == 'continent'){
          if($bounds){
               $locationWhere = "  parks.latitude  BETWEEN $a AND $c AND  parks.longitude between $b AND  $d " ;
               $this->db->where($locationWhere,null,false);  
            }
            else{
              $filterKeyword = $this->getContinentCode($filterKeyword);
              $this->db->where('countries.continent_code',$filterKeyword);
            }
        }
        elseif($filterType == 'all'){
           $str.= " AND ( parks.name LIKE  '%$filterKeyword%' 
                           OR parks.location LIKE  '%$filterKeyword%' 
                           OR countries.country_name LIKE  '%$filterKeyword%' 
                           OR brands.brand_name LIKE  '%$filterKeyword%' 
                           OR park_types.park_type_name LIKE  '%$filterKeyword%'
                            ) ";
           }
       } 
       
       $this->db->where($str);
       $query2 = $this->db->get('parks');
       if($query && $query2){
        
        
        $data["forFirst"] = $query->result_array();
        $data["forThird"] = $query2->result_array();
        $data["forSummary"] = array();
        foreach($query->result_array() as $r){
            
            if($r['att']>0) $r['att'] =  number_format(round($r['att'],-3)); else $r["att"] = '-';
            $tkt_str ='';
            if($r['tkt_native']>0) $tkt_str.=$r['tkt_native']." / "; else $tkt_str.=' <small> - </small> /';
            if($r['tkt']>0) $tkt_str.= "$".$r['tkt']; else $tkt_str.='<small> - </small>';
            if(!$tkt_str) $r["tkt"] = '-'; else $r['tkt'] = $tkt_str;
            
            if($r["capacity"]) $r["capacity"] = number_format(round($r["capacity"],-3)); else $r["capacity"] = '-';
            
            if(is_numeric($r['size'])){
                  
                if($r['size']>99999)
                $size_rounded =  round($r['size'],-4); 
                else 
                $size_rounded = round($r['size'],-3); 
                   
                $size = number_format($size_rounded);        
             }
             else
             $size = htmlspecialchars($size_rounded); 
             if(!$size) $r["size"] = '-'; else $r["size"] = $size.' <small>m<sup>2</sup></small>' ;
            
            array_push($data["forSummary"],array(
                        $r['name'],
                        $r['location'],
                        $r['att'],
                        $r['tkt'],
                        $r['capacity'],
                        $r['size'],
                        $r['park_code'] 
            ));
         }
       
        $data["forSummary"] = array_reverse($data["forSummary"]);     
       
        
        return $data;
       }
       else
       return null;
    }
    
     private function getContinentCode($filterKeyword){
        $filterKeyword = strtolower($filterKeyword);
        $continents = array(
                           'AS'=>'asia',
                           'AF'=>'africa',
                           'EU'=>'europe',
                           'SA'=>'south america',
                           'NA'=>'north america',
                           'AN'=>'antarctica',
                           'OC'=>'australia'
                           );
        return array_search($filterKeyword,$continents);
    }
    
    
    
    
}
?>