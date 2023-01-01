<?php
class Results_model extends CI_Model
{
    public function __construct()
	{
	    $this->load->database(); //LOADS THE DATABASE AND CREATES DATABASE OBJECT
	}
   
    
    public function get_parks($filterKeyword,$filterType)
    {    
        
       $lat = ($this->input->post('lat')) ? $this->input->post('lat') : 0; 
       $long = ($this->input->post('long')) ? $this->input->post('long') : 0; 
       $bounds = ($this->input->post('bounds')) ? $this->input->post('bounds') : 0; 
       if($bounds){
           $a = $bounds['sw'][0];
           $b = $bounds['sw'][1];
           $c = $bounds['ne'][0];
           $d = $bounds['ne'][1];
           if($a > $c){//swap the values
             $tmp = $a;
             $a = $c;
             $c = $tmp;
           }
           if($b > $d){
            $tmp = $b;
            $b = $d;
            $d = $tmp;
           }
       }
       //if($d < 0) 
       //$d = -($d);
       
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
       $tkt_str .= " 'a substitut for zero' ) AS DECIMAL(10,2) ) as tkt ";  
        
        
        
       $str =' parks.is_deleted = 0 AND parks.is_disabled =0 AND parks.is_approved = 1 ' ;
       if($filterKeyword){
        
        if($filterType == 'name'){
          
           if($bounds){
             $locationWhere = "  parks.latitude BETWEEN $a AND $c AND  parks.longitude BETWEEN $b AND  $d " ;
             $this->db->where($locationWhere,null,false);
          }
          else
          $this->db->where(" (parks.park_code = '$filterKeyword' OR parks.name = '$filterKeyword')  ",NULL,false);
        
        }
        elseif($filterType == 'location')
        {
         if($bounds){
             $locationWhere = "  parks.latitude BETWEEN $a AND $c AND  parks.longitude BETWEEN $b AND  $d " ;
             $this->db->where($locationWhere,null,false);
         }
         else{
            $this->db->having('distance_in_km < 100');
            $locationWhere ='  parks.latitude
                 BETWEEN '.$lat.'  - (100 / 111.045)
                     AND '.$lat.'  + (100 / 111.045)
                AND parks.longitude
                 BETWEEN '.$long.' - (100 / (111.045 * COS(RADIANS('.$lat.'))))
                 AND '.$long.' + (100 / (111.045 * COS(RADIANS('.$lat.'))))
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
       
       
       $this->db->join('brands','brands.brand_id = parks.brand_id AND brands.is_deleted <> 1 ','LEFT');
       $this->db->join('park_types','park_types.park_type_id = parks.park_type_id  AND park_types.is_deleted <> 1','LEFT');
       $this->db->join('attendance','attendance.park_id = parks.park_id AND attendance.is_deleted <> 1 AND attendance.is_approved = 1 ','left');
       $this->db->join('tickets_spot','tickets_spot.park_id = parks.park_id  AND  tickets_spot.tkt_code = CONCAT(`parks`.`park_code`,\'_Adult\')  AND tickets_spot.is_deleted <> 1 ','left');
       $this->db->join('countries','countries.country_id = parks.country_id','LEFT'); 
       $this->db->join('currency','currency.currency_id = parks.currency_id','LEFT'); 
       $this->db->join('rides','rides.park_id  = parks.park_id  AND rides.is_deleted <> 1 AND rides.is_approved = 1 ','LEFT');
        
       $this->db->where($str);
       $this->db->select('parks.park_id, parks.park_code, name, latitude, longitude, park_type_color, parks.park_type_id,
                 brands.brand_name, countries.country_name, currency.currency_code, est_value_usd,year_built, parks.cost, parks.size, 
                 SUM(hourly_capacity) as thrc, '.$att_str.' , '.$tkt_str.' , 
                 111.045* DEGREES(ACOS(COS(RADIANS('.$lat.'))
                 * COS(RADIANS(latitude))
                 * COS(RADIANS('.$long.') - RADIANS(longitude))
                 + SIN(RADIANS('.$lat.'))
                 * SIN(RADIANS(latitude)))) AS distance_in_km' ); 
      
       $this->db->order_by('est_value_usd','DESC');
       $this->db->order_by('tkt','DESC');
       $this->db->order_by('park_types.park_type_id','ASC');
       $this->db->order_by('name','ASC');
       
       $this->db->group_by('parks.park_id','ASC');

       $total_query = $this->db->get('parks');
        if(!($this->session->userdata('user') && $this->session->userdata('user')['logged_in'])) {
            $this->db->limit(5);
        }       
       
       $query = $this->db->get('parks');
       //$data["sql"] = str_replace('\n',' ',$this->db->last_query());

       // logging for search 
       $query_details = array(
        'latitude' => $lat,
        'longitude' => $long,
        'keyword_type' => $filterType,
        'keyword' => $filterKeyword,
        'park_count' => count($query->result_array()),
        'created' => date('Y-m-d H:i:s',time()),
        'ip_address' => getenv('REMOTE_ADDR')
       );
       
       $insert = $this->insertQuery($query_details);
       
      if($query->num_rows()>0){
        $data["parks"] = $query->result_array(); 
        $data["park_count"] = count($total_query->result_array());

        return  $data;
      }
      //$data["parks"] =array();
      return false;
        
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
    
     public function get_min_max()
    {
        $sql = "SELECT MIN(est_value_usd) as min_est, MAX(est_value_usd) as max_est, 
    
        MIN(CAST( COALESCE(  NULLIF( `attendance`.`2015`, 0 ), NULLIF( `attendance`.`2014`, 0 ), NULLIF( `attendance`.`2013`, 0 ), NULLIF( `attendance`.`2012`, 0 ), NULLIF( `attendance`.`2011`, 0 ), NULLIF( `attendance`.`2010`, 0 ), NULLIF( `attendance`.`2009`, 0 ), NULLIF( `attendance`.`2008`, 0 ), NULLIF( `attendance`.`2007`, 0 ), NULLIF( `attendance`.`2006`, 0 ), NULLIF( `attendance`.`2005`, 0 ), NULLIF( `attendance`.`2004`, 0 ), NULLIF( `attendance`.`2003`, 0 ), NULLIF( `attendance`.`2002`, 0 ), NULLIF( `attendance`.`2001`, 0 ), NULLIF( `attendance`.`2000`, 0 ), NULLIF( `attendance`.`1999`, 0 ), NULLIF( `attendance`.`1998`, 0 ), NULLIF( `attendance`.`1997`, 0 ), NULLIF( `attendance`.`1996`, 0 ), NULLIF( `attendance`.`1995`, 0 ), NULLIF( `attendance`.`1994`, 0 ), NULLIF( `attendance`.`1993`, 0 ), NULLIF( `attendance`.`1992`, 0 ), NULLIF( `attendance`.`1991`, 0 ), NULLIF( `attendance`.`1990`, 0 ), NULLIF( `attendance`.`1989`, 0 ), NULLIF( `attendance`.`1988`, 0 ), NULLIF( `attendance`.`1987`, 0 ), NULLIF( `attendance`.`1986`, 0 ), NULLIF( `attendance`.`1985`, 0 ), NULLIF( `attendance`.`1984`, 0 ), NULLIF( `attendance`.`1983`, 0 ), NULLIF( `attendance`.`1982`, 0 ), NULLIF( `attendance`.`1981`, 0 ), NULLIF( `attendance`.`1980`, 0 ), NULLIF( `attendance`.`1979`, 0 ), NULLIF( `attendance`.`1978`, 0 ), NULLIF( `attendance`.`1977`, 0 ), NULLIF( `attendance`.`1976`, 0 ), NULLIF( `attendance`.`1975`, 0 ), NULLIF( `attendance`.`1974`, 0 ), NULLIF( `attendance`.`1973`, 0 ), NULLIF( `attendance`.`1972`, 0 ), NULLIF( `attendance`.`1971`, 0 ), NULLIF( `attendance`.`1970`, 0 ), NULLIF( `attendance`.`1969`, 0 ), NULLIF( `attendance`.`1968`, 0 ), NULLIF( `attendance`.`1967`, 0 ), NULLIF( `attendance`.`1966`, 0 ), NULLIF( `attendance`.`1965`, 0 ), NULLIF( `attendance`.`1964`, 0 ), NULLIF( `attendance`.`1963`, 0 ), NULLIF( `attendance`.`1962`, 0 ), NULLIF( `attendance`.`1961`, 0 ), NULLIF( `attendance`.`1960`, 0 ), NULLIF( `attendance`.`1959`, 0 ), NULLIF( `attendance`.`1958`, 0 ), NULLIF( `attendance`.`1957`, 0 ), NULLIF( `attendance`.`1956`, 0 ), NULLIF( `attendance`.`1955`, 0 ), 'a substitute for zero' ) AS UNSIGNED )) as min_att, 
        MAX(CAST( COALESCE(  NULLIF( `attendance`.`2015`, 0 ), NULLIF( `attendance`.`2014`, 0 ), NULLIF( `attendance`.`2013`, 0 ), NULLIF( `attendance`.`2012`, 0 ), NULLIF( `attendance`.`2011`, 0 ), NULLIF( `attendance`.`2010`, 0 ), NULLIF( `attendance`.`2009`, 0 ), NULLIF( `attendance`.`2008`, 0 ), NULLIF( `attendance`.`2007`, 0 ), NULLIF( `attendance`.`2006`, 0 ), NULLIF( `attendance`.`2005`, 0 ), NULLIF( `attendance`.`2004`, 0 ), NULLIF( `attendance`.`2003`, 0 ), NULLIF( `attendance`.`2002`, 0 ), NULLIF( `attendance`.`2001`, 0 ), NULLIF( `attendance`.`2000`, 0 ), NULLIF( `attendance`.`1999`, 0 ), NULLIF( `attendance`.`1998`, 0 ), NULLIF( `attendance`.`1997`, 0 ), NULLIF( `attendance`.`1996`, 0 ), NULLIF( `attendance`.`1995`, 0 ), NULLIF( `attendance`.`1994`, 0 ), NULLIF( `attendance`.`1993`, 0 ), NULLIF( `attendance`.`1992`, 0 ), NULLIF( `attendance`.`1991`, 0 ), NULLIF( `attendance`.`1990`, 0 ), NULLIF( `attendance`.`1989`, 0 ), NULLIF( `attendance`.`1988`, 0 ), NULLIF( `attendance`.`1987`, 0 ), NULLIF( `attendance`.`1986`, 0 ), NULLIF( `attendance`.`1985`, 0 ), NULLIF( `attendance`.`1984`, 0 ), NULLIF( `attendance`.`1983`, 0 ), NULLIF( `attendance`.`1982`, 0 ), NULLIF( `attendance`.`1981`, 0 ), NULLIF( `attendance`.`1980`, 0 ), NULLIF( `attendance`.`1979`, 0 ), NULLIF( `attendance`.`1978`, 0 ), NULLIF( `attendance`.`1977`, 0 ), NULLIF( `attendance`.`1976`, 0 ), NULLIF( `attendance`.`1975`, 0 ), NULLIF( `attendance`.`1974`, 0 ), NULLIF( `attendance`.`1973`, 0 ), NULLIF( `attendance`.`1972`, 0 ), NULLIF( `attendance`.`1971`, 0 ), NULLIF( `attendance`.`1970`, 0 ), NULLIF( `attendance`.`1969`, 0 ), NULLIF( `attendance`.`1968`, 0 ), NULLIF( `attendance`.`1967`, 0 ), NULLIF( `attendance`.`1966`, 0 ), NULLIF( `attendance`.`1965`, 0 ), NULLIF( `attendance`.`1964`, 0 ), NULLIF( `attendance`.`1963`, 0 ), NULLIF( `attendance`.`1962`, 0 ), NULLIF( `attendance`.`1961`, 0 ), NULLIF( `attendance`.`1960`, 0 ), NULLIF( `attendance`.`1959`, 0 ), NULLIF( `attendance`.`1958`, 0 ), NULLIF( `attendance`.`1957`, 0 ), NULLIF( `attendance`.`1956`, 0 ), NULLIF( `attendance`.`1955`, 0 ), 'a substitute for zero' ) AS UNSIGNED )) as max_att, 
        
        MIN(CAST( COALESCE(  NULLIF( `tickets_spot`.`2015`, 0 ), NULLIF( `tickets_spot`.`2014`, 0 ), NULLIF( `tickets_spot`.`2013`, 0 ), NULLIF( `tickets_spot`.`2012`, 0 ), NULLIF( `tickets_spot`.`2011`, 0 ), NULLIF( `tickets_spot`.`2010`, 0 ), NULLIF( `tickets_spot`.`2009`, 0 ), NULLIF( `tickets_spot`.`2008`, 0 ), NULLIF( `tickets_spot`.`2007`, 0 ), NULLIF( `tickets_spot`.`2006`, 0 ), NULLIF( `tickets_spot`.`2005`, 0 ), NULLIF( `tickets_spot`.`2004`, 0 ), NULLIF( `tickets_spot`.`2003`, 0 ), NULLIF( `tickets_spot`.`2002`, 0 ), NULLIF( `tickets_spot`.`2001`, 0 ), NULLIF( `tickets_spot`.`2000`, 0 ), NULLIF( `tickets_spot`.`1999`, 0 ), NULLIF( `tickets_spot`.`1998`, 0 ), NULLIF( `tickets_spot`.`1997`, 0 ), NULLIF( `tickets_spot`.`1996`, 0 ), NULLIF( `tickets_spot`.`1995`, 0 ), NULLIF( `tickets_spot`.`1994`, 0 ), NULLIF( `tickets_spot`.`1993`, 0 ), NULLIF( `tickets_spot`.`1992`, 0 ), NULLIF( `tickets_spot`.`1991`, 0 ), NULLIF( `tickets_spot`.`1990`, 0 ), NULLIF( `tickets_spot`.`1989`, 0 ), NULLIF( `tickets_spot`.`1988`, 0 ), NULLIF( `tickets_spot`.`1987`, 0 ), NULLIF( `tickets_spot`.`1986`, 0 ), NULLIF( `tickets_spot`.`1985`, 0 ), NULLIF( `tickets_spot`.`1984`, 0 ), NULLIF( `tickets_spot`.`1983`, 0 ), NULLIF( `tickets_spot`.`1982`, 0 ), NULLIF( `tickets_spot`.`1981`, 0 ), NULLIF( `tickets_spot`.`1980`, 0 ), NULLIF( `tickets_spot`.`1979`, 0 ), NULLIF( `tickets_spot`.`1978`, 0 ), NULLIF( `tickets_spot`.`1977`, 0 ), NULLIF( `tickets_spot`.`1976`, 0 ), NULLIF( `tickets_spot`.`1975`, 0 ), NULLIF( `tickets_spot`.`1974`, 0 ), NULLIF( `tickets_spot`.`1973`, 0 ), NULLIF( `tickets_spot`.`1972`, 0 ), NULLIF( `tickets_spot`.`1971`, 0 ), NULLIF( `tickets_spot`.`1970`, 0 ), NULLIF( `tickets_spot`.`1969`, 0 ), NULLIF( `tickets_spot`.`1968`, 0 ), NULLIF( `tickets_spot`.`1967`, 0 ), NULLIF( `tickets_spot`.`1966`, 0 ), NULLIF( `tickets_spot`.`1965`, 0 ), NULLIF( `tickets_spot`.`1964`, 0 ), NULLIF( `tickets_spot`.`1963`, 0 ), NULLIF( `tickets_spot`.`1962`, 0 ), NULLIF( `tickets_spot`.`1961`, 0 ), NULLIF( `tickets_spot`.`1960`, 0 ), NULLIF( `tickets_spot`.`1959`, 0 ), NULLIF( `tickets_spot`.`1958`, 0 ), NULLIF( `tickets_spot`.`1957`, 0 ), NULLIF( `tickets_spot`.`1956`, 0 ), NULLIF( `tickets_spot`.`1955`, 0 ), 'a substitute for zero' ) AS UNSIGNED )) as min_tkt,
        MAX(CAST( COALESCE(  NULLIF( `tickets_spot`.`2015`, 0 ), NULLIF( `tickets_spot`.`2014`, 0 ), NULLIF( `tickets_spot`.`2013`, 0 ), NULLIF( `tickets_spot`.`2012`, 0 ), NULLIF( `tickets_spot`.`2011`, 0 ), NULLIF( `tickets_spot`.`2010`, 0 ), NULLIF( `tickets_spot`.`2009`, 0 ), NULLIF( `tickets_spot`.`2008`, 0 ), NULLIF( `tickets_spot`.`2007`, 0 ), NULLIF( `tickets_spot`.`2006`, 0 ), NULLIF( `tickets_spot`.`2005`, 0 ), NULLIF( `tickets_spot`.`2004`, 0 ), NULLIF( `tickets_spot`.`2003`, 0 ), NULLIF( `tickets_spot`.`2002`, 0 ), NULLIF( `tickets_spot`.`2001`, 0 ), NULLIF( `tickets_spot`.`2000`, 0 ), NULLIF( `tickets_spot`.`1999`, 0 ), NULLIF( `tickets_spot`.`1998`, 0 ), NULLIF( `tickets_spot`.`1997`, 0 ), NULLIF( `tickets_spot`.`1996`, 0 ), NULLIF( `tickets_spot`.`1995`, 0 ), NULLIF( `tickets_spot`.`1994`, 0 ), NULLIF( `tickets_spot`.`1993`, 0 ), NULLIF( `tickets_spot`.`1992`, 0 ), NULLIF( `tickets_spot`.`1991`, 0 ), NULLIF( `tickets_spot`.`1990`, 0 ), NULLIF( `tickets_spot`.`1989`, 0 ), NULLIF( `tickets_spot`.`1988`, 0 ), NULLIF( `tickets_spot`.`1987`, 0 ), NULLIF( `tickets_spot`.`1986`, 0 ), NULLIF( `tickets_spot`.`1985`, 0 ), NULLIF( `tickets_spot`.`1984`, 0 ), NULLIF( `tickets_spot`.`1983`, 0 ), NULLIF( `tickets_spot`.`1982`, 0 ), NULLIF( `tickets_spot`.`1981`, 0 ), NULLIF( `tickets_spot`.`1980`, 0 ), NULLIF( `tickets_spot`.`1979`, 0 ), NULLIF( `tickets_spot`.`1978`, 0 ), NULLIF( `tickets_spot`.`1977`, 0 ), NULLIF( `tickets_spot`.`1976`, 0 ), NULLIF( `tickets_spot`.`1975`, 0 ), NULLIF( `tickets_spot`.`1974`, 0 ), NULLIF( `tickets_spot`.`1973`, 0 ), NULLIF( `tickets_spot`.`1972`, 0 ), NULLIF( `tickets_spot`.`1971`, 0 ), NULLIF( `tickets_spot`.`1970`, 0 ), NULLIF( `tickets_spot`.`1969`, 0 ), NULLIF( `tickets_spot`.`1968`, 0 ), NULLIF( `tickets_spot`.`1967`, 0 ), NULLIF( `tickets_spot`.`1966`, 0 ), NULLIF( `tickets_spot`.`1965`, 0 ), NULLIF( `tickets_spot`.`1964`, 0 ), NULLIF( `tickets_spot`.`1963`, 0 ), NULLIF( `tickets_spot`.`1962`, 0 ), NULLIF( `tickets_spot`.`1961`, 0 ), NULLIF( `tickets_spot`.`1960`, 0 ), NULLIF( `tickets_spot`.`1959`, 0 ), NULLIF( `tickets_spot`.`1958`, 0 ), NULLIF( `tickets_spot`.`1957`, 0 ), NULLIF( `tickets_spot`.`1956`, 0 ), NULLIF( `tickets_spot`.`1955`, 0 ), 'a substitute for zero' ) AS UNSIGNED ) ) as max_tkt    
            
        FROM `parks`
        LEFT JOIN `attendance` ON `attendance`.`park_id` = `parks`.`park_id` AND `attendance`.`is_deleted` <> 1 
        LEFT JOIN `tickets_spot` ON `tickets_spot`.`park_id` = `parks`.`park_id`  AND `tickets_spot`.`tkt_code` = CONCAT(`parks`.`park_code`,'_Adult')  AND `tickets_spot`.`is_deleted` <> 1 
        WHERE `parks`.`is_deleted` = 0";
    
        $query = $this->db->query($sql);
        if($query->num_rows()>0)
        return $query->result_array();
        return false;
    }
    
    
     public function get_park_types()
    {
        $this->db->where('is_deleted',0);
        $q = $this->db->get('park_types');
        if($q->num_rows()>0)
        return $q->result_array();
        return false;
    }
    
      public function get_country()
    {
        $this->db->select('countries.country_id,countries.country_name');
        $this->db->join('countries', 'countries.country_id  = parks.country_id');
        $this->db->group_by("countries.country_id"); 
        $countries = $this->db->get('parks');

        return $countries = $countries->result_array();
    }
    
    public function get_keyword_info($filterKeyword,$filterType){
      
       
       $this->db->where('keyword',$filterKeyword);
        
       if($filterType == 'brand') $filterType = 'brand_name';
       if($filterType == 'country') $filterType = 'country_name';
       if($filterType == 'park_type') $filterType = 'park_type_name';
       if($filterType == 'continent') $filterType = 'continent_name';  
       
       if($filterType!='all')  
       $this->db->where('type',$filterType);
       
       $this->db->where('is_deleted',"0");
       $this->db->order_by('type',"DESC");
       $q = $this->db->get('search_keywords');
       if($q->num_rows()>0){
        return $q->result_array();
       }
       
       return false;
    }
    
    public function view_park($park_id)
    {
      
       $this->db->select('parks.*,countries.country_name,park_types.park_type_name, brands.brand_name, SUM(hourly_capacity) as thrc, currency.currency_code as c_code');
       $this->db->join('brands','brands.brand_id = parks.brand_id','left');
       $this->db->join('countries','countries.country_id = parks.country_id','left');
       $this->db->join('currency','currency.currency_id = parks.currency_id','LEFT'); 
       $this->db->join('park_types','park_types.park_type_id = parks.park_type_id','left');
       $this->db->join('rides','rides.park_id  = parks.park_id  AND rides.is_deleted <> 1 AND rides.is_approved = 1  ','LEFT');
       $this->db->where('parks.park_id',$park_id);
       $this->db->where('parks.is_deleted',0);
       $this->db->where('parks.is_approved',1);
       $this->db->group_by('parks.park_id');
       $query = $this->db->get('parks');
       
       
       
       if($query)
        return $query = $query->result_array();
       else
        return false;   
    }
    
    public function get_park_by_code($park_code)
    {
       $this->db->select('parks.*');
       $this->db->where('parks.park_code',$park_code);
       $this->db->where('parks.is_deleted',0);
       $this->db->where('parks.is_approved',1);
       $query = $this->db->get('parks');
       if($query)
        return $query = $query->result_array();
       else
        return false;   
    }
    
    public function get_rides($park_id)
    {
       $this->db->select('rides.ride_name,rides.ride_type,rides.hourly_capacity,rides.created,rides.last_updated'); 
       $this->db->where('rides.park_id',$park_id);
       $this->db->where('is_deleted',0);
       $this->db->where('is_approved',1); 
       $this->db->order_by('rides.ride_type','ASC');
       $query = $this->db->get('rides');
       if($query)
        return $query = $query->result_array();
       else
        return false; 
    }
    
    public function get_tickets($park_id)
    {
       $this->db->where('tickets.park_id',$park_id);
       $this->db->where('is_deleted',0);
       $this->db->where('is_disabled',0);
       $this->db->where('is_approved',1); 
       $query = $this->db->get('tickets');
       if($query)
        return $query = $query->result_array();
       else
        return false; 
    }
    
    public function get_att($park_id)
    {
       $this->db->where('attendance.park_id',$park_id);
       $this->db->where('is_deleted',0);
       $this->db->where('is_disabled',0);
       $this->db->where('is_approved',1); 
       $query = $this->db->get('attendance');
       if($query)
        return $query = $query->result_array();
       else
        return false; 
    }
    
     public function get_misc_info($park_id,$brand_id)
    {
       $where = " ( mice_info_select.park_id = $park_id || mice_info_select.brand_id = $brand_id ) AND mise_info.is_deleted = 0 ";
       $this->db->where($where,null,false);
       $this->db->join('mise_info','mise_info.mise_info_id = mice_info_select.mice_info_id');
       $query = $this->db->get('mice_info_select');
       if($query)
       return $query = $query->result_array();
       else
       return false; 
    }
    
    
    public function get_ppp_rates($country_id){
        $this->db->where('country_id',$country_id);
        $this->db->join('currency','currency.currency_id = ppp_rates.currency_id');
        $q = $this->db->get('ppp_rates');
        if($q->num_rows()>0)
        return $q->result_array();
        return false;
    }
    
    public function save_email()
    {
        $data = array(
            'email' => $this->input->post('email'),
            'created' => date('Y-m-d H:i:s',time())
        );
        $insert = $this->db->insert('email_subscription',$data);
        if($insert)
        return true;
        
        return false;
    }
    
    public function check_email($email)
    {
       
        $this->db->where('email',$email);
        $query = $this->db->get('email_subscription');
        if($query->num_rows() > 0)
        return true;
        
        return false;
    }
    
    private function insertQuery($query_details)
    {
        $insert = $this->db->insert('search_queries',$query_details);
        if($insert)
        return true;
        
        return false;
    }
    
    public function get_related_articles($key, $type='park'){
        if($type=='park'){
              
                $articles = array();
              
                $this->db->where('park_code',$key);
                $query = $this->db->get('parks');
                $park = $query->result_array();
                $key = $park[0]["park_id"];
                $this->db->where('park_id',$key);    
                $query = $this->db->get('related_articles');
                if($query->num_rows() > 0)
                foreach($query->result_array() as $item)
                $articles[] = $item;
            
                //will check if park location have any
                $key = $park[0]["location"];
                $this->db->select('related_articles.*');
                $this->db->join('locations','locations.location_id = related_articles.location_id');
                $this->db->where('locations.location_name',$key);
                $query = $this->db->get('related_articles');
                if($query->num_rows() > 0)
                foreach($query->result_array() as $item)
                $articles[] = $item;
                
                    //will check if park country have any
                    $key = $park[0]["country_id"];
                    $this->db->select('related_articles.*');
                    $this->db->where('related_articles.country_id',$key);
                    $query = $this->db->get('related_articles');
                    if($query->num_rows() > 0)
                    foreach($query->result_array() as $item)
                    $articles[] = $item;
                    
                        //will check if park type have any
                        $key = $park[0]["park_type_id"];
                        $this->db->select('related_articles.*');
                        $this->db->where('related_articles.park_type',$key);
                        $query = $this->db->get('related_articles');
                        if($query->num_rows() > 0)
                        foreach($query->result_array() as $item)
                        $articles[] = $item;
                    
                
                return $articles;
            
            
        }
        elseif($type=='location'){
            $this->db->select('related_articles.*');
            $this->db->join('locations','locations.location_id = related_articles.location_id');
            $this->db->where('locations.location_name',$key);
            $query = $this->db->get('related_articles');
            if($query->num_rows() > 0)
            return $query->result_array();
            return false;
        }
        elseif($type=='park_type'){
            $this->db->select('related_articles.*');
            $this->db->join('park_types','park_types.park_type_id  = related_articles.park_type');
            $this->db->where('park_types.park_type_name',$key);
            $query = $this->db->get('related_articles');
            if($query->num_rows() > 0)
            return $query->result_array();
            return false;
        }
        else{ //country
            $this->db->select('related_articles.*');
            $this->db->join('countries','countries.country_id  = related_articles.country_id');
            $this->db->where('countries.country_name',$key);
            $query = $this->db->get('related_articles');
            if($query->num_rows() > 0)
            return $query->result_array();
            return false;
        }
        
    }
}
?>