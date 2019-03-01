<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
	</head>
	
	<body>	
	
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
			
			if(!$conn){
				header("Location: ./first.php");
				die(mysqli_error($conn));
			}			
			
			if(isset($_SESSION['idnum'])&&isset($_SESSION['pas'])&&isset($_SESSION['but'])){
					echo ("<h2>Welcome&#44;".$_SESSION['idnum'].("&#33;&#32;</h2>") );
			}
			else{
				header("Location: ./login.php");
			}
			
			if($_SESSION['but'] == "admin"){
				$query = "select test.year, test.sem,student_number,test.instructor_number,
						instructor.firstname, test.firstname as fname, instructor.middlename,
						test.middlename as mname,instructor.lastname, test.lastname as lname
						from (select * from student natural join advises) as test,
						instructor where test.instructor_number = instructor.instructor_number";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Student Number</th><th>Student Name</th>
					<th>Instructor Number</th><th>Instructor Name</th>
					<th>Year</th><th>Semester</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['student_number']."</td>
						<td>".$row['fname']." ".$row['mname']." ".$row['lname']."</td>
						<td>".$row['instructor_number']."</td>
						<td>".$row['firstname']." ".$row['middlename']." ".$row['lastname']."</td>
						<td>".$row['year']."</td>
						<td>".$row['sem']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['student_number']."'\">Edit</button></td>
						<td><button onclick=\"location.href='./delc.php?username=".$row['student_number']."'\">Delete</button></td></tr>";
					}
					echo "</table>";
					echo "<button onclick=\"location.href='./addc.php'\">Add users</button>";
				}
				else{ echo "No results";
				}
			}
			if($_SESSION['but'] == "inst"){
				$query = "select * from student";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Student Number</th><th>First Name</th>
					<th>Middle Name</th><th>Last Name</th><th>Sex</th><th>College</th>
					<th>Program</th><th>Permanent Address</th><th>Present Address</th><th>Citizenship</th>
					<th>Contact Number</th><th>E-mail</th><th>School</th><th>Password</th><th>year_lvl</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['student_number']."</td>
						<td>".$row['firstname']."</td>
						<td>".$row['middlename']."</td>
						<td>".$row['lastname']."</td>
						<td>".$row['sex']."</td>
						<td>".$row['college']."</td>
						<td>".$row['program']."</td>
						<td>".$row['permanent_address']."</td>
						<td>".$row['present_address']."</td>
						<td>".$row['citizenship']."</td>
						<td>".$row['contact_number']."</td>
						<td>".$row['email']."</td>
						<td>".$row['school']."</td>
						<td>".$row['password']."</td>
						<td>".$row['year_lvl']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['student_number']."'\">Edit</button></td>
						";
					}
					echo "</table>";
					echo "<button onclick=\"location.href='./addc.php'\">Add users</button>";
				}
				else{ echo "No results";
				}
			}
			if($_SESSION['but'] == "stud"){
				$query = "select * from student where student_number = '" .$_SESSION["idnum"]."'";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Student Number</th><th>First Name</th>
					<th>Middle Name</th><th>Last Name</th><th>Sex</th><th>College</th>
					<th>Program</th><th>Permanent Address</th><th>Present Address</th><th>Citizenship</th>
					<th>Contact Number</th><th>E-mail</th><th>School</th><th>Password</th><th>year_lvl</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['student_number']."</td>
						<td>".$row['firstname']."</td>
						<td>".$row['middlename']."</td>
						<td>".$row['lastname']."</td>
						<td>".$row['sex']."</td>
						<td>".$row['college']."</td>
						<td>".$row['program']."</td>
						<td>".$row['permanent_address']."</td>
						<td>".$row['present_address']."</td>
						<td>".$row['citizenship']."</td>
						<td>".$row['contact_number']."</td>
						<td>".$row['email']."</td>
						<td>".$row['school']."</td>
						<td>".$row['password']."</td>
						<td>".$row['year_lvl']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['student_number']."'\">Edit</button></td>";
						
					}
					echo "</table>";
					
				}
				else{ echo "No results";
				}
			}
			
			
			
			mysqli_close($conn);
			
		?>
		<a href='index.php'>return to index</a><br>;
		<form acton = "./index.php" method="post" >
		<input  type="submit" name="logout" value="Log Out">
	</body>
</html>