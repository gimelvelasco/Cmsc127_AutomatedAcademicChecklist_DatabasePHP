<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "Insert into reportofgrades values ('".$_POST["id"]."',".$_POST["year"].",".$_POST["sem"].",".$_POST["course_code"].",".$_POST["grade"].")";
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = "Yey";
	echo json_encode($ret);
?>