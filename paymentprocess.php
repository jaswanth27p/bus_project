<?php
session_start(); 
$_SESSION['seats-form'] = $_POST;
    header("Location: payment.php");
    exit();
?>