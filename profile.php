<?php session_start(); 
$conn = new mysqli("localhost", "root","", "busproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="profile-card" class="container">
        <div class="card text-center">
            <div class="card-header">
                PROFILE
            </div>
            <div  class="card-body">
                <h5 class="card-title"><?php echo $row["first_name"]." " . $row["last_name"]?></h5>
                <p class="card-text"><?php echo "User Id" . " : " . $row["user_id"]?></p>
                <p class="card-text"><?php echo "User Name" . " : " . $row["user_name"]?></p>
                <p class="card-text"><?php echo "Email" . " : " . $row["email"]?></p>
                <p class="card-text"><?php echo "Contact Number" . " : " . $row["phone"]?></p>
                <a href="index.php" class="btn btn-primary">Home Page</a>
            </div>
            <div class="card-footer text-body-secondary">
                ---
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>