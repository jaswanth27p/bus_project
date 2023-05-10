<?php
session_start();
$conn = new mysqli("localhost", "root","", "busproject");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/bus/admin.php') {
    $sql = "SELECT user_id FROM users WHERE user_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $un = $result->fetch_assoc();
}

$sql = "INSERT INTO bookings (user_id, route_id, seats, contact) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/bus/admin.php') {
    $user_id = $un["user_id"];
}else{
    $user_id = $_POST["user_id"];
}

$route_id = $_POST["route_id"];
$contact = $_POST["contact"];
$seats = json_encode($_POST["seats"]);
$contact = preg_replace('/[^0-9]/', '', $contact);
if (strlen($contact) != 10) {
    echo "invalid contact";
    exit;
}
$stmt->bind_param("iiss", $user_id, $route_id, $seats, $contact);
$status = $stmt->execute();
$booking_id = $stmt->insert_id;
foreach($_POST["seats"] as $seat){
    $stmt3 = $conn->prepare("UPDATE seats SET available = 0 WHERE route_id = ? AND seat_id = ?");
    $stmt3->bind_param("ii", $route_id, $seat);
    $stmt3->execute();
}
$stmt->close();
$conn->close();
if ($status){
    echo $booking_id;
}else{
    echo "booking failed";
}

?>
