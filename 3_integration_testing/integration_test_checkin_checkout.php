<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookings";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
include 'db_test_config.php';

function integration_checkin_then_checkout($confirmation, $id_number, $room, $name) {
    global $conn;

    echo "Integration Test: Check-In → Check-Out\n";

    // Reset state
    $conn->query("UPDATE bookings SET id_number = NULL, checked_out = 1 WHERE confirmation_number = '$confirmation'");

    // Simulate Check-In
    $stmt = $conn->prepare("UPDATE bookings SET id_number = ?, checked_out = 0 WHERE confirmation_number = ?");
    $stmt->bind_param("ss", $id_number, $confirmation);
    $stmt->execute();

    // Simulate Check-Out
    $stmt = $conn->prepare("UPDATE bookings SET checked_out = 1 WHERE room_number = ? AND full_name = ?");
    $stmt->bind_param("ss", $room, $name);
    $stmt->execute();

    // Final state check
    $result = $conn->query("SELECT id_number, checked_out FROM bookings WHERE confirmation_number = '$confirmation'");
    $row = $result->fetch_assoc();

    if ($row && $row['id_number'] === $id_number && $row['checked_out'] == 1) {
        echo "✔ PASS: Guest checked in and then checked out successfully.\n";
    } else {
        echo "✖ FAIL: Integration flow failed.\n";
    }
}

integration_checkin_then_checkout("EP1AHZ80YS", "8888888888", "233", "Richard Smith");
?>
