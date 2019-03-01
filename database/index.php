<!DOCTYPE html>
<html>
	<head>
	<title>Main Page</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<script></script>

	<hr>
	<a target="_blank" href="http://www.up.edu.ph/"><img class="upLogo" src="./Imgs/uplogo.png"></a>
	<h4 id="upH"><br>University of the Philippines</h4>
	<h6 id="upH">Honor And Excellence</h6>
	<hr>

	</head>

	<body>	

		<h2>Home Page</h2><br>
		
		<div>
		<?php
		error_reporting(0);
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
			
			if(isset($_POST['idnum'])&&isset($_POST['pas'])&&isset($_POST['but'])){
				$_SESSION['idnum'] = $_POST['idnum'];
				$_SESSION['pas'] = $_POST['pas'];
				$_SESSION['but'] = $_POST['but'];
			}
			
			if(isset($_SESSION['idnum'])&&isset($_SESSION['pas'])&&isset($_SESSION['but'])){
				
			$test=0;
			if($_SESSION['but'] == "stud"){
				$query = "select * from student";
				$result = mysqli_query($conn,$query);
				$exists = false;
				while($row = mysqli_fetch_assoc($result)){
					if(($row['student_number'] == $_SESSION['idnum'])
					&& ($row['password'] == $_SESSION['pas']))
					{
						$test=1;
						$exists = true;
					}
				}
			}
			elseif($_SESSION['but'] == "admin"){
				$query = "select * from admin";
				$result = mysqli_query($conn,$query);
				$exists = false;
				while($row = mysqli_fetch_assoc($result)){
					if(($row['id'] == $_SESSION['idnum'])
					&& ($row['password'] == $_SESSION['pas']))
					{
						$test=1;
						$exists = true;
					}
				}
			}
			elseif($_SESSION['but'] == "inst"){
				$query = "select * from instructor";
				$result = mysqli_query($conn,$query);
				$exists = false;
				
				while($row = mysqli_fetch_assoc($result)){
					if(($row['instructor_number'] == $_SESSION['idnum'])
					&& ($row['password'] == $_SESSION['pas']))
					{
						$test=1;
						$exists = true;
					}
				}
			}
			
			if($test==1){
			
				if($_SESSION['but'] == "admin"){
					echo "<div class='hTab'>
						<h3>Administrator Access</h3>
					</div>";

					echo "<div class='hTab_menu'>
					<div class='homeTab'><a href='index.php'><img src='./Imgs/home_icon.png' class='navLogo'></a></div>
					<div class='piTab'><a href='admininfo.php'><img src='./Imgs/info_icon.png' class='navLogo'></a></div>
					<div class='rogTab'><a href='repogr.php'><img src='./Imgs/rog_icon.png' class='navLogo'></a></div>
					<div class='cTab'><a href='checklist.php'><img src='./Imgs/clist_icon.png' class='navLogo'></a></div>
					<h5><br>Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Info&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grades&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checklist&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
					</div>";

					$query = "SELECT firstname, middlename, lastname, school,student.student_number,test.year,sem,course_number FROM (SELECT student_number,takescourses.year,takescourses.sem,course_number FROM takescourses, offeredcourses where offeredcourses.course_code=takescourses.course_code) as test natural join student";
					$result = mysqli_query($conn, $query);
					$ctr = 0;
					if(mysqli_num_rows($result) > 0){
						// DISPLAY TABLE
						echo "<table id=\"dtbl\"><tr><th>Student No.</th><th> Name </th><th>Year</th><th>Semester</th><th>Course No.</th><th>School</th></tr>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr id=\"row".$ctr."\">
							<td>".$row["student_number"]."</td>
							<td>".$row["firstname"]." ".$row["middlename"]." ".$row["lastname"]."</td>
							<td>".$row["year"]."</td>
							<td>".$row["sem"]."</td>
							<td>".$row["course_number"]."</td>
							<td>".$row["school"]."</td>
							</tr>";
							$ctr++;
						}
						
						echo "</table>";
						echo "<table id=\"dtbl2\"></table>";
						mysqli_close($conn);
					}
					else echo "";
					
					
					
					
				}
				if($_SESSION['but'] == "inst"){
					echo "<div class='hTab'>
						<h3>Instructor Advising Overview</h3>
					</div>";

					echo "<div class='hTab_menu'>
					<div class='homeTab'><a href='index.php'><img src='./Imgs/home_icon.png' class='navLogo'></a></div>
					<div class='piTab'><a href='teacher.php'><img src='./Imgs/info_icon.png' class='navLogo'></a></div>
					<div class='rogTab'><a href='repogr.php'><img src='./Imgs/rog_icon.png' class='navLogo'></a></div>
					<div class='cTab'><a href='checklist.php'><img src='./Imgs/clist_icon.png' class='navLogo'></a></div>
					<h5><br>Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Info&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grades&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checklist&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
					</div>";

					$query = "SELECT student.student_number,year,sem,course_number,course_units FROM takesCourses JOIN allCourses ON takesCourses.course_code = allCourses.course_code";
					$result = mysqli_query($conn, $query);
					$ctr = 0;
					if(mysqli_num_rows($result) > 0){
						// DISPLAY TABLE
						echo "<table id=\"dtbl\"><tr><th>Student No.</th><th>Year</th><th>Semester</th><th>Course No.</th><th>Units</th></tr>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr id=\"row".$ctr."\">
							<td>".$row["student_number"]."</td>
							<td>".$row["year"]."</td>
							<td>".$row["sem"]."</td>
							<td>".$row["course_number"]."</td>
							<td>".$row["course_units"]."</td>
							</tr>";
							$ctr++;
						}
						echo "</table>";
						echo "<table id=\"dtbl2\"></table>";
						mysqli_close($conn);
					}
					else echo "";
					
					echo "<div class='button'><a href='students.php'>View Students being Advised</a><br></div>";
					echo "<div class='button'><a href='checklist.php'>View Student Checklist</a><br></div>";
					
				}
				if($_SESSION['but'] == "stud"){
					echo "<div class='hTab'>
						<h3>Overall Student Performance</h3>
					</div>";

					echo "<div class='hTab_menu'>
					<div class='homeTab'><a href='index.php'><img src='./Imgs/home_icon.png' class='navLogo'></a></div>
					<div class='piTab'><a href='students.php'><img src='./Imgs/info_icon.png' class='navLogo'></a></div>
					<div class='rogTab'><a href='repogr.php'><img src='./Imgs/rog_icon.png' class='navLogo'></a></div>
					<div class='cTab'><a href='checklist.php'><img src='./Imgs/clist_icon.png' class='navLogo'></a></div>
					<h5><br>Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Info&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grades&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checklist&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
					</div>";
					
					$query = "SELECT course_code,allCourses.course_number,course_title, course_units FROM allCourses natural join offeredCourses natural join takesCourses where student_number = '".$_SESSION['idnum']."';";
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
			}
			else{
				echo ("<form acton = './fail.php' method='post' >");
				echo ("<input type='hidden' name='err' value=0></form>");
				session_destroy();
				header("Location: ./fail.php");
				exit;
			}
			}else{
				echo ("<form acton = './fail.php' method='post' >");
				echo ("<input type='hidden' name='err' value=0></form>");
				header("Location: ./login.php");
				exit;
			}
			
			mysqli_close($conn);
			
		?>
		
		</div>
		
		<hr>
		<form acton = "./index.php" method="post" >
		<input  type="submit" name="logout" value="Log Out">

	<hr>
	<div class="bottom">
	</div>
	</body>
</html>