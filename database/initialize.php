<!DOCTYPE html>

<html>
<body>
<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "cmsc127";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn){
		die(mysqli_error($conn));
	}
	else{
		echo "Connection Success<br>";

		$query = "create table student(
			student_number varchar(100),
			firstname varchar(100),
			middlename varchar(100),
			lastname varchar(100),
			sex varchar(100),
			sais_id varchar(100),
			college varchar(100),
			program varchar(100),
			st_discount varchar(100),
			permanent_address varchar(100),
			present_address varchar(100),
			contact_number varchar(100),
			email varchar(100),
			password varchar(100),
			primary key (student_number)	
		)";
		mysqli_query($conn,$query);
		$query = "create table instructor(
			instructor_number varchar(100),
			firstname varchar(100),
			middlename varchar(100),
			lastname varchar(100),
			sex varchar(100),
			college varchar(100),
			permanent_address varchar(100),
			present_address varchar(100),
			contact_number varchar(100),
			email varchar(100),
			password varchar(100),
			primary key (instructor_number)	
		)";
		mysqli_query($conn,$query);
		$query = "create table advises(
			student_number varchar(100),
			instructor_number varchar(100),
			year int,
			sem int,
			primary key (student_number,instructor_number,year,sem),
			foreign key (student_number) references student(student_number),
			foreign key (instructor_number) references instructor(instructor_number)
		)";
		mysqli_query($conn,$query);
		$query = "create table allCourses(
			course_code int,
			course_number varchar(100),
			course_title varchar(100),
			course_units float,
			primary key (course_code)
		)";
		//GE would determine if the subject is a ge and what type le us say 1 for cs ,2 for css, 3 for cac, 4 for pe, 5 for nstp, and 0 for non of the above
		//it will determine if it is a major or an elective through the syllabus
		mysqli_query($conn,$query);
		//course code ay tinanggal ko na kasi nagiibaiba kada sem para isa lang ang makukuha at hindi maging redundant masyado
		//pag ge nakalagay i checheck nalang yung type	
		//Categories: Major | Elective | Free Elective | PE | NatSciGE | SocSciGE | HumGE | NSTP | PI | Additional
		$query = "create table checklist(
			student_number varchar(100),
			course_code int,
			student_units float,
			course_categ varchar(100),
			foreign key (student_number) references student(student_number),
			foreign key (course_code) references allCourses(course_code)
		)";
		mysqli_query($conn,$query);
		$query = "create table reportOfGrades(
			student_number varchar(100),
			year int,
			sem int,
			course_code int,
			course_grade float,
			foreign key (student_number) references student(student_number),
			foreign key (course_code) references allCourses(course_code)
		)";
		mysqli_query($conn,$query);
	
		$query = "create table offeredCourses(
			year int,
			sem int,
			course_code int,
			foreign key (course_code) references allCourses(course_code)
		)";
		//dinagdagan ng course_number para may basis pa
		mysqli_query($conn,$query);
		$query = "create table course_prereq(
			course_code int,
			precourse_code int,
			foreign key (course_code) references allCourses(course_code),
			foreign key (precourse_code) references allCourses(course_code)
		)";
		//rinereference course_number kasi hindi naman require na sa specific sem tinake
		mysqli_query($conn,$query);
		$query = "create table course_quali(
			course_code int,
			yearlvl int,
			sex varchar(100),
			program varchar(100),
			primary key (course_code),
			foreign key (course_code) references allCourses(course_code)
		)";
		//pinalitan ko ng course_number tapos course title para sa pe2 like subjects
		mysqli_query($conn,$query);
		$query = "create table course_equiv(
			course_code int,
			equcourse_code int,
			foreign key (course_code) references allCourses(course_code),
			foreign key (equcourse_code) references allCourses(course_code)
		)";
		mysqli_query($conn,$query);
		//course number
		$query = "create table req_GE(
			program varchar(100),
			course_code int,
			foreign key (course_code) references allCourses(course_code)
		)";
		mysqli_query($conn,$query);
		$query = "create table prog_elec(
			program varchar(100),
			course_code int,
			foreign key (course_code) references allCourses(course_code)
		)";
		mysqli_query($conn,$query);
		//eto ung pipapakita muna sa adviser na balak na kuning subject ng student
		$query = "create table takesCourses(
			student_number varchar(100),
			year int,
			sem int,
			course_code int,
			foreign key (student_number) references student(student_number),
			foreign key (course_code) references offeredCourses(course_code)
		)";
		mysqli_query($conn,$query);

		////////////////////////////////

		$query = "insert into allCourses values
			(24610,'Bio 10','The Gene In Life',3.0),
			(24361,'Chem 1','Chemistry A Practical Approach',3.0),
			(3541,'Eng 1','Basic English',3.0),
			(628417,'Math 17','Algebra and Trigonometry',5.0),
			(744561,'Philo 1','Philosophical Analysis',3.0),


			(44781,'Hist 1','Philippine History',3.0),
			(6284101,'Math 101','Elementary Statistics',3.0),
			(628453,'Math 53','Elementary Analysis I',5.0),
			(73288,'PE 2 TTen','Table Tennis',2.0),
			(7792410,'Psych 10','Psychology For Everyday Life',3.0),
			(7637341,'SocSci I','Foundation Of Behavioral Sciences',3.0),
			
			(267211,'Cmsc 11','Introduction To Computer Science',3.0),
			(628429,'Math 29','Basic Concepts In Mathematics',3.0),
			(628454,'Math 54','Elementary Analysis II',3.0),
			(67871,'NSTP 1','National Service Training Program - Reserve Officers Training Corps',3.0),
			(7637342,'SocSci II','Social, Economic and Political Thought',3.0),
			(77266610,'SpComm 10','Basic Speech Communication',3.0),
			
			(267212,'Cmsc 12','Advanced Programming Techniques',3.0),
			(26661,'Comm 1','Communication Skills',3.0),
			(48631,'HumD 1','Pagbasa ng Panitikan',3.0),
			(628455,'Math 55','Elementary Analysis III',3.0),
			(67872,'NSTP 2','National Service Training Program - Reserve Officers Training Corps',3.0),
			(732223,'PE 2 Bad','Badminton',2.0),
			(7497101,'Physics 101','Fundamental Physics I',4.0),
			(74971011,'Physics 101.1','Fundamental Physics I Laboratory',1.0),
			
			(243611,'Chem 11','General and Inorganic Chemistry',5.0),
			(6711,'MedStud 11','Reading Media',3.0),
			(7497102,'Physics 102','Fundamental Physics II',4.0),
			(74971021,'Physics 102.1','Fundamental Physics II Laboratory',1.0),
			
			(6284182,'Math 182','Introduction to Computer Programming',3.0),
			(4287343,'NatSci 3','Earth and Life Through Time',3.0),
			(75112,'PhLang 1.1 II','Ibaloi',3.0),
			(7497103,'Physics 103','Fundamental Physics III',4.0),
			(74971031,'Physics 103.1','Fundamental Physics III Laboratory',1.0),
			
			(267255,'Cmsc 55','Discrete Mathematical Structures in Computer Science',3.0),
			(2672110,'Cmsc 110','Internet Technologies',3.0),
			(2672116,'Cmsc 116','Mathematical Methods for the Computational Sciences',3.0),
			(2672130,'Cmsc 130','Logic Design and Digital Computer Circuits',3.0),
			(74100,'PI 100','Life and Works of Jose Rizal',3.0),
			
			(2672117,'Cmsc 117','Numerical Methods',3.0),
			(2672123,'Cmsc 123','Data Structures',3.0),
			(2672131,'Cmsc 131','Introduction to Computer Organization and Machine Level Programming',3.0),
			(2672190,'Cmsc 190','Special Problem',3.0),
			(6284163,'Math 163','Mathematical Statistics',3.0),

			(2672124,'Cmsc 124','Design and Implementation of Programming Languages',3.0),
			(2672127,'Cmsc 127','File Processing and Database System',3.0),
			(2672141,'Cmsc 141','Automata and Language Theory',3.0),
			(2672191,'Cmsc 191','Special Topics',3.0),
			(731,'PE 1','Foundations of Physical Fitness',2.0)
			
			";
		mysqli_query($conn,$query);

		$query = "insert into offeredCourses values
			(1617,1,2672124),
			(1617,1,2672127),
			(1617,1,2672141),
			(1617,1,2672191),
			(1617,1,2672190),
			(1617,1,731)
		";
		mysqli_query($conn,$query);

		$query = "insert into student values
			('2012-58922','Gimel David','Flores','Velasco','Male','10047621','College of Science','BS Computer Science','FDS','3 Production St. GSIS Village, Project 8, Quezon City 1116','22 Upper Tacay Rd., Pinsao Proper, Quezon Hill, Baguio City 2600','09176633201','gfvelasco\@up.edu.ph','password'),
			('2012-58921','Gabriel Derik','Flores','Velasco','Male','10047620','College of Science','BS Computer Science','FDS','3 Production St. GSIS Village, Project 8, Quezon City 1116','22 Upper Tacay Rd., Pinsao Proper, Quezon Hill, Baguio City 2600','09176633200','gfvelasco\@up.edu.ph','password')
		";
		mysqli_query($conn,$query);
		$query = "insert into instructor values
			('2014-11111','Neil','Pogi','Mempin','Male','College of Science','Sa baba ng baguio','Upper Tacay Rd., Pinsao Proper, Quezon Hill, Baguio City 2600','09876543210','npmempin\@up.edu.ph','password')
		";
		mysqli_query($conn,$query);
		$query = "insert into advises values
			('2012-58922','2014-11111',1617,1)
		";
		mysqli_query($conn,$query);

		$query = "insert into reportOfGrades values
			('2012-58922',1213,1,24610,2.5),
			('2012-58922',1213,1,24361,2.25),
			('2012-58922',1213,1,3541,2.0),
			('2012-58922',1213,1,628417,1.5),
			('2012-58922',1213,1,744561,2.5),

			('2012-58922',1213,2,44781,2.5),
			('2012-58922',1213,2,6284101,2.5),
			('2012-58922',1213,2,628453,2.75),
			('2012-58922',1213,2,73288,1.75),
			('2012-58922',1213,2,7792410,2.25),
			('2012-58922',1213,2,7637341,3.0),

			('2012-58922',1314,1,267211,2.0),
			('2012-58922',1314,1,628429,4.0),
			('2012-58922',1314,1,628454,2.75),
			('2012-58922',1314,1,67871,1.0),
			('2012-58922',1314,1,7637342,2.75),
			('2012-58922',1314,1,77266610,2.25),

			('2012-58922',1314,2,267212,1.5),
			('2012-58922',1314,2,26661,2.0),
			('2012-58922',1314,2,48631,2.0),
			('2012-58922',1314,2,628455,5.0),
			('2012-58922',1314,2,67872,1.0),
			('2012-58922',1314,2,732223,3.0),
			('2012-58922',1314,2,7497101,1.75),
			('2012-58922',1314,2,74971011,1.5),

			('2012-58922',1415,1,243611,2.5),
			('2012-58922',1415,1,628429,1.75),
			('2012-58922',1415,1,6711,1.75),
			('2012-58922',1415,1,7497102,1.75),
			('2012-58922',1415,1,74971021,2.25),

			('2012-58922',1415,1,6284182,1.0),
			('2012-58922',1415,1,4287343,2.25),
			('2012-58922',1415,1,75112,2.5),
			('2012-58922',1415,1,7497103,1.5),
			('2012-58922',1415,1,74971031,1.75),

			('2012-58922',1516,1,267255,2.0),
			('2012-58922',1516,1,2672110,2.0),
			('2012-58922',1516,1,2672116,2.25),
			('2012-58922',1516,1,2672130,2.5),
			('2012-58922',1516,1,74100,2.25),

			('2012-58922',1516,2,2672117,2.5),
			('2012-58922',1516,2,2672123,2.5),
			('2012-58922',1516,2,2672131,3.0),
			('2012-58922',1516,2,2672190,4.0),
			('2012-58922',1516,2,6284163,5.0)
		";
		mysqli_query($conn,$query);

		$query = "insert into takesCourses values
			('2012-58922',1617,1,2672124),
			('2012-58922',1617,1,2672127),
			('2012-58922',1617,1,2672141),
			('2012-58922',1617,1,2672191),
			('2012-58922',1617,1,731),

			('2012-58921',1617,1,2672124),
			('2012-58921',1617,1,2672127),
			('2012-58921',1617,1,2672141),
			('2012-58921',1617,1,2672191),
			('2012-58921',1617,1,731)
		";
		mysqli_query($conn,$query);




		echo "Ok :)";
		mysqli_close($conn);
	}
	//header("Location: ./login.php");
	
?>
</body>
</html>