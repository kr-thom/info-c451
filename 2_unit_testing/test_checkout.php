//Test check out process
<?php
include 'db_test_config.php';

function test_checkout($room, $name) {
    global $conn;

    // Set it to checked-in first
    $conn->query("UPDATE bookings SET checked_out = 0 WHERE room_number = '$room' AND full_name = '$name'");

    $stmt = $conn->prepare("UPDATE bookings SET checked_out = 1 WHERE room_number = ? AND full_name = ?");
    $stmt->bind_param("ss", $room, $name);
    $stmt->execute();

    $result = $conn->query("SELECT checked_out FROM bookings WHERE room_number = '$room' AND full_name = '$name'");
    $row = $result->fetch_assoc();

    if ($row && $row['checked_out'] == 1) {
        echo "Check-Out Test: PASS\n";
    } else {
        echo "Check-Out Test: FAIL\n";
    }
}

test_checkout("233", "Richard Smith");
?>
