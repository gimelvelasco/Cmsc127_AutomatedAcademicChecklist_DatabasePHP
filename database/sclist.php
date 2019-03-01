<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<hr>
	<a target="_blank" href="http://www.up.edu.ph/"><img class="upLogo" src="./Imgs/uplogo.png"></a>
	<h4 id="upH"><br>University of the Philippines</h4>
	<h6 id="upH">Honor And Excellence</h6>
	<hr>
	</head>
	
	<body>	
		<?php
		
			session_start();
			if(isset($_POST['logout'])){
				session_destroy();
				header("Location: ./login.php");
				exit;
			}
			if($_SESSION['but'] == "admin"){
				if(!isset($_POST['scl'])){
					header("Location: ./checklist.php");
					exit;
				}
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
				}
				else if($_SESSION['but'] == "inst"){
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


					echo "<hr>Select a student : <br><form action = \"sclist.php\" method = \"POST\"><select name='scl'>";
					$query7 = "select distinct student.* from student join advises where advises.instructor_number =  '".$_SESSION['idnum']."' and advises.student_number = student.student_number";
					$result7 = mysqli_query($conn,$query7);
					while($row7 = mysqli_fetch_assoc($result7)){
							echo "<option value='".$row7['student_number']."'>".$row7['student_number']." ".$row7['firstname']." ".$row7['middlename']." ".$row7['lastname']."</option>";
						
					}
					
					echo "<br><input  type=\"submit\" name=\"sub\" value=\"View\"/>";
					echo"</select></form><br>";

				}
				else if($_SESSION['but'] == "stud"){
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
				}

				echo "<h2>Checklist</h2><br>";

				if($_SESSION['but'] == "stud"){
					$_POST['scl'] = $_SESSION['idnum'];
				}
				if($_SESSION['but'] == "inst"){
					if(!isset($_POST['scl'])){
						$_POST['scl']="no student chosen";
					}
				}
				$queryp = "select program from student where student_number = '".$_POST['scl']."'" ;
				$resp = mysqli_query($conn,$queryp);
				
					$ps = mysqli_fetch_assoc($resp);
				
				
				
				echo "<h1>".$_POST['scl']."</h1>";
				$squery1 = "select * from takescourses natural join offeredcourses natural join allcourses where type =1 AND student_number='".$_POST['scl']."'" ;
				$sub1 = mysqli_query($conn,$squery1);
				$squery2 = "select * from takescourses natural join offeredcourses natural join allcourses where type =2 AND student_number='".$_POST['scl']."'" ;
				$sub2 = mysqli_query($conn,$squery2);
				$squery3 = "select * from takescourses natural join offeredcourses natural join allcourses where type =3 AND student_number='".$_POST['scl']."'" ;
				$sub3 = mysqli_query($conn,$squery3);
				$squery4 = "select * from takescourses natural join offeredcourses natural join allcourses where type =4 AND student_number='".$_POST['scl']."'" ;
				$sub4 = mysqli_query($conn,$squery4);
				for($i=1;$i<=4;$i++){
					echo "<table id='cDiv'>";
						if($i==1)
							echo"<tr><th>1st year</th></tr>";
						elseif($i==2)
							echo"<tr><th>2nd year</th></tr>";
						elseif($i==3)
							echo"<tr><th>3rd year</th></tr>";
						elseif($i==4)
							echo"<tr><th>4th year</th></tr>";
						echo "</table>
						<table id='cDiv'>
						<th> 1st Semester</th><th>2nd Semester</th></tr></table>";
					$query = "select * from checklist where presc_sem = '1st' and prec_yearlvl = ".$i." and program = '".$ps['program']."'";
					$result = mysqli_query($conn,$query);
					$query2 = "select * from checklist where presc_sem = '2nd' and prec_yearlvl = ".$i." and program = '".$ps['program']."'";
					$result2 = mysqli_query($conn,$query2);
					if(mysqli_num_rows($result) > 0){
						echo "<table id ='cDiv' border='1'>
						<tr><th>&nbsp &nbsp Course Number&nbsp &nbsp </th><th>&nbsp &nbsp &nbsp &nbsp Grade&nbsp &nbsp &nbsp &nbsp </th>
						<th>&nbsp &nbsp Course Number&nbsp &nbsp </th><th>&nbsp &nbsp &nbsp &nbsp Grade&nbsp &nbsp &nbsp &nbsp </th></tr>";
						while($row = mysqli_fetch_assoc($result)){
							if($row){$col = mysqli_fetch_assoc($result2);}
								if ($row['course_number']=="HUM GE"){
									if($sub03 = mysqli_fetch_assoc($sub3)){
									echo  "<tr><td>".$sub03['course_number']."</td>";
									$cg =$sub03['course_number'];
									}
									else{
									echo "<tr><td>".$row['course_number']."</td>";
									$cg =$row['course_number'];
									}
								}
								elseif($row['course_number']=="SOCSCI GE"){
									if($sub02 = mysqli_fetch_assoc($sub2)){
									echo  "<tr><td>".$sub02['course_number']."</td>";
									$cg =$sub02['course_number'];
									}
									else{
									echo "<tr><td>".$row['course_number']."</td>";
									$cg =$row['course_number'];
									}
								}
								elseif($row['course_number']=="NAT SCI GE"){
									if($sub01 = mysqli_fetch_assoc($sub1)){
									echo  "<tr><td>".$sub01['course_number']."</td>";
									$cg =$sub01['course_number'];
									}
									else{
									echo "<tr><td>".$row['course_number']."</td>";
									$cg =$row['course_number'];
									}
								}
								elseif($row['course_number']=="PE"){
									if($sub04 = mysqli_fetch_assoc($sub4)){
									echo  "<tr><td>".$sub04['course_number']."</td>";
									$cg =$sub04['course_number'];
									}
									else{
									echo "<tr><td>".$row['course_number']."</td>";
									$cg =$row['course_number'];
									}}
								else{
									echo "<tr><td>".$row['course_number']."</td>";
									$cg = $row['course_number'];
								}
				
							echo"<td>";
							$query3 = "select * from offeredcourses natural join allcourses natural join reportofgrades where course_number ='".$cg."' AND student_number='".$_POST['scl']."'" ;
							$result3 = mysqli_query($conn,$query3);
							if(mysqli_num_rows($result3)>0)
								while($row3 = mysqli_fetch_assoc($result3)){
									echo $row3['course_grade'];
									
									echo " ; ";
								}
					
							echo "</td>";
							if ($col['course_number']=="HUM GE"){
								if($sub03 = mysqli_fetch_assoc($sub3)){
								echo  "<td>".$sub03['course_number']."</td>";
								$cg =$sub03['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}
							}
							elseif($col['course_number']=="SOCSCI GE"){
								if($sub02 = mysqli_fetch_assoc($sub2)){
								echo  "<td>".$sub02['course_number']."</td>";
								$cg =$sub02['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}
							}
							elseif($col['course_number']=="NAT SCI GE"){
								if($sub01 = mysqli_fetch_assoc($sub1)){
								echo  "<td>".$sub01['course_number']."</td>";
								$cg =$sub01['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}
							}
							elseif($col['course_number']=="PE"){
								if($sub04 = mysqli_fetch_assoc($sub4)){
								echo  "<td>".$sub04['course_number']."</td>";
								$cg =$sub04['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}}
							else{
								echo "<td>".$col['course_number']."</td>";
								$cg = $col['course_number'];
							}
							echo "<td>";
							$query3 = "select * from offeredcourses natural join allcourses natural join reportofgrades where course_number ='".$cg."' AND student_number='2012-58922'" ;
							$result3 = mysqli_query($conn,$query3);
							while($row3 = mysqli_fetch_assoc($result3)){
								echo $row3['course_grade'];
								
								echo " ; ";
							} 
							echo "</td></tr>";
						}
						while($col = mysqli_fetch_assoc($result2)){
							echo "<tr><td></td><td>";
							
							if ($col['course_number']=="HUM GE"){
								if($sub03 = mysqli_fetch_assoc($sub3)){
								echo  "<td>".$sub03['course_number']."</td>";
								$cg =$sub03['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}
							}
							elseif($col['course_number']=="SOCSCI GE"){
								if($sub02 = mysqli_fetch_assoc($sub2)){
								echo  "<td>".$sub02['course_number']."</td>";
								$cg =$sub02['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}
							}
							elseif($col['course_number']=="NAT SCI GE"){
								if($sub01 = mysqli_fetch_assoc($sub1)){
								echo  "<td>".$sub01['course_number']."</td>";
								$cg =$sub01['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}
							}
							elseif($col['course_number']=="PE"){
								if($sub04 = mysqli_fetch_assoc($sub4)){
								echo  "<td>".$sub04['course_number']."</td>";
								$cg =$sub04['course_number'];
								}
								else{
								echo "<td>".$col['course_number']."</td>";
								$cg =$col['course_number'];
								}}
							else{
								echo "<td>".$col['course_number']."</td>";
								$cg = $col['course_number'];
							}
							
							echo "</td><td>";
							
							$query3 = "select * from offeredcourses natural join allcourses natural join reportofgrades where course_number ='".$cg."' AND student_number='2012-58922'" ;
							$result3 = mysqli_query($conn,$query3);
							while($row3 = mysqli_fetch_assoc($result3)){
								echo $row3['course_grade'];
								
								echo " ; ";
							} 
							
							echo"</td>";
						}
						echo "</table>";
					}
					else{ echo "<table border='1'>
						<tr><th>&nbsp &nbsp Course Number&nbsp &nbsp </th><th>&nbsp &nbsp &nbsp &nbsp Grade&nbsp &nbsp &nbsp &nbsp </th>
						<th>&nbsp &nbsp course Number&nbsp &nbsp </th><th>&nbsp &nbsp &nbsp &nbsp Grade&nbsp &nbsp &nbsp &nbsp </th><th>Edit</th><th>Delete</th></tr></table>";
						echo "No results<br>";
					
					
					}
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
			
		
			
			
			mysqli_close($conn);
			
		?>
		<hr><a href='index.php'>return to index</a><br>
		<form acton = "./index.php" method="post" />
		<input  type="submit" name="logout" value="Log Out"/>

		<hr>
		<div class="bottom">
		</div>
	</body>
</html>
<!--select * from takescourses natural join allcourses natural join reportOfGrades natural join ( select * from reportofgrades, OfferedCourses where reportofgrades.course_code =offeredcourses.course_code) as weh where course_number ='Cmsc 127' AND student_number='2012-58922'-->