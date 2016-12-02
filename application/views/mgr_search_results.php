<script type="text/javascript" src="/js/mgr_search.js"></script>
<div id="mgr_search">
<div id="mgr_form">
<h1>Select Location(s)</h1><hr>
<?php

echo form_open('rvl_portal/mgr_rma_search'); 

$ns = explode(',',$my_sites); 

foreach ($ns as $val)
{
	if ($val != '0'){
		echo '<input type="checkbox" name="'.$val.'" value="1" checked>' .$site[$val]['desc'];
	 	echo '<br>'; 
	}
} 
echo '<hr>'; 
echo 'RMA Number or Serial Number: <input type="text" name="rma"><br>'; 

	$in = array('id' => 'start_date', 'class' => 'dateinput', 'name' => 'start_date');
	echo form_label('From: ', 'start_date') ;
	echo form_input($in);

	$in = array('id' => 'end_date', 'class' => 'dateinput', 'name' => 'end_date');
	echo form_label('To: ', 'end_date') ;
	echo form_input($in);
	echo '<br>';
	
	$filters = array('-select a field-', 'Receipt Date','Shipped Date' ,'RMA Creation Date');
	echo form_label('Filter: ', 'filter');
	echo form_dropdown('filter', $filters);

echo form_submit('mgr_csv', "Create CSV"); 
echo form_submit('mysubmit', 'Search');
echo form_close(); 
?>
</div>
<div id="mgr_res">
<h1>Results from last search:</h1> <hr>
<h3>Sites :</h3><?php
$m_s = explode(',',$searched_sites); 
foreach ($m_s as $i) {
	if (!empty($i)) {
		echo $site[$i]['desc'] .'<br>';
	}
}?>
<hr>
<h3>Count : <?php echo count($list['results']); ?></h3>
<?php 
$on = 'Creation Date'; 
if (!empty ($dateinfo)){ 
		if ($dateinfo['by'] == 1)
			$on = 'Receipt Date'; 	
		if ($dateinfo['by'] == 1)
			$on = 'Shipping Date'; 
		
		echo '<h3> Searching on ' .$on . '</h3>';  
	?>
<h3>Dates : <?php echo $dateinfo['start'];  ?> to <?php echo $dateinfo['end']; ?></h3><?php }?>
</div><hr>
<div class="results" id="resultlist">
<?php
foreach ($list['results'] as $r)
{
	echo '<div class="result"><div class="rma_header">';
	echo anchor('rvl_portal/edit/' . $r['id'], 'RMA #: '. $r['customer_rma_num'], 'title="Edit RMA"' );
	if ($r['iomega_sn'] != ''){
		echo "  Unit S/N: " . (!empty($r['iomega_sn']) ? $r['iomega_sn'] : '') .'<br> </div>';
	} else {
		echo "  Raw S/N: " . (!empty($r['bare_hdd_sn']) ? $r['bare_hdd_sn'] : '') .'<br> </div>';
	}
	if ( isset( $site[$r['site_id']]['desc'] ) ) {
		echo 'Site: ' . $site[$r['site_id']]['desc'] . '<br>';
	} else {
		echo 'Site: <br>';
	}
	echo 'Company Name: ' . (!empty($r['company_name']) ? $r['company_name'] : ''). '<br>';
	echo 'First Name: ' . (!empty($r['first_name']) ? $r['first_name'] : '') .'<br>';
	echo 'Last Name: ' . (!empty($r['last_name']) ? $r['last_name'] : '') . '<br> </div>' ;
}

//print_r($data); 
?>
</div>

</div>
