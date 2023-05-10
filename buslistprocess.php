<?php
session_start(); 
$_SESSION['from-to'] = $_POST;
if ($_POST["from"]==$_POST["to"]){
    header("Location: index.php");
    exit();
}else{
    header("Location: buslist.php");
    exit();
}
?>