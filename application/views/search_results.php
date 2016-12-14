<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*		 
*	$data = list of the results in an array	
*	results => array of data from last search
*	statement => statement
*
*/
$results = $data['results']; 
if (!isset($data['statement']))
{
	$data['statement'] = ' ' ; 
}
?>

<div id="search_results">
<script type="text/javascript" src="/js/report.js"></script>
<h3>Search Results: Count <?php echo count($results); ?></h3>

<form name="input" action="/index.php/rvl_portal/rma_csv/" method="post">
<?php 
	foreach ($data['statement'] as $key => $value)
		echo '<input type="hidden" name="' .$key .'" value="'. $value .'">'; 

?>
<input type="submit" value="CSV Download">
</form>

<div id="resultmenu">
<?php 
	echo form_open('rvl_portal/filtersearch');
	$info = array('id' => 'start_date', 'class' => 'dateinput', 'name' => 'start_date');
	echo form_label('From: ', 'start_date') ;
	echo form_input($info);
	
	$info = array('id' => 'end_date', 'class' => 'dateinput', 'name' => 'end_date'); 
	echo form_label('To: ', 'end_date') ; 
	echo form_input($info); 
	echo '<br>';
	$filters = array('-select a field-', 'Receipt Date','Shipped Date' ,'RMA Creation Date');
	echo form_label('Filter: ', 'filter');
	echo form_dropdown('filter', $filters);	
	echo form_submit('submit', 'Filter'); 
    echo form_submit('ftp_upload', 'FTP Upload Report'); 
	echo form_close(); 	
?>
</div>
<div id="csv">
	<div id="rma_search">
		<form name="input" action="/index.php/rvl_portal/search/" method="post">
		RMA Number or Serial Number: <input type="stext" name="stext">
		<input type="submit" value="Submit">
		</form>
	</div>
</div>
<div class="results" id="resultlist">
<?php
	foreach ($results as $r)
	{
		echo '<div class="result"><div class="rma_header">';
		echo anchor('rvl_portal/edit/' . $r['id'], 'RMA #: '. $r['customer_rma_num'], 'title="Edit RMA"' ); 
		if ($r['iomega_sn'] != '')
			echo "  Unit S/N: " .$r['iomega_sn'] .'<br> </div>'; 
		else 
			echo "  Raw S/N: " .$r['bare_hdd_sn'] .'<br> </div>';
		echo 'Company Name: ' . $r['company_name'] . '<br>'; 
		echo 'First Name: ' . $r['first_name'] .'<br>'; 
		echo 'Last Name: ' . $r['last_name'] . '<br> </div>' ; 
	}
?>
</div>

<h3>Searched on: </h3>
<?php
	if( isset($data['statement']) ) 
	{	
		foreach ($data['statement'] as $key => $value) 
		{
			if( $key== 'site' ) {
				echo $key.' : '.(int)$value.' <br />';
			} else {
				echo $key.' : '.substr($value, 0, 10).'...<br />';
			}
			
		}
	}
?>
</div>