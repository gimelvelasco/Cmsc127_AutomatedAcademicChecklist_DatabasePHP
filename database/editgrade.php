<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "update reportofgrades set course_grade = '".$_POST["grade"]."' where sem = ".$_POST["sem"]." and year = " .$_POST["year"]. " and student_number = '" .$_POST["sn"]."' and course_code = " .$_POST["course"];
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = "Yey";
	echo json_encode($ret);
?>