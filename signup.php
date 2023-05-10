<?php
session_start();
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['createuser']);
    $password = $_POST['createpass'];
    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'http://localhost/bus/admin.php') {
        $cpassword = $_POST['createpass'];
    }else{
        $cpassword = $_POST['createpass2'];
    }
    $fname = trim($_POST['fn']);
    $lname = trim($_POST['ln']);
    $email = trim($_POST['createemail']);
    $phnNum = trim($_POST['phnNum']);
    if (empty($fname)) {
        echo "First name is required";
        exit;
    }
    if (empty($lname)) {
        echo "Last name is required";
        exit;
    }
    if (!preg_match("/^[0-9]{10}$/", $phnNum)) {
        echo "Invalid phone number";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "User already exists";
    } elseif ($password != $cpassword) {
        echo "Password and confirm password must be the same";
    }elseif (strlen($password) < 8) {
        echo "Password must be at least 8 characters long"; 
    }else {
        $sql = "INSERT INTO users (user_name, email, phone, first_name, last_name, password) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $username, $email, $phnNum, $fname, $lname, $password);
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