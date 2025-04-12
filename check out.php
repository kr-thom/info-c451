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
		
		p{
			font-family:Arial;
								font-size:14px;
								color:#1c5178;
								margin-top: 70px;
		} 
		
		h3 {
			font-family:Arial;
			text-align:center;
			margin-top: 50px;
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
							height = '50';>
		</div>
		
		<div id="titleSection2" style="height:80px; 
									  width:840px; 
									  float:left;
									  border-bottom: thick double #32a1ce;">
									  
				<h2 style="font-family:Arial;">Hotel Name</h2>
		</div>
		
		<div id="checkOut" style="background-color: white; height:550px; width:900px; float:left;">
			<?php
				session_start();
				$filename = "bookings_XML.txt";
				$message = "";
				$step = 1;
				$matchedBooking = null;

				// Step 1: Form submission
				if (isset($_POST['submit_checkout'])) {
					$room = trim($_POST['room_number']);
					$fullName = strtolower(trim($_POST['full_name']));

					if (file_exists($filename)) {
						$xml = simplexml_load_file($filename);
						foreach ($xml->booking as $booking) {
							if (
								(!empty($room) && (string)$booking->room_number === $room) ||
								(!empty($fullName) && strtolower((string)$booking->full_name) === $fullName)
							) {
								// Set checkout status to true
								$booking->checked_out = "false";
								$xml->asXML($filename);
								$matchedBooking = $booking;
								$step = 2;
								break;
							}
						}

						if ($step === 1) {
							$message = "No matching reservation found.";
						}
					} else {
						$message = "Booking file not found.";
					}
				}
			?>
			
			<?php if (!empty($message)): ?>
				<p class="error"><?= $message ?></p>
			<?php endif; ?>
			<h3>Express Check Out</h3>
			
			<center>
				<?php if ($step === 1): ?>
					<p style="font-family:Arial; margin-top: 20px;">Please enter your room number and last name to Check Out:</p>
					<form method="POST">
						<table style = "font-family:Arial; font-size:14px; color:#1c5178; margin-top: 50px;">
						<tr>
							<td>Enter Room Number:</td>
							<td><input type="text" name="room_number" required></td>
						</tr>
						<tr>
							<td>Enter Full Name:</td>
							<td><input type="text" name="full_name" required></td>
						</tr>
						</table> <br>
						<input type="submit" name="submit_checkout" value="Check Out">
					</form>

				<?php elseif ($step === 2 && $matchedBooking): ?>
					<p class="success" style = "margin-top: 20px;">Success! Guest <?= htmlspecialchars($matchedBooking->full_name) ?> has been checked out.</p>
					<p style="margin: 2px 0;"><strong>Room:</strong> <?= $matchedBooking->room_number ?> (<?= $matchedBooking->room_type ?>)</p>
					<p style="margin: 2px 0;"><strong>Check-In Status:</strong> <?= $matchedBooking->checked_out === "true" ? "Checked In" : "Checked Out" ?></p>
					
					<a href = "Hotel_homepage.php">Back to Home</a>
				<?php endif; ?>
				
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
			<center><a href = "manager log in.php">Management Mode</a></center>
		</div>
		
	</div>
</body>
</html>