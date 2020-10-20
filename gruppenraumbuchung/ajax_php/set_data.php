<?php
// Set data

require_once("../classes/required_classes.php");

$rr=new RoomReservation();

$action=$_GET['action'];
$data=$_GET['value'];

switch($action)
{
	case "book_room":
		$data=$_GET['value'];
		
		if(!preg_match("!^[0-9]{8}\,[0-9]{3,4}\,[0-9]{3,4}\,[0-9]{1,3}\,[^\ ,\'\’]+$!", $data))
		{
		    echo "error";
		    exit;
		}
		
		$data=explode(",", $data);

		$response=$rr->bookRoom($data);
		echo utf8_encode($response);
		break;	
		
	case "confirm":
		$data=$_GET['value'];
		
		if(!preg_match("!^[0-9]{8}\,[0-9]{3,4}\,[0-9]{1,3}$!", $data))
		{
		    echo "error";
		    exit;
		}
		
		$data=explode(",", $data);
		$response=$rr->confirm($data);
		echo utf8_encode($response);
		break;	
		
		
	case "delete":
		$data=$_GET['value'];
		
		if(!preg_match("!^[0-9]{8}\,[0-9]{3,4}\,[0-9]{1,3}$!", $data))
		{
		    echo "error";
		    exit;
		}
		
		$data=explode(",", $data);
		$response=$rr->delete($data);
		echo utf8_encode($response);
		break;	

}
?>

