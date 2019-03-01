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

		$query = "create database cmsc127";
		if(mysqli_query($conn, $query)){
			echo "Created cmsc127<br>";}
		else	
			echo "error creating cmsc127<br>" . mysqli_error($conn);
		
		if(!$conn) die(mysqli_error($conn));
			if(!$conn) die(mysqli_error($conn));
			
		mysqli_close($conn);
		
		
		$server = "localhost:3306";//optional
		$user = "root"; //usrname
		$password = "";
		$db = "cmsc127";
		$conn = mysqli_connect($server, $user, $password,$db);	
		if(!$conn) die(mysqli_error($conn));
	
		$query = "create table school(
			id varchar(20),
			name varchar(20),
			address  varchar(100),
			contact_num varchar(20),
			primary key (name)
		)";
		mysqli_query($conn,$query);
	
		$query = "create table admin(
			id varchar(20),
			password varchar(20),
			primary key (id)
		)";
		mysqli_query($conn,$query);
	
		$query = "create table allCourses(
			course_number varchar(20),
			school varchar(20),
			course_title varchar(100),
			course_units float,
			type int,
			primary key (course_number,school),
			foreign key(school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		//GE would determine if the subject is a ge and what type le us say 1 for cs ,2 for css, 3 for cac, 4 for pe, 5 for nstp, and 0 for non of the above
		//it will determine if it is a major or an elective through the syllabus
		mysqli_query($conn,$query);
		
		
		$query = "create table checklist(
			course_number varchar(20),
			program varchar(20),
			presc_sem varchar(20),
			prec_yearlvl int,
			school varchar(20),
			primary key (program, school, course_number,presc_sem,prec_yearlvl),
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		//hindi na to tinanggal dahil hindi siya kaya i derive
		//pag ge nakalagay i checheck nalang yung type		
		$query = "create table student(
			student_number varchar(20),
			firstname varchar(20),
			middlename varchar(20),
			lastname varchar(20),
			sex varchar(7),
			college varchar(20),
			program varchar(20),
			permanent_address varchar(100),
			present_address varchar(100),
			citizenship varchar(20),
			contact_number varchar(20),
			email varchar(20),
			school varchar(30),
			password varchar(20),
			year_lvl int,
			primary key (student_number),
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		$query = "create table instructor(
			instructor_number varchar(20),
			firstname varchar(20),
			middlename varchar(20),
			lastname varchar(20),
			sex varchar(7),
			college varchar(20),
			department varchar(20),
			permanent_address varchar(100),
			present_address varchar(100),
			citizenship varchar(20),
			contact_number varchar(20),
			email varchar(20),
			school varchar(20),
			password varchar(20),
			primary key (instructor_number),	
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		$query = "create table advises(
			student_number varchar(20),
			instructor_number varchar(20),
			year int,
			sem int,
			primary key (student_number,instructor_number,year,sem),
			foreign key (student_number) references student(student_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (instructor_number) references instructor(instructor_number) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		$query = "create table offeredCourses(
			year int,
			sem int,
			course_code int,
			school varchar(20),
			course_number varchar(20),
			primary key (course_code,school,year),
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		$query = "create table reportOfGrades(
			student_number varchar(100),
			year int,
			sem int,
			course_code int,
			course_grade float,
			foreign key (student_number) references student(student_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (course_code) references offeredCourses(course_code) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		$query = "create table course_prereq(
			course_number varchar(20),
			precourse_number varchar(20),
			school varchar(20),
			primary key (course_number, precourse_number, school),
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (precourse_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (school) references school(name)
		)";
		mysqli_query($conn,$query);
		$query = "create table course_quali(
			course_number varchar(20),
			yearlvl int,
			sex varchar(20),
			program varchar(20),
			school varchar(20),
			primary key (course_number,school),
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE
		)";

		mysqli_query($conn,$query);
		$query = "create table course_equiv(
			course_number varchar(20),
			equcourse_number varchar(20),
			school varchar(20),
			primary key (course_number,equcourse_number,school),
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (equcourse_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);

		$query = "create table req_GE(
			program varchar(20),
			course_number varchar(20),
			school varchar(20),
			primary key (program,school),
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (program) references checklist(program) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		$query = "create table prog_elec(
			program varchar(20),
			course_number varchar(20),
			school varchar(20),
			primary key (program, course_number, school),
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (course_number) references allCourses(course_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (program) references checklist(program) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		// dinagdag dahil hindi rin maderive electives;
		$query = "create table takesCourses(
			student_number varchar(100),
			year int,
			sem int,
			course_code int,
			school varchar(20),
			foreign key (school) references school(name) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (student_number) references student(student_number) ON DELETE CASCADE ON UPDATE CASCADE,
			foreign key (course_code) references offeredCourses(course_code) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		mysqli_query($conn,$query);
		//para ala kung ano tung balak i take ng student
	
	
	//insertion of test cases
		$query = "insert into school values ('123434', 'UP Baguio', 'Baguio city', '0912344543')";
		mysqli_query($conn,$query);
		$query = "insert into admin values ('admin', 'admin')";
		mysqli_query($conn,$query);
		
		$query = "insert into allCourses values
			('Bio 10','UP Baguio','The Gene In Life',3.0,1),
			('Chem 1','UP Baguio','Chemistry A Practical Approach',3.0,1),
			('Eng 1','UP Baguio','Basic English',3.0,1),
			('Math 17','UP Baguio','Algebra and Trigonometry',5.0,1),
			('Philo 1','UP Baguio','Philosophical Analysis',3.0,1),


			('Hist 1','UP Baguio','Philippine History',3.0,2),
			('Math 101','UP Baguio','Elementary Statistics',3.0,0),
			('Math 53','UP Baguio','Elementary Analysis I',5.0,0),
			('PE 2 TTen','UP Baguio','Table Tennis',2.0,4),
			('Psych 10','UP Baguio','Psychology For Everyday Life',3.0,2),
			('SocSci I','UP Baguio','Foundation Of Behavioral Sciences',3.0,2),
			
			('Cmsc 11','UP Baguio','Introduction To Computer Science',3.0,0),
			('Math 29','UP Baguio','Basic Concepts In Mathematics',3.0,0),
			('Math 54','UP Baguio','Elementary Analysis II',3.0,0),
			('SocSci II','UP Baguio','Social, Economic and Political Thought',3.0,2),
			('SpComm 10','UP Baguio','Basic Speech Communication',3.0,3),
			
			('Cmsc 12','UP Baguio','Advanced Programming Techniques',3.0,0),
			('Comm 1','UP Baguio','Communication Skills',3.0,3),
			('HumD 1','UP Baguio','Pagbasa ng Panitikan',3.0,3),
			('Math 55','UP Baguio','Elementary Analysis III',3.0,0),
			('PE 2 Bad','UP Baguio','Badminton',2.0,4),
			('Physics 101','UP Baguio','Fundamental Physics I',4.0,0),
			('Physics 101.1','UP Baguio','Fundamental Physics I Laboratory',1.0,0),
			
			('Chem 11','UP Baguio','General and Inorganic Chemistry',5.0,0),
			('MedStud 11','UP Baguio','Reading Media',3.0,3),
			('Physics 102','UP Baguio','Fundamental Physics II',4.0,0),
			('Physics 102.1','UP Baguio','Fundamental Physics II Laboratory',1.0,0),
			
			('Math 182','UP Baguio','Introduction to Computer Programming',3.0,0),
			('NatSci 3','UP Baguio','Earth and Life Through Time',3.0,1),
			('PhLang 1.1 II','UP Baguio','Ibaloi',3.0,2),
			('Physics 103','UP Baguio','Fundamental Physics III',4.0, 0),
			('Physics 103.1','UP Baguio','Fundamental Physics III Laboratory',1.0, 0),
			
			('Cmsc 55','UP Baguio','Discrete Mathematical Structures in Computer Science',3.0,0),
			('Cmsc 110','UP Baguio','Internet Technologies',3.0,0),
			('Cmsc 116','UP Baguio','Mathematical Methods for the Computational Sciences',3.0,0),
			('Cmsc 130','UP Baguio','Logic Design and Digital Computer Circuits',3.0,0),
			('PI 100','UP Baguio','Life and Works of Jose Rizal',3.0,0),
			
			('Cmsc 123','UP Baguio','---',3.0,0),
			('Cmsc 131','UP Baguio','---',3.0,0),
			('Cmsc 190','UP Baguio','Special Problem',3.0,0),
			('Cmsc 117','UP Baguio','---',3.0,0),
			('Math 163','UP Baguio','---',3.0,0),

			('Cmsc 124','UP Baguio','Design and Implementation of Programming Languages',3.0,0),
			('Cmsc 127','UP Baguio','File Processing and Database System',3.0,0),
			('Cmsc 141','UP Baguio','Automata and Language Theory',3.0,0),
			('Cmsc 191','UP Baguio','Special Topics',3.0,0),

			('Cmsc 142','UP Baguio','Design and Analysis of Algorithms',3.0,0),
			('Cmsc 199','UP Baguio','Undergraduate Seminar',1.0,0),
			('Cmsc 125','UP Baguio','Operating Systems',3.0,0),
			('Cmsc 128','UP Baguio','Introduction to Software Engineering',3.0,0),
			('Cmsc 135','UP Baguio','Computer Networks',3.0,0),
			
			('HUM GE','UP Baguio','n/a',3.0,0),
			('SOCSCI GE','UP Baguio','n/a',3.0,0),
			('NAT SCI GE','UP Baguio','n/a',3.0,0),
			('NSTP 1','UP Baguio','National Service Training Program',3.0,5),
			('NSTP 2','UP Baguio','National Service Training Program',3.0,5),
			('PE 1','UP Baguio','Foundations of Physical Fitness',2.0,0),

			('Botany 10','UP Baguio','---',5.0,0),
			('Math 11','UP Baguio','---',3.0,0),
			('Zoology 10','UP Baguio','---',5.0,0),
			('Math 14','UP Baguio','---',3.0,0),
			('Zoology 102','UP Baguio','---',5.0,0),
			('Chem 31','UP Baguio','---',3.0,0),
			('Chem 31.1','UP Baguio','---',2.0,0),
			('Botany 109','UP Baguio','---',4.0,0),
			('Math 100','UP Baguio','---',4.0,0),
			('Biology 101','UP Baguio','---',3.0,0),
			('Chem 26','UP Baguio','---',3.0,0),
			('Chem 26.1','UP Baguio','---',2.0,0),
			('Zoology 111','UP Baguio','---',3.0,0),
			('Zoology 111.1','UP Baguio','---',2.0,0),
			('Chem 40','UP Baguio','---',3.0,0),
			('Chem 40.1','UP Baguio','---',2.0,0),
			('Physics 31','UP Baguio','---',3.0,0),
			('Physics 31.1','UP Baguio','---',1.0,0),
			('Geology 11','UP Baguio','---',3.0,0),
			('Botany 119','UP Baguio','---',5.0,0),
			('Biology 150','UP Baguio','---',3.0,0),
			('Physics 32','UP Baguio','---',3.0,0),
			('Physics 32.1','UP Baguio','---',1.0,0),
			('Biology 160','UP Baguio','---',4.0,0),
			('Biology 120','UP Baguio','---',5.0,0),
			('Biology 140','UP Baguio','---',4.0,0),
			('Zoology 120','UP Baguio','---',4.0,0),
			('Biology 200','UP Baguio','---',2.0,0),
			('Botany 120','UP Baguio','---',4.0,0),
			('Biology 198','UP Baguio','---',2.0,0)
			



			";
		mysqli_query($conn,$query);
		
		$query = "insert into checklist values
			('HUM GE','BS Computer Science','1st',1,'UP Baguio'),
			('SOCSCI GE','BS Computer Science','1st',1,'UP Baguio'),
			('NAT SCI GE','BS Computer Science','1st',1,'UP Baguio'),
			('Cmsc 11','BS Computer Science','1st',1,'UP Baguio'),
			('Math 17','BS Computer Science','1st',1,'UP Baguio'),
			('PE 1','BS Computer Science','1st',1,'UP Baguio'),
			('Cmsc 12','BS Computer Science', '2nd', 1,'UP Baguio'),
			('Math 53','BS Computer Science', '2nd', 1,'UP Baguio'),
			('Math 101','BS Computer Science', '2nd', 1,'UP Baguio'),
			('HUM GE','BS Computer Science','2nd',1,'UP Baguio'),
			('SOCSCI GE','BS Computer Science','2nd',1,'UP Baguio'),
			('Cmsc 55','BS Computer Science', '1st', 2,'UP Baguio'),
			('Cmsc 110','BS Computer Science', '1st', 2,'UP Baguio'),
			('Cmsc 130','BS Computer Science', '1st', 2,'UP Baguio'),
			('Math 54','BS Computer Science', '1st', 2,'UP Baguio'),
			('SOCSCI GE','BS Computer Science','1st',2,'UP Baguio'),
			('Cmsc 123','BS Computer Science', '2nd', 2,'UP Baguio'),
			('Cmsc 131','BS Computer Science', '2nd', 2,'UP Baguio'),
			('Math 55','BS Computer Science', '2nd', 2,'UP Baguio'),
			('Physics 101','BS Computer Science', '2nd', 2,'UP Baguio'),
			('Physics 101.1','BS Computer Science', '2nd', 2,'UP Baguio'),
			('HUM GE','BS Computer Science','2nd',2,'UP Baguio'),
			('SOCSCI GE','BS Computer Science','2nd',2,'UP Baguio'),
			('Cmsc 124','BS Computer Science', '1st', 3,'UP Baguio'),
			('Cmsc 127','BS Computer Science', '1st', 3,'UP Baguio'),
			('Cmsc 116','BS Computer Science', '1st', 3,'UP Baguio'),
			('Physics 102','BS Computer Science', '1st', 3,'UP Baguio'),
			('Physics 102.1','BS Computer Science', '1st', 3,'UP Baguio'),
			('SOCSCI GE','BS Computer Science','1st',3,'UP Baguio'),
			('Cmsc 125','BS Computer Science', '2nd', 3,'UP Baguio'),
			('Cmsc 128','BS Computer Science', '2nd', 3,'UP Baguio'),
			('Cmsc 117','BS Computer Science', '2nd', 3,'UP Baguio'),
			('HUM GE','BS Computer Science','2nd',3,'UP Baguio'),
			('NAT SCI GE','BS Computer Science','2nd',3,'UP Baguio'),
			('Cmsc 199','BS Computer Science', '2nd', 3,'UP Baguio'),
			('Cmsc 135','BS Computer Science', '1st', 4,'UP Baguio'),
			('Cmsc 141','BS Computer Science', '1st', 4,'UP Baguio'),
			('Cmsc 190','BS Computer Science', '1st', 4,'UP Baguio'),
			('PI 100','BS Computer Science', '1st', 4,'UP Baguio'),
			('Cmsc 142','BS Computer Science', '2nd', 4,'UP Baguio'),
			('HUM GE','BS Computer Science','2nd',4,'UP Baguio'),
			('NAT SCI GE','BS Computer Science','2nd',4,'UP Baguio'),
			('Cmsc 190','BS Computer Science', '2nd', 4,'UP Baguio'),

			('Botany 10','BS Biology','1st',1,'UP Baguio'),
			('HUM GE','BS Biology','1st',1,'UP Baguio'),
			('SOCSCI GE','BS Biology','1st',1,'UP Baguio'),
			('NAT SCI GE','BS Biology','2nd',2,'UP Baguio'),
			('PE 1','BS Biology','1st',1,'UP Baguio'),
			('Math 11','BS Biology','1st',1,'UP Baguio'),
			('Zoology 10','BS Biology','2nd',1,'UP Baguio'),
			('HUM GE','BS Biology','2nd',1,'UP Baguio'),
			('Chem 11','BS Biology','2nd',1,'UP Baguio'),
			('SOCSCI GE','BS Biology','2nd',1,'UP Baguio'),
			('Math 14','BS Biology','2nd',1,'UP Baguio'),
			('Zoology 102','BS Biology','1st',2,'UP Baguio'),
			('Chem 31','BS Biology','1st',2,'UP Baguio'),
			('Chem 31.1','BS Biology','1st',2,'UP Baguio'),
			('Botany 109','BS Biology','1st',2,'UP Baguio'),
			('Math 100','BS Biology','1st',2,'UP Baguio'),
			('SOCSCI GE','BS Biology','2nd',2,'UP Baguio'),
			('Biology 101','BS Biology','2nd',2,'UP Baguio'),
			('HUM GE','BS Biology','2nd',2,'UP Baguio'),
			('Chem 26','BS Biology','2nd',2,'UP Baguio'),
			('Chem 26.1','BS Biology','2nd',2,'UP Baguio'),
			('Zoology 111','BS Biology','2nd',2,'UP Baguio'),
			('Zoology 111.1','BS Biology','2nd',2,'UP Baguio'),
			('HUM GE','BS Biology','1st',3,'UP Baguio'),
			('Chem 40','BS Biology','1st',3,'UP Baguio'),
			('Chem 40.1','BS Biology','1st',3,'UP Baguio'),
			('Physics 31','BS Biology','1st',3,'UP Baguio'),
			('Physics 31.1','BS Biology','1st',3,'UP Baguio'),
			('PI 100','BS Biology', '1st',3,'UP Baguio'),
			('Geology 11','BS Biology','1st',3,'UP Baguio'),
			('SOCSCI GE','BS Biology','1st',3,'UP Baguio'),
			('Botany 119','BS Biology','2nd',3,'UP Baguio'),
			('Biology 150','BS Biology','2nd',3,'UP Baguio'),
			('Physics 32','BS Biology','2nd',3,'UP Baguio'),
			('Physics 32.1','BS Biology','2nd',3,'UP Baguio'),
			('Biology 160','BS Biology','2nd',3,'UP Baguio'),
			('Biology 120','BS Biology','1st',4,'UP Baguio'),
			('Biology 140','BS Biology','1st',4,'UP Baguio'),
			('Zoology 120','BS Biology','1st',4,'UP Baguio'),
			('Biology 200','BS Biology','1st',3,'UP Baguio'),
			('Botany 120','BS Biology','2nd',4,'UP Baguio'),
			('HUM GE','BS Biology','2nd',4,'UP Baguio'),
			('Biology 198','BS Biology','2nd',4,'UP Baguio'),
			('Biology 200','BS Biology','2nd',4,'UP Baguio'),
			('SOCSCI GE','BS Biology','2nd',4,'UP Baguio')
		";
		/*
			tsaka wala pa ung mga PE2 tsaka mga GE
		*/
		mysqli_query($conn,$query);
		
		$query = "insert into student values
			('2012-58922','Gimel David','Flores','Velasco','Male','College of Science','BS Computer Science','3 Production St. GSIS Village, Project 8, Quezon City 1116','22 Upper Tacay Rd., Pinsao Proper, Quezon Hill, Baguio City 2600', 'Philippines','09176633201','gfvelasco\@up.edu.ph','UP Baguio','password',4),
			('2014-11111','Neil Anthony','Garcia','Mempin','Male','College of Science','BS Computer Science','Sa baba ng baguio','Upper Tacay Rd., Pinsao Proper, Quezon Hill, Baguio City 2600','Philippines','09876543210','npmempin\@up.edu.ph','UP Baguio','password2',3)
		";
		mysqli_query($conn,$query);
		
		$query = "insert into instructor values
			('2000-12321','Sir','Dot','Teacher','Male','College of Science','DMCS','Sa baba ng baguio','per Taa Rd.,roper,zonill, Baguio City 2600','Philippines','09876543210','npmempin\@up.edu.ph','UP Baguio','password3')
		";
		mysqli_query($conn,$query);
		
		$query = "insert into offeredCourses values

			(1213,1,24610,'UP Baguio','Bio 10'),
			(1213,1,24361,'UP Baguio','Chem 1'),
			(1213,1,3541,'UP Baguio','Eng 1'),
			(1213,1,628417,'UP Baguio','Math 17'),
			(1213,1,744561,'UP Baguio','Philo 1'),

			(1213,2,44781,'UP Baguio','Hist 1'),
			(1213,2,6284101,'UP Baguio','Math 101'),
			(1213,2,628453,'UP Baguio','Math 53'),
			(1213,2,73288,'UP Baguio','PE 2 TTen'),
			(1213,2,7792410,'UP Baguio','Psych 10'),
			(1213,2,7637341,'UP Baguio','SocSci I'),

			(1314,1,267211,'UP Baguio','Cmsc 11'),
			(1314,1,628429,'UP Baguio','Math 29'),
			(1314,1,628454,'UP Baguio','Math 54'),
			(1314,1,67871,'UP Baguio','NSTP 1'),
			(1314,1,7637342,'UP Baguio','SocSci II'),
			(1314,1,77266610,'UP Baguio','SpComm 10'),

			(1314,2,267212,'UP Baguio','Cmsc 12'),
			(1314,2,26661,'UP Baguio','Comm 1'),
			(1314,2,48631,'UP Baguio','HumD 1'),
			(1314,2,628455,'UP Baguio','Math 55'),
			(1314,2,67872,'UP Baguio','NSTP 2'),
			(1314,2,732223,'UP Baguio','PE 2 Bad'),
			(1314,2,7497101,'UP Baguio','Physics 101'),
			(1314,2,74971011,'UP Baguio','Physics 101.1'),

			(1415,1,243611,'UP Baguio','Chem 11'),
			(1415,1,6711,'UP Baguio','MedStud 11'),
			(1415,1,7497102,'UP Baguio','Physics 102'),
			(1415,1,74971021,'UP Baguio','Physics 102.1'),

			(1415,1,6284182,'UP Baguio','Math 182'),
			(1415,1,4287343,'UP Baguio','NatSci 3'),
			(1415,1,75112,'UP Baguio','PhLang 1.1 II'),
			(1415,1,7497103,'UP Baguio','Physics 103'),
			(1415,1,74971031,'UP Baguio','Physics 103.1'),

			(1516,1,267255,'UP Baguio','Cmsc 55'),
			(1415,1,267255,'UP Baguio','Cmsc 55'),
			(1516,1,2672110,'UP Baguio','Cmsc 110'),
			(1516,1,2672116,'UP Baguio','Cmsc 116'),
			(1516,1,2672130,'UP Baguio','Cmsc 130'),
			(1516,1,74100,'UP Baguio','PI 100'),

			(1516,2,2672117,'UP Baguio','Cmsc 117'),
			(1516,2,2672123,'UP Baguio','Cmsc 123'),
			(1516,2,2672131,'UP Baguio','Cmsc 131'),
			(1516,2,2672190,'UP Baguio','Cmsc 190'),
			(1516,2,6284163,'UP Baguio','Math 163'),

			(1617,1,2672124,'UP Baguio','Cmsc 124'),
			(1617,1,2672127,'UP Baguio','Cmsc 127'),
			(1617,1,2672141,'UP Baguio','Cmsc 141'),
			(1617,1,2672191,'UP Baguio','Cmsc 191'),
			(1617,1,731,'UP Baguio','PE 1')
		";
		
		mysqli_query($conn,$query);
		
		$query = "insert into advises values
			('2012-58922','2000-12321',1617,1)
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
			('2012-58922',1314,1,628454,2.75),
			('2012-58922',1314,1,628429,4.0),
			('2012-58922',1314,1,67871,1.0),
			('2012-58922',1314,1,7637342,2.75),
			('2012-58922',1314,1,77266610,2.25),

			('2012-58922',1314,2,267212,1.5),
			('2012-58922',1314,2,26661,2.0),
			('2012-58922',1314,2,48631,2.0),
			('2012-58922',1314,2,67872,1.0),
			('2012-58922',1314,2,732223,3.0),
			('2012-58922',1314,2,7497101,1.75),
			('2012-58922',1314,2,74971011,1.5),

			('2012-58922',1415,1,6284182,1.0),
			('2012-58922',1415,1,243611,2.5),
			('2012-58922',1415,1,628429,1.75),
			('2012-58922',1415,1,267255,5.0),
			('2012-58922',1415,1,6711,1.75),
			('2012-58922',1415,1,7497102,1.75),
			('2012-58922',1415,1,74971021,2.25),

			('2012-58922',1415,2,4287343,2.25),
			('2012-58922',1415,1,75112,2.5),
			('2012-58922',1415,2,7497103,1.5),
			('2012-58922',1415,2,74971031,1.75),

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
		
			('2012-58922',1213,1,24610,'UP Baguio'),
			('2012-58922',1213,1,24361,'UP Baguio'),
			('2012-58922',1213,1,3541,'UP Baguio'),
			('2012-58922',1213,1,628417,'UP Baguio'),
			('2012-58922',1213,1,744561,'UP Baguio'),

			('2012-58922',1213,2,44781,'UP Baguio'),
			('2012-58922',1213,2,6284101,'UP Baguio'),
			('2012-58922',1213,2,628453,'UP Baguio'),
			('2012-58922',1213,2,73288,'UP Baguio'),
			('2012-58922',1213,2,7792410,'UP Baguio'),
			('2012-58922',1213,2,7637341,'UP Baguio'),

			('2012-58922',1314,1,267211,'UP Baguio'),
			('2012-58922',1314,1,628429,'UP Baguio'),
			('2012-58922',1314,1,628454,'UP Baguio'),
			('2012-58922',1314,1,67871,'UP Baguio'),
			('2012-58922',1314,1,7637342,'UP Baguio'),
			('2012-58922',1314,1,77266610,'UP Baguio'),

			('2012-58922',1314,2,267212,'UP Baguio'),
			('2012-58922',1314,2,26661,'UP Baguio'),
			('2012-58922',1314,2,48631,'UP Baguio'),
			('2012-58922',1314,2,628455,'UP Baguio'),
			('2012-58922',1314,2,67872,'UP Baguio'),
			('2012-58922',1314,2,732223,'UP Baguio'),
			('2012-58922',1314,2,7497101,'UP Baguio'),
			('2012-58922',1314,2,74971011,'UP Baguio'),

			('2012-58922',1415,1,243611,'UP Baguio'),
			('2012-58922',1415,1,628429,'UP Baguio'),
			('2012-58922',1415,1,6711,'UP Baguio'),
			('2012-58922',1415,1,7497102,'UP Baguio'),
			('2012-58922',1415,1,74971021,'UP Baguio'),

			('2012-58922',1415,1,6284182,'UP Baguio'),
			('2012-58922',1415,1,4287343,'UP Baguio'),
			('2012-58922',1415,1,75112,'UP Baguio'),
			('2012-58922',1415,1,7497103,'UP Baguio'),
			('2012-58922',1415,1,74971031,'UP Baguio'),

			('2012-58922',1516,1,267255,'UP Baguio'),
			('2012-58922',1516,1,2672110,'UP Baguio'),
			('2012-58922',1516,1,2672116,'UP Baguio'),
			('2012-58922',1516,1,2672130,'UP Baguio'),
			('2012-58922',1516,1,74100,'UP Baguio'),

			('2012-58922',1516,2,2672117,'UP Baguio'),
			('2012-58922',1516,2,2672123,'UP Baguio'),
			('2012-58922',1516,2,2672131,'UP Baguio'),
			('2012-58922',1516,2,2672190,'UP Baguio'),
			('2012-58922',1516,2,6284163,'UP Baguio')
		";
		mysqli_query($conn,$query);
		
		mysqli_close($conn);
		header("Location: ./login.php")
		?>
			</body>

</html>