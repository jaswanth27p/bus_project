<?php
session_start();
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM places";
    $result = $conn->query($sql);
    $conn->close();
    $places = array();
    while ($row = $result->fetch_assoc()) {
        $places[] = $row['place_name'];
    }
    $_SESSION["places"] = $places;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Bus Booking</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar  bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img
                    src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/bus-design-template-8c93bb9e0e8495ef91938dc7f1aa641d_screen.jpg?ts=1581069350"
                    alt="Logo" width="40" height="34" class="d-inline-block align-text-center">Bus Booking</a>
            <div class="d-flex">
                <button <?php if (isset($_SESSION["username"])) {
              echo "style='display:none'";
            }
            ?> id="signin" class="btn btn-outline-success me-2" type="button">Sign
                    In</button>
                <div <?php if (!isset($_SESSION["username"])) {
              echo "style='display:none'";
            }
            ?> class="profile">
                    <div class="dropstart">
                        <button class=" navbar-toggler btn btn-secondary" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                            <li><a class="dropdown-item" id="signout">Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="popup" style="display:none">
        <div style="display:none" class="popup-container login-form">
            <h3>Log In</h3>
            <button class="btn btn-outline-danger loginCancle">X</button>
            <form>
                <input required type="text" name="loginusername" id="loginusername" placeholder="Username">
                <input required type="password" name="loginpass" id="loginpass" placeholder="Password">
                <button type="button" class="btn btn-outline-success" id="userlogin">Log In</button>
            </form>
            <button id="newAcc" class="btn info">New User</button>
            <button id="admin" class="btn info">Admin Login</button>
        </div>
        <div style="display:none" class="popup-container create-form">
            <h3>Create Account</h3>
            <button class="btn btn-outline-danger loginCancle">X</button>
            <form>
                <input required type="text" name="createuser" id="createuser" placeholder="Username">
                <input required type="email" name="createemail" id="createemail" placeholder="example@gmail.com">
                <input required type="tel" name="phnNum" id="phnNum" placeholder="ex : 9876123450">
                <input required type="text" name="fn" id="fn" placeholder="Full Name">
                <input required type="text" name="ln" id="ln" placeholder="Last Name">
                <input required type="password" name="createpass" id="createpass" placeholder="Password">
                <input required type="password" name="createpass2" id="createpass2" placeholder="Conform Password">
                <button type="button" class="btn btn-outline-success createacc" id="createUser">Create Account</button>
            </form>
        </div>
        <div class="popup-container admin-form" style="display:none">
            <h3>Admin</h3>
            <button class="btn btn-outline-danger loginCancle">X</button>
            <form>
                <input type="text" name="adminusername" id="adminusername" placeholder="Username">
                <input type="password" name="adminpass" id="adminpass" placeholder="Password">
                <button type="button" class="btn btn-outline-success" id="adminlogin">Log In</button>
            </form>
        </div>
    </div>
    <div class="form-container">
        <form id="main-form" action="buslistprocess.php" method="post">
            <label>From</label>
            <select required From="main-form" name="from" class="form-select" aria-label="Default select example">
                <option disabled selected value="">Select From Destination</option>
                <option value="0">Vijayawada</option>
                <option value="1">Vizag</option>
                <option value="2">Hyderabad</option>
                <option value="3">Warangal</option>
                <option value="4">Tirupati</option>
            </select>
            <label>To</label>
            <select required name="to" id="toDest" class="form-select" aria-label="Default select example">
                <option disabled selected value="">Select To Destination</option>
                <option value="0">Vijayawada</option>
                <option value="1">Vizag</option>
                <option value="2">Hyderabad</option>
                <option value="3">Warangal</option>
                <option value="4">Tirupati</option>
            </select>
            <input required type="date" name="Date" id="Date" min="<?= date('Y-m-d'); ?>">
            <input id="search" class="btn btn-outline-primary" type="submit" value="Search">
        </form>
    </div>
    <br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(function() {
        $("#admin").click(function(e) {
            e.preventDefault();
            $(".login-form").hide();
            $(".admin-form").show();
            $(".create-form").hide();
        });
        $("#signin").click(function(e) {
            e.preventDefault();
            $(".popup").show();
            $(".login-form").show();

        });
        $("#newAcc").click(function(e) {
            e.preventDefault();
            $(".login-form").hide();
            $(".admin-form").hide();
            $(".create-form").show();

        });
        $(".loginCancle").click(function(e) {
            e.preventDefault();
            $(".popup").hide();
            $(".login-form").hide();
            $(".create-form").hide();
            $(".admin-form").hide();

        });
        $("#userlogin").click(function(e) {
            e.preventDefault();
            var formData = $(this).parent().serialize();
            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.trim() == "done") {
                        console.log("Success!");
                        alert("login success!");
                    } else {
                        console.log("Error!");
                        alert("login failed!");
                    }
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("something went wrong!")
                }
            });
        });
        $("#adminlogin").click(function(e) {
            e.preventDefault();
            var formData = $(this).parent().serialize();
            $.ajax({
                type: 'POST',
                url: 'adminlogin.php',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $(".popup").hide();
                    $(".login-form").hide();
                    $(".create-form").hide();
                    $(".admin-form").hide();
                    if (response.trim() == "done") {
                        console.log("Success!");
                        alert("login success!");
                        window.location.href = "admin.php";
                    } else {
                        console.log("Error!");
                        alert("login failed!");
                    }


                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("something went wrong!")
                }
            });
        });
        $("#createUser").click(function(e) {
            e.preventDefault();
            var formData = $(this).parent().serialize();
            $.ajax({
                type: 'POST',
                url: 'signup.php',
                data: formData,
                success: function(response) {
                    if (response.trim() == "done") {
                        alert("Account Created Successfully");
                        $(".popup").show();
                        $(".login-form").show();
                        $(".create-form").hide();
                        $(".admin-form").hide();
                    } else {
                        alert(response);
                    }

                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("something went wrong!")
                }
            });
        });
        $("#signout").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'signout.php',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $("#main-form").submit(function(e) {
            if (!
                <?php
                if(isset($_SESSION['username'])){
                    echo "true";
                   } else {
                    echo "false";
                   }
                ?>
            ) {
                alert("please login before searching")
                e.preventDefault();
            }
        });
    });
    </script>

</body>

</html>