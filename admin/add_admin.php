<?php
session_start();
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = trim($_POST['user']);
    $pass = trim($_POST['pass']);
     
    if (empty($user_id)) {
        echo "user name is required";
        exit;
    }
    if (empty($pass)) {
        echo "password is required";
        exit;
    }
    $sql = "SELECT * FROM adminusers WHERE admin_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "user already exists";
    }else {
        $sql = "INSERT INTO adminusers (user_name, password ) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_id, $pass );
        if ($stmt->execute()) {
            echo "done";
        } else {
            echo "Error : " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}

?>