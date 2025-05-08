<?php
	session_start();

	// Database connection
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "bookings";
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$message = "";
	$step = 1;
	$matchedBooking = null;

	// Step 1: Form submission
	if (isset($_POST['submit_checkout'])) {
		$room = trim($_POST['room_number']);
		$fullName = strtolower(trim($_POST['full_name']));

		// Search for booking in the database
		$stmt = $conn->prepare("SELECT * FROM bookings WHERE (room_number = ? OR LOWER(full_name) = ?) AND checked_out = 0");
		$stmt->bind_param("ss", $room, $fullName);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			// Set checkout status to true
			$stmt = $conn->prepare("UPDATE bookings SET checked_out = 1 WHERE confirmation_number = ?");
			$stmt->bind_param("s", $row['confirmation_number']);
			if ($stmt->execute()) {
				$message = "Success! Guest " . htmlspecialchars($row['full_name']) . " has been checked out.";
				$matchedBooking = $row;
				$step = 2;
			} else {
				$message = "Error updating checkout status.";
			}
		} else {
			$message = "No matching reservation found.";
		}
	}
?>

<!DOCTYPE html>
<!--Kristen Thomas
	System Implementation
	Final Project
	SPRING 2025-->
<html>
<head>
	<title>Express Checkout</title>
	
	<!--Stylesheet/CSS-->
	<link rel="stylesheet" type="text/css" href="pages_stylesheet.css">
</head>

<body>
	<div id="container" style="width:900px;">
		<hr style = "height:10px; background-color: #5b94bd; margin:0px;">
		
		
		<div id="titleSection">
			<img src = "hotel-flat-icon-building-and-architecture-vector.jpg" height = '50';>
		</div>
		<div id="titleSection2">				  
				<h2>Hotel Name</h2>
		</div>
		
		<div id="checkOut" style="background-color: white; height:550px; width:900px; float:left;">
            <?php if (!empty($message)): ?>
                <p class="error"><?= $message ?></p>
            <?php endif; ?>

            <center>
                <h2 style="margin-top: 50px;">Express Check Out</h2>

                <?php if ($step === 1): ?>
                    <p>Please enter your room number and last name to Check Out:</p>
                    <form method="POST">
                        <table style="margin-top: 50px;">
                            <tr>
                                <td>Enter Room Number:</td>
                                <td><input type="text" name="room_number" required></td>
                            </tr>
                            <tr>
                                <td>Enter Full Name:</td>
                                <td><input type="text" name="full_name" required></td>
                            </tr>
                        </table><br>
                        <input type="submit" name="submit_checkout" value="Check Out">
                    </form>

                <?php elseif ($step === 2 && $matchedBooking): ?>
                    <p class="success" style="margin-top: 20px;">Success! Guest <?= htmlspecialchars($matchedBooking['full_name']) ?> has been checked out.</p>
                    <p><strong>Room:</strong> <?= htmlspecialchars($matchedBooking['room_number']) ?> (<?= htmlspecialchars($matchedBooking['room_type']) ?>)</p>
                    <p><strong>Check-Out Status:</strong> <?= $matchedBooking['checked_out'] == 0 ? "Checked Out" : "Not Checked Out" ?></p>
                    
                    <a href="Hotel_homepage.php">Back to Home</a>
                <?php endif; ?>
            </center>
        </div>
		
		<!--Footer Containers-->
		<div id="footer1">
			<a href = "Hotel_homepage.php">Home</a>
		</div>
		
		<div id="footer2">
			<center><a href = "manager_log_in.php">Management Mode</a></center>
		</div>
		
	</div>
</body>
</html>
