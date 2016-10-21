<div id="leadtime_div">
<h1>Set Lead Time</h1>
<form name="leadtime" action="/index.php/rvl_portal/save_lt" method="post">
<table>
<tr>
<th>Part Number</th>
<th>Site Number</th>
<th>Enter Lead Time</th>
</tr>
<tr>
<td><?php echo $part; ?></td>
<td><?php echo $site; ?></td>
<td>
<input type="hidden" name="part" value="<?php echo $part; ?>">
<input type="hidden" name="site" value="<?php echo $site; ?>">
<input type="text" name="leadtime">
</td>
</tr>
</table>
<input type="submit" value="Submit">
</form>
<?php


?>

  </div>