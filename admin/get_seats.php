<?php
session_start();
$conn = new mysqli("localhost", "root", "", "busproject");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$route_id = $_POST['route_id'];
$stmt = $conn->prepare("SELECT * FROM seats WHERE route_id=?");
$stmt->bind_param("s", $route_id);
$stmt->execute();
$seats = $stmt->get_result();

$counter = 0;
$counter2 = 0;
while ($seat_row = $seats->fetch_assoc()) {
    $availability = ($seat_row["available"] == 0) ? 'disabled' : '';
    echo '<input class="seat-checkbox" type="checkbox" value="' . $seat_row["seat_id"] . '" name="seats[]" ' . $availability . '>';
    $counter++;
    $counter2++;
    if ($counter == 5) {
        echo '<div class="col-12"></div>';
        $counter = 0;
    }
    if ($counter2 == 10) {
        echo '<hr>';
    }
}
$conn->close();
?>
