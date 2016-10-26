<?php

//($history)=> all data from the part/site; 
$sites = array(); 
foreach ($all_sites as $s)
{
	$sites[$s['id']] = $s['description']; 
}
////$other => all inventory in sites for that week
 ?>

 <link href="/css/part.css" rel="stylesheet" type="text/css" />
		
 
<div id="part_history"><div>
<h1>History for <?php echo $sites[$history[0]['site']]; ?></h1>
<table id="history" >
<tr>
<th>Week</th>
<th>Part Number</th>
<th>Location</th>
<th>Quantity</th>
</tr>
<?php 
	foreach ($history as $d)
	{
		
		echo '<tr><td>'. $d['week'] 
		. '</td><td>' . $d['part_number'] 
		. '</td><td>' . $d['location']
		. '</td><td>' . $d['quantity'] .'</td></tr>'; 
	}
?>

</table>
<hr>
</div>
<div id="locations">
<h1>All Locations</h1>
<table>
<tr>
<th>Site</th>
<th>Part Number</th>
<th>Location</th>
<th>Quantity</th>
</tr>
<?php 
	foreach ($other as $d)
	{
		
		echo '<tr><td>'. $sites[$d['site']] 
		. '</td><td>' . $d['part_number'] 
		. '</td><td>' . $d['location']
		. '</td><td>' . $d['quantity'] .'</td></tr>'; 
	}
?>

</table>

</div></div>