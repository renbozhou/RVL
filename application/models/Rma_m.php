<?php

class Rma_m extends CI_Model {
	
	public function get_customer_type()
	{
		$ct = array(); 	
		$q = $this->db->query('select * from customer_type'); 
		foreach($q->result_array() as $r)
		{
			$ct[] = $r['name']; 			
		}
		return $ct; 
	}
	
	public function get_rma_status_id()
	{
		$ct = array();
		$q = $this->db->query('select * from rma_status');
		foreach($q->result_array() as $r)
		{
			$ct[] = $r['name'];	
		}
		return $ct;
	}	
	
	public function get_product_type()
	{
		$ct = array();
		$q = $this->db->query('select * from product_type');
		foreach($q->result_array() as $r)
		{
			$ct[] = $r['name'];
		}
		return $ct;
	}
	
	public function get_fa_codes()
	{
		return array('BADHDD','BOARD','BUTTON','CNECTR','COSMC','CPU','REVERROR','REVNPF','DND','DOA','DOOR','FAN','FAROY','FRAUD','FWM',
		'LED','NICERR','NOISE','NPF','OTHER','POWSUP','MEMORY','REPEAT','ROBOCODE','SMOKE','SUPPLIER','TESTERROR');
	}
	
	public function get_suppliers()
	{
		return array('Seagate','Samsung','Hitachi','Toshiba','Western Digital','Argosy',
		'Goodman','MaPower','Min-Aik','Onnto','USI','Wistron','Pegatron','Alpha');
	}
	
	public function set_rma($info)
	{
		$this->db->insert('rma', $info);
		return $this->db->affected_rows(); 
	}
	
	public function update_rma($id, $data)
	{
		$where = "id = " .$id;
		$q = $this->db->update_string('rma', $data, $where);
		return $this->db->query($q); 
	}
	
