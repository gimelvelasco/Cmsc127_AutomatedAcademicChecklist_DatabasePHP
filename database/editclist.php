<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "UPDATE checklist SET  course_number ='"
	.$_POST["course_number"]."', program = '".$_POST["program"]
	."', presc_sem = '".$_POST["sem"]."', prec_yearlvl = ".$_POST["year"].", school = '".$_POST["school"]."' WHERE course_number = '".$_POST["orig"]."' and prec_yearlvl = ".$_POST["origyear"]." and presc_sem = '".$_POST["origsem"]."'";
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = "Yey";
	echo json_encode($ret);
?>