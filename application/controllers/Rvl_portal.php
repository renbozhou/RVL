<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*	rvl_portal is the main controller for the site, manages all the site views
*	constructor autochecks the session
*	
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Rvl_portal extends MY_Controller
{
	public function __construct()
	{
		// check if the user is logged on for every action
		parent::__construct(); 
		date_default_timezone_set("GMT");
		$this->is_logged_in();
		
	}
	
	public function index()
	{
		/// same as home but need index for default rvl_portal access
		$this->home();
	}
	
	public function home($message = null)
	{
		// landing page with a message for the user (if needed)
		$data['data']['message'] = $message; 
		$data['main_content'] = 'home';
		$this->load->view('includes/template', $data);
	}
		
	public function password_reset()
	{
		$id = $this->session->userdata('id'); 
		$this->load->model('user_m');
		$data['data'] = $this->user_m->get_pw_from_id($id);
		$data['main_content'] = 'password_reset';
		$this->load->view('includes/template', $data);
	}

	public function help()
	{
		$data['main_content'] = 'help';
		$this->load->view('includes/template', $data);
	}
	
	function update_rma()
	{
		// save an already existing rma from the rma_id; 

		// need to take out 0-0-0000 or null dates
		
		$shipped_date = $this->input->post('shipped_date'); 
		if ($shipped_date == '0000-00-00' || $shipped_date == '' )
		{
			$shipped_date = null;
		} 
		
		$return_date = $this->input->post('receipt_date');
		if ($return_date == '0000-00-00' || $return_date == '' )
		{
			$return_date = null; 
		}
		
		
		$screen_date =  $this->input->post('screen_date'); 
		if ($screen_date == '0000-00-00' || $screen_date == '' )
		{
			$screen_date = null;
		}
		
		$modified = date('Y-m-d');
		$id = (int)$this->input->post('rma_id'); 
		{
			$rma = array(
					'receipt_date' => $return_date,
					'customer_type' => $this->input->post('customertype'),
					'company_name' => $this->input->post('company_name'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'customer_rma_num'=> $this->input->post('rma_number'),
					'rma_type' => $this->input->post('rma_type'),
					'iomega_sn' => $this->input->post('iomegasn'),
					'bare_hdd_sn' => $this->input->post('bhddsn'),
					'ret_part_num' => $this->input->post('partnumber'),
					'ret_part_desc' => $this->input->post('partdesc'),
					'shipped_date' => $shipped_date,
					'warranty' => 1,
					'replacement_sn' => $this->input->post('replacesn'),
					'replacement_part_num' => $this->input->post('replacenum'),
					'replacement_part_desc' => $this->input->post('replacedesc'),
					'courier_tn' => $this->input->post('couriertrack'),
					'screen_date' => $screen_date,
					'fa_cause_code'=> $this->input->post('facausecode'),
					'product_disposition'=> $this->input->post('product_dis'),
					'rtv_category'=> $this->input->post('rtvcat'),
					'raw_hdd_sn' => $this->input->post('raw_hdd_sn'),
					'raw_hdd_part_num' => $this->input->post('raw_hdd_sn'),
					'raw_hdd_part_num2' => $this->input->post('raw_hdd_sn2'),
					'raw_hdd_part_num3' => $this->input->post('raw_hdd_sn3'),
					'supplier' => $this->input->post('supplier'),
					'supplier_rma' => $this->input->post('supplierrma'),
					'notes' => $this->input->post('notes'),
					//'modified_by' => $this->session->userdata('tracking_id'),
                    'modified_by' => $this->session->userdata('id'),                    
					'last_modified' => $modified,
					'product_type_id' => $this->input->post('product_type'),
					'shipment_document_num' => $this->input->post('shipdocnum'),
					'rma_status_id' => $this->input->post('status'),
					'replacement_mode' => $this->input->post('replacemode'),
					'added_wip_sn' => $this->input->post('added_wip_sn'),
					'added_wip_pn' => $this->input->post('added_wip_pn'),
					'used_wip_sn' => $this->input->post('used_wip_sn'),
					'used_wip_pn' => $this->input->post('used_wip_pn'),
                    'returned_mtm' => $this->input->post('returned_mtm'),
                    'shipped_mtm' => $this->input->post('shipped_mtm'));
		}
		$this->load->model('rma_m');
		if ($this->rma_m->update_rma($id, $rma))
		{
			if( $this->input->post('cloan') )
			{
				$c['rma_number'] = $rma['customer_rma_num'];
				$c['company_name']= $rma['company_name'];
				$c['first_name']= $rma['first_name'];
				$c['last_name']= $rma['last_name'];
				$c['customer_type']= $rma['customer_type'];
				$c['rma_type']= $rma['rma_type'];
					
				$this->copy_rma($c);
			}
			else 
			{
				$this->home('Update Successful'); 
			}
		}else 
		{
			$this->home('Error Updating');
		}
		
		
		
	}
	
	function save_new_rma() 
	{
		//save the data from the RVL form
		
		// need to take out 0-0-0000 or null dates
		
		$shipped_date = $this->input->post('shipped_date');
		if ($shipped_date == '0000-00-00' || $shipped_date == '' )
		{
			$shipped_date = null;
		}
		
		$return_date = $this->input->post('receipt_date');
		if ($return_date == '0000-00-00' || $return_date == '' )
		{
			$return_date = null;
		}
		
		$screen_date =  $this->input->post('screen_date');
		if ($screen_date == '0000-00-00' || $screen_date == '' )
		{
			$screen_date = null;
		}
		
		$created = date('Y-m-d'); 
		
		{
			$rma = array( 
					'receipt_date' => $return_date,
					'customer_type' => $this->input->post('customertype'),
					'company_name' => $this->input->post('company_name'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'customer_rma_num'=> $this->input->post('rma_number'),
					'rma_type' => $this->input->post('rma_type'),
					'iomega_sn' => $this->input->post('iomegasn'),
					'bare_hdd_sn' => $this->input->post('bhddsn'),
					'ret_part_num' => $this->input->post('partnumber'),
					'ret_part_desc' => $this->input->post('partdesc'),
					'shipped_date' => $shipped_date,
					'warranty' => 1,
					'replacement_sn' => $this->input->post('replacesn'),
					'replacement_part_num' => $this->input->post('replacenum'),
					'replacement_part_desc' => $this->input->post('replacedesc'),
					'courier_tn' => $this->input->post('couriertrack'),
					'screen_date' => $screen_date,
					'fa_cause_code'=> $this->input->post('facausecode'),
					'product_disposition'=> $this->input->post('product_dis'),
					'rtv_category'=> $this->input->post('rtvcat'),
					'raw_hdd_sn' => $this->input->post('raw_hdd_sn'),
					'raw_hdd_part_num' => $this->input->post('raw_hdd_sn'),
					'raw_hdd_part_num2' => $this->input->post('raw_hdd_sn2'),
					'raw_hdd_part_num3' => $this->input->post('raw_hdd_sn3'),
					'supplier' => $this->input->post('supplier'),
					'supplier_rma' => $this->input->post('supplierrma'),
					'notes' => $this->input->post('notes'),
					'site_id' => $this->input->post('site'),
					//'modified_by' => $this->session->userdata('tracking_id'),
                    'modified_by' => $this->session->userdata('id'),
					'created' => $created,
					'last_modified' => $created,
					//'created_by' => $this->session->userdata('tracking_id'),
                    'created_by' => $this->session->userdata('id'),
					'product_type_id' => $this->input->post('product_type'),
					'shipment_document_num' => $this->input->post('shipdocnum'),
					'rma_status_id' => $this->input->post('status'),
					'replacement_mode' => $this->input->post('replacemode'),
					'added_wip_sn' => $this->input->post('added_wip_sn'),
					'added_wip_pn' => $this->input->post('added_wip_pn'),
					'used_wip_sn' => $this->input->post('used_wip_sn'),
					'used_wip_pn' => $this->input->post('used_wip_pn'),
                    'returned_mtm' => $this->input->post('returned_mtm'),
                    'shipped_mtm' => $this->input->post('shipped_mtm'));
			
			
			$this->load->model('rma_m');
			if ($this->rma_m->set_rma($rma))
			{
				if( $this->input->post('cloan') )
				{
					$c['rma_number'] = $rma['customer_rma_num'];
					$c['company_name']= $rma['company_name'];
					$c['first_name']= $rma['first_name'];
					$c['last_name']= $rma['last_name'];
					$c['customer_type']= $rma['customer_type'];
					$c['rma_type']= $rma['rma_type'];
					$this->copy_rma($c);
				} else {
					$this->home('New RMA Created');
				}
			} else {
				$this->home('Error in Creating RMA'); 
			} 
		}
				
	}

	function copy_rma($info)
	{
		/*
		 *  used for save and clone function 
		 *  use rma info from $data and populate a new rma
		 */

		$this->load->model('user_m');
		$id = "new";
		$t = 'RMA Cloan';
		$data['values'] =  $this->rma_m->blank_rma();
		$data['new'] = true;
		$data['id'] = 0;
		
		$data['values']['customer_rma_num'] = $info['rma_number']; 
		
		$data['values']['company_name'] = $info['company_name'];
		$data['values']['first_name'] = $info['first_name']; 
		$data['values']['last_name'] = $info['last_name']; 
		$data['values']['customer_type'] = $info['customer_type']; 
		$data['values']['rma_type'] = $info['rma_type']; 
		
		$data['customertype'] = $this->rma_m->get_customer_type();
		$data['producttype'] = $this->rma_m->get_product_type();
		$data['facodes'] = $this->rma_m->get_fa_codes();
		$data['rmastatus'] = $this->rma_m->get_rma_status_id();
		$data['suppliers'] = $this->rma_m->get_suppliers();
		$data['title'] = $t;
			
		$data['id'] = $id;
		$s['data']=$data;
		$s['data']['all_sites'] = $this->user_m->get_all_sites();
		$s['main_content']='single_edit';
		$this->load->view('includes/template', $s);
		
	}
	
	function edit($id = null)
	{
		// Single edit screen *based on ID of rma
		
		$this->load->model('rma_m');
		$this->load->model('user_m');
		if ($id == null) {
			$id = "new";
			$t = 'Create New RMA'; 
			$data['values'] =  $this->rma_m->blank_rma(); 
			$data['new'] = true; 
			$data['id'] = 0;
		} else {
			
			$data['values'] = $this->rma_m->get_single_rma($id);
			$data['new'] = false; 
			$data['id'] = $id;
			$t = 'RMA# '.$data['values']['customer_rma_num']; 
			
		}
		
		if ($this->session->userdata('site_id') == 0)
		{
			$data['mgr_site'] = $this->user_m->get_mgr($this->session->userdata('id')); 
			
 		}
		
		$data['customertype'] = $this->rma_m->get_customer_type();
		$data['producttype'] = $this->rma_m->get_product_type();
		$data['facodes'] = $this->rma_m->get_fa_codes();
		$data['rmastatus'] = $this->rma_m->get_rma_status_id();
		$data['suppliers'] = $this->rma_m->get_suppliers();
		$data['title'] = $t;
		
		$data['id'] = $id;
		$s['data'] = $data;
		$s['data']['all_sites'] = $this->user_m->get_all_sites();
		$s['main_content'] = 'single_edit';
		$this->load->view('includes/template', $s);
	}
	
	function search()
	{	// get rma's by the rma_number
		$this->load->model('rma_m');
		$data = $this->rma_m->rma_by_rma_or_serial_nbr($this->input->post('stext',true)); //rma_by_rmanumber
		$s['data'] = $data;
		//search for RVL
		$s['main_content']='search_results';
		$this->load->view('includes/template', $s);
	} 
	
    /*
	function allrmas()
	{
		// get all rma's 
		$this->load->model('rma_m');
		$data = $this->rma_m->rma_all();
		$s['data'] = $data; 
		//search for RVL
		$s['main_content']='search_results';		
		$this->load->view('includes/template', $s);
	}
	*/
    
	function adminpage($val=0)
	{
		//check permissions 
		if ($this->session->userdata('use_admin') == 0)
		{
			$this->home(); 
			die();
		} 
		//get list of users
		$this->load->model('user_m');		
		
		// get user info
		// send to view
		$s['data'] = $this->user_m->all_users();
		$tmp = $this->user_m->get_all_sites();
		$site = array(); 
		foreach ($tmp as $t)
		{
			$site[$t['id']] = array ('name' => $t['code'], 'desc' => $t['description']); 
		}
		$s['data']['site'] = $site; 
		
		
		$s['main_content'] = 'adminpage';
		$this->load->view('includes/template', $s);
		//push list to view
	}
	
    function sitepage($val=0)
	{
		//check permissions 
		if ($this->session->userdata('use_admin') == 0)
		{
			$this->home(); 
			die(); 
		} 
		//get list of sites
		$this->load->model('site_m');		
		
		// get site info
		// send to view
		$s['data'] = $this->site_m->all_sites();	
		
		$s['main_content'] = 'sitepage';
		$this->load->view('includes/template', $s);
		//push list to view
	}
    
    function update_site()
	{
        //check permissions 
		if ($this->session->userdata('use_admin') == 0)
		{
			$this->home("No permissions to update sites."); 
			die(); 
		} 
		//save an already existing site from the id;
		$id = (int)$this->input->post('id');
        $code = $this->input->post('code');
        $description = $this->input->post('description');
        
		$this->load->model('site_m');
        $site = array( 'code' => $code, 'description' => $description);

        //determine if update or insert, then invoke appropriate database save
        if($id == "-1") {
            if ($this->site_m->set_site($site))
		    {		
			    $this->home('Insert Successful'); 			
		    } else {
			    $this->home('Error Inserting');
		    }
        } else {
		    if ($this->site_m->update_site($id, $site))
		    {			
			    $this->home('Update Successful'); 			
		    } else {
			    $this->home('Error Updating');
		    }
        }
		
		
		
	}
    
	function addprivs()
	{
		// admin user page function to update user's privlages
		$rma = $inv = $lc = $adm = 0; 
		$id = (int)$this->input->post('id');
		$site = (int)$this->input->post('site');

		$this->input->post('rma') && $rma = 1;
		$this->input->post('inv') && $inv = 1;
		$this->input->post('lc')  && $lc  = 1;
		$this->input->post('adm') && $adm = 1;

		$per = array('use_rma'=> $rma,'permission'=> $inv,'use_lc'=> $lc,'use_admin'=> $adm, 'site_id' => $site);
		$this->load->model('user_m');
		$this->user_m->user_permission($id, $per);
		$mgr = '0'; 
		if ($site == '0') {
			foreach ($_POST as $key => $value) {
				is_numeric($key) && $mgr .=  ',' .$key;
			}
			$this->user_m->save_mgr($id,$mgr);
		}
		$this->adminpage(0);
	}
	
	function edituser($id)
	{
		// admin access to edit a user
		if ($this->session->userdata('use_admin') == 0)
		{
			$this->home();
			die();
		}
		
		$this->load->model('user_m');
		$s['data'] = $this->user_m->user_info($id); 
		$s['data']['id'] = $id;
		$s['data']['mgr'] = $this->user_m->get_mgr($id);
		$s['data']['sites'] = $this->user_m->get_all_sites();
		$s['main_content'] = 'permissions';
		$this->load->view('includes/template', $s);
	}
	
	function userpage()
	{
		// user access to user information
		$this->load->model('user_m');
		
		$id = $this->session->userdata('id'); 
		// get user info
		// send to view 
		$s['data'] = $this->user_m->user_info($id);
		if ($s['data']['user']['site'] == 0)
		{
			$s['data']['mgr'] = $this->user_m->get_mgr($id);
		}
		$s['data']['all_sites'] = $this->user_m->get_all_sites();
		$s['main_content'] = 'userpage';
		$this->load->view('includes/template', $s);
	}
    
    function editsite($id)
	{
		// admin access to edit a user
		if ($this->session->userdata('use_admin') == 0)
		{
			$this->home("No permission to edit sites.");
			die();
		}
				
		$this->load->model('site_m');        
		$s['data'] = $this->site_m->site_info($id); 
        $s['data']['id'] = $id; 
        
        if($id == "-1") {
            $s['data']['site'] = $this->site_m->blank_site();             
        }
        
		$s['main_content'] = 'edit_site';
		$this->load->view('includes/template', $s);
	}
        
	function set_alias()
	{
		// Get the data
		$id = $this->session->userdata('id'); 
		$alias = $this->input->post('alias', true); 
		
		// load into model
		$this->load->model('user_m');
		
		if ($this->user_m->set_alias($id, $alias) > 0)
		{
			$this->session->set_userdata('alias', $alias);
			$this->home('Site Name Updated');
		}else 
		{
			$this->home('Error Updating Alias');
		}
	}

	function learn_admin()
	{
		$fn = trim($this->input->post('filename', true)); 
		$this->load->model('user_m');
		// check if the file is in the db 
		if ($this->user_m->check_learning_name($fn)) {
			$this->user_m->remove_learning_name($fn); 
		}
		// diplay the form
		$this->learning();
	}
	
	function learn_new()
	{
		// get the posted filename
		$s['data']['filename'] =  $this->input->post('filename', true);
		// load the form
		$s['main_content'] = 'learn_create';
		$this->load->view('includes/template', $s);
	}
	
	function learn_save()
	{
		// save the data
		$this->load->model('user_m');
		$this->user_m->savelc();
		$this->learning();
	}

	function learning()
	{
		// learning center 
		$filename = array(); 
		$this->load->model('user_m');
		$lcdb = $this->user_m->get_learning(); 
				
		$this->load->helper('file');
		// get the filenames from upload folder
		$d = get_dir_file_info('upload');
               
		foreach ($d as $obj) {
			$filename[] = $obj['name'];
		}        
        uksort($filename, 'strcasecmp');
        
		$badfiles = array(); 
		$counted = array(); 
		$list = array();
		// check all the db files are included)
		foreach ($lcdb as $obj) // get row information
		{
			$bf = true; // set badfile toggle
			for ($i = 0; $i < count($filename); $i++)
			{
				if ($obj['name'] == $filename[$i]) // if the file is part of the directory
				{ 
					$counted [] = $filename[$i]; // set to counted
					$list[$filename[$i]] = array ( // add to list
							'name' => $filename[$i], 
							'id' => $obj['id'], 
							'desc' => $obj['desc']);
					$bf = false;  // set badfile toggle to false
                    break;
				 }
					
			}
			if ($bf) // list of bad files in the 
			{
				$badfiles[] = array('name' => $obj['name'], 'id' => $obj['id']);
			}
			
		}
        uksort($counted, 'strcasecmp');
                        
        usort($list, $this->build_sorter('name'));
        
		$data['filenames'] = $filename; 
		$data['counted'] = $list; 
		$data['badfiles'] = $badfiles;//sortmulti ($badfiles, 'name', 'asc'); //quickSortMultiDimensional($badfiles, 'name');//$badfiles; 		

        $dif = array_diff($filename, $counted);
        uksort($dif, 'strcasecmp');
        //var_dump($dif);
        $data['newfiles'] = $dif; //  sortmulti( quickSortMultiDimensional(array_diff($filename, $counted), 'name'); //array_diff($filename, $counted); // get the files that are not in database	 
		$s['data']=$data;
		$s['main_content'] = 'learning';	
		$this->load->view('includes/template', $s);
	}
	
	function myrmas()
	{	
		/// grab rma's depending on user's site 
		$this->load->model('rma_m');
		$site=$this->session->userdata('site_id');
		if ($site != 0)
			{
				$data = $this->rma_m->rma_by_site($site);
			}else 
			{
				$data = $this->rma_m->rma_all();
			}	
				  
		$s['data'] = $data; 
		$s['main_content'] = 'search_results'; 
		
		$this->load->view('includes/template', $s);
	}
	
	function filtersearch($id='null')
	{
		$this->load->model('rma_m');
		$sb = $this->input->post('filter');
		$startdate = $this->input->post('start_date');
		$enddate =  $this->input->post('end_date');
		$number = $this->input->post('number'); 
		
        if(isset($_POST['ftp_upload'])) {
            $this->rma_ftp_upload_csv($sb, $startdate,$enddate);
            return;
        } 
        
		switch ($sb) {
			
			case 1:
				$data = $this->rma_m->rma_rec($startdate, $enddate);
				break;
			case 2:
				$data = $this->rma_m->rma_shipped($startdate, $enddate);
				break;
			default: 
				$data = $this->rma_m->rma_created($startdate, $enddate);
				break;
		}
		
		$s['data'] = $data; 
		//search for RVL
		$s['main_content']='search_results';
		$this->load->view('includes/template', $s);
	}
	
	function mgr_rma_search()
	{
		// check if the manager is logged in
		if ($this->session->userdata('use_admin') == 0)
		{
			$this->home(); 
			die(); 
		}
		
		$this->load->model('user_m');
		$this->load->model('rma_m');
		
		$tmp = $this->user_m->get_all_sites();
		$site = array();
		// set site as id  => array ( name, desc )
		foreach ($tmp as $t)
		{
			$site[$t['id']] = array ('name' => $t['code'], 'desc' => $t['description']);
		}
		
	
		$id = $this->session->userdata('id');	
		$s = array(); 
		$s['data']['site'] = $site;
		$s['data']['my_sites'] = $this->user_m->get_mgr($id); 
		$csv = false; 
		$search_site = $start = $end = ""; 
		$search_by = ''; 
		
		if (!empty($_POST))
		{ // go though the post data
			foreach ($_POST as $key => $value)
			{
				if ($key =='filter')
				{
					$search_by = $value; 
				}
				if ($key == 'start_date')
				{
					$start = $value; 
				}
				if ($key == 'end_date')
				{
					$end = $value; 
				}
				if ($key == 'rma')
				{
					$rma = $value; 
				}
				if ($key == 'mgr_csv')
				{
					$csv = true; 
				} 
				if (is_numeric($key))
					$search_site .= $key . ','; 
			}
			if ($end == '')
			{
				$end = date('Y/m/d');
			}
			if ($start > $end)
			{
				$temp = $start; 
				$start = $end; 
				$end = $temp; 
				
			}
			$date_info = array('start' => $start, 'end' => $end, 'by' => $search_by); 
		}
		else 
		{
			$search_site = $s['data']['my_sites'];
			$date_info = array(); 
		}
		
		$s['data']['searched_sites'] = $search_site;
		$s['data']['dateinfo'] = $date_info; 
		if (empty($rma))
		{
			$s['data']['list'] = $this->rma_m->mgr_rma_all($search_site, $date_info); 
		}else {
			$s['data']['list'] = $this->rma_m->mgr_rma_search($search_site, $date_info, $rma);
		}
		
		$s['main_content']='mgr_search_results';

        if ($csv) {
				$mgrdata = $this->rma_m->mgr_csv($search_site, $date_info);
				$this->load->helper('download');
				force_download('mgr_lenovo_rma.csv', $mgrdata);
			    return;		
		}
        
        $this->load->view('includes/template', $s);
		
	}
	
	function upload()
	{
		$this->load->model('user_m');
		$s['main_content']='upload';
		if ($this->session->userdata('site_id') == 0)
		{
			$s['data']['mgr'] = $this->user_m->get_mgr($this->session->userdata('id'));
				
		}
		
		$tmp = $this->user_m->get_all_sites();
		$site = array();
		foreach ($tmp as $t)
		{
			$site[$t['id']] = array ('name' => $t['code'], 'desc' => $t['description']);
		}
		
		
		$s['data']['all_sites'] = $site;
		
		$this->load->view('includes/template', $s);
	}
	
	function save_inv()
	{
		// get contents from stream, put in db, send home
		$tmp = json_decode($this->input->post('data')); 
		/*$data = array (); 
		foreach ($tmp as $val)
		{
			$data[]=array(  'quantity' => $val->quantity,
					 'part_number' => $val->part_number ,
					 'hd_type' => $val->hd_type ,
					 'location' => $val->location ,
					 'part_desc' => $val->part_desc ,
					 'site' => $val->site ,
					 'week' => $val->week ,
					 'oracle_desc' => $val->oracle_desc ); 
				
		}
		
		$data =   html_entity_decode(json_decode($this->input->post('data'))); */
		$this->load->model('inv_m');
		$this->inv_m->save_inv($tmp); 
		$this->home("Inventory Saved Successfully"); 
		
	}
	
	function inventory_report()
	{
		$this->load->model('user_m');
		$s['data']['lt'] = array(); 
		$s['data']['data'] = null; 
		$s['data']['all_sites'] = $this->user_m->get_all_sites();
		$id = $this->session->userdata('id');
		$s['data']['mgr_sites'] = $this->user_m->get_my_sites($id);    //get_mgr($id));
		// grab the data from the post 
		$s['data']['loc'] = "Howdy"; //$this->input->post('location');
		$s['main_content']='inventory_report';
		$this->load->view('includes/template', $s);
	}
	
	function inventory_csv()
	{
		$this->load->model('inv_m');
		$data = $this->inv_m->csv_inv(); 
		$this->load->helper('download');
		force_download('inventory.csv', $data);
		
	}
	
    // function show_create_view_rma_vw() {
    //     $qry = "SHOW CREATE VIEW rma_vw";
    //     $test = $this->db->query($qry); 
        
    //     $result = mysql_query($sql);

    //     if (!$result) {
    //         echo "DB Error, could not list tables\n";
    //         echo 'MySQL Error: ' . mysql_error();
    //         exit;
    //     }

    //     while ($row = mysql_fetch_row($result)) {
    //         echo "Row: {$row[0]} {$row[1]}\n";
    //     }

    //     mysql_free_result($result);
    // }
    
	function rma_csv()
	{
        //$this->show_create_view_rma_vw();
        //return;
        $userId = $this->session->userdata('id');
        if(isset($_POST['ftp_upload'])) {
            $query = "SELECT r.iomega_sn, r.replacement_part_num, r.replacement_sn, r.ret_part_num , sysdate() report_date, r.receipt_date, r.customer_rma_num, r.shipped_date, r.site_id, s.code site_code FROM rma r join rma_vw rv on (r.id = rv.id)  join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = ".$userId." and r.iomega_sn is not null ";
            $filename = 'lenovo_ftp_uload_rma.csv';
        } else {
            $query = "SELECT  rv.*, r.returned_mtm, r.shipped_mtm FROM  rma r join rma_vw rv on (r.id = rv.id)  join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = ".$userId." ";
		    $filename = 'lenovo_rma.csv';
        }

        $post = ($_POST); 
        
		// most should have site defined
		if (isset($post['site']) && $post['site'] != 0)
		{
			$query .= ' and r.site_id = "' .$post['site'] .'"'; 
		}
		// created date
		if (isset($post['csdate']))
		{
			$query .= ' and (r.created >= "'.$post['csdate'] .'")'; 
		}
		
		if (isset($post['cedate']))
		{
			$query .= ' and (r.created <= "'.$post['cedate'] .'")';
		}
		// recieved
		if (isset($post['rsdate']))
		{
			$query .= ' and (r.receipt_date >= "'.$post['rsdate'] .'")';
		}
		
		if (isset($post['redate']))
		{
			$query .= ' and (r.receipt_date <= "'.$post['redate'] .'")';
		}
		
		// shipped
		if (isset($post['ssdate']))
		{
			$query .= ' and (r.shipped_date >= "'.$post['ssdate'] .'")';
		}
		
		if (isset($post['sedate']))
		{
			$query .= ' and (r.shipped_date <= "'.$post['sedate'] .'")';
		}
		
		if (isset($post['rma_number_like']))
		{
			$query .= ' and r.customer_rma_num like '."'%" .$post['rma_number_like'] ."%';"; 
		}
				
		$this->load->model('rma_m');
		$data = $this->rma_m->csv_rma($query);
		$this->load->helper('download');
                
		force_download($filename, $data);
	}
	
    	function rma_ftp_upload_csv($filter=null, $startdate=null, $enddate=null)
	{
		$post = ($_POST); 
		//if (empty($post))
		//{
		//	$query = 'select * from rma ';
		//}else{
		$userId = $this->session->userdata('id');
        
        $query = "SELECT r.iomega_sn, r.ret_part_num, r.returned_mtm ret_mtm, r.replacement_sn, r.replacement_part_num, r.shipped_mtm replacement_mtm, sysdate() report_date, r.receipt_date, r.customer_rma_num, r.shipped_date, r.site_id, s.code site_code FROM rma r join user_sites_vw us on (r.site_id = us.site_id) join sites s on (r.site_id = s.id) where us.user_id = ".$userId." and iomega_sn is not null ";
		//}
        
        switch($filter) {
            case 1:
                $field = 'r.receipt_date';
                break;
            case 2:
                $field = 'r.shipped_date';
                break;
            default:
                $field = 'r.created';
                break;
        }
                        
		if (isset($startdate) && strlen($startdate) > 0)
		{
			$query .= ' and ('.$field.' >= "'.$startdate.'")';
		}
		
		if (isset($enddate)  && strlen($enddate) > 0)
		{
			$query .= ' and ('.$field.' <= "'.$enddate.'")';
		}
				
		$this->load->model('rma_m');
		$data = $this->rma_m->csv_rma($query);
		$this->load->helper('download');
		force_download('lenovo_ftp_uload_rma.csv', $data);
		
	
	}
    
    
	function inventory_part($id=null)
	{
		if ($id==null){
			$id = 0; 
		}
		// get the history of the part 
		$this->load->model('inv_m');
		// put it into an array, send to view
		$s['data']['parts'] = $this->inv_m->part_history($id);
		$s['main_content'] = 'inventory_part'; 
		$this->load->view('includes/template', $s);
	}
	
	function inventory_search ()
	{
		$this->load->model('user_m');
		$this->load->model('inv_m');
		$s['data']['all_sites'] = $this->user_m->get_all_sites();
		$id = $this->session->userdata('id');
		$s['data']['mgr_sites'] = $this->user_m->get_my_sites($id);
		// grab the data from the post 
		$loc = $this->input->post('location', true);

		$s['data']['loc'] = $loc;
		$date = $this->input->post('filedate'); 		
		// get the data
		$s['data']['data'] = $this->inv_m->search_inv($loc, $date);
		
		$lt = array(); 
		foreach ($s['data']['data'] as $p)
		{
			$val = $this->inv_m->lead_time($p['part_number'],$p['site'], $id);
			($val) && $lt[$p['part_number']][$p['site']]=$val;
		}
		$s['data']['lt'] = ($lt);
		$s['main_content']='inventory_report';
		$this->load->view('includes/template', $s);
	}
	
	function inventory_history($part = 0, $site = 0)
	{
		/*
		 * Single inventory part history and location finder
		 *  what do I need to do here?
		 *  get current site/location
		 *  get all other locations (for current inventory)
		 */
		
		$this->load->model('user_m');
		$this->load->model('inv_m');
		$s['data']['all_sites'] = $this->user_m->get_all_sites();
		$s['data']['history'] = $this->inv_m->part_history($part,$site); 
		$week = $s['data']['history'][0]['week']; 
		$s['data']['other'] = $this->inv_m->part_loc($part,$week); 
		$s['main_content']='part_view';
		$this->load->view('includes/template', $s);
		
	}
	
	function learn_upload(){
	/*
	 * Learning uploader for the learning center (limited on size and type)
	 * 
	 */

		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|png|txt|csv';
		$config['max_size']	= '1000';
		
		$this->load->helper('file');
		$this->load->library('upload', $config);
		
		if ( !$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			
			$this->home('Can not open file');
			
		}
		else {
			$this->learning(); 
		}
	}

	function inventory_details($part = null, $site = null)
	{
		// if the part of number is null then populate from the post data
		($part == null) && $part = $this->input->post('part_number');
		($site == null) && $site = (int)$this->input->post('site');
		$this->load->model('inv_m');

		$id = $this->session->userdata('id');
		$s['data']['lt'] = $this->inv_m->lead_time($part, $site, $id);
		// get the lead time, and all instances of the part in that site 
	}
	
	function lead_time($part = null, $site = null)
	{
		// send the data if any to the input screen
		$this->load->model('inv_m');
		$id = $this->session->userdata('id');
		$s['data']['part'] = $part;
		$s['data']['site'] = $site;
		$s['data']['id'] = $id;
		$s['main_content']='inventory_lt';
		$this->load->view('includes/template', $s);
	}
	
	function save_lt()
	{
		$this->load->model('inv_m');
		// get data from post
		$part = $this->input->post('part');
		$id = $this->session->userdata('id');
		$site = $this->input->post('site');
		$lt = $this->input->post('leadtime');

		// save to database
		$this->inv_m->set_lt($part, $site, $lt, $id);
		// send back to search inventory 
		$this->inventory_search(); 
	}
	
	function do_upload()
	{
		/*
		 * Inventory verifyer
		Cannot have multiple records or the same part number and location combination
		Location can be null, if it is null default to FGI
		Part numbers need to be 10, 8 or 5
		Look up the database description based upon the part number and auto populate. Also load the file description into a separate field so that both can be seen.
		Site will be auto populated when they select to upload the file.
		Week will be auto populated when they select to upload the file.
		*/
		$term = $this->input->post('filedate', true);
		$site = (int)$this->input->post('site_id');
		
		// check db here
		$qry = 'select * from inventory where week = "' .$term .'" and site = ' .$site .';'; 
		$test = $this->db->query($qry); 
		if ($test->num_rows() > 0)
		{
			$this->home('Inventory File Already Exists in the Database for site ' .$site .' and week ' .$term);
		}
		else 
		{
		$config['upload_path'] = './temp/';
		$config['allowed_types'] = 'css|csv|txt';
		$config['max_size']	= '1000';

		$this->load->helper('file');
		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
			$this->home($error);
		}
		else
		{
			 
			$inv = array(); 
			$fileinfo = $this->upload->data(); 
			 
			$part = array(); 
			$content = array(); 
			$desc = '';
			$row = 0; // set 0 for discription
			if (($handle = fopen($fileinfo['full_path'], "r")) !== FALSE) { //if file is there
			  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // read line
			  	if ($row == 0) // this is the description row
			  	{ 
			  		$desc = array(
			  				'quantity' =>$data[0],
			  				'part_number' =>$data[1],
			  				'hdtype'  =>$data[2],
			  				'site' =>$data[3],
			  				'location' =>$data[4], 
			  				'part_desc' => $data[5], 
			  				'oracle_desc' => 'db description'
			  				); 
			  	}
			  	else { 
			  		
					//  set values
			  		$verify = 'none';
			  		$quantity = 0;
			  		$partnumber = 0;
			  		$site_input = ''; 
			  		$description = '';
			  		
			  		$location = 'FGI'; // if Location is null default to FGI
			  		
			  		
			  		if (count($data)!=6) // check the count
			  		{
			  			$verify = 'row size invalid';			  			
			  		}
			  		else 
			  		{
			  			$quantity = utf8_encode($data[0]);
			  			$partnumber = utf8_encode($data[1]); 
			  			$hd_type = utf8_encode($data[2]);
			  			$site_input = utf8_encode($data[3]);
			  			$description = utf8_encode($data[5]); 
			  			// discription will not show on localhost
			  			if (ENVIRONMENT != 'localhost'){
				  			$o = $this->oracle_code($partnumber);
				  			$oracle_desc = $o['DESCRIPTION'];
			  			}else 
			  			{
			  				$oracle_desc = 	'localhost'; 
			  			}	  		
				  		if ($data[4] != ''){ //if Location is not null use the value
				  			$location = utf8_encode($data[4]);
				  		}
			  		}
			  		
			  		
			  		if ($quantity < 1 || $quantity == null) // Qty cannot be null and must be greater than 0
			  		{
			  			$verify = 'quantity less then one';
			  		}
			  		
			  		$size = (strlen($partnumber)); 
			  		if ($size != 10 && $size !=8 && $size != 5)
			  		{
			  			$verify = "part length not 10, 8, or 5";
			  		}
			  		if ($partnumber == '')// Part number cannot be null
			  		{
			  			$verify = 'No Part Number on row #' . ($row+1);
			  		}
			  		
			  		if (isset($part[$partnumber][$location]))
			  		{
			  			$verify = 'Duplicate Part Number in List'; 
			  		}
			  		else 
			  		{
			  			$part[$partnumber][$location]=true; 
			  		}
			  		
			  		// add to inventory array
			  		$inv[] = array(
			  				'quantity' =>$quantity,
			  				'part_number' =>$partnumber,
			  				'hd_type' => $hd_type,
			  				'location' =>$location, 
			  				'part_desc' => $description, 
			  				'site' => $site,
			  				'week' => $term, 
			  				'oracle_desc' => $oracle_desc
			  				); 
			  		if ($verify!='none'){
				  		$content[] = array(
				  				'site' => $site, 
				  				'part' =>  $partnumber, 
				  				'error' => $verify
				  				); 
			  		}
			  		
			  		}
			  		$row++; // next row #
			  	}
			}
			else {
				$content = "Issue: Cannot Open File"; 
			}
			fclose($handle);
			delete_files('./temp/');
			$data = array(
					'error' => $content,
					'title' => $desc, 
					'inventory' => $inv);
			
			
			$s['data']=$data;
			$s['main_content'] = 'verify_inv';
				
			$this->load->view('includes/template', $s);
		}}
	}
	
 	private	function oracle_code($pn)
	{
		$conn = oci_connect('RVL_PORTAL', 'portal', 'prod-db-web.iomegacorp.com:1526/WEBPROD');
		$query = 'select description from cmf_item_master where item_number = :pn';
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ':pn', $pn);
		oci_execute($stid);
		return oci_fetch_assoc($stid);
	}

	public function build_sorter($key) {
	    return function ($a, $b) use ($key) {
	        return strcasecmp($a[$key], $b[$key]);
	    };
	}

}
	