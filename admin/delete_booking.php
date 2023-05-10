<?php
session_start();
try {
    $conn = new mysqli("localhost", "root", "", "busproject");
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $booking_id = $_POST['booking_id'];

    // Get seats from bookings table
    $query = "SELECT seats, route_id FROM bookings WHERE booking_id = '$booking_id'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        throw new Exception("No booking found with booking ID $booking_id");
    }

    $row = $result->fetch_assoc();
    $seats = json_decode($row['seats'], true);
    $route_id = $row['route_id'];

    // Delete booking from bookings table
    $sql = "DELETE FROM bookings WHERE booking_id = '$booking_id'";
    if ($conn->query($sql) !== TRUE) {
        throw new Exception("Error deleting booking");
    }

    // Set available=1 in seats table for each seat in the booking
    foreach ($seats as $seat){
        $sql = "UPDATE seats SET available=1 WHERE route_id=$route_id AND seat_id=$seat";
        if ($conn->query($sql) !== TRUE) {
            throw new Exception("Error updating seats");
        }
    }

    echo "Booking deleted successfully";
    
    $conn->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
