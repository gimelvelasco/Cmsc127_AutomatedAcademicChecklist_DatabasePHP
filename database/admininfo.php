<!DOCTYPE html>
<html>
	<head>
		<title>Admin Info</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
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
				header("Location: ./login.php");
				die(mysqli_error($conn));
			}		
			if($_SESSION['but'] != "admin"){
				header("Location: ./index.php");
			}
		?>
		<hr>
		<a target="_blank" href="http://www.up.edu.ph/"><img class="upLogo" src="./Imgs/uplogo.png"></a>
		<h4 id="upH"><br>University of the Philippines</h4>
		<h6 id="upH">Honor And Excellence</h6>
		<hr>
	</head>
	
	<body>	
	
		<?php
			//session_start();
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
				<div class='piTab'><a href='admininfo.php'><img src='./Imgs/info_icon.png' class='navLogo'></a></div>
				<div class='rogTab'><a href='repogr.php'><img src='./Imgs/rog_icon.png' class='navLogo'></a></div>
				<div class='cTab'><a href='checklist.php'><img src='./Imgs/clist_icon.png' class='navLogo'></a></div>
				<h5><br>Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Info&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grades&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checklist&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
				</div>";
			
				echo "<h2>Administrator Information</h2><br>";
				
				$query = "select * from admin where id='".$_SESSION['idnum']."'";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){
					echo "
						<div id='rogDiv'>
						<table class='rogTable'>
							<tr>
								<th>ID</th>
								<th>Password</th>
							</tr>";
					while($row = mysqli_fetch_assoc($result)){
						echo "

						<tr>
						<td>".$row['id']."</td>
						<td>".$row['password']."</td>
						</tr></table></div>";
					}
				}
				else{ echo "No results";
				}
			}
			else{
				
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