<?php
include '../db_connection.php'; // or however your DB is connected

function testFindBookingByConfirmation($confirmation_number) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE confirmation_number = ?");
    $stmt->bind_param("s", $confirmation_number);
    $stmt->execute();
    $result = $stmt->get_result();
    echo $result->num_rows > 0 ? "PASS\n" : "FAIL\n";
}

echo "Testing valid confirmation number:\n";
testFindBookingByConfirmation("CONF12345");

echo "Testing invalid confirmation number:\n";
testFindBookingByConfirmation("INVALID123");
?>
