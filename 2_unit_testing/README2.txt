Files:
- test_checkin.php          : Tests db connection and if a user can successfully check in
- test_checkout.php         : Tests if a guest can check out correctly
- test_find_reservation.php : Verifies guest lookup by confirmation number and personal details

How to Run:
    1. Make sure MySQL is running and the `bookings` database is set up.
    2. Ensure the test script can connect to the database (check db_connection.php).
    3. From a terminal, navigate to this folder and run: php test_bookings.php
    4. The script will output PASS or FAIL for each test case.
