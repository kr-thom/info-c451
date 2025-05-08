<!DOCTYPE html>
<!--Kristen Thomas
	System Implementation
	Final Project
	SPRING 2025-->
<html>
<head>
	<title>Hotel Management System</title>
	
	<!--Stylesheet/CSS-->
	<link rel="stylesheet" type="text/css" href="homepage_stylesheet.css">
</head>

<body>
	<!--Entire Container-->
	<div id="container" style="width:900px;">
		<hr style = "height:10px; background-color: #5b94bd; margin:0px;">
		
		<!--Container For Hotel Name and Icon-->
		<div id="titleSection">
			<center>
				<img src = "hotel-flat-icon-building-and-architecture-vector.jpg" alt="Hotel icon" height = '50';>
				<h2 style="font-family:Arial;">Hotel Name</h2>
			</center>
		</div>
		
		<!--Main Container for Customer Tasks-->
		<div id="mainMenu">
			<!--Background image-->
			<img src = "HMG-Hotel-Lobby-1920x720.jpg" 
			   width = '900'
			   style = "opacity: .60;
						position: absolute;
						left: 0;
						height: 71%;">
			
			<div style="position: absolute; top: 45%; left: 0; width: 100%; text-align: center;">
			<h3><!--Links to Different Customer Tasks-->
					<a href = "find_my_reservation.php">Find My Reservation</a> 
					<a href = "check_in.php">Check In</a>
					<a href = "check_out.php">Check Out</a>
					<a href = "hotel_info.php">Hotel Information</a>
			</h3>
			</div>
		</div>
		
		<!--Footer Container-->
		<div id="footer1">
			<a href = "manager_log_in.php"
			  style = "padding: 8px; border-radius: 10px;">Management Mode</a>
		</div>
		
	</div>
</body>
</html>
