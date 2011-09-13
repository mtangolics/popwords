<?php 
	require_once("../awsphp/sdk.class.php");
	
	$year = $_GET['year'];
	
	$sdb = new AmazonSDB();
	$resp = $sdb->get_attributes("poplyrics",$year);
	
	$attr = $resp->body->GetAttributesResult[0];
	echo $attr->to_json();
?>