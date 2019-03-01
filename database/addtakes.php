<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "INSERT INTO takesCourses VALUES (
	'".$_POST["student_number"]."',
	".$_POST["year"].",
	".$_POST["sem"].",
	".$_POST["course_code"].",
	'".$_POST["school"]."'
	)";
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = "Success Kunanamet";
	echo json_encode($ret);
?>


