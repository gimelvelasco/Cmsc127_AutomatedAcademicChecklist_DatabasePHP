<!DOCTYPE html>
<html>
	<head>
		<title>Student Checklist</title>
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
				
		}
		else{
			header("Location: ./login.php");
		}
		if($_SESSION['but'] != "admin"){
			header("Location: ./sclist.php");
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
	function editEntry2(rowname,year){
		rowID = "#"+rowname+" td";
		i=0;
		orig = $(rowID).eq(4).text();
		val = $(rowID).eq(4).text();
		$(rowID).eq(4).html("<input type='text' value='"+val+"' />");
		$(rowID).eq(5).html("Semester:<input type='text' value = '2nd' />");
		$(rowID).eq(6).html("Year:<input type='text' value='"+year+"' />");
		$(rowID).eq(7).html("<input type='button' value='Save' onclick=\"saveToDB2('"+rowname+"','"+orig+"','"+year+"')\" />");
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
	</head>
	<body>	
		<?php
			//session_start();
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "cmsc127";
			$conn = mysqli_connect($server, $user, $pass, $db);
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
				
				echo "<h2>Checklist Editing</h2><br>";

				if(!isset($_POST['program'])){
					if(!isset($_SESSION['program'])){
						$_SESSION['program']="No Program Chosen";
					}
				}
				else{
					$_SESSION['program'] = $_POST['program'];
				}
				
				echo"Select a program : <br><form action = \"checklist.php\" method = \"POST\"><select name='program'>";
				$query7 = "select distinct program from checklist";
				$result7 = mysqli_query($conn,$query7);
				echo "<option value='No Program Chosen'>SELECT A PROGRAM</option>";
				while($row7 = mysqli_fetch_assoc($result7)){
					echo "<option value='".$row7['program']."'>".$row7['program']."</option>";	
				}
				
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"Edit checklist\"/>";
				echo"</select></form><br>";
				$counter = 0;
				echo "<h3 id = program >".$_SESSION['program']."</h3>";
				for($i=1;$i<=4;$i++){
					$query = "select * from checklist where presc_sem = '1st' and prec_yearlvl = ".$i." and program ='".$_SESSION['program']."'";
					$result = mysqli_query($conn,$query);
					$query2 = "select * from checklist where presc_sem = '2nd' and prec_yearlvl = ".$i." and program ='".$_SESSION['program']."'";
					$result2 = mysqli_query($conn,$query2);
					if(mysqli_num_rows($result) > 0){
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
						echo "<table id='cDiv'>
						<tr><th>Course Number</th><th>Grade</th><th>Edit</th><th>Delete</th>
						<th>Course Number</th><th>Grade</th><th>Edit</th><th>Delete</th></tr>";
						while($row = mysqli_fetch_assoc($result)){
							if($row){$col = mysqli_fetch_assoc($result2);}
							echo "<tr id='row".$counter."'><td>".$row['course_number']."</td>";
							
							echo"<td>";
							echo "</td><td><input type=\"button\" value=\"Edit\" onclick=\"editEntry('row".$counter."','".$i."')\" /></td>
							<td><input type=\"button\" value=\"Delete\" onclick=\"removeEntry('row".$counter."','".$i."')\" /></td>";
												
							echo "<td>".$col['course_number']."</td><td></td>";
							
							echo "<td><input type=\"button\" value=\"Edit\" onclick=\"editEntry2('row".$counter."','".$i."')\" /></td>
							<td><button onclick=\"location.href='./delc.php?username=".$row['course_number']."'\">Delete</button></td></tr>";
							$counter++;
						}
						while($col = mysqli_fetch_assoc($result2)){
							echo "<tr id='row".$counter."'><td></td><td></td><td><input type=\"button\" value=\"Edit\" onclick=\"editEntry('row".$counter."')\" /></td>
							<td><input type=\"button\" value=\"Delete\" onclick=\"removeEntry('row".$counter."','".$i."')\" /><td>".$col['course_number']."</td><td>";
							
							echo"</td>
							<td><input type=\"button\" value=\"Edit\" onclick=\"editEntry2('row".$counter."','".$i."')\" /></td>
							<td><input type=\"button\" value=\"Delete\" onclick=\"removeEntry('row".$counter."','".$i."')\" /></td></tr>";
							$counter++;
						}
						echo "</table>";
						
					}
					else{ echo "<table id='cDiv'>
						<tr><th>Course Number</th><th>Grade</th>
						<th>course Number</th><th>Grade</th><th>Edit</th><th>Delete</th></tr></table>";
						echo "No results<br>";
					
					}
				}
				if($_SESSION['program']!="No Program Chosen")
					echo "<input type=\"button\" value=\"Add New Course Number\" onclick=\"insertEntry()\" />";
				
				echo "<table id='ins'></table>";
				echo "<h4>ELECTIVES</h4>";
				$query = "select * from prog_elec";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "<table id='cDiv'>
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
					echo "<table id='cDiv'>
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

				echo "<hr>Select a student : <br><form action = \"sclist.php\" method = \"POST\"><select name='scl'>";
				$query7 = "select * from student";
				$result7 = mysqli_query($conn,$query7);
				while($row7 = mysqli_fetch_assoc($result7)){
						echo "<option value='".$row7['student_number']."'>".$row7['student_number']." ".$row7['firstname']." ".$row7['middlename']." ".$row7['lastname']."</option>";
					
				}
				
				echo "<br><input  type=\"submit\" name=\"sub\" value=\"Edit checklist\"/>";
				echo"</select></form><br>";
			}

			mysqli_close($conn);
			
		?>
		
		<hr>
		<form acton = "./index.php" method="post" />
		<input  type="submit" name="logout" value="Log Out"/>
		<div class="bottom">
		</div>
	</body>
</html>