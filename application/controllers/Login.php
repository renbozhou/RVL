<?php 
/*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*  controlls the login and user signup	 
*/
class Login extends CI_Controller
{
	/*
	 * Desc: 登录页面首页
	 */	
	public function index()
	{
		@session_start();
		$this->session->sess_destroy();
		$data['main_content'] = 'loginform';
		$this->load->view('includes/template', $data);
	}

	/*
	 * Desc: 检查用户是否能登录,如果成功则保存用户信息到session中
	 */
	public function checkcred()
	{
		$this->load->model('user_m');
		$check = $this->user_m->valid();
		if ($check) {
			redirect('rvl_portal/home'); 
		} else {
			$this->index();
		}
	}

	/*
	 * Desc: 操作忘记密码的页面
	 */
	public function forgot()
	{
		$data['main_content'] = 'forgot_password';
		$this->load->view('includes/template', $data);
	}

	/*
	 * Desc: 注册页面
	 */
	public function signup ()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $data);  
	}

	/*
	 * Desc: 用户登录退出操作
	 */	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->index(); 
	}

	/*
	 * Desc: 用户注册操作
	 */
	public function create_member()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'); 
		$this->form_validation->set_rules('pw1', 'Password', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('pw2', 'Password Confirm', 'trim|required|matches[pw1]');
		
		if ( $this->form_validation->run() === false ) {
			$this->signup(); 
		} else {
			$this->load->model('user_m'); 
			if ( $this->user_m->create_user() ) {
				redirect('login/index');
			} else {
				$data['main_content'] = 'loginerror';
				$this->load->view('includes/template', $data);
			} 
		}
		
	}

	/*
	 * Desc: 修改用户信息
	 */
	public function update_user()
	{
		$tid = (int)$this->input->post('tracking_id');
		( $tid != 0 ) && $user['type'] = $tid;
		$user['alias'] = $this->input->post('uname');
		$user['site_id'] = (int)$this->input->post('site_val');

		$this->load->model('user_m');
		if ( $this->user_m->update_user($user) ) {
			$this->session->sess_destroy(); 
			redirect('rvl_portal/home/');
		} else {
			redirect('rvl_portal/userpage/');
		}
	}

	/*
	 * Desc: 发送修改密码的连接
	 */
	public function recover_pw ()
	{
		// steps check email
		$this->load->driver('cache');		
		$this->load->model('user_m');
		$this->load->library('form_validation');
		$email =  $this->input->post('email');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ( $this->form_validation->run() && $this->user_m->check_email($email) > 0)
		{
			$this->load->library('email');
			$token = md5(uniqid('',true));
			$encrypt_datas = json_encode(array('token' => $token, 'email' =>$email));
		 	$this->cache->file->save($token, $encrypt_datas, 60*15);

		 	$send_url = base_url('login/password_reset_by_code').'?token='.$token;
			
		 	if ( file_exists(APPPATH.'config/email.php') )
		 	{
				$this->config->load('email', TRUE); 
				$econfig = $this->config->item('email', 'email');
				$this->email->initialize($econfig);
				list($from_email, $from_name) = [$econfig['smtp_user'], 'RVL Do Not Reply'];
		 	} else {
		 		list($from_email, $from_name) = ['do_not_reply@lenovoemc.com', 'RVL Do Not Reply'];
		 	}

			$this->email->from($from_email, $from_name);
			$this->email->to($email);
			$this->email->subject('RVL Portal Password Recovery');
			$this->email->message('You can click the url to change your password:'.$send_url);

			$this->email->send();
			
			$data['emailinfo'] = $this->email->print_debugger();
			$data['email'] = $email;
			
			$data['main_content'] = 'pw_email_sent';
			$this->load->view('includes/template', $data);
		} else {
			$data['email'] = $email;
			$data['main_content'] = 'pw_not_found';
			$this->load->view('includes/template', $data);
		}
	}

	/*
	 * Desc: 通过邮箱可以点击进入修改密码的操作页面
	 */
	public function password_reset_by_code()
	{
		$this->load->driver('cache');
		$outside_token = $this->input->get('token');
		$sysemail_cache = json_decode($this->cache->file->get($outside_token));
		$sys_email = isset($sysemail_cache->email) ? $sysemail_cache->email : null;
		$sys_email_token = isset($sysemail_cache->token) ? $sysemail_cache->token : null;

		if( !empty($sys_email) && !empty($sys_email_token) && ($sysemail_cache->token == $outside_token) )
		{
			$data['token'] = $sys_email_token;
			$data['main_content'] = 'password_reset_by_code';
			$this->load->view('includes/template', $data);
		} else {
			rvl_show_error('Illegal Operation For The Email Info Page.<br />'.anchor(site_url(), 'Click Here Return Home Page.'), null, 404);
		}
	}

	/*
	 * Desc: 通过token 获取系统缓存数据,然后修改密码[15 分钟后会自动超时清除]
	 */	
	public function change_password_by_code()
	{
		$this->load->driver('cache');
		$outside_token = $this->input->post('token');
		$password = $this->input->post('password');
		$con_password = $this->input->post('password_con');

		$sysemail_cache = json_decode($this->cache->file->get($outside_token));
		$sys_email = isset($sysemail_cache->email) ? $sysemail_cache->email : null;
		$sys_email_token = isset($sysemail_cache->token) ? $sysemail_cache->token : null;

		if( !empty($sys_email) && !empty($sys_email_token) && ($sysemail_cache->token == $outside_token) && ($con_password == $con_password) )
		{
			$params = array (
				'email' => $sys_email,
				'password' => do_hash($this->input->post('password') , 'sha256'),
			);

			$this->load->model('user_m');
			$query = $this->user_m->change_pw_by_email($params);
			if( !$query ) {
				$return_url = base_url('login/password_reset_by_code').'?token='.$outside_token;
				$datas = array( 'gourl' => $return_url );
				rvl_show_error('The User Password change error.<br />'.anchor(site_url(), 'Please Click Here For A New Operation.'), $datas , 404);
			}
			$this->cache->file->delete($outside_token);
			$this->index();
		} else {
			rvl_show_error('Illegal Operation For The Email Info Page.<br />'.anchor(site_url(), 'Click Here Return Home Page.'), null ,404);
		}
	}

	/*
	 * Desc: 修改密码的操作
	 */
	public function change_password()
	{
		$pw = array ('password' => do_hash($this->input->post('password'), 'sha256') );
		$this->load->model('user_m');
		$query = $this->user_m->change_pw($pw);
		$this->index();
	}
}