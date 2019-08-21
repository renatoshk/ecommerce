<?php  
$connection = mysqli_connect('localhost', 'root', '', 'ecommerce');
if(!$connection){
	die("Failed connection" . mysqli_error($connection));
}
?>