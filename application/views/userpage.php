<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*		 
*		$user = information about the user from the database
*
*/

$admin = $this->session->userdata('use_admin');
$s = array();
foreach ($all_sites as $val) {
	if( isset($val['description']) && isset($val['id']) ) 
	{
		$s[$val['id']] = $val['description'];
	}
}
?>
<script type="text/javascript" src="/js/user.js"></script>
<link href="/css/user.css" rel="stylesheet" type="text/css" />
<div id="admindiv">

	<div id="accordion">
		<h3>User Info</h3>
		<div>
			<h1>Alias</h1>
			<?php
				echo form_open('rvl_portal/set_alias'); 
				$value = array(
					'name' => 'alias',
					'id' => 'alias',
					'value' => $user['alias']
				);
				echo form_input($value);
				echo form_submit('alais_btn', 'Change');
			?>
			<br><h1>Email :</h1> <?php echo $user['email'];?><br>	  
			<h1>User #</h1> <?php echo $user['tracking_id'];?><br>
			<?php echo anchor('rvl_portal/password_reset','Reset Password', array('title'=>'Password Reset')); ?>
		</div>
		<h3>Privileges</h3>
		<div id="pwdiv">
			<input type='checkbox' name='rma' value='1' <?php if($user['use_rma']==1){echo 'checked';}?> />RMA<br>
			<input type='checkbox' name='inv' value='1' <?php if($user['permission']==1){echo 'checked';}?> />Permission<br>
			<input type='checkbox' name='lc' value='1' <?php if($user['use_lc']==1){echo 'checked';}?>>Learning Center<br>
			<input type='checkbox' name='adm' value='1' <?php if($user['use_admin']==1){echo 'checked';}?>>Admin<br>
		</div>
		<h3>Site Information</h3>
		<div>
			<input id="site_val" name="site_val" type="hidden" value="<?php echo $user['site'];?>" />
			<h1>Site:</h1>
			<?php 
				echo isset($user['site_info']['code']) ? $user['site_info']['code'] : ''; 
			?>
			<br>
			<h1>Site Description: </h1>
			<div id="sitedes">
			<?php
				if ( !empty($mgr) ) {
					$my_sites = explode(',' , $mgr);
					if (is_array($my_sites) && !empty($my_sites)) {
						foreach($my_sites as $val) {
							echo ( isset($s[$val]) ? $s[$val] : '') . '<br>';
						}
					}
				} else {
					echo $user['site_info']['description'];
				}
			?>
			</div>
		</div>
	</div>
	</form>
</div>
<script> 
$(function (){ 
	$("#accordion").accordion({ icons: false}); 
});
</script>