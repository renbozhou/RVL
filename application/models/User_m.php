<?php
/*
 * Class Name  : User model
 * Description : Operating the users table related functions
 */
class User_m extends CI_Model {
	/*
	 * Desc: 检验users表用户是否存在,如果存在保存到session数据中
	 */
	public function valid()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'); 
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
		if ( $this->form_validation->run() === false ) {
			return false;
		}
		
		$em = $this->input->post('email', true);
		$pw = do_hash($this->input->post('password'),'sha256');

		$this->db->where('email', $em);
		$this->db->where('password',$pw);
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			foreach ($query->result() as $row) {
				$data = [
					'id' => $row->id,
					'username' => $row->email,
					'alias' => $row->alias,
					'is_logged_in' => true,
					'tracking_id' => $row->type,
					'permission' => $row->permission,
					'use_lc' => $row->use_lc,
					'use_rma' => $row->use_rma,
					'site_id' => $row->site_id,
					'site' =>  $this->get_site_loc($row->site_id),
					'use_admin' => $row->use_admin,
				];
				$this->session->set_userdata($data);
			}
			return true; 
		}		
		return false; 	
	}

	/*
	 * Desc: 检验users表用户是否存在,如果存在保存到session数据中
	 */
	public function user_permission($id, $data)
	{
		$this->db->update('users', $data, array('id' => $id));
		return $this->db->affected_rows();
	}
	
	public function update_user($user)
	{ 
		$id = $this->session->userdata('id');
		$this->db->update('users', $user, array('id' => $id));
		return $this->db->affected_rows();
	}
	
	public function get_all_sites()
	{
		$q = $this->db->query('select * from sites');
		foreach ($q->result_array() as $row)
		{
			$m[]= array(
				'id' => $row['id'], 
				'code' => $row['code'], 
				'description' => $row['description']
			);
		}
		return $m;
	}
	
	public function get_my_sites($userid)
	{
		$q = $this->db->query('select s.* from sites s join user_sites_vw us on (s.id = us.site_id) where s.id != 0 and us.user_id = '.$userid);
		foreach ($q->result_array() as $row)
		{
			$m[]= array(
				'id' => $row['id'], 
				'code' => $row['code'], 
				'description' => $row['description']
			);
		}
		return $m;
	}

	public function get_site_info($site)
	{
		$query = $this->db->query('SELECT code, description FROM sites where id ="' . $site .'"');
		$row = $query->row();
		if ($query->num_rows()< 1) {
			return array ( 'code'=>'NO_LOC', 'description'=>'No Location Set'); 
		} else {
			$d = array ( 'code' => $row->code,	'description' => $row->description);
			return $d; 
		}
	}
	
	public function get_site_loc($site)
	{
		$query = $this->db->query('SELECT description FROM sites where id ="' . $site .'"');
		$row = $query->row();
		if ($query->num_rows()< 1) {
			return("No Location Set");
		} else{
			$d = $row->description;
			return $d;
		}
	}

	public function get_autocomplete()
	{
		$this->db->select('code, description');
		$this->db->from('sites'); 
		$this->db->like('id',$this->input->post('queryString', true));
		return $this->db->get();
	}
	
	public function get_autodesc()
	{
		$this->db->select('id, code, description');
		$this->db->from('sites');
		$this->db->where('id', $this->input->post('queryString',true));
		return $this->db->get();
	}
	
	public function get_learning()
	{
		$m = array (); 
		$q = $this->db->query('select * from files order by filename'); 
		foreach ($q->result_array() as $row)
		{
			$m[]= array('id' => $row['id'], 'name' => $row['filename'],
					'desc' => $row['description'], 'section' => $row['section']);						
		}
		return $m; 
	}
	
	public function check_learning_name($filename)
	{
		!isset($filename) && $filename = 'g';
		$q = $this->db->query('select * from files where filename = "'.$filename .'"');
		if ($q->num_rows >= 1){
			return true;
		}
		return false; 
	}
	
	public function savelc()
	{
		$data = array(
				'filename' => $this->input->post('filename'),
				'description' => $this->input->post('desc'), 
				'section' => $this->input->post('type')); 
		$i = $this->db->insert('files', $data);
		return $i;
	}

	public function save_mgr($id,$list)
	{
		// destroy all old files
		
		$this->db->where('user_id', $id);
		//$this->db->delete('manager_site');				
		$this->db->delete('user_sites');
		
        //echo $list;
        
		$sites = explode(',', $list);
		$i = 0;
        
        //echo 'inserting:';
		foreach ($sites as $s) {
			$data = array('user_id' => $id,
						  'site_id'=> $s);
			$i = $i + $this->db->insert('user_sites', $data);
            //echo 'uid:'.$id.' ';
            //echo 'site_id:'.' '.$s;
		}

		//$data = array(
		//		'user_id' => $id,
		//		'sites' => $list
		//		);
		//$i = $this->db->insert('manager_site', $data);
		return $i;
		
	}

	public function set_alias($id, $alias)
	{
		$a = array ('alias' => $alias);
		$this->db->where('id', $id); 
		$this->db->update('users', $a);
		return $this->db->affected_rows();
		
	}
	
	public function get_mgr($id)
	{
			$ct = array();
		$st = 'select site_id from user_sites_vw where user_id ="' .$id .'";';
		$query = $this->db->query($st);
		if ($query->num_rows() > 0) 
		{
            //echo 'rows:'.$query->num_rows().' ';
        
			foreach ($query->result_array() as $r)
			{
				//below structure adds an element to the array in php
				$ct[] = $r['site_id'];
			}

            //echo 'mgrsites:'.implode(',', $ct);
            
			//now need to compact array into comma delimited string and return
			return implode(',', $ct);
		} else {
			return 0;
		}

		//
		//$query = $this->db->query( 'select user_id, sites from manager_site where user_id = "' .$id .'";');
		
		//$r = $query->row();
		//if ($query->num_rows == 1){
		//return ($r->sites); 
		//}
		//else {
		//	return 0; 
		//}
	}
	
	public function remove_learning_name($filename)
	{
		$this->db->where('filename', $filename);
		$this->db->delete('files'); 
		
		return true; 
	}
	
    public function get_admin_emails() 
    {
        $q='select email from users where use_admin = 1;';
		$query = $this->db->query($q);
        
        return $query->result_array();        
    }
    
	public function create_user()
	{
		// check if email is already in the db
		$this->db->where('email', $this->input->post('email'));
		$query = $this->db->get('users');
		if ($query->num_rows == 1) {
			return false; 
		}
		
		$n = array(
			'email' => $this->input->post('email'),
			'password' => do_hash($this->input->post('pw1'),'sha256'),
		);

		$i = $this->db->insert('users', $n);

        //now email admins that user was created
        $admins = $this->get_admin_emails();
        $this->load->library('email');
        foreach ($admins as $email)
		{
	        $this->email->from('do_not_reply@lenovo.com', 'RVL Do Not Reply');
	        $this->email->to($email['email']);
	        $this->email->subject('New user created on RVL portal: '.$this->input->post('email'));
	        $this->email->message('New user created on RVL portal: '.$this->input->post('email'));
	        $this->email->send();
		}
		return $i; 
	}

	public function check_email($email)
	{
		$q='select * from users where email ="' .$email .'";';
		$query = $this->db->query($q);
		
		return $query->num_rows();
		
	}
	
	public function get_pw_from_email($email)
	{
		$q = $this->db->query('select password from users where email ="' .$email .'";');
		foreach ($q->result_array() as $row){
			$r = $row['password']; 
		}
		return $r;
						
	}
	
	public function get_pw_from_id($id)
	{
		$q = $this->db->query('select password from users where id ="' .$id .'";');
		foreach ($q->result_array() as $row){
			$r = $row['password'];
		}
		return $r;
	}
	
	public function user_info($uid)
	{
		$r = array(); 
		if (isset($uid)){
		$q = $this->db->query('select * from users where id =' .$uid .";"); 
		foreach ($q->result_array() as $row){
			$r['user']= array (
					'email' => $row['email'],
					'alias' => $row['alias'], 
					'password' => $row['password'],
					'tracking_id' => $row['type'],
					'use_rma' => $row['use_rma'],
					'permission' => $row['permission'],
					'site' => $row['site_id'],
					'site_info' => $this->get_site_info($row['site_id']), 
					'edit_rma' => $row['edit_rma'],
					'use_lc' => $row['use_lc'],
					'edit_lc' => $row['edit_lc'],
					'use_admin' => $row['use_admin'],
					'admin_search' => $row['admin_search'],
					'admin_report' => $row['admin_report']); 
					}
		}
		return $r; 
		
	}
	
	public function user_old($email)
	{
		$r = array();
		$q = $this->db->query('select * from mybb_users where email ="' .$email .'";');
		foreach ($q->result_array() as $row){
			$r[]= array ('user_id' => $row['uid'], 'uname' => $row['username'],
					'password' => $row['password'], 'email' => $row['email'] );
		}
		return $r;
	}
	
	public function all_users()
	{
		$r = array(); 
		$q = $this->db->query('select * from users;'); 
		foreach ($q->result_array() as $row) {
			$name = 'user' . $row['id'];
			$r[$name]= array (
				'id' => $row['id'],
				'email' => $row['email'],
				'alias' => $row['alias'],
				'password' => $row['password'],
				'tracking_id' => $row['type'],
				'use_rma' => $row['use_rma'],
				'site' => $row['site_id'],
				'edit_rma' => $row['edit_rma'],
				'use_lc' => $row['use_lc'],
				'edit_lc' => $row['edit_lc'],
				'use_admin' => $row['use_admin'],
				'admin_search' => $row['admin_search'],
				'admin_report' => $row['admin_report']
			);
		}
		$sd['users'] = $r; 
		return $sd;
		
	}

	/*
	 * Desc: 通过 id 修改用户的数据[如:密码]
	 */
	public function change_pw($pw)
	{
		$id = intval($this->session->userdata('id'));
		$this->db->where('id', $id);
		$this->db->update('users', $pw);
		$r = $this->db->affected_rows();
		return $id;
	}

	/*
	 * Desc: 通过 email 修改用户的数据[如:密码]
	 */
	public function change_pw_by_email( $params=array() )
	{
		if( !empty($params) ) {
			$this->db->where('email', $params['email']);
			unset($params['email']);
			$this->db->update('users', $params);
			return $this->db->affected_rows();
		}
		return null;
	}

}