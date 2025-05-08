<!--Start session, require manager PIN-->
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookings";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$pin = "1738";
$error = "";
$action = $_GET['action'] ?? null;

// Handle login
if (isset($_POST['submit_login'])) {
    if ($_POST['pin'] === $pin) {
        $_SESSION['manager_logged_in'] = true;
        header("Location: manager_log_in.php?action=dashboard");
        exit();
    } else {
        $error = "Incorrect PIN";
    }
}

// Handle logout
if ($action === "logout") {
    session_destroy();
    header("Location: manager_log_in.php");
    exit();
}

//Redirect
if (!isset($_SESSION['manager_logged_in']) && $action !== null) {
    header("Location: manager_log_in.php");
    exit();
}
?>

<!DOCTYPE html>
<!--Kristen Thomas
	System Implementation
	Final Project
	SPRING 2025-->
<html>
<head>
	<title>Hotel Management System</title>
	
	<!--Stylesheet/CSS-->
	<link rel="stylesheet" type="text/css" href="pages_stylesheet.css">
</head>

<body>
	<div id="container" style="width:900px;">
		<hr>
		
		<!--Title Sections-->
		<div id="titleSection">
			<img src = "hotel-flat-icon-building-and-architecture-vector.jpg" height = '50'; style = "margin-top: 10px;">
		</div>
		<div id="titleSection2">				  
				<h2>Hotel Name</h2>
		</div>
		
		<!-- Management Section-->
		<div id="management">
			<center>
			<!--Log in page-->
			<?php if (!isset($_SESSION['manager_logged_in'])): ?>
                <form method="POST">
				<h2 style = "margin-top: 50px;">Management Log In</h2>
				<table>
				<tr>
					<th>Enter Manager PIN: </th>
					<td><input type="password" name="pin" maxlength="4" required></td>
				</tr>
				</table> <br>
				<input type="submit" name="submit_login" value="Log In">

			</form>
                <?php if ($error) echo "<br><p style='color:#b02328;'>$error</p>"; ?>
            </form>

        <?php elseif ($action === "dashboard" || $action === null): ?>
            
			<!--Management dashboard -->
            <h2 style = "margin-top: 50px;">Management Dashboard</h2>
			<div style="position: absolute; top: 40%; left: 0; width: 100%; text-align: center;">
				<a href="manager_log_in.php?action=edit" class="button" style = "padding: 35px 20px;">Create/Edit Reservation</a>
				<a href="manager_log_in.php?action=kiosk" class="button" style = "padding: 35px 20px;">Manage Kiosk</a>
				<a href="manager_log_in.php?action=search" class="button" style = "padding: 35px 20px;">Search Bookings</a>
				<a href="manager_log_in.php?action=logout" class="button" style = "padding: 35px 20px; background-color:#289487;">Log Out</a>
			</div>

        <?php elseif ($action === "edit"): ?>
            <!-- Create/Edit Reservation page-->
            <h2 style = "margin-top: 50px;">Create or Edit Reservation</h2>
				<form method="POST">
					<table>
						<tr>
							<td>Confirmation Number:</td>
							<td><input type="text" name="confirmation_number" required></td>
						</tr>
						<tr>
							<td>Full Name:</td>
							<td><input type="text" name="full_name" required></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><input type="email" name="email"></td>
						</tr>
						<tr>
							<td>Phone Number:</td>
							<td><input type="text" name="phone_number"></td>
						</tr>
						<tr>
							<td>ID Number:</td>
							<td><input type="text" name="id_number" maxlength="30"></td>
						</tr>
						<tr>
							<td>Number of Guests:</td>
							<td><input type="number" name="number_of_guests"></td>
						</tr>
						<tr>
							<td>Room Number:</td>
							<td><input type="text" name="room_number"></td>
						</tr>
							<tr><td>Room Type:</td>
							<td><input type="text" name="room_type"></td>
						</tr>
						<tr>
							<td>Check-In Date:</td>
							<td><input type="date" name="check_in_date"></td>
						</tr>
						<tr>
							<td>Check-Out Date:</td>
							<td><input type="date" name="check_out_date"></td>
						</tr>
					</table>
					<br>
					<input type="submit" name="save_reservation" value="Save Reservation">
				</form>
				</center>
				<br>
				
				<?php
					if (isset($_POST['save_reservation'])) {
						$confirmation = $_POST['confirmation_number'];
						$full_name = $_POST['full_name'];
						$email = $_POST['email'];
						$phone = $_POST['phone_number'];
						$guests = $_POST['number_of_guests'];
						$room_number = $_POST['room_number'];
						$room_type = $_POST['room_type'];
						$checkin = $_POST['check_in_date'];
						$checkout = $_POST['check_out_date'];

						// Check if booking exists
						$stmt = $conn->prepare("SELECT confirmation_number FROM bookings WHERE confirmation_number = ?");
						$stmt->bind_param("s", $confirmation);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							// Update existing
							$update = $conn->prepare("UPDATE bookings SET full_name=?, email=?, phone_number=?, number_of_guests=?, room_number=?, room_type=?, check_in_date=?, check_out_date=? WHERE confirmation_number=?");
							$update->bind_param("sssssssss", $full_name, $email, $phone, $guests, $room_number, $room_type, $checkin, $checkout, $confirmation);
							$update->execute();
							echo "<p style='color:#289487;'>Reservation updated.</p>";
						} else {
							// Insert new
							$insert = $conn->prepare("INSERT INTO bookings (confirmation_number, full_name, email, phone_number, number_of_guests, room_number, room_type, check_in_date, check_out_date, checked_out) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, FALSE)");
							$insert->bind_param("sssssssss", $confirmation, $full_name, $email, $phone, $guests, $room_number, $room_type, $checkin, $checkout);
							$insert->execute();
							echo "<p style='color:#289487;'>Reservation created.</p>";
						}
					}
					?>

					<div style="position: absolute; bottom: 140px; left: 20px;">
						<a href="manager_log_in.php?action=dashboard">Back to Dashboard</a>
					</div>
			<center>
			
        <?php elseif ($action === "kiosk"): ?>
            <!-- Manage Kiosk -->
            <h2 style = "margin-top: 50px;">Manage Kiosk</h2>
            <p>This section is under construction.</p><br>
            <a href = "manager_log_in.php?action=dashboard"
			  style = "padding: 8px; border-radius: 10px;">Back to Dashboard</a>


        <?php elseif ($action === "search"): ?>
            <!-- Search Bookings -->
            <h2 style = "margin-top: 50px;">Search Bookings</h2>
            <form method="POST">
				<table>
					<tr>
					<td>Enter Any Guest Information:</td>
					<td><input type="text" name="search_term" required></td>
					<tr>
				</table>
				<br>
				<input type="submit" name="search" value="Search">
            </form>

            <?php
				if (isset($_POST['search'])) {
					$search = "%" . $_POST['search_term'] . "%";

					$query = $conn->prepare("SELECT * FROM bookings WHERE 
						full_name LIKE ? OR email LIKE ? OR phone_number LIKE ? OR confirmation_number LIKE ?");
					$query->bind_param("ssss", $search, $search, $search, $search);
					$query->execute();
					$results = $query->get_result();

					if ($results->num_rows > 0) {
						echo "<br><hr style='height:2px; border:none; margin:10px 0;'>";
						echo "<h3 style = 'margin-top:30px;'>Search Results:</h3>";
						while ($row = $results->fetch_assoc()) {
							echo "<p>
								<strong>Name:</strong> {$row['full_name']}<br>
								<strong>Email:</strong> {$row['email']}<br>
								<strong>Phone:</strong> {$row['phone_number']}<br>
								<strong>Room:</strong> {$row['room_number']} ({$row['room_type']})<br>
								<strong>Check-In:</strong> {$row['check_in_date']} | <strong>Check-Out:</strong> {$row['check_out_date']}<br>
								<strong>Confirmation #:</strong> {$row['confirmation_number']}
							</p>";
						}
					} else {
						echo "<br><p>No bookings found.</p>";
					}
				}
            ?>
			</center>
			
			<div style="position: absolute; bottom: 140px; left: 20px;">
				<a href = "manager_log_in.php?action=dashboard"
			      style = "padding: 8px; border-radius: 10px;">Back to Dashboard</a>
			</div>

        <?php endif; ?>
		</div>
		
		<!--Footer Container-->
		<div id="footer1" style = "width:900px;">
			<center><a href = "Hotel_homepage.php"
					  style = "padding: 8px; border-radius: 10px;">Home</a></center>
		</div>
		
	</div>
</body>
</html>
