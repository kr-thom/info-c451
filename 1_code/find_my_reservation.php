<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookings";
$conn = new mysqli($servername, $username, $password, $database);
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

// Step 2: Verify personal info and check the reservation status
if (isset($_POST['submit_verify'])) {
    $name = trim($_POST['full_name']);
    $phone = trim($_POST['phone_number']);
    $email = trim($_POST['email']);

    if (isset($_SESSION['booking_data'])) {
        $booking = json_decode($_SESSION['booking_data'], true);
        if (
            strtolower($booking['full_name']) === strtolower($name) &&
            $booking['phone_number'] === $phone &&
            strtolower($booking['email']) === strtolower($email)
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

<!DOCTYPE html>
<html>
<head>
    <title>Find Reservation</title>
    <link rel="stylesheet" type="text/css" href="pages_stylesheet.css">
</head>

<body>
    <div id="container" style="width:900px;">
        <hr>
        <!--Title Divs-->
        <div id="titleSection">
            <img src="hotel-flat-icon-building-and-architecture-vector.jpg" height="50" style="margin-top: 10px;">
        </div>
        
        <div id="titleSection2">                      
            <h2>Hotel Name</h2>
        </div>

        <!--Main Div for Find My Reservation-->
        <div id="reservationOptions">
            <center>

            <?php if ($step === 1): ?>
                <h2 style="margin-top: 50px;">Find My Reservation</h2>
                <form method="POST">
                    <table>
                        <tr>
                            <td>Enter Confirmation Number: </td>
                            <td><input type="text" name="confirmation_number" required></td>
                        </tr>
                    </table><br>
                    <input type="submit" name="submit_confirm" value="Next">
                </form>
                <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>

            <?php elseif ($step === 2): ?>
                <h2>Verify Your Information</h2>
                <form method="POST">
                    <table>
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
                    </table><br>
                    <input type="submit" name="submit_verify" value="Confirm">
                </form>
                <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>

            <?php elseif ($step === 3 && $matchBooking): ?>
                <h4>Reservation Details</h4>
                <p>Your reservation was successfully verified:</p>
                <p><strong>Name:</strong> <?= htmlspecialchars($matchBooking['full_name']) ?></p>
                <p><strong>Room:</strong> <?= htmlspecialchars($matchBooking['room_number']) ?> (<?= htmlspecialchars($matchBooking['room_type']) ?>)</p>
                <p><strong>Check-In:</strong> <?= htmlspecialchars($matchBooking['check_in_date']) ?></p>
                <p><strong>Check-Out:</strong> <?= htmlspecialchars($matchBooking['check_out_date']) ?></p>
                <p><strong>Check-In Status:</strong> <?= $matchBooking['checked_out'] == 0 ? "Checked In" : "Checked Out" ?></p>
                
                <a href="Hotel_homepage.php">Back to Home</a>
            <?php endif; ?>

            </center>
        </div>

        <!--Footer-->
        <div id="footer1">
            <a href="Hotel_homepage.php">Home</a>
        </div>

        <div id="footer2">
            <center><a href="manager_log_in.php">Management Mode</a></center>
        </div>
        
    </div>
</body>
</html>
