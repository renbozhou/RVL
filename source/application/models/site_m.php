<?php
class Site_m extends CI_Model {
	/*
     *  Created by David Brenchley 12/4/2013 
     *	site_m is a model for interacting with sites
     *	constructor autochecks the session
     *	
     */
    
    
	/*function get_customer_type()
	{
		$ct = array(); 	
		$q = $this->db->query('select * from customer_type'); 
		foreach($q->result_array() as $r)
		{
			$ct[] = $r['name']; 			
		}
		return $ct; 
	}
	
	function get_rma_status_id()
	{
		$ct = array();
		$q = $this->db->query('select * from rma_status');
		foreach($q->result_array() as $r)
		{
			$ct[] = $r['name'];	
		}
		return $ct;
	}	
	
	function get_product_type()
	{
		$ct = array();
		$q = $this->db->query('select * from product_type');
		foreach($q->result_array() as $r)
		{
			$ct[] = $r['name'];
		}
		return $ct;
	}
	
	function get_fa_codes()
	{
		return array('BADHDD','BOARD','BUTTON','CNECTR','COSMC','CPU','REVERROR','REVNPF','DND','DOA','DOOR','FAN','FAROY','FRAUD','FWM',
		'LED','NICERR','NOISE','NPF','OTHER','POWSUP','MEMORY','REPEAT','ROBOCODE','SMOKE','SUPPLIER','TESTERROR');
	}
	
	function get_suppliers()
	{
		return array('Seagate','Samsung','Hitachi','Toshiba','Western Digital','Argosy',
		'Goodman','MaPower','Min-Aik','Onnto','USI','Wistron','Pegatron','Alpha');
	}
	*/
	
	function set_site($info)
	{
		$this->db->insert('sites', $info);
		return $this->db->affected_rows(); 
	}
	
	function update_site($id, $data)
	{
		$where = "id = " .$id;
		$q = $this->db->update_string('sites', $data, $where);
		return $this->db->query($q); 
	}
	
	function get_single_site($id)
	{
		$ct = array();
		//$uid = $this->session->userdata('tracking_id');
		$q = $this->db->query('select * from sites where id = ' .$id . ' ;' );
		foreach($q->result_array() as $r)
		{ 
			$data = array(
					'code' => $r['code'],
					'description' => $r['description']);			
		}
		return $data;
	}
	
	function blank_site()
	{
		$data = array(
                //'id' => '-1',
				'code' => '',
				'description' => '');
		
		return $data;
	}
		
    function site_info($sid)
	{
		$r = array(); 
		if (isset($sid)){
            $q = $this->db->query('select * from sites where id =' .$sid .";"); 
            foreach ($q->result_array() as $row){
                $r['site']= array (
                        //'id' => $sid,
                        'code' => $row['code'],
                        'description' => $row['description']); 
            }
		}
		return $r; 
		
	}
    
	function get_all_sites()
	{
		$ct = array(); 
		$ct['statement'] = array();
		
		$statement = 'select * from sites order by id';
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'code' => $r['code'],
					'description' => $r['description']);
		}
		
		// return everything
		return $ct;
	}	
    
    function all_sites()
	{
		$r = array(); 
		$q = $this->db->query('select * from sites order by id;'); 
		foreach ($q->result_array() as $row){
			$name = 'site' . $row['id']; 
			$r[$name]= array (
					'id' => $row['id'], 
					'code' => $row['code'], 
					'description' => $row['description']); 
        }
		$sd['sites'] = $r; 
		return $sd;
		
	}
    
}

