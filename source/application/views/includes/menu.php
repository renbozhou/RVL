<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*	Left banner edit 8-7-13	 
*		
*
*/?>
<div id="panel">
			
<?php
	
	$user = $this->session->userdata('username');
	$auth = $this->session->userdata('edit_rma'); 
	$is_logged_in = $this->session->userdata('is_logged_in');
	$admin = $this->session->userdata('use_admin');	
	$alias = $this->session->userdata('alias');
	$uid = $this->session->userdata('userid');
	$siteinfo =  $this->session->userdata('site');
	$userma = $this->session->userdata('use_rma');
	$inv = $this->session->userdata('permission');
	$lc = $this->session->userdata('use_lc');
	$sid = $this->session->userdata('site_id');

 	if ($userma > 0) { // set rma navigaion here 
 		echo '<br><h3>';
 		echo anchor('rvl_portal/edit', 'RMA', array('title' => 'RMA'));
 		echo '</h3><br>';
		echo '<img src="/images/addnew.png" id="start_rma">'; 
		echo anchor('rvl_portal/edit', 'Create New RMA', array('title' => 'new_rma'));
		echo '<br><br><img src="/images/search.png" id="update_rma"> '; 
		echo anchor('rvl_portal/myrmas', 'Search RMAs', array('title' => 'search_rma'));
		echo '<br>';  
		
		if ($sid == '0')
		{
		echo '<br>';
		echo anchor('rvl_portal/mgr_rma_search', 'Manager Search RMA', array('title' => 'nmanager_search'));
		echo '<br>'; 
		}
 	}	?>

	
	<hr>	
	<?php 
	if ($lc > 0){
		echo '<h3><br>'; 
		echo anchor('rvl_portal/learning', 'Learning Center', array('title' => 'Learning Center'));
		echo '</h3><br>'; 
	}?>
	<hr>
	<?php 
	if ($inv > 0){
		echo '<h3><br>';
		echo anchor('rvl_portal/upload', 'Inventory',  array('title' => 'Inventory'));
		echo '</h3><br>';
		//if ($sid == '0'){
		echo '<img src="/images/search.png" id="update_rma"> ';
		echo anchor('rvl_portal/inventory_report', 'Search Inventory', array('title' => 'inventory'));
		echo '<br>';
		//}
	}
	echo '<hr><br><h3>';
	echo anchor('rvl_portal/help', 'Help Section', array('title' => 'Help Section'));
	echo '</h3><br>';
	?>
</div>