<!DOCTYPE html>
<html>
	<head>
		<title>Instructor Personal Information</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
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
			if($_SESSION['but'] == "stud"){
				header("Location: ./students.php");
			}
		?>
		<script>

			function saveToDB(rowname, orig, year){
				rowID = "#"+rowname+" td";
				rowID2 = "#program";
				data = {}
				data["origyear"]=year;
				data["orig"] = orig;
				data["origsem"]= "1st";
				data["course_number"] = $(rowID).eq(0).find("input:eq(0)").val();
				data["year"] = $(rowID).eq(2).find("input:eq(0)").val();
				data["sem"] = $(rowID).eq(1).find("input:eq(0)").val();
				data["program"] = $(rowID2).eq(0).text();
				data["school"] = "UP Baguio";
				
				$.post(
					"./editclist.php",
					data,
					function(ret){
						window.location.replace("./checklist.php");
					}, "json"
				);
			}
			function removeEntry(rowname,year){
				rowID = "#"+rowname+" td";
				rowID2 = "#program";
				data = {}
				data["orig"] = $(rowID).eq(0).text();
				data["origyear"]=year;
				data["origsem"]= "1st";
				data["program"] = $(rowID2).eq(0).text();
				$.post(
					"./delclist.php",
					data,
					function(ret){
						alert(ret["msg"]);
						window.location.replace("./checklist.php");
					}, "json"
				);
			}
			function removeEntry2(rowname,year){
				rowID = "#"+rowname+" td";
				rowID2 = "#program";
				data = {}
				data["orig"] = $(rowID).eq(4).text();
				data["origyear"]=year;
				data["origsem"]= "2nd";
				data["program"] = $(rowID2).eq(0).text();
				$.post(
					"./delclist.php",
					data,
					function(ret){
						alert(ret["msg"]);
						window.location.replace("./checklist.php");
					}, "json"
				);
			}
			function saveToDB2(rowname, orig,year){
				rowID = "#"+rowname+" td";
				rowID2 = "#program";
				data = {}
				data["origsem"]= "2nd";
				data["origyear"]=year;
				data["orig"] = orig;
				data["course_number"] = $(rowID).eq(4).find("input:eq(0)").val();
				data["year"] = $(rowID).eq(6).find("input:eq(0)").val();
				data["sem"] = $(rowID).eq(5).find("input:eq(0)").val();
				data["program"] = $(rowID2).eq(0).text();
				data["school"] = "UP Baguio";
				
				$.post(
					"./editclist.php",
					data,
					function(ret){
						window.location.replace("./checklist.php");
					}, "json"
				);
			}
			function editEntry(rowname,year){
				rowID = "#"+rowname+" td";
				rowID2 = "#program";
				i=0;
				orig = $(rowID).eq(0).text();
				val = $(rowID).eq(0).text();
				$(rowID).eq(0).html("<input type='text' value='"+val+"' />");
				$(rowID).eq(1).html("Semester:<input type='text' value ='1st' />");
				$(rowID).eq(2).html("Year:<input type='text' value = '"+year+"' />");
				$(rowID).eq(3).html("<input type='button' value='Save' onclick=\"saveToDB('"+rowname+"','"+orig+"','"+year+"')\" />");
			}
			function studentsave(){
				
				
				rowID2 = "#program";
				
				newarray = {};
				newarray["snum"] = $("#snum").text();
				newarray["citi"] = $("#citii").val();
				newarray["prad"] =  $("#pradd").val();
				newarray["pead"] =  $("#peadd").val();
				newarray["email"] =  $("#emaill").val();
				newarray["cnum"] = $("#cnumm").val();
				

				$.post(
					"./tsave.php",
					newarray,
					function(ret){
						window.location.replace("./teacher.php");
					}, "json"
				);
				
			}
			
			function editEntry2(){
				
				i=0;
				v1=$("#citi").eq(0).text();
				v2=$("#prad").eq(0).text();
				v3=$("#pead").eq(0).text();
				v4=$("#email").eq(0).text();
				v5=$("#cnum").eq(0).text();
				$("#citi").eq(0).html("<input id ='citii' type='text' value = '"+v1+"'/>");
				$("#prad").eq(0).html("<input id ='pradd' type='text' value = '"+v2+"'/>");
				$("#pead").eq(0).html("<input id ='peadd' type='text' value = '"+v3+"'/>");
				$("#email").eq(0).html("<input id = 'emaill' type='text' value = '"+v4+"'/>");
				$("#cnum").eq(0).html("<input id = 'cnumm' type='text' value = '"+v5+"'/>");
				$("#buts").eq(0).html("<input type=\"button\" value=\"Save Changes\" onclick=\"studentsave()\" />")
				$("#ep").hide();
				
			}
			
			function insertNewEntry(){
				rowID2 = "#program";
				
				newarray = {};
				newarray["program"] = $(rowID2).eq(0).text();
				newarray["course_number"] =  $("#new1").val();
				newarray["sem"] =  $("#new2").val();
				newarray["year"] =  $("#new3").val();
				newarray["school"] = "UP Baguio";
				
				alert(newarray["year"]);

				$.post(
					"./insclist.php",
					newarray,
					function(ret){
						window.location.replace("./checklist.php");
					}, "json"
				);
				window.location.replace("./checklist.php");
			}
			function insertEntry(){
				newrow = "<tr><th>Course_number:</th><td><input id=\"new1\" type=\"text\" name =\"course_number\" /></td><th>Semester:</th><td><input id=\"new2\" type=\"text\" name =\"Semester\" /></td><th>Year:</th><td><input id=\"new3\" type=\"text\" name =\"Year\" /></td><td><input type=\"button\" value=\"Insert\" onclick=\"insertNewEntry()\"/></td></tr>";
				$("#ins").append(newrow);
				//$("#abut").hide();
				//$("#dbut").hide();
			}
			function addNewEntry2(){
				newrow = "<tr><td><input id=\"new1\" type=\"text\" name =\"course_code\"/></td><td>NO VALUE</td><td><input id=\"new2\" type=\"text\" name =\"id_num\" /></td><td><input id=\"new3\" type=\"text\" name =\"name_num\" /></td><td>COURSE CODE:<input id=\"new4\" type=\"text\" name =\"name_num\" /></td><td><input type=\"button\" value=\"Insert\" onclick=\"insertNewEntry()\"/></td></tr>";
				$("#dtbl").append(newrow);
				$("#abut").hide();
				$("#dbut").hide();
			}
			function deleteEntry(){
				delrow = "<tr><th>Delete | Course Code:</th><td><input id=\"del1\" type=\"text\" name =\"course_code\" /></td><td><input type=\"button\" value=\"Delete\" onclick=\"removeEntry()\"/></td></tr>";
				$("#dtbl2").append(delrow);
				$("#dbut").hide();
				$("#abut").hide();
			}
		</script>
		<hr>
		<a target="_blank" href="http://www.up.edu.ph/"><img class="upLogo" src="./Imgs/uplogo.png"></a>
		<h4 id="upH"><br>University of the Philippines</h4>
		<h6 id="upH">Honor And Excellence</h6>
		<hr>
		<div class='hTab'>
			<h3>Instructor Advising Overview</h3>
		</div>
	</head>
	
	<body>	

		<h2>Personal Information</h2><br>

		<?php
			
			
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
					
				$query = "select * from instructor";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table border='1'>
					<tr><th>Instructor Number</th><th>First Name</th>
					<th>Middle Name</th><th>Last Name</th><th>College</th>
					<th>Department</th><th>Permanent Address</th><th>Present Address</th><th>Citizenship</th>
					<th>Contact Number</th><th>E-mail</th><th>School</th><th>Password</th></tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "<tr><td>".$row['instructor_number']."</td>
						<td>".$row['firstname']."</td>
						<td>".$row['middlename']."</td>
						<td>".$row['lastname']."</td>
						<td>".$row['college']."</td>
						<td>".$row['department']."</td>
						<td>".$row['permanent_address']."</td>
						<td>".$row['present_address']."</td>
						<td>".$row['citizenship']."</td>
						<td>".$row['contact_number']."</td>
						<td>".$row['email']."</td>
						<td>".$row['school']."</td>
						<td>".$row['password']."</td>
						<td><button onclick=\"location.href='./editc.php?username=".$row['instructor_number']."'\">Edit</button></td>
						<td><button onclick=\"location.href='./delc.php?username=".$row['instructor_number']."'\">Delete</button></td></tr>";
					}
					echo "</table>";
					echo "<button onclick=\"location.href='./addc.php'\">Add users</button>";
				}
				else{ echo "No results";
				}
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

				$query = "select * from instructor where instructor_number = '" .$_SESSION["idnum"]."'";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					/*
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
					*/
					while($row = mysqli_fetch_assoc($result)){
					echo "
					<div id='mainDiv'>
						<table class='cTable'>
							<tr>
								<th>Name</th>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<td>".$row['lastname'].", ".$row['firstname']." ".$row['middlename']."</td>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<th>Instructor Information</th>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<td>Sex</td>
								<td>".$row['sex']."</td>
							</tr>
							<tr>
								<td>ID Number</td>
								<td id='snum'>".$row['instructor_number']."</td>
							</tr>
							<tr>
								<td>College</td>
								<td>".$row['college']."</td>
							</tr>
							<tr>
								<td>Department</td>
								<td>".$row['department']."</td>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<th>Address</th>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<td>Permanent</td>
								<td id = pead>".$row['permanent_address']."</td>
							</tr>
							<tr>
								<td>Present</td>
								<td id = 'prad'>".$row['present_address']."</td>
							</tr>
							<tr>
								<td>Country of Citizenship</td>
								<td id = 'citi'>".$row['citizenship']."</td>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<th>Contact Information</th>
							</tr>
						</table>
						<table class='cTable'>
							<tr>
								<td>Contact Number</td>
								<td id = 'cnum'>".$row['contact_number']."</td>
							</tr>
							<tr>
								<td>E-Mail</td>
								<td id = 'email'>".$row['email']."</td>
							</tr>
						</table>
					</div>
					";
					}

					echo "</table>";
				}
				else{ echo "No results";
				}
			}
			
			mysqli_close($conn);
			
		?>
		<a href='index.php'>return to index</a><br>
		<a id="buts"></a>
		<input type="button" id="ep" value="Edit Profile" onclick="editEntry2()" />
		<form acton = "./index.php" method="post" >
		<input  type="submit" name="logout" value="Log Out">
	
	<hr>
	<div class="bottom">
	</div>
	</body>
</html>