<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*		 
*		
*
*/
	// get variables from session
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$admin = $this->session->userdata('use_admin');	
		$uname = $this->session->userdata('username');
		$alias = $this->session->userdata('alias');
		$uid = $this->session->userdata('userid'); 
		$siteinfo =  $this->session->userdata('site'); 
		$userma = $this->session->userdata('use_rma');
		$inv = $this->session->userdata('permission');
		$lc = $this->session->userdata('use_lc'); 

?>
<div id="user">
<?php
if (isset($is_logged_in) && $is_logged_in == true){
	echo anchor('rvl_portal/userpage/' .$uid, $alias. " - " .$siteinfo . ' - ' . ENVIRONMENT, 'title="userinfo page"');
} 
?>
</div>

<div id="header"></div>
	<div id="headmenubar">
	<div id="headmenu">
	<div id="head_navigation">
	<?php
	if (isset($is_logged_in) && $is_logged_in == true){?>
	<div id="navhome"><a href="/">Home</a></div>		
	<?php 
	if(isset($is_logged_in) && $admin != 0){
		echo '<div id="navfilem">'; 
		echo anchor('rvl_portal/adminpage/' .$uid, 'User Manager', 'title="Users"');
		echo '</div>'; 
        
        echo '<div id="navsitem">'; 
		echo anchor('rvl_portal/sitepage/' .$uid, 'Site Manager', 'title="Sites"');
		echo '</div>'; 
	}
	if ($userma > 0)
	{
		echo '<div id="myrmaheader">'; 
		echo anchor('/rvl_portal/edit', 'RMA');
		echo '</div>'; 
	}
	if ($inv > 0)
	{
		echo '<div id="inventory_upload">'; 
		echo anchor('/rvl_portal/upload', 'Inventory');
		echo '</div>';  
	}
	if ($lc > 0)
	{
		echo '<div id="learningcenter">';
		echo anchor('/rvl_portal/learning', 'Learning Center');
		echo '</div>';
	}
	echo '<div id="help">';
	echo anchor('/rvl_portal/help', 'Help');
	echo '</div>';
	
	 ?>		
	<div id="logout">
	<?php echo anchor('login/logout', 'Logout'); }?>
	</div></div></div></div>