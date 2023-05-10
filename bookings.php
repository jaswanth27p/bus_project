<?php
session_start();
if (!isset($_SESSION["username"])){
    header("Location: index.php");
}
$conn = new mysqli("localhost", "root", "", "busproject");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT bookings.booking_id, bookings.seats, bookings.booking_time,bookings.contact,bookings.route_id,routes.source, routes.destination, routes.start_time, routes.end_time, routes.price, buses.bus_number, buses.driver_contact,buses.bus_driver 
        FROM bookings
        INNER JOIN routes ON bookings.route_id = routes.route_id
        INNER JOIN buses ON routes.bus_id = buses.bus_id
        WHERE bookings.user_id = ? ORDER BY bookings.booking_time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img
                    src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/bus-design-template-8c93bb9e0e8495ef91938dc7f1aa641d_screen.jpg?ts=1581069350"
                    alt="Logo" width="40" height="34" class="d-inline-block align-text-center">Bus Booking</a>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="table-responsive">
            <?php if ($result->num_rows > 0) { // check if there are any rows returned ?>
            <table class="table table-hover table-bordered table-striped-columns">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Route Number</th>
                        <th>Bus Number</th>
                        <th>Seats</th>
                        <th>Booking Time</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Price</th>
                        <th>Driver Name</th>
                        <th>Driver Contact</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) {
                            $seats = json_decode($row['seats']);
                            $num_seats = count($seats);
                            $price = $row['price'] * $num_seats;
                        ?>
                    <tr class="align-middle">
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['route_id']; ?></td>
                        <td><?php echo $row['bus_number']; ?></td>
                        <td><?php echo implode(",", $seats); ?></td>
                        <td><?php echo $row['booking_time']; ?></td>
                        <td><?php echo $row['source']; ?></td>
                        <td><?php echo $row['destination']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['end_time']; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $row['bus_driver']; ?></td>
                        <td><?php echo $row['driver_contact']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><button class="download-btn"
                                data-booking-id="<?php echo $row['booking_id']; ?>">Download</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else {?>
            <p>No bookings found.</p>
            <?php } ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $(".download-btn").click(function() {
            var booking_id = $(this).data("booking-id");
            $.ajax({
                url: 'download_ticket.php?booking_id=' + booking_id,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    var a = window.open('', '', 'height=500, width=500');
                    a.document.write(response);
                    a.document.close();
                    a.print();  
                }
            });
        });
    });
    </script>
</body>

</html>