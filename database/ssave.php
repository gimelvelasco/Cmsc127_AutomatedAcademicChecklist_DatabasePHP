<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	// Insert na tayo
	$query = "UPDATE student SET permanent_address = '".$_POST["pead"]."', present_address = '".$_POST["prad"]."', citizenship = '".$_POST["citi"]."', contact_number = '".$_POST["cnum"]."', email = '".$_POST["email"]."' where student_number = '".$_POST["snum"]."'";
	mysqli_query($conn, $query);
	mysqli_close($conn);
	$ret["msg"] = "Yey";
	echo json_encode($ret);
?>