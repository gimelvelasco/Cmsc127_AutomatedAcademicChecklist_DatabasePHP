<!DOCTYPE html>
<html>
<head>
<title>Main Page</title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
</head>
<body>

<form action="./main.php" method="post">
	<input type="submit" name="logout" value="Log Out" id="logoutbut">
</form>

<hr>

<h2>Offered Courses</h2><br>
<div id="center">
<?php
	session_start();
	if(isset($_POST['logout'])){
		session_destroy();
		header("Location: ./login.php");
		exit;
	}
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	$exists = true;

	if($_SESSION['utype'] == "advsr"){
		$query = "select * from instructor";
		$result = mysqli_query($conn,$query);
		$exists = false;
		while($row = mysqli_fetch_assoc($result)){
			if(($row['instructor_number'] == $_SESSION['username']) && ($row['password'] == $_SESSION['password'])){
				echo "Current User Account: ".$_SESSION['username'];
				$exists = true;
				break;
			}
		}
		
		$query = "SELECT * FROM allCourses WHERE course_code IN (SELECT course_code FROM offeredCourses)";
		$result = mysqli_query($conn, $query);
		$ctr = 0;
		if(mysqli_num_rows($result) > 0){
			// DISPLAY TABLE
			echo "<table id=\"dtbl\"><tr><th>Course Code</th>	<th>Course Number</th><th>Course Title</th><th>Units</th></tr>";
			while($row = mysqli_fetch_assoc($result)){
				echo "<tr id=\"row".$ctr."\"><td>".$row["course_code"]
				."</td><td>".$row["course_number"]
				."</td><td>".$row["course_title"]."</td>
				<td>".$row["course_units"]."</td>
				</tr>";
				$ctr++;
			}
			echo "</table>";
			echo "<table id=\"dtbl2\"></table>";
			mysqli_close($conn);
		}
		else echo "No Pre-enlisted courses.<br>";
	}

	if($_SESSION['utype'] == "stdnt"){
		$query = "select * from student";
		$result = mysqli_query($conn,$query);
		$exists = false;
		while($row = mysqli_fetch_assoc($result)){
			if(($row['student_number'] == $_SESSION['username']) && ($row['password'] == $_SESSION['password'])){
				echo "Current User Account: ".$_SESSION['username'];
				$exists = true;
				break;
			}
		}
		
		$query = "SELECT * FROM allCourses WHERE course_code IN (SELECT course_code FROM offeredCourses)";
		$result = mysqli_query($conn, $query);
		$ctr = 0;
		if(mysqli_num_rows($result) > 0){
			// DISPLAY TABLE
			echo "<table id=\"dtbl\"><tr><th>Course Code</th>	<th>Course Number</th><th>Course Title</th><th>Units</th></tr>";
			while($row = mysqli_fetch_assoc($result)){
				echo "<tr id=\"row".$ctr."\"><td>".$row["course_code"]
				."</td><td>".$row["course_number"]
				."</td><td>".$row["course_title"]."</td>
				<td>".$row["course_units"]."</td>
				</tr>";
				$ctr++;
			}
			echo "</table>";
			echo "<table id=\"dtbl2\"></table>";
			mysqli_close($conn);
		}
		else echo "No Pre-enlisted courses.<br>";
	}
	
	if($exists == false){
		session_destroy();
		header("Location: ./login.php");
		exit;
	}
?>
</div>
<input id="abut" type="button" value="Add Course" onclick="addNewEntry()"/>
<input id="dbut" type="button" value="Delete Course" onclick="deleteEntry()"/> | 
<a target="_blank" href="./viewOffered.php">
	<input id="obut" type="button" value="View Offered Courses"/>
</a>
<hr>
</body>
</html>