	<link href="/css/part.css" rel="stylesheet" type="text/css" />

<div id="inv_div">
Inventory Records Submitted:  
<?php
	echo count($inventory); ?>
<?php 
	if (count($error) == 0){ ?>
<form action="/index.php/rvl_portal/save_inv" method="post">
<input type="hidden" name="data" value="<?php echo htmlspecialchars(json_encode($inventory));?>">
<input type="submit" value="Submit">
</form>
<?php 
	echo '<hr> <table id="inv_val"><tr><th>number</th>'; 
	foreach ($title as $key=>$value)
	{
		echo '<th>' . $value .'</th>'; 	
	}
	echo '</tr>';
	foreach ($inventory as $key => $value)
	{
		echo '<tr><td>' . ($key + 1)
		.'</td><td>' .$value['quantity'] 
		.'</td><td>' .$value['part_number']
		.'</td><td>' .$value['hd_type']
		.'</td><td>' .$value['site']
		.'</td><td>' .$value['location']
		.'</td><td>' .$value['part_desc']
		.'</td><td>' .$value['oracle_desc'] . '</td></tr>'; 
	}
	echo '</table>'; 
}
else {
	echo ('<hr><div class="error">'); 
	foreach ($error as $e){
		echo $e['part']. ' -- ' .$e['error'] .'<br>'; 
	}
	echo '</div>'; 
}
?>

</div>