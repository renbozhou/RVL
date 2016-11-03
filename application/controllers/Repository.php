<?php 
/*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*	returns the files in the learning center
*/

class Repository extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
	
	}
	
	public function learning ($id)
	{
		// right now I an not checking the permissions
		//$data = file_get_contents("upload/" . $id); // Read the file's contents
		$name = $id;
		$this->load->helper('download');
		force_download("upload/".$name); //, $data);
		
	}
	
	public function autosite()
	{
		$this->load->model('user_m');
		$query = $this->user_m->get_autocomplete();
		$data = array(); 
		foreach($query->result() as $row){
			$data[$row->code] = $row->description;
		}
		exit(json_encode($data)); 
	}

	public function autodesc()
	{
		$this->load->model('user_m');
		$query = $this->user_m->get_autodesc();
		$data = array();
		foreach($query->result() as $row){
			$data[$row->id] = $row->description;
		}
		exit(json_encode($data));
	}

	public function delete_lc($title = 0)
	{

		$this->load->helper('file');
		if ($title=='0')
		{
			redirect('login/index');
			die();
		}
		@unlink('./upload/' .$title);
		redirect('rvl_portal/learning');
	}
	
	public function model_code()
	{
		// try to connect to the oracle database:
		$mc = $this->input->post('queryString', true);
		$conn = oci_connect('RVL_PORTAL', 'portal', 'prod-db-web.iomegacorp.com:1526/WEBPROD');
		$pn=(-1); 
		if( $mc )
		{
			$query = 'select REMAN_PART_NUMBER as part_number from CMF_RVL_MODEL_CODE_MASTER WHERE ';
			$term = strtoupper(substr($mc, 0, 2));
			$query .= 'MODEL_CODE = :term';
		
			$stid = oci_parse($conn, $query);
			oci_bind_by_name($stid, ':term', $term);
			oci_execute($stid);
			$pn = oci_fetch_assoc($stid);
			$pn = $pn['PART_NUMBER'];
		}
		$this->part_code($pn); 
		
	}
	
	public function part_code($pn=null)
	{
		$conn = oci_connect('RVL_PORTAL', 'portal', 'prod-db-web.iomegacorp.com:1526/WEBPROD');
		($pn == null) && ($pn = $this->input->post('queryString', true));
		$query = 'select description from cmf_item_master where item_number = :pn';
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ':pn', $pn);
		oci_execute($stid);
		$return = oci_fetch_assoc($stid);
		$return['PART_NUMBER'] = $pn;
		
		exit(json_encode($return));
	}
}

