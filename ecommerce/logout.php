<?php 
session_start();
//session_destroy();
unset($_SESSION["customer_email"]);
header("Location:index.php");
?>