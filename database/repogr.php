<!DOCTYPE html>
<html>
	<head>
		<title>Student Report Of Grades</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
		<script>

	function saveToDB(rowname, course, year,sem,sn){
		rowID = "#"+rowname+" td";
		data = {}
		data["year"]=year;
		data["sem"] = sem;
		data["sn"]= sn;
		data["course"] = course;
		data["grade"] = $(rowID).eq(2).find("input:eq(0)").val();

		
		$.post(
			"./editgrade.php",
			data,
			function(ret){
				window.location.replace("./repogr.php");
			}, "json"
		);
	}
	function removeEntry(rowname, course, year,sem,sn){
	rowID = "#"+rowname+" td";
		data = {}
		data["year"]=year;
		data["sem"] = sem;
		data["sn"]= sn;
		data["course"] = course;
		$.post(
			"./delgrade.php",
			data,
			function(ret){
				window.location.replace("./repogr.php");
			}, "json"
		);
	}
	function editEntry(rowname, course, year,sem,sn){
		
		rowID = "#"+rowname+" td";
		i=0;
		val2=$(rowID).eq(2).text();
		$(rowID).eq(2).html("<input type='text' value = '"+val2+"'/>");
		$(rowID).eq(4).html("<input type='button' value='Save' onclick=\"saveToDB('"+rowname+"','"+course+"','"+year+"','"+sem+"','"+sn+"')\" />");
	}
	function insertNewEntry(sid){
		rowID2 = "#program";
		
		newarray = {};
		
		newarray["course_code"] =  $("#new1").val();
		newarray["sem"] =  $("#new2").val();
		newarray["year"] =  $("#new3").val();
		newarray["grade"] =  $("#new4").val();
		newarray["id"] =  sid;
		
		
		alert(newarray["sem"]);

		$.post(
			"./insertgrade.php",
			newarray,
			function(ret){
				window.location.replace("./repogr.php");
			}, "json"
		);
		window.location.replace("./repogr.php");
	}
	function insertEntry(sid){
		newrow = "<tr><th>Course_code:</th>><th>Semester:</th><th>Year:</th><th>Grade:</th><th>save:</th></tr><tr><td><input id=\"new1\" type=\"text\" name =\"course_number\" /></td><td><input id=\"new2\" type=\"text\" name =\"Semester\" /></td><td><input id=\"new3\" type=\"text\" name =\"Year\" /></td><td><input id=\"new4\" type=\"text\" name =\"Semester\" /><td><input type=\"button\" value=\"Insert\" onclick=\"insertNewEntry('"+sid+"')\"/></td></tr>";
		$("#ins").append(newrow);
		$("#abut").hide();
		//$("#dbut").hide();
	}
	
	</script>
		
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
					echo ("<h2>Welcome&#44;&nbsp;".$_SESSION['idnum'].("&#33;&#32;</h2>") );
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
				<div class='piTab'><a href='index.php'><img src='./Imgs/info_icon.png' class='navLogo'></a></div>
				<div class='rogTab'><a href='repogr.php'><img src='./Imgs/rog_icon.png' class='navLogo'></a></div>
				<div class='cTab'><a href='checklist.php'><img src='./Imgs/clist_icon.png' class='navLogo'></a></div>
				<h5><br>Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Info&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grades&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checklist&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
				</div>";
			
				echo "<h2>Report of Grades</h2><br>";
					
				if(!isset($_POST['student_id'])){
					$_POST['student_id']="LIST";
					if(isset($_SESSION['student_id']))
						$_POST['student_id']=$_SESSION['student_id'];
				}
				else{
					$_SESSION['student_id']=$_POST['student_id'];
				}
				echo "Select a Student : <br><form action = \"repogr.php\" method = \"POST\"><select name='student_id'>";
				$query7 = "select * from student";
				$result7 = mysqli_query($conn,$query7);
				while($row7 = mysqli_fetch_assoc($result7)){
						echo "<option value='".$row7['student_number']."'>".$row7['student_number']." ".$row7['firstname']." ".$row7['middlename']." ".$row7['lastname']."</option>";
					
				}			
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"VIEW GRADES\"/>";
				echo"</select></form><br>";
				
				echo "Select Semester : <br><form action = \"repogr.php\" method = \"POST\"><select name = 'semyear'>";
				echo "<option value='all'> ALL </option>";
				$query7 = "select  distinct sem ,year from reportofgrades where student_number='".$_POST['student_id']."'";
				$result7 = mysqli_query($conn,$query7);
				while($row7 = mysqli_fetch_assoc($result7)){
						echo "<option value=' sem = ".$row7['sem']." and year =".$row7['year']."'> sem".$row7['sem']." A.Y.".$row7['year']."-".($row7['year']+1)."</option>";
					
				}			
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"Select\"/>";
				echo"</select></form><br>";

				
				$query = "select * from student where student_number='".$_POST['student_id']."'";
				if(!isset($_POST['semyear']))
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."'";
				elseif($_POST['semyear']=="all"){
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."' ";
				}
				else{
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."' and ". $_POST['semyear'];
					
					echo "<h2>".$_POST['semyear']."</h2>";
				}
				$result2 = mysqli_query($conn,$query2);
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "
						<div id='rogDiv'>
						<table class='rogTable'>
							<tr>
								<th>Student No.</th>
								<th>Student Name</th> 
								<th>College</th>
								<th>Year</th>
								<th>Program</th>
								<th>University</th>
							</tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "

						<tr><td>".$row['student_number']."</td>
						<td>".$row['lastname'].", ".$row['firstname']." ".$row['middlename']."</td>
						<td>".$row['college']."</td>
						<td>".$row['year_lvl']."</td>
						<td>".$row['program']."</td>
						<td>".$row['school']."</td>";
					}
					echo "</table>
					<table class='rogTable'>
					<tr>
						<th>Course No.</th>
						<th>Course Title</th> 
						<th>Grade</th>
						<th>Unit</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>";	
					$counter=0;
					while($row2 = mysqli_fetch_assoc($result2)){
						echo "<tr id='row".$counter."'><td>".$row2['course_number']."</td>
						<td>".$row2['course_title']."</td>
						<td>".$row2['course_grade']."</td>
						<td>".$row2['course_units']."</td>
						
						<td><input type=\"button\" value=\"Edit\" onclick=\"editEntry('row".$counter."', '".$row2['course_code']."', '".$row2['year']."', '".$row2['sem']."', '".$row2['student_number']."' )\" /></td>
						<td><input type=\"button\" value=\"Delete\" onclick=\"removeEntry('row".$counter."', '".$row2['course_code']."', '".$row2['year']."', '".$row2['sem']."', '".$row2['student_number']."' )\" /></td></tr>";
						$counter++;
					}					
					echo "</table> <table id =\"ins\" class='rogTable'></table></div>";
					echo "<input type=\"button\" id ='abut' value=\"Insert Entry\" onclick=\"insertEntry('".$_POST['student_id']."')\"/>";
				}
				else{ echo "No results";
				}
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

				echo "<h2>Report of Grades</h2><br>";

				if(!isset($_POST['student_id'])){
					$_POST['student_id']="LIST";
					if(isset($_SESSION['student_id']))
						$_POST['student_id']=$_SESSION['student_id'];
				}
				else{
					$_SESSION['student_id']=$_POST['student_id'];
				}
				
				echo "Select a Student : <br><form action = \"repogr.php\" method = \"POST\"><select name='student_id'>";
				$query7 = "select distinct student.* from student join advises where advises.instructor_number =  '".$_SESSION['idnum']."' and advises.student_number = student.student_number";
				$result7 = mysqli_query($conn,$query7);
				while($row7 = mysqli_fetch_assoc($result7)){
						echo "<option value='".$row7['student_number']."'>".$row7['student_number']." ".$row7['firstname']." ".$row7['middlename']." ".$row7['lastname']."</option>";
					
				}			
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"View\"/>";
				echo"</select></form><br>";
				
				echo "Select Semester : <br><form action = \"repogr.php\" method = \"POST\"><select name = 'semyear'>";
				echo "<option value='all'> ALL </option>";
				$query7 = "select  distinct sem ,year from reportofgrades where student_number='".$_POST['student_id']."'";
				$result7 = mysqli_query($conn,$query7);
				while($row7 = mysqli_fetch_assoc($result7)){
						echo "<option value='sem = ".$row7['sem']." and year =".$row7['year']."'> sem".$row7['sem']." A.Y.".$row7['year']."-".($row7['year']+1)."</option>";
					
				}			
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"Select\"/>";
				echo"</select></form><br>";

				$query = "select * from student where student_number='".$_POST['student_id']."'";
				if(!isset($_POST['semyear']))
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."'";
				elseif($_POST['semyear']=="all"){
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."' ";
				}
				else{
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."' and ". $_POST['semyear'];
					
					echo "<h2> ".$_POST['semyear']."</h2>";
				}
				$result2 = mysqli_query($conn,$query2);
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "
						<div id='rogDiv'>
						<table class='rogTable'>
							<tr>
								<th>Student No.</th>
								<th>Student Name</th> 
								<th>College</th>
								<th>Year</th>
								<th>Program</th>
								<th>University</th>
							</tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "

						<tr><td>".$row['student_number']."</td>
						<td>".$row['lastname'].", ".$row['firstname']." ".$row['middlename']."</td>
						<td>".$row['college']."</td>
						<td>".$row['year_lvl']."</td>
						<td>".$row['program']."</td>
						<td>".$row['school']."</td>";
					}
					echo "</table>
					<table class='rogTable'>
					<tr>
						<th>Course No.</th>
						<th>Course Title</th> 
						<th>Grade</th>
						<th>Unit</th>
					</tr>";	
					while($row2 = mysqli_fetch_assoc($result2)){
						echo "<tr><td>".$row2['course_number']."</td>
						<td>".$row2['course_title']."</td>
						<td>".$row2['course_grade']."</td>
						<td>".$row2['course_units']."</td>";
					}					
					echo "</table></div>";
				}
				else{ echo "No results";
				}
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

				echo "<h2>Report of Grades</h2><br>";

				if(!isset($_POST['student_id'])){
					$_POST['student_id']=$_SESSION['idnum'];
				}
				
				echo "Select Semester : <br><form action = \"repogr.php\" method = \"POST\"><select name = 'semyear'>";
				echo "<option value='all'> ALL </option>";
				$query7 = "select  distinct sem ,year from reportofgrades where student_number='".$_POST['student_id']."'";
				$result7 = mysqli_query($conn,$query7);
				while($row7 = mysqli_fetch_assoc($result7)){
						echo "<option value=' sem = ".$row7['sem']." and year =".$row7['year']."'> sem".$row7['sem']." A.Y.".$row7['year']."-".($row7['year']+1)."</option>";
					
				}			
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"Select\"/>";
				echo"</select></form><br>";

				$query = "select * from student where student_number='".$_POST['student_id']."'";
				if(!isset($_POST['semyear']))
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."'";
				elseif($_POST['semyear']=="all"){
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."' ";
				}
				else{
					$query2 = "select * from reportOfgrades natural join offeredcourses natural join allcourses where student_number='".$_POST['student_id']."' and ". $_POST['semyear'];
					
					echo "<h2> ".$_POST['semyear']."</h2>";
				}
				
				$result2 = mysqli_query($conn,$query2);
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "
						<div id='rogDiv'>
						<table class='rogTable'>
							<tr>
								<th>Student No.</th>
								<th>Student Name</th> 
								<th>College</th>
								<th>Year</th>
								<th>Program</th>
								<th>University</th>
							</tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "

						<tr><td>".$row['student_number']."</td>
						<td>".$row['lastname'].", ".$row['firstname']." ".$row['middlename']."</td>
						<td>".$row['college']."</td>
						<td>".$row['year_lvl']."</td>
						<td>".$row['program']."</td>
						<td>".$row['school']."</td>";
					}
					echo "</table>
					<table class='rogTable'>
					<tr>
						<th>Course No.</th>
						<th>Course Title</th> 
						<th>Grade</th>
						<th>Unit</th>
					</tr>";	
					while($row2 = mysqli_fetch_assoc($result2)){
						echo "<tr><td>".$row2['course_number']."</td>
						<td>".$row2['course_title']."</td>
						<td>".$row2['course_grade']."</td>
						<td>".$row2['course_units']."</td>";
					}					
					echo "</table></div>";
				}
				else{ echo "No results";
				}
			}
			
			
			mysqli_close($conn);
			
		?>
		<a href='index.php'>return to index</a><br>
		<form acton = "./index.php" method="post" >
		<input  type="submit" name="logout" value="Log Out">
		<hr>
		<div class="bottom">
		</div>
	</body>
</html>