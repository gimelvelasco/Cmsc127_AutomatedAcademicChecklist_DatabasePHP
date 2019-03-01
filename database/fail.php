<!DOCTYPE html>

<html>
	<head>
		<?php  
			session_start();
		?>
		<link rel="stylesheet" href="./css/style.css">
		<title>
		Login Page
		</title>
		<hr>
		<a target="_blank" href="http://www.up.edu.ph/"><img class="upLogo" src="./Imgs/uplogo.png"></a>
		<h4 id="upH"><br>University of the Philippines</h4>
		<h6 id="upH">Honor And Excellence</h6>
		<div class='hTab'>
			<h3>Automated Checklist System</h3>
		</div>
		<hr>
	</head>
	<body>
		<?php
			if(isset($_SESSION['pas'])&&isset($_SESSION['pas'])&&isset($_SESSION['but'])){
					header("Location: ./index.php");
					exit;
			}
		?>
		

		<div id="loginDiv" format="background:gray">
		<form action = "index.php" method = "POST">
			<center><h1>LOGIN</h1></center>
			<hr>
			<center>|<input type="radio"  name="but" value="stud"/>Student&nbsp;|<input type="radio"  name="but" value="inst"/>Instructor&nbsp;|</center>
			<hr>
			<center>User ID<br><input type="text"  name="idnum" /></center><br>
			<center>Password<br><input type="password"  name="pas" /></center><br>
			<center><h6 class="failnotif">Invalid Username and/or Password</h6></center>
			<hr>
			<center><input type = "submit" value ="Log In"></center>
		</div>
	<p id="invite">Don't have an account yet? Contact Admin at<br>gfvelasco@up.edu.ph<br>npmempin@up.edu.ph</p>



	<hr>
	<div class="bottom">
		<input type="radio"  name="but" value="admin"/>
		</form>
	</div>
	</body>
</html>
