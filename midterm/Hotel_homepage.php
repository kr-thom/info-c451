<!DOCTYPE html>
<!--Kristen Thomas
	System Implementation
	Midterm Project
	SPRING 2025-->
<html>
<head>
	<title>Hotel Management System</title>
	
	<style>
	<!-- Page Style-->
		body,
		html {
		  margin: 0;
		  font-family: sans-serif;
		}

		.container {
		  display: flex;
		  gap: 0.625%;
		}

		a {
		  flex: 1;
		  text-decoration: none;
		  outline-color: transparent;
		  text-align: center;
		  line-height: 3;
		  color: black;
		}

		a:link,
		a:visited,
		a:focus {
		  background: #234687;
		  color: white;
		}

		a:active {
		  background: lightblue;
		  color: white;
		}
		

	</style>
</head>

<body>
	<!--Entire Container-->
	<div id="container" style="width:900px;">
		<hr style = "height:10px; background-color: #5b94bd; margin:0px;">
		
		<!--Container For Hotel Name and Icon-->
		<div id="titleSection" style="height:110px; 
									  width:900px; 
									  float:left;
									  border-bottom: thick double #32a1ce;">
			
			
			<center>
				<img src = "hotel-flat-icon-building-and-architecture-vector.jpg"
							height = '50';>
				<h2 style="font-family:Arial;">Hotel Name</h2>
			</center>
		</div>
		
		<!--Main Container for Customer Tasks-->
		<div id="mainMenu" style = "height:550px;
									width:900px;
									float:left;">
			
			<h3 style="font-family: Arial;
						text-align:center;
						color: white;">
						
						<!--Relative Links to Different Customer Tasks-->
						<a href = "find_my_reservation.php">Find My Reservation</a> 
						<a href = "check in.php">Check In</a>
						<a href = "check out.php">Check Out</a>
						<a href = "hotel info.html">Hotel Information</a>
			</h3>
			
			<img src = "HMG-Hotel-Lobby-1920x720.jpg"
				style = "opacity: .70;
						 margin: auto;
						 display: block;"
				width = '900'>
				
			
		</div>
		
		<!--Footer Containers-->
		<div id="footer1" style="border-top: thick double #32a1ce; 
								 height:75px; 
								 width:900px; 
								 float:left;">
			<center><a href = "manager log in.php">Management Mode</a></center>
		</div>
		
	</div>
</body>
</html>
