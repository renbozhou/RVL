<?php
/* Permissions page to edit users permissions
 * Set Locations for users
 * Add Admins
 * 
 */
if ($data['id'] ==  $this->session->userdata('userid'))
	echo "if you change the current user's info you must log out and back in to see changes"; 

?>

<script type="text/javascript" src="/js/permission.js"></script>
<link rel="stylesheet" href="/css/permission.css" type="text/css" media="screen"/>
<div id="edit_user">
	<div id="usr_info">
	<h1>Username: <?php echo $data['user']['email'];?></h1>
	</div>
	<hr/>
	<div id="permissions">
	<form name="input" action="/index.php/rvl_portal/addprivs" method="post">
	<div id="priv_div">
	<h3>Privileges</h3>
	<div id="priv_list">
		<input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>" />
		<input type="checkbox" name="rma" value="1" <?php if ($data['user']['use_rma'] == 1){ echo 'checked';}?>>RMA<br>
		<input type="checkbox" name="inv" value="1" <?php if ($data['user']['permission'] == 1){ echo 'checked';}?>>Inventory<br>
		<input type="checkbox" name="lc" value="1" <?php if ($data['user']['use_lc'] == 1){ echo 'checked';}?>>Learning Center<br>
		<input type="checkbox" name="adm" value="1" <?php if ($data['user']['use_admin'] == 1){ echo 'checked';}?>>Admin<br>
	</div></div>
	<div id="site_info_div">
		
 		<input type="hidden" id="site" name="site" value="<?php echo $user['site'];?>" />
		
		Site Code <select id="siteinfo" onchange="lookup(this.value)" >
			<?php 
				foreach ($data['sites'] as $site){
				echo '<option value ="' .$site['id'] .'">'.$site['code'] .'</option>'; 
				} ?>
		</select>
		<br/>
		Site Desc: <div id="sitedes"><?php echo $user['site_info']['description'];?>
		</div>
	</div>
	<div id="mgr_sites">

	<?php 
	$my_sites = explode(',',$mgr); 
	//print_r($my_sites); 
	foreach ($data['sites'] as $loc){
		 if ($loc['id'] != '0'){
			//  check the set values
			$checked = ''; 
			for ($i = 0; $i <= (count($my_sites)-1); $i++) {
  				if ($my_sites[$i] == $loc['id']){
  					$checked = 'checked'; 
  				}
	  					
		}
			
			echo '<input type="checkbox" name="'.$loc['id'] .'" value="1" '.$checked .'>' .$loc['description']; 
			echo '<br>';  
		}
	}
	
	
	?>
	</div>
		<div id="enter">
		<br/>
			<input type="submit" value="Submit Changes"/>
		</div>
	</form>
	</div>
	
</div>
