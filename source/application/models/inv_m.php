<?php
class Inv_m extends CI_Model {
	
	function save_inv($data){
		foreach($data as $d)
		{
			$this->db->insert('inventory', $d);			
			if (!$this->db->affected_rows())
			{
				return 'bad'; 
			}
			
		}
	}
	
	function site_info($id)
	{
		$ct = array();
		$st = 'select * from sites where id ="' .$id .'";';
		$q = $this->db->query($st);
		if ($q->num_rows() > 0) 
		{
			$ct = $q->row_array(); 	
		}
		return $ct;
	}
	
	function lead_time($part, $site, $userId)
	{
		
		$ct = array(); 
		$st = 'select lead_time from lead_time i join user_sites_vw us on (i.site = us.site_id)  where part_number ="' .$part .'" and site = "' .$site .'" and us.user_id = '.$userId.';';
		$q = $this->db->query($st);
		$row = $q->row();
		if(isset($row->lead_time))
		{
			return $row->lead_time;
		}
		return false; 
	}
	
	function set_lt($part, $site, $lt, $userId)
	{
			//first check if user has rights to site
			$st = 'select count(*) count from user_sites_vw where site_id = "' .$site .'" and user_id = "'.$userId.'";';
			$q = $this->db->query($st);
			$row = $q->row();
			if($row->count < 1) {
				return false;
			}
			//if($row->num_rows() < 1) {
			//	return;
			//}

			$data = array(
			   'part_number' => $part ,
			   'site' => $site ,
			   'lead_time' => $lt
				);
			if ($this->lead_time($part, $site, $userId) == array())
			{
				return $this->db->insert('lead_time', $data); 
			}
			else 
			{
				$this->db->where('part_number', $part); 
				$this->db->where('site', $site); 
				return $this->db->update('lead_time', $data); 
			}
	}
	function part_loc($part, $week)
	{
		$st = 'select * from inventory where part_number ="' .$part .'" and week ="' .$week .'";';
		$q = $this->db->query($st);
		foreach($q->result_array() as $r)
		{
			$ct[] = $r;
		}
		return $ct;
	}
	
	function part_history($part, $site)
	{
		/*
		 *  Find the listing for a part, order by week (so latest entry is first)
		 *  
		 */
		$st = 'select * from inventory where part_number ="' .$part .'" and site ="' .$site .'" Order by week desc;'; 
		$q = $this->db->query($st);
		foreach($q->result_array() as $r)
		{
			$ct[] = $r;
		}
		return $ct;
	}
	
	function search_inv($loc, $date)
	{
		$statement = ''; 
		if (($loc == ''))
		{
			$loc = -1; 
		}
		if ($date =='')
		{
			$date = '9999-01-01';
		}
		$ct = array();
		$id = $this->session->userdata('id');
		if ($loc == -1){
			$statement = 'select site, part_number, quantity, location from inventory i join user_sites_vw us on (i.site = us.site_id) where week = "' .$date .'" and us.user_id = '.$id.';';
			
		}else {
		$statement = 'select site, part_number, quantity, location from inventory  i join user_sites_vw us on (i.site = us.site_id)  where site = ' .$loc .' and week = "' .$date .'" and us.user_id = '.$id.';';
		} 

		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct[] = $r;
		}
        
		return $ct;
		
	}
	
	function csv_inv()
	{
		$this->load->dbutil();
		$id = $this->session->userdata('id');
		$query = $this->db->query("SELECT s.code site_code, i.* FROM inventory i join sites s on (s.id = i.site)  join user_sites_vw us on (i.site = us.site_id) where us.site_id != 0 and us.user_id = ".$id.";");
		
		return $this->dbutil->csv_from_result($query);
	}
	
	function parts($site = null){
		
		$ct = array();
		// get all parts if null, if not only parts associated with the site		
		if ($site == null || $site == -1)
		{
			$statement = 'select DISTINCT part_number from inventory';
		}
		else 
		{
			$statement = 'select DISTINCT part_number from inventory where site ="' .$site  .'";';
		}
		//echo $statement; 
		$q = $this->db->query($statement);
			
		foreach($q->result_array() as $r)
		{
			$ct[] = $r;
		}
		return $ct;
		
	}
	
	function get_location($location){
		$ct = array(); 
		$q = $this->db->query('select * from sites where description like '."'%" .$location ."%';");
		
		foreach($q->result_array() as $r)
			{
				$ct[] = $r;
			}
		
		return $ct; 
		}
	
}
