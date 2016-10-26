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
	function index()
	{
		@session_start();
		$this->session->sess_destroy();
		$data['main_content'] = 'loginform';
		$this->load->view('includes/template', $data);
	}

	/*
	 * Desc: 检查用户是否能登录,如果成功则保存用户信息到session中
	 */
	function checkcred()
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
	function forgot()
	{
		$data['main_content'] = 'forgot_password';
		$this->load->view('includes/template', $data);
		
	}

	/*
	 * Desc: 修改密码的动作连接
	 */
	function recover_pw ()
	{
		// steps check email
		$this->load->model('user_m');
		$email =  $this->input->post('email');
		if ($this->user_m->check_email($email) > 0)
		{
			// get password
			$pw = $this->user_m->get_pw_from_email($email);
			
			// email password
			$this->load->library('email');

			$this->email->from('do_not_reply@lenovoemc.com', 'RVL Do Not Reply');
			$this->email->to($email);

			$this->email->subject('RVL Portal Password Recovery');
			$this->email->message('You have requested your password to be sent to you.  Your password is : ' .$pw);
			
			$this->email->send();
			
			$data['emailinfo'] = $this->email->print_debugger();
			$data['email'] = $email;
			$data['pw'] = $pw;
			
			$data['main_content'] = 'pw_email_sent';
			$this->load->view('includes/template', $data);
		} else {
			$data['email'] = $email;
			$data['main_content'] = 'pw_not_found';
			$this->load->view('includes/template', $data);
		}
	}

	/*
	 * Desc: 注册页面
	 */
	function signup ()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $data);  
	}

	/*
	 * Desc: 用户登录退出操作
	 */	
	function logout()
	{
		$this->session->sess_destroy();
		$this->index(); 
	}

	/*
	 * Desc: 用户注册操作
	 */
	function create_member()
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

	function update_user()
	{
		$tid = $this->input->post('tracking_id'); 
		if ($tid != 0){
		$user = array(
				'alias' => $this->input->post('uname'),	
				'type' => $tid, 
				'site_id' => $this->input->post('site_val')); 
		}
		else{
			$user = array(
					'alias' => $this->input->post('uname'),			
					'site_id' => $this->input->post('site_val'));
			
		} 
			
		$this->load->model('user_m');
		if ($this->user_m->update_user($user))
		{
			$this->session->sess_destroy(); 
			redirect('rvl_portal/home/');
			die();
		}else 
		{
			
			redirect('rvl_portal/userpage/');
			die(); 
		}
	}
	
	function change_password()
	{
		$pw = array ('password' => $this->input->post('password'));
		$this->load->model('user_m');
		$query = $this->user_m->change_pw($pw);
		$this->index();
	}

}