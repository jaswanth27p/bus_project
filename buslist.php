<?php session_start(); 
$arr=$_SESSION["places"];
if (isset($_SESSION['from-to'])){
    $formData = $_SESSION['from-to'];
    $from = $formData['from'];
    $to = $formData['to'];
    unset($_SESSION['from-to']);
}else{
    header("Location: index.php");
}
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM routes WHERE source = ? and destination = ?  and Date(start_time)=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss",$arr["$from"],$arr["$to"],$formData["Date"]);
    $stmt->execute();
    $result = $stmt->get_result(); 
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
    <title>Bus</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img
                    src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/bus-design-template-8c93bb9e0e8495ef91938dc7f1aa641d_screen.jpg?ts=1581069350"
                    alt="Logo" width="40" height="34" class="d-inline-block align-text-center">Bus Booking</a>
        </div>
    </nav>
    <h1 class="hcenter"><?php echo  $arr["$from"] . " to " . $arr["$to"]?></h1>
    <div class="container ">
        <div class="col-12">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="c">
                <div class="card-body">
                    <h5 class="card-title">route number <?php echo $row["route_id"]; ?></h5>
                    <p class="card-text"><?php echo $row["source"] . ' to ' . $row["destination"]; ?></p>
                    <p class="card-text"><?php echo $row["start_time"] . ' to ' . $row["end_time"]; ?></p>
                    <p class="card-text"><?php echo 'Price : '.$row["price"]; ?></p>
                    <?php
                    $conn = new mysqli("localhost", "root","", "busproject");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM seats WHERE route_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s",$row["route_id"]);
                    $stmt->execute();
                    $seats = $stmt->get_result();
                    ?>
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="<?php echo '#'.$row["route_id"]; ?>"
                        role="button" aria-expanded="false" aria-controls="<?php echo $row["route_id"]; ?>">Select
                        Seats</a>
                    <div class="collapse" id="<?php echo $row["route_id"]; ?>">
                        <div class=" seat-card card card-body">
                            <form class="seat-form" action="paymentprocess.php" method="post">
                                <input style="display:none" checked type="checkbox"
                                    value="<?php echo $row["route_id"]; ?>" name="bus">
                                <input style="display:none" checked type="checkbox" value="<?php echo $row["price"]; ?>"
                                    name="price">
                                <?php 
                                $counter = 0;
                                $counter2=0;
                                while ($seat_row = $seats->fetch_assoc()): 
                                    $availability = ($seat_row["available"] == 0) ? 'disabled' : '';
                                    echo '<input class="seat-checkbox" type="checkbox" value="'.$seat_row["seat_id"].'" name="seats[]" '.$availability.'>';
                                    $counter++;
                                    $counter2++;
                                    if ($counter == 5) {
                                        echo '<div class="col-12"></div>'; 
                                        $counter = 0;
                                    }
                                    if ($counter2==10){
                                        echo '<hr>';
                                    }
                                endwhile; 
                            ?>
                                <p class="totalprice">total price : 0</p>
                                <input class="btn btn-primary" type="submit" value="Continue">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <br><br>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        $(document).ready(function() {
            $('.seat-checkbox').change(function() {
                var form = $(this).closest('form');
                var total = form.find('.totalprice');
                var price = form.find('input[name="price"]').val();
                var numChecked = form.find('.seat-checkbox:checked').length;
                var newTotal = price * numChecked;
                total.text('total price : ' + newTotal);
            });
        });
        $('.seat-form').submit(function(event) {
            if (!$('.seat-checkbox:checked').length) {
                event.preventDefault();
                alert('Please select at least one seat');
            }
        });
        </script>
</body>

</html>