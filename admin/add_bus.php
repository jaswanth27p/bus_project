<?php
session_start();
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $busdriver = trim($_POST['busdriver']);
    $busnumber = trim($_POST['busnumber']);
    $phnNum = ($_POST['drivercontact']);
    if (empty($busnumber)) {
        echo "bus number is required";
        exit;
    }
    if (empty($busdriver)) {
        echo "driver name is required";
        exit;
    }
    if (!preg_match("/^[0-9]{10}$/", $phnNum)) {
        echo "Invalid phone number";
        exit;
    }
    $sql = "SELECT * FROM buses WHERE bus_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $busnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "bus already exists";
    }else {
        $sql = "INSERT INTO buses (bus_number, bus_driver, driver_contact ) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $busnumber, $busdriver,$phnNum );
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