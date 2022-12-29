<?php
class Search_model extends CI_Model
{
    public function __construct()
	{
	    $this->load->database();
	}
    
    public function search_keywords($search_key,$limit=false){
            $searchExp = '';
            $keywords = explode(' ',$search_key);
            foreach($keywords as $keyword){
                if($keyword == '-')
                continue;
                $keyword = trim($this->db->escape($keyword),'\'');
                $searchExp .= '+(>'.$keyword.'*)';
            }
            //query for fulltext index search
            $q = "SELECT search_keywords.keyword,search_keywords.type,search_keywords.latitude,search_keywords.longitude,parks.park_code, MATCH(keyword) AGAINST ('$searchExp' IN BOOLEAN MODE) AS relevance
                  FROM `search_keywords` 
                  LEFT JOIN parks ON (parks.name = keyword AND type = 'name')
                  WHERE MATCH(keyword) AGAINST ('$searchExp' IN BOOLEAN MODE) 
                  ORDER BY relevance DESC";
                  
            if($limit)
            $q .= " LIMIT 5";
            
            
            
            $query = $this->db->query($q);
            if($query->num_rows() > 0){
            return $query->result();
            }
            
        return null;
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
	$q= "SELECT search_keywords.keyword as l,
                         search_keywords.type as t,
                         search_keywords.latitude as lt,
                         search_keywords.longitude as lg,
                         parks.park_code as p,
                         search_keywords.geo_type_1 as g
                  FROM `search_keywords` 
                  LEFT JOIN parks ON (parks.name = keyword AND type = 'name' AND parks.is_deleted = 0 AND search_keywords.latitude = parks.latitude  )
                  WHERE search_keywords.is_deleted = 0";		
            $query = $this->db->query($q);
            if($query->num_rows() > 0){
            return $query->result_array();
            }
            
        return null;
    }
    
    
}
