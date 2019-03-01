<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "DELETE from checklist WHERE course_number = '".$_POST["orig"]."' and prec_yearlvl = ".$_POST["origyear"]." and presc_sem = '".$_POST["origsem"]."' and program = '".$_POST['program']."'";
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = $query;
	echo json_encode($ret);
?>