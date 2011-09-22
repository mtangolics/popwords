<?php 
    require_once("../awsphp/sdk.class.php");
	
	$sdb = new AmazonSDB();
	$resp = $sdb->domain_metadata("poplyrics");
	
	$attr = $resp->body;
	echo $attr;

?>