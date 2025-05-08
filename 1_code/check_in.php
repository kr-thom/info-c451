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

$step = 1;
$message = "";
$matchBooking = null;

// Step 1: Enter confirmation number
if (isset($_POST['submit_confirm'])) {
    $confirmation_number = $_POST['confirmation_number'];

    $stmt = $conn->prepare("SELECT * FROM bookings WHERE confirmation_number = ?");
    $stmt->bind_param("s", $confirmation_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['confirmation_number'] = $confirmation_number;
        $_SESSION['booking_data'] = json_encode($row);
        $step = 2;
    } else {
        $message = "Confirmation number not found.";
    }
}

// Step 2: Enter ID number and mark as checked in
if (isset($_POST['submit_id'])) {
    $id_number = $_POST['id_number'];

    if (isset($_SESSION['confirmation_number'])) {
        $confirmation_number = $_SESSION['confirmation_number'];

        // Fetch booking to confirm status
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE confirmation_number = ?");
        $stmt->bind_param("s", $confirmation_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Only update if not already checked out (checked_out = 1 means checked out)
            if ($row['checked_out'] == 1) {
                // Update checked_out field to 0 (indicating they are checked in)
                $stmt = $conn->prepare("UPDATE bookings SET id_number = ?, checked_out = 0 WHERE confirmation_number = ?");
                $stmt->bind_param("ss", $id_number, $confirmation_number);
                if ($stmt->execute()) {
                    $message = "Check-In Complete! Your ID has been saved.";
                } else {
                    $message = "Failed to update check-in status.";
                }
            } else {
                $message = "Check-In Complete!";
            }

            $matchBooking = $row;
            $matchBooking['id_number'] = $id_number; // For display
            $step = 3;
        }
        unset($_SESSION['confirmation_number']);
        unset($_SESSION['booking_data']);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Check In</title>
    <link rel="stylesheet" type="text/css" href="pages_stylesheet.css">
</head>
<body>
    <div id="container" style="width:900px;">
        <hr>
        <!-- Title Section -->
        <div id="titleSection">
            <img src="hotel-flat-icon-building-and-architecture-vector.jpg" height="50" style="margin-top: 10px;">
        </div>

        <div id="titleSection2">
            <h2>Hotel Name</h2>
        </div>

        <!-- Check-In Main Section -->
        <div id="checkIn">
            <center>

            <?php if ($step === 1): ?>
                <h2 style="margin-top: 50px;">Check In</h2>
                <form method="POST">
                    <table>
                        <tr>
                            <th>Enter Confirmation Number: </th>
                            <td><input type="text" name="confirmation_number" maxlength="10" required></td>
                        </tr>
                    </table><br>
                    <input type="submit" name="submit_confirm" value="Next">
                </form>
                <?php if ($message) echo "<p style='color:#b02328;'>$message</p>"; ?>

            <?php elseif ($step === 2): ?>
                <h3>Confirmation Number Found</h3>
                <form method="POST">
                    <table style="font-family:Arial; font-size:14px; color:#1c5178; margin-top: 70px;">
                        <tr>
                            <th>Enter ID Number: </th>
                            <td><input type="text" name="id_number" maxlength="20" required></td>
                        </tr>
                    </table><br>
                    <input type="submit" name="submit_id" value="Check In">
                </form>

            <?php elseif ($step === 3 && $matchBooking): ?>
                <h3><?= $message ?></h3>
                <p><strong>Full Name:</strong> <?= htmlspecialchars($matchBooking['full_name']) ?></p>
                <p><strong>Email Address:</strong> <?= htmlspecialchars($matchBooking['email']) ?></p>
                <p><strong>Phone Number:</strong> <?= htmlspecialchars($matchBooking['phone_number']) ?></p>
                <p><strong>Number of Guests:</strong> <?= htmlspecialchars($matchBooking['number_of_guests']) ?></p>
                <p><strong>Room:</strong> <?= htmlspecialchars($matchBooking['room_number']) ?> (<?= htmlspecialchars($matchBooking['room_type']) ?>)</p>
                <p><strong>Check-In Date:</strong> <?= htmlspecialchars($matchBooking['check_in_date']) ?></p>
                <p><strong>Check-Out Date:</strong> <?= htmlspecialchars($matchBooking['check_out_date']) ?></p>
                <p><strong>Check-Out Status:</strong> <?= $matchBooking['checked_out'] == 0 ? "Checked In" : "Checked Out" ?></p>
                <a href="Hotel_homepage.php">Back to Home</a>
            <?php endif; ?>

            </center>
        </div>

        <!-- Footer -->
        <div id="footer1">
            <a href="Hotel_homepage.php">Home</a>
        </div>

        <div id="footer2">
            <a href="manager_log_in.php">Management Mode</a>
        </div>

    </div>
</body>
</html>
