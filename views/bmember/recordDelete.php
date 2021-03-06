<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}
if($_POST){
    include_once "../../config/database.php";
    include_once "../../classes/record.php";
    include_once "../../classes/history.php";
    include_once "../../classes/person.php";

    $database = new Database();
    $db = $database->getConnection();
 	
 	$history = new History($db);
	$record = new Record($db);
	$person = new Person($db);

	$record->rid = $_POST['rid'];

	//history
	$person->rid = $_POST['rid'];
	$person->readspecPersonRecord($person->rid);

	date_default_timezone_set("Asia/Manila");
	$history->daterecorded = date("Y-m-d h:i:s");
	$avar = "Archived record of";
	$into = "from records.";
	$history->action = $avar.' '.$person->firstname.' '.$person->lastname.' '.$into;
	$history->createPersonHis();


 
	$record->archiveRecord();
}
?>