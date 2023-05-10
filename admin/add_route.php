<?php
session_start();
$conn = new mysqli("localhost", "root", "", "busproject");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = trim($_POST['bus_id']);
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);
    $price = ($_POST['price']);
    $start = ($_POST['start_time']);
    $end = ($_POST['end_time']);
    if ($price < 0) {
        echo "price should be positive";
        exit;
    }
    if ($start > $end) {
        echo "start should be less than end";
        exit;
    }
    if ($source==$destination) {
        echo "source and destination should not be same";
        exit;
    }

    $sql = "INSERT INTO routes (bus_id, source, destination, price, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $bus_id, $source, $destination, $price, $start, $end);
    if ($stmt->execute()) {
        $route_id = $stmt->insert_id; 
        for ($i = 1; $i <= 20; $i++) {
            $sql = "INSERT INTO seats (route_id, seat_id, available) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $route_id, $i, $available);
            $available = 1; 
            $stmt->execute();
        }
        echo "done";
    } else {
        echo "Error : " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
