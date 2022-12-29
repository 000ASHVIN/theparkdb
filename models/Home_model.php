<?php
class Home_model extends CI_Model
{
    public function __construct()
	{
	    $this->load->database(); //LOADS THE DATABASE AND CREATES DATABASE OBJECT
	}
    
    public function getParksCount(){
        $sql ='SELECT COUNT(parks.park_id) as parks FROM parks WHERE is_deleted = 0  AND parks.is_approved = 1  ';
        $q = $this->db->query($sql);
        $data = $q->result_array();
        $count["parks"] = $data[0]["parks"];
        
        $sql ='SELECT COUNT(rides.ride_id) as rides FROM rides WHERE is_deleted = 0  AND rides.is_approved = 1 ';
        $q = $this->db->query($sql);
        $data = $q->result_array();
        $count["rides"] = $data[0]["rides"];
        
        return $count;
    }
    
    
   public function getLastUpdated(){
        $sql = "SELECT r2.name,r2.park_code,r2.park_date,r2.ride_date,r2.ticket_date,r2.action,  
                IF(`r2`.`park_date` >= `r2`.`rt_date`,`r2`.`park_date`,r2.rt_date) as high_date
                               
                FROM 
                (
                  SELECT r1.name,r1.park_code,r1.park_date,r1.ride_date,r1.ticket_date,r1.action,
                  IF(`r1`.`ride_date` >= `r1`.`ticket_date`,`r1`.`ride_date`,r1.ticket_date) as rt_date
                  
                  FROM
                  (
                    SELECT p.name,p.park_code,
                    IF(`p`.`last_updated` >= `p`.`created`,`p`.`last_updated`,`p`.`created`) as  park_date,
                    IF(max(r.last_updated) >= max(r.created),max(r.last_updated),max(r.created)) as ride_date,
                    IF(max(t.last_updated) >= max(t.created),max(t.last_updated),max(t.created)) as ticket_date,
                    
                    IF(`p`.`last_updated` >= `p`.`created`,'Updated','Added') as action  
                        
                    FROM parks p
                        
                    LEFT JOIN `rides` `r`
                    ON r.park_id = p.park_id AND r.is_deleted = 0
                    
                    LEFT JOIN `tickets` `t`
                    ON t.park_id = p.park_id AND t.is_deleted = 0
                    
                    WHERE (DATE(p.last_updated) >= DATE_ADD(CURDATE(), INTERVAL -60 DAY)
                    OR DATE(p.created) >= DATE_ADD(CURDATE(), INTERVAL -60 DAY))
                    AND p.is_deleted = 0  AND p.is_approved = 1 
                    
                    GROUP BY p.park_id
                    
                   )r1
                    
                ) r2
                
                ORDER BY UNIX_TIMESTAMP(high_date) DESC
                
                LIMIT 8";
                
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
        
        
        $sql = " SELECT `t`.`name`, `t`.`last_updated`, `t`.`created`, park_type_name,
                IF( IF(`child_last_updated` > `t`.`last_updated`, `child_last_updated`, `t`.`last_updated` ) >= `t`.`created`,IF(`child_last_updated` > `t`.`last_updated`, `child_last_updated`, `t`.`last_updated` ),`t`.`created`) as high_date,
                IF( IF(`child_last_updated` > `t`.`last_updated`, `child_last_updated`, `t`.`last_updated` ) >= `t`.`created`,'Updated','Added') as action, t.park_code,  location
                FROM `parks` `t`
                JOIN park_types ON park_types.park_type_id = t.park_type_id
                WHERE t.is_deleted = 0 AND t.is_approved = 1  ORDER BY UNIX_TIMESTAMP(high_date) DESC LIMIT 8";         
                
        $query = $this->db->query($sql);
        if($query->num_rows() >0){ 
            return $query->result_array();
        }
        else
        return false;
    }
    
