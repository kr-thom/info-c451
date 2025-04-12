<!DOCTYPE html>
<!--Kristen Thomas
	System Implementation
	Midterm Project
	SPRING 2025-->
<html>
<head>
	<title>Hotel Management System</title>
	
	<style>
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
	</style>
</head>

<body>
	<div id="container" style="width:900px;">
		<hr style = "height:10px; background-color: #5b94bd; margin:0px;">
		
		
		<div id="titleSection" style="height:80px; 
									  width:60px; 
									  float:left;
									  border-bottom: thick double #32a1ce;">
			
				<img src = "hotel-flat-icon-building-and-architecture-vector.jpg"
							height = '50';
							style = "margin-top: 10px;">
		</div>
		
		<div id="titleSection2" style="height:80px; 
									  width:840px; 
									  float:left;
									  border-bottom: thick double #32a1ce;">
									  
				<h2 style="font-family:Arial;">Hotel Name</h2>
		</div>
		
		<div id="management" style="background-color: white; height:550px; width:900px; float:left;">
			<h3 style="font-family:Arial;
					   text-align:center;
					   margin-top: 50px;">Check In</h3>
			
			
			<center>
			<form>
				<table style = "font-family:Arial;
								font-size:14px;
								color:#1c5178;
								margin-top: 70px;">
				<tr>
					<th>Enter Manager Password: </th>
					<td><input type ='int' maxlength = '6' required></td>
				</tr>
				</table> <br>
				
				<input type='submit' name= 'submit' value='Submit Form' />

			</form>
			</center>
				
		</div>
		
		<!--Footer Containers-->
		<div id="footer1" style="border-top: thick double #32a1ce; 
								 height:75px; 
								 width:750px; 
								 float:left;">
			<a href = "Hotel_homepage.php">Home</a>
		</div>
		
		<div id="footer2" style="border-top: thick double #32a1ce; 
								 height:75px; 
								 width:150px; 
								 float:left;">
		</div>
		
	</div>
</body>
</html>