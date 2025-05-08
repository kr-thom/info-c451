//Test database connection
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookings"; // use a test database if possible

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

//test check in process
<?php
include 'db_test_config.php';

function test_checkin($confirmation, $id_number) {
    global $conn;

    // Set up the test row
    $conn->query("UPDATE bookings SET id_number = NULL, checked_out = 1 WHERE confirmation_number = '$confirmation'");

    $stmt = $conn->prepare("UPDATE bookings SET id_number = ?, checked_out = 0 WHERE confirmation_number = ?");
    $stmt->bind_param("ss", $id_number, $confirmation);
    $stmt->execute();

    $result = $conn->query("SELECT id_number, checked_out FROM bookings WHERE confirmation_number = '$confirmation'");
    $row = $result->fetch_assoc();

    if ($row['id_number'] === $id_number && $row['checked_out'] == 0) {
        echo "Check-In Test: PASS\n";
    } else {
        echo "Check-In Test: FAIL\n";
    }
}

test_checkin("EFGAKJ11YS", "9999999999");
?>
