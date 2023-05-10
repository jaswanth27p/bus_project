<?php
session_start();

try {
    $conn = new mysqli("localhost", "root", "", "busproject");

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        throw new Exception("Error deleting user: operation not allowed");
    }

    $conn->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
