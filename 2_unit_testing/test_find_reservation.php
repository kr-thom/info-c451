//Test find reservation
<?php
include 'db_test_config.php';

function test_find_reservation($confirmation, $name, $email, $phone) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM bookings WHERE confirmation_number = ?");
    $stmt->bind_param("s", $confirmation);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row &&
        strtolower($row['full_name']) === strtolower($name) &&
        strtolower($row['email']) === strtolower($email) &&
        $row['phone_number'] === $phone) {
        echo "Find Reservation Test: PASS\n";
    } else {
        echo "Find Reservation Test: FAIL\n";
    }
}

test_find_reservation("EP1AHZ80YS", "Richard Smith", "rich@gmail.com", "555-123-4567");
?>
