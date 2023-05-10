<?php
session_start();

try {
    $conn = new mysqli("localhost", "root", "", "busproject");

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $bus_id = $_POST['bus_id'];

    $sql = "DELETE FROM buses WHERE bus_id = '$bus_id'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        throw new Exception("Error deleting user");
    }
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
