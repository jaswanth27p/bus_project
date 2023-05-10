<?php
session_start();

try {
    $conn = new mysqli("localhost", "root", "", "busproject");

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $admin_id = $_POST['admin_id'];

    $sql = "DELETE FROM adminusers WHERE admin_user_id = '$admin_id'";

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
