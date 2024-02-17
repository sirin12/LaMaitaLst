<?php

Class Statistics_model extends CI_Model {

  function count_views($site_id=false)
  {
    $result = array(0,0,0,0,0,0,0,0,0,0,0,0);
    for($i=1;$i<=12; $i++)
    {
	  $this->db->select_sum('count');
          $this->db->where('Year(datetime)=Year(CURRENT_TIMESTAMP)');
          $this->db->where('Month(datetime)',$i);
          if($site_id)
          $this->db->where('site_id',$site_id);
            else  
          $this->db->where('site_id >',1);
          
          $query = $this->db->get('info')->row();
          
	  $result[$i-1]=$query->count?:0;
    }
    return $result;
  }
}
