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
		
		p {
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
		
		h4 {
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
							height = '50';
							style = "margin-top: 10px;">
		</div>
		
		<div id="titleSection2" style="height:80px; 
									  width:840px; 
									  float:left;
									  border-bottom: thick double #32a1ce;">
									  
				<h2 style="font-family:Arial;
							margin-top: 25px;">Hotel Name</h2>
		</div>
		
		<div id="reservationOptions" style="background-color: white; height:550px; width:900px; float:left;">		   
			<center>
				<?php
					session_start();
					$filename = "bookings_XML.txt";
					$step = 1;
					$message = "";
					$matchBooking = null;

					// Step 1: Confirm number
					if (isset($_POST['submit_confirm'])) {
						$confirmation_number = trim($_POST['confirmation_number']);

						if (file_exists($filename)) {
							$xml = simplexml_load_file($filename);
							foreach ($xml->booking as $booking) {
								if ((string)$booking->confirmation_number === $confirmation_number) {
									$_SESSION['confirmation_number'] = $confirmation_number;
									$_SESSION['raw_booking'] = json_encode($booking);
									$step = 2;
									break;
								}
							}
							if ($step === 1) $message = "Confirmation number not found.";
						} else {
							$message = "Reservation file not found.";
						}
					}

					// Step 2: Verify personal info
					elseif (isset($_POST['submit_verify'])) {
						$name = trim($_POST['full_name']);
						$phone = trim($_POST['phone_number']);
						$email = trim($_POST['email']);

						if (isset($_SESSION['raw_booking'])) {
							$booking = json_decode($_SESSION['raw_booking']);
							if (
								strtolower($booking->full_name) === strtolower($name) &&
								$booking->phone_number === $phone &&
								strtolower($booking->email) === strtolower($email)
							) {
								$matchBooking = $booking;
								$step = 3;
							} else {
								$message = "Information does not match our records.";
								$step = 2;
							}
						} else {
							$message = "Session expired. Please restart.";
							$step = 1;
						}
					}
				?>

				<?php if (!empty($message)): ?>
					<p class="error"><?= $message ?></p>
				<?php endif; ?>

				<?php if ($step === 1): ?>
					<h3>Find My Reservation</h3>
					<form method="POST">
						<table style = "font-family:Arial; font-size:14px; color:#1c5178; margin-top: 70px;">
							<tr>
								<td>Enter Confirmation Number: </td>
								<td><input type="text" name="confirmation_number" required></td>
							</tr>
						</table> <br>
						<input type="submit" name="submit_confirm" value="Next">
					</form>

				<?php elseif ($step === 2): ?>
					<form method="POST">
						<table style = "font-family:Arial; font-size:14px; color:#1c5178; margin-top: 70px;">
							<tr>
								<td>Full Name: </td>
								<td><input type="text" name="full_name" required></td>
							</tr>
							<tr>
								<td>Phone Number: </td>
								<td><input type="text" name="phone_number" required></td>
							</tr>
							<tr>
								<td>Email Address:</td>
								<td><input type="text" name="email" required></td>
							</tr>
						</table> <br>
						<input type="submit" name="submit_verify" value="Confirm">
					</form>

				<?php elseif ($step === 3 && $matchBooking): ?>
					<h4>Reservation Details</h4>
					<p style = "margin-top: 10px; color: black;">Your reservation was successfully verified and can be viewed below:</p>
					<p class="info"  style="margin: 2px 0;"><strong>Name:</strong> <?= htmlspecialchars($matchBooking->full_name) ?></p>
					<p class="info"  style="margin: 2px 0;"><strong>Room:</strong> <?= $matchBooking->room_number ?> (<?= $matchBooking->room_type ?>)</p>
					<p class="info"  style="margin: 2px 0;"><strong>Check-In:</strong> <?= $matchBooking->check_in_date ?></p>
					<p class="info"  style="margin: 2px 0;"><strong>Check-Out:</strong> <?= $matchBooking->check_out_date ?></p>
					<p class="info"  style="margin: 2px 0;"><strong>Check-In Status:</strong> <?= $matchBooking->checked_out === "true" ? "Checked In" : "Not Checked In" ?></p>
				
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