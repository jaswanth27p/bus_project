<?php session_start(); 
if (!isset($_SESSION["admin"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar fixed-top bg-body-tertiary">
        <div class="container-fluid">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link " href="#users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#buses">Buses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#routes">Routes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#bookings">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Admin">Admin</a>
                </li>
                <li class="nav-item">
                    <a id="adminlogout" class="nav-link">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        </div>
        <div id="users" class="adminpageforms">
            <div class="container">
                <br>
                <h3>Users</h3><br>
                <?php
            $conn = new mysqli("localhost", "root", "", "busproject");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {

            echo "<div class='table-responsive '><table class=' table table-hover table-bordered table-striped-columns'><tr><th>User ID</th><th>Username</th><th>Email</th><th>Phone</th><th>First Name</th><th>Last Name</th><th>Password</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr class='align-middle'>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["user_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td><button class='btn delete-user-btn' data-user-id='" . $row["user_id"] . "'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</table></div>";
            } else {
            echo "No users found";
            }
            ;?>
                <form class="row gx-3 gy-2 align-items-center user-form">
                    <div class="col-auto">
                        <label class="visually-hidden" for="username">Name</label>
                        <input type="text" class="form-control" name="createuser" id="username" placeholder="User Name">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="createpass" placeholder="Password">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="email">Password</label>
                        <input type="email" class="form-control" id="email" name="createemail" placeholder="email">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="phnNum">Password</label>
                        <input type="number" class="form-control" id="phnNUm" name="phnNum" placeholder="Phone">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="fn">Password</label>
                        <input type="text" class="form-control" id="fn" name="fn" placeholder="First Name">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="ln">Password</label>
                        <input type="text" class="form-control" id="ln" name="ln" placeholder="Last Name">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="add-user-btn">Add User</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div id="buses" class="adminpageforms">
            <div class="container">
                <br>
                <h3>Buses</h3><br>
                <?php
            $conn = new mysqli("localhost", "root", "", "busproject");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM buses";
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {

            echo "<div class='table-responsive '><table class=' table table-hover table-bordered table-striped-columns'><tr><th>Bus ID</th><th>Bus Number</th><th>Bus Driver</th><th>Driver Contact</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr class='align-middle'>";
                echo "<td>" . $row["bus_id"] . "</td>";
                echo "<td>" . $row["bus_number"] . "</td>";
                echo "<td>" . $row["bus_driver"] . "</td>";
                echo "<td>" . $row["driver_contact"] . "</td>";
                echo "<td><button class='btn delete-bus-btn' data-bus-id='" . $row["bus_id"] . "'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</table></div>";
            } else {
            echo "No buses found";
            }
            ;?>
                <form class="row gx-3 gy-2 align-items-center bus-form">
                    <div class="col-auto">
                        <input type="text" class="form-control" name="busnumber" id="busnumber"
                            placeholder="bus number">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" id="busdriver" name="busdriver"
                            placeholder="bus driver">
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control" id="drivercontact" name="drivercontact"
                            placeholder="driver contact">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="add-bus-btn">Add Bus</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div id="routes" class="adminpageforms">
            <div class="container">
                <br>
                <h3>Routes</h3><br>
                <?php
            $conn = new mysqli("localhost", "root", "", "busproject");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM routes";
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {

            echo "<div class='table-responsive '><table class=' table table-hover table-bordered table-striped-columns'><tr><th>Route ID</th><th>Bus ID</th><th>Source</th><th>Destination</th><th>Start Time</th><th>End Time</th><th>Price</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr class='align-middle'>";
                echo "<td>" . $row["route_id"] . "</td>";
                echo "<td>" . $row["bus_id"] . "</td>";
                echo "<td>" . $row["source"] . "</td>";
                echo "<td>" . $row["destination"] . "</td>";
                echo "<td>" . $row["start_time"] . "</td>";
                echo "<td>" . $row["end_time"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td><button class='btn delete-route-btn' data-route-id='" . $row["route_id"] . "'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</table></div>";
            } else {
            echo "No routes found";
            }
            ;?><br>
                <form class=" border row gx-3 gy-2 align-items-center route-form">
                    <div class="col-auto">
                        <select class="form-select" name="bus_id" id="bus_id">
                            <option selected disabled>select bus</option>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "busproject");
                            if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "SELECT bus_id,bus_number FROM buses";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["bus_id"] . '">' . $row["bus_number"] . '</option>';
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="source" id="source">
                            <option selected disabled>source</option>

                            <?php
                        $conn = new mysqli("localhost", "root", "", "busproject");
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT place_name FROM places";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["place_name"] . '">' . $row["place_name"] . '</option>';
                        }
                        $conn->close();
                        ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="destination" id="destination">
                            <option selected disabled>destination</option>

                            <?php
                        $conn = new mysqli("localhost", "root", "", "busproject");
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT place_name FROM places";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["place_name"] . '">' . $row["place_name"] . '</option>';
                        }
                        $conn->close();
                        ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="start_time">Start :</label>
                        <input min="<?php echo (new DateTime())->format('Y-m-d\TH:i:s'); ?>" type="datetime-local"
                            class="form-control" id="start_time" name="start_time">
                    </div>
                    <div class="col-auto">
                        <label for="start_time">End :</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time"
                            min="<?php echo (new DateTime())->format('Y-m-d\TH:i:s'); ?>">
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control" id="price" name="price" placeholder="price">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="add-route-btn">Add Route</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div id="bookings" class="adminpageforms">
            <div class="container">
                <br>
                <h3>Bookings</h3><br>
                <?php
            $conn = new mysqli("localhost", "root", "", "busproject");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM bookings ORDER BY booking_time DESC";
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
            echo "<div class='table-responsive '><table class=' table table-hover table-bordered table-striped-columns'><tr><th>Booking ID</th><th>User ID</th><th>Route ID</th><th>Seats</th><th>contact</th><th>Booking Time</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr class='align-middle'>";
                echo "<td>" . $row["booking_id"] . "</td>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["route_id"] . "</td>";
                echo "<td>" . $row["seats"] . "</td>";
                echo "<td>" . $row["contact"] . "</td>";
                echo "<td>" . $row["booking_time"] . "</td>";
                echo "<td><button class='btn delete-booking-btn' data-booking-id='" . $row["booking_id"] . "'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</table></div>";
            } else {
            echo "No bookings found";
            }
            ;?>
            <br>
            <form class="border row gx-3 gy-2 align-items-center book-form" action="process_booking.php"
                    method="POST">
                    
                    <div class="col-auto">
                        <select class="form-select" name="user_id" id="user_id">
                            <option selected disabled>Select user</option>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "busproject");
                            if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "SELECT user_id, user_name FROM users";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["user_id"] . '">' . $row["user_name"] . '</option>';
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="route_id" id="route_id">
                            <option selected disabled>select route</option>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "busproject");
                            if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "SELECT route_id  FROM routes";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $route_id = $row["route_id"];
                                echo '<option value="' . $route_id . '">' . $route_id . '</option>';
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-auto" id="seats">

                    </div>
                    <div class="col-auto">
                        <input type="tel" class="form-control" id="contact" name="contact" placeholder="Contact number">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="book-btn">Book now</button>
                    </div>
                    
                </form>
            </div>
        </div>
        <hr>
        <div id="Admin" class="adminpageforms">
            <div class="container">
                <br>
                <h3>Admins</h3><br>
                <?php
            $conn = new mysqli("localhost", "root", "", "busproject");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM adminusers";
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {

            echo "<div class='table-responsive '><table class=' table table-hover table-bordered table-striped-columns'><tr><th>Admin ID</th><th>Username</th><th>Password</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr class='align-middle'>";
                echo "<td>" . $row["admin_user_id"] . "</td>";
                echo "<td>" . $row["user_name"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td><button class='btn delete-admin-btn' data-admin-id='" . $row["admin_user_id"] . "'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</table></div>";
            } else {
            echo "No users found";
            }
            ;?>
                <form class="row gx-3 gy-2 align-items-center admin-form">
                    <div class="col-auto">
                        <input type="text" class="form-control" id="admin_user_id" name="user" placeholder="User Name">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" id="adminpassword" name="pass" placeholder="Password">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="add-admin-btn">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        var navbarHeight = $('nav').outerHeight();
        $('.adminpageforms').css('padding-top', navbarHeight);
        $('.popup').css('padding-top', navbarHeight);
        $("#adminlogout").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "adminlogout.php",
                success: function(response) {
                    window.location.href = "index.php";
                }
            });

        });
        $('.delete-user-btn').click(function() {
            var userId = $(this).data('user-id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'admin/delete_user.php',
                    method: 'POST',
                    data: {
                        user_id: userId
                    },
                    success: function(response) {
                        alert(response)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("something went wrong!")
                    }
                });
            }
        });
        $("#add-user-btn").click(function(e) {
            e.preventDefault();
            var formData = $(".user-form").serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: 'signup.php',
                data: formData,
                success: function(response) {
                    if (response.trim() == "done") {
                        alert("Account Created Successfully");
                        location.reload();
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
        $('.delete-bus-btn').click(function() {
            var busId = $(this).data('bus-id');
            if (confirm('Are you sure you want to delete this bus?')) {
                $.ajax({
                    url: 'admin/delete_bus.php',
                    method: 'POST',
                    data: {
                        bus_id: busId
                    },
                    success: function(response) {
                        alert(response)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("something went wrong!")
                    }
                });
            }
        });
        $("#add-bus-btn").click(function(e) {
            e.preventDefault();
            var formData = $(".bus-form").serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: 'admin/add_bus.php',
                data: formData,
                success: function(response) {
                    if (response.trim() == "done") {
                        alert("Bus added Successfully");
                        location.reload();
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
        $("#add-admin-btn").click(function(e) {
            e.preventDefault();
            var formData = $(".admin-form").serialize();
            $.ajax({
                type: 'POST',
                url: 'admin/add_admin.php',
                data: formData,
                success: function(response) {
                    if (response.trim() == "done") {
                        alert("Account Created Successfully");
                        location.reload();
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
        $('.delete-admin-btn').click(function() {
            var adminId = $(this).data('admin-id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'admin/delete_admin.php',
                    method: 'POST',
                    data: {
                        admin_id: adminId
                    },
                    success: function(response) {
                        alert(response)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("something went wrong!")
                    }
                });
            }
        });
        $('.delete-booking-btn').click(function() {
            var bookingId = $(this).data('booking-id');
            if (confirm('Are you sure you want to delete this booking?')) {
                $.ajax({
                    url: 'admin/delete_booking.php',
                    method: 'POST',
                    data: {
                        booking_id: bookingId
                    },
                    success: function(response) {
                        alert(response)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("something went wrong!")
                    }
                });
            }
        });
        $("#add-route-btn").click(function(e) {
            e.preventDefault();
            var formData = $(".route-form").serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: 'admin/add_route.php',
                data: formData,
                success: function(response) {
                    if (response.trim() == "done") {
                        alert("Route added Successfully");
                        location.reload();
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
        $('#route_id').on('change', function() {
            var route_id = $(this).val();
            $.ajax({
                url: 'admin/get_seats.php',
                type: 'POST',
                data: {
                    route_id: route_id
                },
                success: function(data) {
                    $('#seats').html(data);
                }
            });
        });
        $('#book-btn').click(function(e) {
            e.preventDefault();
            var formData = $('.book-form').serialize();
            $.ajax({
                type: 'POST',
                url: 'booking.php',
                data: formData,
                success: function(response) {
                    if (response!="booking failed" && response!="invalid contact"){
                        alert("booking done!");
                        location.reload();
                    }else{
                        alert(response);
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
        $('.delete-route-btn').click(function() {
            var routeId = $(this).data('route-id');
            if (confirm('Are you sure you want to delete this route?')) {
                $.ajax({
                    url: 'admin/delete_route.php',
                    method: 'POST',
                    data: {
                        route_id: routeId
                    },
                    success: function(response) {
                        alert(response)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("something went wrong!")
                    }
                });
            }
        });
    });
    </script>
</body>

</html>