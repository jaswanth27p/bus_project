<?php
session_start();
try {
    $conn = new mysqli("localhost", "root", "", "busproject");
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $route_id = $_POST['route_id'];

    // Check if all seats are available for the given route_id
    $sql = "SELECT COUNT(*) AS count FROM seats WHERE route_id = ? AND available = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $route_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Get total number of seats for the given route_id
    $sql = "SELECT COUNT(*) AS count FROM seats WHERE route_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $route_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_seats = $row['count'];

    if ($count == $total_seats) {
        // All seats are available, delete both route and seats
        $sql = "DELETE FROM routes WHERE route_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $route_id);
        if ($stmt->execute()) {
            echo "route deleted successfully";
        } else {
            throw new Exception("Error deleting route");
        }
    } else {
        throw new Exception("Cannot delete route: some seats are booked");
    }
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>