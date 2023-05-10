<?php session_start(); 
$arr=$_SESSION["places"];
if (isset($_SESSION['seats-form'])){
    $seats_form=$_SESSION['seats-form'];
    unset($_SESSION['seats-form']);
}else{
    header("Location: buslist.php");
}
$conn = new mysqli("localhost", "root","", "busproject");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM routes WHERE route_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$seats_form["bus"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $bus_id = $row["bus_id"];
    $sql = "SELECT * FROM buses WHERE bus_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$bus_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bus = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
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
    <div class="container">
        <br>
        <div style="display:none" class="alert alert-success" role="alert">Payment Success
        </div>
        <div style="display:none" class="alert alert-danger" role="alert">Payment Failed
        </div>
        <div class="row">
            <div class="col-sm-6 mb-3 mb-sm-0 details">
                <div class="card details-card">
                    <div class="card-header">
                        <h5 class="card-title">Bokking Details</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $row["source"]."  to  ".$row["destination"]  ?></p>
                        <p class="card-text"><?php echo $row["start_time"]."  to  ".$row["end_time"] ?></p>
                        <p class="card-text"><?php echo "BUS : ".$bus["bus_number"]  ?></p>
                        <p class="card-text"><?php echo "Seats : ". implode(" , ",$seats_form["seats"])  ?></p>
                        <p class="card-text"><?php echo  "Driver : ".$bus["bus_driver"]." ".$bus["driver_contact"] ?>
                        </p>
                        <hr>
                        <div class="passenger">    
                        <p class="card-text"></p> 
                        </div>
                        <hr>
                        <div class="card-fotter">
                            <p class="card-test">
                                <?php echo  "Total : ".$seats_form["price"]*count($seats_form["seats"]) ?></p>
                            <p id="pay-status" class="card-text">---Payment Pending---</p>
                            <a style="display:none" id="print-t" class="btn btn-primary">Download Ticket</a><br>
                            <a style="display:none" id="tobookings" href="bookings.php" class="btn btn-primary">View
                                Bookings</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0 payment-div">
                <div class="container py-5">
                    <!-- For demo purpose -->
                    <div class="row">
                        <div>
                            <div class="card ">
                                <div class="card-header">
                                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                                        <!-- Credit card form tabs -->
                                        <h5 class="card-title">Payment</h5>
                                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                            <li class="nav-item"> <a data-toggle="pill" href="#credit-card"
                                                    class="nav-link active "> <i class="fas fa-credit-card mr-2"></i>
                                                    Credit Card </a> </li>
                                            <li class="nav-item"> <a data-toggle="pill" href="#paypal"
                                                    class="nav-link "> <i class="fab fa-paypal mr-2"></i> Paypal </a>
                                            </li>
                                            <li class="nav-item"> <a data-toggle="pill" href="#net-banking"
                                                    class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> Net
                                                    Banking </a> </li>
                                        </ul>
                                    </div> <!-- End -->
                                    <!-- Credit card form content -->
                                    <div class="tab-content">
                                        <!-- credit card info-->
                                        <div id="credit-card" class="tab-pane fade show active pt-3">
                                            <form role="form" onsubmit="event.preventDefault()">
                                                <div class="form-group"> <label for="username">
                                                        <h6>Card Owner</h6>
                                                    </label> <input type="text" name="username"
                                                        placeholder="Card Owner Name" required class="form-control ">
                                                </div>
                                                <div class="form-group"> <label for="cardNumber">
                                                        <h6>Card number</h6>
                                                    </label>
                                                    <div class="input-group"> <input type="text" name="cardNumber"
                                                            placeholder="Valid card number" class="form-control "
                                                            required>
                                                        <div class="input-group-append"> <span
                                                                class="input-group-text text-muted"> <i
                                                                    class="fab fa-cc-visa mx-1"></i> <i
                                                                    class="fab fa-cc-mastercard mx-1"></i> <i
                                                                    class="fab fa-cc-amex mx-1"></i> </span> </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-group"> <label><span class="hidden-xs">
                                                                    <h6>Expiration Date</h6>
                                                                </span></label>
                                                            <div class="input-group"> <input type="number"
                                                                    placeholder="MM" name="" class="form-control"
                                                                    required> <input type="number" placeholder="YY"
                                                                    name="" class="form-control" required> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group mb-4"> <label data-toggle="tooltip"
                                                                title="Three digit CV code on the back of your card">
                                                                <h6>CVV <i class="fa fa-question-circle d-inline"></i>
                                                                </h6>
                                                            </label> <input type="text" required class="form-control">
                                                        </div>
                                                    </div>
                                                    <div id="pdetails">
                                                        <input id="contact" placeholder="conatct number" type="number" name="contact">
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <input type="checkbox" name="sc" id="sc">
                                                    <label id="demo">demo sucess</label>
                                                    <button type="button" id="pay"
                                                        class="subscribe btn btn-primary btn-block shadow-sm"> Confirm
                                                        Payment </button>
                                            </form>
                                        </div>
                                    </div> <!-- End -->
                                    <!-- Paypal info -->
                                    <div id="paypal" class="tab-pane fade pt-3">
                                        <h6 class="pb-2">Select your paypal account type</h6>
                                        <div class="form-group ">
                                            <label class="radio-inline">
                                                <input type="radio" name="optradio" checked> Domestic
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optradio" class="ml-5">International
                                            </label>
                                        </div>
                                        <p> <button type="button" class="btn btn-primary "><i
                                                    class="fab fa-paypal mr-2"></i> Log into my Paypal</button> </p>
                                        <p class="text-muted">Note : this is only for demo perpose</p>
                                    </div> <!-- End -->
                                    <!-- bank transfer info -->
                                    <div id="net-banking" class="tab-pane fade pt-3">
                                        <div class="form-group "> <label for="Select Your Bank">
                                                <h6>Select your Bank</h6>
                                            </label> <select class="form-control" id="ccmonth">
                                                <option value="" selected disabled>--Please select your Bank--</option>
                                                <option>Bank 1</option>
                                                <option>Bank 2</option>
                                                <option>Bank 3</option>
                                                <option>Bank 4</option>
                                                <option>Bank 5</option>
                                                <option>Bank 6</option>
                                                <option>Bank 7</option>
                                                <option>Bank 8</option>
                                                <option>Bank 9</option>
                                                <option>Bank 10</option>
                                            </select> </div>
                                        <div class="form-group">
                                            <p> <button type="button" class="btn btn-primary "><i
                                                        class="fas fa-mobile-alt mr-2"></i> Proceed Payment</button>
                                            </p>
                                        </div>
                                    </div> 
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
            <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()


                var booking_id;

                $("#pay").click(function(e) {
                    e.preventDefault();
                    var contact = $("#contact").val();
                    if ($("#sc")[0].checked) {
                        $.ajax({
                            type: "post",
                            url: "booking.php",
                            data: {
                                route_id: <?php echo $seats_form["bus"] ?>,
                                seats: <?php echo json_encode($seats_form["seats"])?>,
                                contact: contact
                            },
                            success: function(response) {
                                if (response.trim() != "booking failed" && response
                                    .trim() != "invalid contact") {
                                    booking_id = response;
                                    console.log(booking_id);
                                    $(".alert-success").show();
                                    $(".alert-danger").hide();
                                    $("#print-t").show();
                                    $("#pay-status").text("---Payment Done---");
                                    var inputs = $("#pdetails input");
                                    var values = [];
                                    inputs.each(function() {
                                        values.push($(this).val());
                                    });
                                    var namePTags = $(".passenger p");
                                    namePTags.eq(0).text("contact : " + values[0]);
                                    console.log(values);
                                    $(".payment-div").hide();
                                    $(".details").removeClass("col-sm-6");
                                    $("#tobookings").show();
                                    $('html, body').animate({
                                        scrollTop: $('.alert-success').offset().top
                                    }, 'fast');
                                } else {
                                    $(".alert-danger").show();
                                    $(".alert-success").hide();
                                    $('html, body').animate({
                                        scrollTop: $('.alert-danger').offset().top
                                    }, 'fast');
                                    alert(response)
                                }
                            }
                        });
                    } else {
                        alert("something went wrong")
                        $(".alert-danger").show();
                        $(".alert-success").hide();
                        $('html, body').animate({
                            scrollTop: $('.alert-danger').offset().top
                        }, 'fast');
                    }
                });

                $('#print-t').click(function() {
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