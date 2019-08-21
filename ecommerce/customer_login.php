<div>
	<form action="" method="post">
			<table width="500" align="center" bgcolor="skyblue">
				<tr align="center">
					<td colspan="3"><h2>Login or Register to buy!</h2></td>
				</tr>
				<tr>
					<td align="right"><b>Email:</b></td>
					<td><input type="text" name="email"></td>

				</tr>
				<tr>
					<td align="right"><b>Passwornd: </b></td>
					<td><input type="password" name="password"></td>
				</tr>
				<tr align="center">
					<td colspan="3"><a href="checkout.php?forgot_pass">Forgot Password?</a></td>
				</tr>
				<tr align="center">
					<td colspan="4"><input type="submit" name="login" value="Login"></td>
				</tr>
		</table>
		<h2 style="float: left;"><a href="customer_register.php" style="text-decoration: none;">Register Here!</a></h2>	
	</form>
</div>
<?php 
if(isset($_POST['login'])){
   $c_email = $_POST['email'];
   $c_pass = $_POST['password'];

      $sel_query = "SELECT * FROM customers WHERE customer_email = '$c_email' AND customer_pass = '$c_pass' ";
      $sel_customer = mysqli_query($connection, $sel_query);
      $counts = mysqli_num_rows($sel_customer);
      if($counts == 0){
      	echo "<script>alert('Check email or password')</script>";
      	exit();
      }

      $ip = getIp();
        $sel_cart = "SELECT * FROM cart WHERE ip_add = '$ip' ";
		$sel_res = mysqli_query($connection, $sel_cart);
		if(!$sel_res){
			die("Failed" . mysqli_query($connection));
		}
		$count = mysqli_num_rows($sel_res);
		if($counts > 0 && $count == 0){
			$_SESSION["customer_email"] == $c_email;
			header("Location:customer/my_account.php");
		}
		else {
			$_SESSION['customer_email'] == $c_email;
			
			header("Location:checkout.php");
		}
}
?>