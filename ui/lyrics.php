<?php 
	require_once("../awsphp/sdk.class.php");
	
	$year = isset($_GET['year']) ? $_GET['year'] : "";
	
    if($year != "") 
    {
    	$sdb = new AmazonSDB();
    	$resp = $sdb->get_attributes("poplyrics",$year);
    	$attr = $resp->body->GetAttributesResult[0];
		if($attr) {
			echo $attr->to_json();
		}
    }
    else
    {
        echo "{}";
    }
?>