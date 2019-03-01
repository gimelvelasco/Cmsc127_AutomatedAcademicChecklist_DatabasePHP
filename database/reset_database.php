<html>
	<head>
		<title></title>
	</head>
	
	<body>
	
	<?php
		$server = "localhost:3306";//optional
		$user = "root"; //usrname
		$password = "";

		$conn = mysqli_connect($server, $user, $password);
		if(!$conn) die(msqli_connect_error());
		else echo "Connection Success<br>";

		$query = "drop database cmsc127";
		if(mysqli_query($conn, $query)){
			echo "Dropped cmsc127<br>";}
		else	
			echo "error dropping cmsc127<br>" . mysqli_error($conn);

		
		if(!$conn) die(mysqli_error($conn));
			if(!$conn) die(mysqli_error($conn));
		
		echo "Ok :)";	
		mysqli_close($conn);

		header("Location: ./first.php");
	?>
	</body>
</html>