<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "DELETE FROM takesCourses WHERE student_number = '".$_POST["student_number"]."' AND year = '".$_POST["year"]."' AND sem = '".$_POST["sem"]."' AND course_code = '".$_POST["course_code"]."' AND school = '".$_POST["school"]."'";
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = "Yey";
	echo json_encode($ret);
?>