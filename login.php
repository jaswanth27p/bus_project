
<?php
session_start();
$validation=true;
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST["loginusername"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $validation=false;
    }else {
        $row = $result->fetch_assoc();
        if ($row["password"]!=$_POST["loginpass"]){
            $validation=false;
        }
    }
    $stmt->close();
    $conn->close();
if ($validation){
    $_SESSION["username"]=$_POST["loginusername"];
    $_SESSION["user_id"]=$row["user_id"];
    echo "done";
}else{
    echo "failed";
}
?> 
