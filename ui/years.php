<?php 
    require_once("../awsphp/sdk.class.php");
	
    if($year != "") 
    {
    	$sdb = new AmazonSDB();
    	$resp = $sdb->domain_metadata("poplyrics");
    	
    	$attr = $resp->body;
    	echo $attr;
    }
    else
    {
        echo "{}";
    }
?>