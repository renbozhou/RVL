<?php
/*
 * Cody Hillyard 8/8/2013
 * Inventory searching and reporting 
 * Values from controler 
 * 
 * $all_sites => db sites list
 * $data => inventory report array
 * $lt => lead times for inventory
 * $mgr_sites => db sites list to which user has access
 * 
 */

$sites = array();
if( !empty($mgr_sites) ) {
	foreach ($mgr_sites as $s) // ($all_sites as $s)
	{
	  //echo $s['description'];
		$sites[$s['id']] = $s['description'];
	}
}

?>
	<link href="/css/inventory.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/js/functions.js"></script>
<div id="inventory_report">
<form name="inv_search" action="/index.php/rvl_portal/inventory_search" method="post">
<div>
<h1>Select location</h1><br> 
<label>Location</label>  <select id="location" name="location" >
	<option value="-1">All My Sites</option>
	<?php 
		//foreach ($all_sites as $site){
    $select = "";
    if( !empty($mgr_sites) ) {
	    foreach ($mgr_sites as $site){
	     if($site['id'] == $loc)
	        $select = " selected ";
	     else
	        $select = "";
				echo '<option value ="' .$site['id'] .'" '.$select.'>'.$site['code'] .'</option>'; 
		} 
    }

	?></select>
</div>
<div>
<h1>Select Week</h1><br>
</div>
<div>
<div class="week-picker"></div>
<br />
<br />
<label>Week :</label> <span id="startDate"></span> - <span id="endDate"></span>
<input type="hidden" name="filedate" value="" class="filedate" >                          	
</div><br>
<input type="submit" value="Search">
</form><hr>
<a href="/index.php/rvl_portal/inventory_csv">CSV</a>
</div>
<?php 
	if (is_array($data) && !empty($data)){ ?>
<div id="inventory_results">
<h3>Show results</h3>
<table id="inventory_table">
<tr>
<th>Part</th>
<th>Site</th>
<th>Lead Time</th>
<th>Qty</th>
<th>Part Location</th>
<th>History</th></tr>
<?php 
	foreach ($data as $d)
	{
		echo '<tr><td><p>' .$d['part_number'] 
		.'</p></td><td><p>' . $sites[$d['site']] 
		.'</p></td><td><p>'; 
		
		echo '<a href="/index.php/rvl_portal/lead_time/'.$d['part_number'] .'/' .$d['site'] .' ">'; 
			
	if (isset($lt[$d['part_number']][$d['site']])){
			echo $lt[$d['part_number']][$d['site']]; 
		}
		else {
			echo 'Lead Time Not Set'; 
		}
			echo '</a>'; 
		
		echo '</p></td><td><p>' .$d['quantity']
		.'</p></td><td><p>' .$d['location']
		.'</p></td><td><p>';
		echo '<a href="/index.php/rvl_portal/inventory_history/'.$d['part_number'] .'/' .$d['site'] .' ">';
		echo $d['part_number'] .'</a>';
		echo '</td></tr>'; 
	} }
?>
</table>
</div>