	public function get_single_rma($id)
	{
		$ct = array();
		$uid = $this->session->userdata('tracking_id');
		$q = $this->db->query('select * from rma where id = ' .$id . ' ;' );
		foreach($q->result_array() as $r)
		{ 
			$data = array(
					'receipt_date' => $r['receipt_date'],
					'customer_type' => $r['customer_type'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name'],
					'customer_rma_num'=> $r['customer_rma_num'],
					'rma_type' => $r['rma_type'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'ret_part_num' => $r['ret_part_num'],
					'ret_part_desc' => $r['ret_part_desc'],
					'shipped_date' => $r['shipped_date'],
					'warranty' => $r['warranty'],
					'replacement_sn' => $r['replacement_sn'],
                    'returned_mtm' => $r['returned_mtm'],
                    'shipped_mtm' => $r['shipped_mtm'],
					'replacement_part_num' => $r['replacement_part_num'],
					'replacement_part_desc' =>$r['replacement_part_desc'],
					'courier_tn' => $r['courier_tn'],
					'screen_date' => $r['screen_date'],
					'fa_cause_code'=> $r['fa_cause_code'],
					'product_disposition'=> $r['product_disposition'],
					'rtv_category'=> $r['rtv_category'],
					'raw_hdd_sn' => $r['raw_hdd_sn'],
					'raw_hdd_part_num' =>$r['raw_hdd_part_num'],
					'raw_hdd_part_num2' => $r['raw_hdd_part_num2'],
					'raw_hdd_part_num3' => $r['raw_hdd_part_num3'],
					'supplier' => $r['supplier'],
					'supplier_rma' => $r['supplier_rma'],
					'notes' => $r['notes'],
					'site_id' => $r['site_id'],
					'modified_by' => $r['modified_by'],
					'created' => $r['created'],
					'last_modified' => $r['last_modified'],
					'created_by' =>$r['created_by'],
					'product_type_id' => $r['product_type_id'],
					'shipment_document_num' => $r['shipment_document_num'],
					'rma_status_id' => $r['rma_status_id'],
					'replacement_mode' => $r['replacement_mode'], 
					'added_wip_sn' => $r['added_wip_sn'], 
					'added_wip_pn' => $r['added_wip_pn'],
					'used_wip_sn' => $r['used_wip_sn'],
					'used_wip_pn' => $r['used_wip_pn']);
			
		}
		return $data;
	}
	
	public function blank_rma()
	{
		$data = array(
				'receipt_date' => '',
				'customer_type' => '',
				'company_name' => '',
				'first_name' => '',
				'last_name' => '',
				'customer_rma_num'=> '',
				'rma_type' => '',
				'iomega_sn' => '',
				'bare_hdd_sn' => '',
				'ret_part_num' => '',
				'ret_part_desc' => '',
				'shipped_date' => '',
				'warranty' => '',
				'replacement_sn' => '',
				'replacement_part_num' => '',
                'returned_mtm' => '',
                'shipped_mtm' => '',
				'replacement_part_desc' => '',
				'courier_tn' => '',
				'screen_date' => '',
				'fa_cause_code'=>'',
				'product_disposition'=> '',
				'rtv_category'=> '',
				'raw_hdd_sn' =>'',
				'raw_hdd_part_num' =>'',
				'raw_hdd_part_num2' => '',
				'raw_hdd_part_num3' => '',
				'supplier' => '',
				'supplier_rma' =>'',
				'notes' => '',
				'site_id' =>'',
				'modified_by' => '',
				'created' => '',
				'last_modified' => '',
				'created_by' =>'',
				'product_type_id' =>'',
				'shipment_document_num' => '',
				'rma_status_id' => '',
				'replacement_mode' => '', 
				'added_wip_sn' => '', 
				'added_wip_pn' => '',
				'used_wip_sn' => '',
				'used_wip_pn' => '');
		
		return $data;
	}
	
	public function rmas_by_user()
	{
		$ct = array();
		$uid = $this->session->userdata('tracking_id');
		$q = $this->db->query('select * from rma where modified_by = ' .$uid . ' or created_by = ' .$uid ); 
		foreach($q->result_array() as $r)
		{
			$ct[] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'], 
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
		return $ct; 
	}
	
	public function rma_by_site($site)
	{
		$statement ='SELECT * FROM rma WHERE (site_id = "' .$site .'");';
	
		
		// set varibles
		$ct['statement'] = array('site' => $site);
		$ct['results'] = array();
		
		// run the query
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
		
		// return everything
		return $ct;
		
	}
	
	public function rma_by_rmanumber($number)
	{
		$ct = array();
		$site=$this->session->userdata('site_id');
		$ct['statement'] = array('site' => $site, 'rma_number_like' => $number);
		$ct['results'] = array();
        
        $userId = $this->session->userdata('id');
                        
		$q = $this->db->query('select r.*, s.code site_code from rma r join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = '.$userId.' and customer_rma_num like '."'%" .$number ."%';");
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
		return $ct;
		
	}
	
    public function rma_by_rma_or_serial_nbr($number)
	{
		$ct = array();
		$site=$this->session->userdata('site_id');
		if( !empty($number) ) {
			$ct['statement']['site'] = $site;
			$ct['statement']['rma_number_like'] = $number;
			$ct['statement']['iomega_sn_like'] = $number;
			$ct['statement']['bare_hdd_sn_like'] = $number;
			$ct['results'] = array();
	        $userId = $this->session->userdata('id');
	        $whereCondition = 
			$q = $this->db->query('select r.*, s.code site_code from rma r join user_sites_vw us on (r.site_id = us.site_id)  join sites s on (r.site_id = s.id) where us.user_id = '.$userId.' and (customer_rma_num like '."'%" .$number ."%' or iomega_sn like "."'%" .$number ."%' or  bare_hdd_sn like "."'%" .$number ."%'  );");
			foreach($q->result_array() as $r)
			{
				$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']
				);
			}
		}
		return $ct;
	}
    
	public function mgr_rma_all($info, $dateinfo)
	{
		$sites = explode(',',$info); 
		$statement ='SELECT * FROM rma WHERE ((site_id = "' .$sites[0] .'")';
		$by = 'created'; 
		for ($s = 1; $s<(count($sites)); $s++)
		{
			if (!empty($sites[$s]))
				$statement .= ' or (site_id ="' .$sites[$s] .'")'; 
		}
		$statement .= ')'; 
		if (!empty($dateinfo)){
			if ($dateinfo['by'] == 1)
				$by = 'receipt_date';
			if ($dateinfo['by'] == 2)
				$by = 'shipped_date'; 
			if ( $dateinfo['start'] != '')
			{
				$statement .= ' and  (( ' .$by .' >= "'.$dateinfo['start'] .'") AND ('.$by .'<= "' .$dateinfo['end'] .'"));';
		}}
		//echo $statement; 
		// set varibles
		$ct['statement'] = array('site' => $info);
		$ct['results'] = array();
		
		// run the query
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'site_id' => $r['site_id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
		
		// return everything
		return $ct;
	}
	
	public function mgr_rma_search($info, $dateinfo, $nbr)
	{
		$sites = explode(',',$info);
		$statement ='SELECT r.*, s.code site_code FROM rma r join sites s on (r.site_id = s.id)  WHERE ((r.site_id = "' .$sites[0] .'")';
		$by = 'created';
		for ($s = 1; $s<(count($sites)); $s++)
		{
		if (!empty($sites[$s]))
			$statement .= ' or (site_id ="' .$sites[$s] .'")';
		}
					$statement .= ')';
					if (!empty($dateinfo)){
					if ($dateinfo['by'] == 1)
							$by = 'receipt_date';
					if ($dateinfo['by'] == 2)
							$by = 'shipped_date';
					if ( $dateinfo['start'] != '')
					{
					$statement .= ' and  (( ' .$by .' >= "'.$dateinfo['start'] .'") AND ('.$by .'<= "' .$dateinfo['end'] .'"))';
					}}
					
		$statement .= 'and (customer_rma_num like '."'%" .$nbr ."%' or iomega_sn like "."'%" .$nbr ."%' or bare_hdd_sn like "."'%" .$nbr ."%'   );"; 
							//echo $statement;
							// set varibles
		$ct['statement'] = array('site' => $info);
		$ct['results'] = array();
		
							// run the query
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
				$ct['results'][] = array (
						'id' => $r['id'],
						'site_id' => $r['site_id'],
						'iomega_sn' => $r['iomega_sn'],
						'bare_hdd_sn' => $r['bare_hdd_sn'],
						'customer_rma_num' => $r['customer_rma_num'],
						'company_name' => $r['company_name'],
						'first_name' => $r['first_name'],
						'last_name' => $r['last_name']);
		}
		
				// return everything
				return $ct;
	}    
    
	public function rma_all()
	{
		$ct = array(); 
		$ct['statement'] = array();
		
        $id = $this->session->userdata('id');
		$statement = 'select r.*, s.code site_code from rma r join user_sites_vw us on (r.site_id = us.site_id)  join sites s on (r.site_id = s.id)  where us.user_id = '.$id.';';
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
		
		// return everything
		return $ct;
	}
	public function rma_created($start_date = null, $end_date = null)
	{
		// Set the select statement 
		$site=$this->session->userdata('site_id');        
        $userId = $this->session->userdata('id');
        
		if ($start_date==null)
		{
			$start_date = '0-0-0000'; 
			$statement = 'select * from rma WHERE (site_id = "' .$site .'")'; 
			$end_date = date('Y-m-d');
		} else {
			if ($end_date==null)
			{
				$end_date = date('Y-m-d'); 
			}
			$statement ='SELECT r.*, s.code site_code FROM rma r join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = '.$userId.' AND (created >= "'.$start_date .'") AND (created <= "' .$end_date .'");';
		}
        
		// set varibles 
		$ct['statement'] = array( 'csdate' => $start_date, 'cedate'=> $end_date, 'site' => $site);
		
		$ct['results'] = array();
	
        
		// run the query
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
		
		// return everything 
		return $ct;
	
	}
	public function mgr_csv($info=null, $dateinfo)
	{		
		$this->load->dbutil();
        //strip out any extra commas from end
		//$sites = explode(',',$info);
        $info = rtrim($info, ',');
                    
		$by = 'r.created'; 
        
        $statement ='SELECT rv.*, returned_mtm, shipped_mtm FROM rma r join rma_vw rv on (r.id = rv.id) join sites s on (r.site_id = s.id)  WHERE 1 = 1 ';
        
        if($info != null)
            $statement .= ' and r.site_id in ('.$info.') ';
        else 
            $statement .= ' and 1 = 2 ';
		
		if ($dateinfo['start'] != '')
		{
			if ($dateinfo['by'] == 1)
				$by = 'r.receipt_date';
			if ($dateinfo['by'] == 2)
				$by = 'r.shipped_date';
			
			$statement .= ' and  (( ' .$by .' >= "'.$dateinfo['start'] .'") AND ('.$by .'<= "' .$dateinfo['end'] .'"));';
		}
		$qu = $this->db->query($statement); 
        
		return $this->dbutil->csv_from_result($qu);
		
	}
		
	public function csv_rma($q=null)
	{
		$this->load->dbutil();
     		
      // Set the select statement 
	  $site=$this->session->userdata('site_id');        
      $userId = $this->session->userdata('id');
        
	  if ($q == null){
          $qu = $this->db->query("SELECT rv.*, returned_mtm, shipped_mtm FROM rma r join rma_vw rv on (r.id = rv.id) join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.site_id) where us.user_id = ".$userId.";");
	  }	
	  else { $qu=$this->db->query($q); }
           
	  return $this->dbutil->csv_from_result($qu);
	}
	
	public function rma_shipped($start_date = null, $end_date = null)
	{
		$site=$this->session->userdata('site_id');
        $userId = $this->session->userdata('id');
        // Set the select statement
		if ($start_date==null)
		{
			$start_date = '1-1-2000';			
		}
		if ($end_date==null)
		{
			$end_date = date('Y-m-d');
		}
	                
		$statement ='SELECT r.*, s.code site_code FROM rma r join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = '.$userId.' AND (shipped_date >= "'.$start_date .'") AND (shipped_date <= "' .$end_date .'");';
		// set varibles
		
		$ct['statement'] = array( 'ssdate' => $start_date, 'sedate'=> $end_date, 'site' => $site);
		$ct['results'] = array();
	
		// run the query
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
	
		// return everything
		return $ct;
	
	}
	
	public function rma_rec($start_date = null, $end_date = null)
	{
		$site=$this->session->userdata('site_id');
		$userId = $this->session->userdata('id');
		// Set the select statement
		if ($start_date==null)
		{
			$start_date = '1-1-2000';
		}
		if ($end_date==null)
		{
			$end_date = date('Y-m-d');
		}
	
		$statement ='SELECT r.*, s.code site_code FROM rma r join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = '.$userId.'  AND (receipt_date >= "'.$start_date .'") AND (receipt_date <= "' .$end_date .'");';
		// set varibles
		$ct['statement'] = array( 'rsdate' => $start_date, 'redate'=> $end_date, 'site' => $site);
	
		$ct['results'] = array();
	
		// run the query
		$q = $this->db->query($statement);
		foreach($q->result_array() as $r)
		{
			$ct['results'][] = array (
					'id' => $r['id'],
					'iomega_sn' => $r['iomega_sn'],
					'bare_hdd_sn' => $r['bare_hdd_sn'],
					'customer_rma_num' => $r['customer_rma_num'],
					'company_name' => $r['company_name'],
					'first_name' => $r['first_name'],
					'last_name' => $r['last_name']);
		}
	
		// return everything
		return $ct;
	
	}
	
}