    public function get_parks_by_value($type)
    {
        $this->db->select('park_id, name,park_code, est_value_usd, year_built');
        $this->db->where('parks.is_deleted',0);
        $this->db->where('parks.is_disabled',0);
        $this->db->where('park_type_id',$type);
        $this->db->order_by('est_value_usd','DESC');
        $this->db->limit(6);
        $query = $this->db->get('parks'); 
        
           
        if($query->num_rows()>0)
        return $query->result_array();
        return false;
        
    }
    
    
    public function getParkCountByCountry()
    {
        $sql= 'SELECT country_name, count(parks.country_id) as park_count FROM `parks`
               JOIN countries ON countries.country_id = parks.country_id
               WHERE parks.is_deleted = 0 AND parks.is_disabled = 0
               group by parks.country_id
               ';
        $query = $this->db->query($sql);
        if($query->num_rows() >0){ 
            $data = array();
            foreach($query->result_array() as $item)
            $data[$item["country_name"]] = $item["park_count"];
            
            return $data;
            
        }
        else
        return false;       
    }
    
    public function get_admin_email()
    {
        $this->db->select('email');
        $this->db->where('username','admin');
        $query = $this->db->get('users');
        if($query->num_rows() == 1)
        {
            return $query->row();
        }else{
            return false;
        }
    }
    
    public function get_countries(){
        $sql = 'SELECT  DISTINCT parks.country_id, countries.country_name, countries.continent_code, countries.country_code    FROM `parks` 
                JOIN countries on  parks.country_id  = countries.country_id order by country_name';
        $q = $this->db->query($sql);
        if($q->num_rows()>0){
            return $q->result_array();
        }        
        return false;    
    }
    
    public function get_all_parks()
    {
        $this->db->select('parks.name,parks.park_id');
        $this->db->where('is_deleted',0);
        $this->db->where('is_disabled',0);
        $query = $this->db->get('parks');
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        return NULL;
    }
    
    public function get_all_keywords()
    {
        $this->db->select('search_keywords.keyword,search_keywords.type');
        $this->db->where('is_deleted',0);
        $this->db->where('search_keywords.type !=','name');
        $query = $this->db->get('search_keywords');

        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        return NULL;
    }
    
    public function get_news()
    {
        $this->db->select('news.*');
        $this->db->where('is_deleted',0);
        $this->db->limit(4);
        $this->db->order_by('news.display_order','ASC');
        $query = $this->db->get('news');
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        return NULL;
    }

    /**
     * Get view_widget
     * @param int 
     * @return array()
     * */
      public function view_widget($uid)
      {       
          $q=$this->db->select('*')->where('id',$uid)->get('widgets')->result_array();
          return $q;         
      }
      /**
     * Get get_widget_by_name
     * @param int 
     * @return array()
     * */
      public function get_widget_by_name($name)
      {       
          $q=$this->db->select('*')->where('name',$name)->get('widgets')->result_array();
          return $q;         
      }

      public function all_search_keywords(){
           
            //query for fulltext index search
            $q = "SELECT search_keywords.keyword as label,
                         search_keywords.type as t,
                         search_keywords.latitude as lt,
                         search_keywords.longitude as lg,
                         parks.park_code as p,
                         search_keywords.geo_type_1 as g
                  FROM `search_keywords` 
                  LEFT JOIN parks ON (parks.name = keyword AND type = 'name')
                  WHERE search_keywords.is_deleted = 0
                  GROUP BY search_keywords.id
                  ";
            $q= "SELECT search_keywords.keyword as label,
                         search_keywords.type as t,
                         search_keywords.latitude as lt,
                         search_keywords.longitude as lg,
                         parks.park_code as p,
                         search_keywords.geo_type_1 as g
                  FROM `search_keywords` 
                  LEFT JOIN parks ON (parks.name = keyword AND type = 'name' AND parks.is_deleted = 0 AND search_keywords.latitude = parks.latitude  )
                  WHERE search_keywords.is_deleted = 0
                  ORDER BY search_keywords.type ASC
                  ";    
            $query = $this->db->query($q);
            if($query->num_rows() > 0){
            return $query->result_array();
            }
            
        return null;
    }
   
}
?>