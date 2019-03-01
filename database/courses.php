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
				$query = "select * from allcourses";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Course Number</th><th>Program</th>
					<th>Semester</th><th>Year level</th><th>School</th><th>Edit</th><th>Delete</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['course_number']."</td>
						<td>".$row['school']."</td>
						<td>".$row['course_title']."</td>
						<td>".$row['course_units']."</td>
						<td>".$row['type']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['course_number']."'\">Edit</button></td>
						<td><button onclick=\"location.href='./delc.php?username=".$row['course_number']."'\">Delete</button></td></tr>";
					}
					echo "</table>";
					echo "<button onclick=\"location.href='./addc.php'\">Add users</button>";
				}
				else{ echo "No results";
				}
				echo "<h4>ELECTIVES</h4>";
				$query = "select * from prog_elec";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Program</th><th>Course Number</th>
					<th>School</th><th>Edit</th><th>Delete</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['program']."</td>
						<td>".$row['course_number']."</td>
						<td>".$row['school']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['course_number']."'\">Edit</button></td>
						<td><button onclick=\"location.href='./delc.php?username=".$row['course_number']."'\">Delete</button></td></tr>";
					}
					echo "</table>";
					echo "<button onclick=\"location.href='./addc.php'\">Add users</button>";
				}
				else{ echo "No results";
				}
				echo "<h4>Required GEs</h4>";
				$query = "select * from req_ge";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Program</th><th>Course Number</th>
					<th>School</th><th>Edit</th><th>Delete</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['program']."</td>
						<td>".$row['course_number']."</td>
						<td>".$row['school']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['course_number']."'\">Edit</button></td>
						<td><button onclick=\"location.href='./delc.php?username=".$row['course_number']."'\">Delete</button></td></tr>";
					}
					echo "</table>";
					echo "<button onclick=\"location.href='./addc.php'\">Add users</button>";
				}
				else{ echo "No results";
				}
			}
			if($_SESSION['but'] == "inst"){
				$query = "select * from checklist";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Course Number</th><th>Program</th>
					<th>Semester</th><th>Year level</th><th>School</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['course_number']."</td>
						<td>".$row['program']."</td>
						<td>".$row['presc_sem']."</td>
						<td>".$row['prec_yearlvl']."</td>
						<td>".$row['school']."</td>";
					}
					echo "</table>";
					
				}
				else{ echo "No results";
				}
			}
			if($_SESSION['but'] == "stud"){
				$query = "select * from checklist where program = (select program from student where student_number = '".$_SESSION['idnum']."')";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Course Number</th><th>Program</th>
					<th>Semester</th><th>Year level</th><th>School</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['course_number']."</td>
						<td>".$row['program']."</td>
						<td>".$row['presc_sem']."</td>
						<td>".$row['prec_yearlvl']."</td>
						<td>".$row['school']."</td>";
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