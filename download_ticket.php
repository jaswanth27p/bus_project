<?php session_start(); 
$booking_id = $_GET['booking_id'];
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
$sql = "SELECT bookings.booking_id, bookings.seats, bookings.booking_time, bookings.contact, bookings.route_id, routes.source, routes.destination, routes.start_time, routes.end_time, routes.price, buses.bus_number, buses.driver_contact, buses.bus_driver 
        FROM bookings
        INNER JOIN routes ON bookings.route_id = routes.route_id
        INNER JOIN buses ON routes.bus_id = buses.bus_id
        WHERE bookings.booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticket</title>
	<style>
		.ticket {
			border: 1px solid black;
			padding: 10px;
			width: 300px;
			margin: auto;
			font-family: Arial, sans-serif;
			font-size: 14px;
		}

		h2, h3 {
			margin: 0;
			padding: 0;
			text-align: center;
		}

		.ticket-info {
			margin-top: 20px;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			font-size: 16px;
		}

		.row {
			display: flex;
			flex-direction: row;
			justify-content: space-between;
			width: 100%;
			margin-top: 10px;
		}

		.label {
			font-weight: bold;
		}

		.value {
			margin-left: 10px;
		}
	</style>
</head>
<body>
	<div class="ticket">
		<h2>Ticket</h2>
		<h3>Booking ID: <?php echo $row['booking_id']; ?></h3>
		<div class="ticket-info">
			<div class="row">
				<span class="label">Route:</span>
				<span class="value"><?php echo $row['source']; ?> - <?php echo $row['destination']; ?></span>
			</div>
			<div class="row">
				<span class="label">Date and time:</span>
				<span class="value"><?php echo $row['start_time']; ?> - <?php echo $row['end_time']; ?></span>
			</div>
			<div class="row">
				<span class="label">Bus:</span>
				<span class="value"><?php echo $row['bus_number']; ?></span>
			</div>
			<div class="row">
				<span class="label">Driver:</span>
				<span class="value"><?php echo $row['bus_driver']; ?></span>
			</div>
			<div class="row">
				<span class="label">Contact:</span>
				<span class="value"><?php echo $row['driver_contact']; ?></span>
			</div>
			<div class="row">
				<span class="label">Seats:</span>
				<span class="value"><?php echo implode(",", json_decode($row['seats'])); ?></span>
			</div>
			<div class="row">
				<span class="label">Price:</span>
				<span class="value"><?php echo $row['price'] * count(json_decode($row['seats'])); ?></span>
			</div>
		</div>
	</div>
</body>
</html>
