<!DOCTYPE html>
<!--Kristen Thomas
	System Implementation
	Final Project
	SPRING 2025-->
<html>
<head>
	<title>Check In</title>
	
	<!--Stylesheet/CSS-->
	<link rel="stylesheet" type="text/css" href="pages_stylesheet.css">
</head>

<body>
	<div id="container" style="width:900px;">
		<hr>
		<!--Title Divs-->
		<div id="titleSection">
				<img src = "hotel-flat-icon-building-and-architecture-vector.jpg" height = '50'; style = "margin-top: 10px;">
		</div>
		
		<div id="titleSection2">					  
				<h2>Hotel Name</h2>
		</div>
		
		<!--Main Container for check in-->
		<div id="checkIn">	
			<?php
				session_start();
				$filename = "bookings_XML.txt";
				$step = 1;
				$matchBooking = null;
				$message = "";

				// Handle confirmation number
				if (isset($_POST['submit_confirm'])) {
					$confirmation_number = $_POST['confirmation_number'];

					if (file_exists($filename)) {
						$xml = simplexml_load_file($filename);

						foreach ($xml->booking as $booking) {
							if ((string)$booking->confirmation_number === $confirmation_number) {
								$_SESSION['confirmation_number'] = $confirmation_number;
								$booking->checked_out = "true";
								$xml->asXML($filename);
								$step = 2; // Proceed to ID input step
								break;
							}
						}

						if ($step === 1) {
							$message = "Confirmation number not found.";
						}
					} else {
						$message = "Booking file not found.";
					}
				}

				// Handle ID number
				if (isset($_POST['submit_id'])) {
					$id_number = $_POST['id_number'];

					if (isset($_SESSION['confirmation_number']) && file_exists($filename)) {
						$xml = simplexml_load_file($filename);
						$confirmation_number = $_SESSION['confirmation_number'];

						foreach ($xml->booking as $booking) {
							if ((string)$booking->confirmation_number === $confirmation_number) {
								if (empty($booking->id_number)) {
									$booking->id_number = $id_number;
									$xml->asXML($filename);
									$message = "Check-In Complete! Your ID has been saved.";
								} else {
									$message = "You have already successfully checked in!";
								}

								$matchBooking = $booking;
								unset($_SESSION['confirmation_number']); // Clear session after check-in
								$step = 3; // Show final result
								break;
							}
						}
					}
				}
			?>
			
			<!--Confirmation and ID Input Screens-->
			<center>
			<?php if ($step === 1): ?>
				<h2 style = "margin-top: 50px;">Check In</h2>
				<form method = "POST">
					<table>
					<tr>
						<th>Enter Confirmation Number: </th>
						<td><input type ='text' input name = 'confirmation_number' maxlength = '10' required></td>
					</tr>
					</table> <br>
					<input type="submit" name="submit_confirm" value="Next">
				</form>
				
			<?php elseif ($step === 2): ?>
				<h3>Confirmation Number Found</h3>
				<form method="POST">
					<table style = "font-family:Arial; font-size:14px; color:#1c5178; margin-top: 70px;">
							<tr>
								<th>Enter ID Number: </th>
								<td><input type="text" name="id_number" maxlength="20" required></td>
							</tr>
					</table> <br>
					<input type="submit" name="submit_id" value="Check In">
				</form>
					
			<?php elseif ($step === 3 && $matchBooking): ?>
				<h3><?= $message ?></h3>
				<p><strong>Full Name:</strong> <?= htmlspecialchars($matchBooking->full_name) ?></p>
				<p><strong>Email Address:</strong> <?= htmlspecialchars($matchBooking->email) ?></p>
				<p><strong>Phone Number:</strong> <?= htmlspecialchars($matchBooking->phone_number) ?></p>
				<p><strong>Number of Guests:</strong> <?= htmlspecialchars($matchBooking->number_of_guests) ?></p>
				<p><strong>Room:</strong> <?= htmlspecialchars($matchBooking->room_number) ?> (<?= $matchBooking->room_type ?>)</p>
				<p><strong>Check-In Date:</strong> <?= $matchBooking->check_in_date ?></p>
				<p><strong>Check-Out Date:</strong> <?= $matchBooking->check_out_date ?></p>
					
				<a href = "Hotel_homepage.php">Back to Home</a>
			<?php endif; ?>
			</center>	
		</div>
		
		<!--Footer Containers-->
		<div id="footer1">
			<a href = "Hotel_homepage.php">Home</a>
		</div>
		
		<div id="footer2">
			<a href = "manager_log_in.php">Management Mode</a>
		</div>
		
	</div>
</body>
</html>
