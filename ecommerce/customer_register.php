<?php include("functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My Online Shopping</title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>
<body>
	<div class="main_wrapper">
		 <div class="header_wrapper">
		 	  <a href="index.php"><img id="logo" src="images/logo.gif"/></a>
		 	  <img id="banner" src="images/ad_banner.gif"/>
		 </div>
		 <div class="menubar">
		 	 	<ul id="menu">
		 	 		<li><a href="index.php">Home</a></li>
		 	 		<li><a href="all_products.php">All Products</a></li>
		 	 		<li><a href="customer/my_account.php">My account</a></li>
		 	 		<li><a href="">Sign Up</a></li>
		 	 		<li><a href="cart.php">Shopping Cart</a></li>	
		 	 		<li><a href="#">Contact Us</a></li>	
		 	 	</ul>
		 	 	<div id="form">
		 	 		<form method="get" action="results.php" enctype="multipart/form-data">
		 	 			<input type="text" name="user_query">
		 	 			<input type="submit" name="search" value="Search" >
		 	 		</form>
		 	 	</div>
		 </div>
		 <div class="content_wrapper">
		      <div id="sidebar">
		      <div id="sidebar_title">Categories</div>
		      	<ul id="cats">
		      		<?php getCats(); ?>
		      	</ul>

		      <div id="sidebar_title">Brands</div>
		      	<ul id="cats">
		      		<?php getBrands();

		      		 ?>
		      	</ul>
		      	
		      </div>
		      <div id="content_area">
		      	<?php carts(); ?>
                <div id="shopping_cart">
                	 
                   <span style="float: right; font-size: 18px; line-height: 40px; ">Welcome Guest!
                   	<b style="color:yellow;">Shoping Cart- </b> Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?> <a href="cart.php" style="color: yellow;">Go to Cart</a>
                   </span>

                </div>
               <div id="products_box">
                   <form action="customer_register.php" method="post" enctype="multipart/form-data">
            		<table align="center" width="750">
            			<tr align="center">
            				<td colspan="6"><h2>Create an Account!</h2></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Name:</td>
            				<td><input type="text" name="c_name"></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Email:</td>
            				<td><input type="text" name="c_email"></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Password:</td>
            				<td><input type="password" name="c_pass"></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Image:</td>
            				<td><input type="file" name="c_image"></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Country:</td>
            				<td>
            					<select name="c_country">
            						<option>Select a Country</option>
            						<option>USA</option>
            						<option>ALBANIA</option>
            						<option>KOSOVO</option>
            						<option>GERMANY</option>
            					</select>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">Customer City:</td>
            				<td><input type="text" name="c_city"></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Contact:</td>
            				<td><input type="text" name="c_contact"></td>
            			</tr>
            			<tr>
            				<td align="right">Customer Address:</td>
            				<td><input type="text" name="c_addr"></td>
            			</tr>
            			<tr align="center">
            				<td colspan="5"><input type="submit" name="register" value="Create Account"></td>
            			</tr>


            		</table>       	
			

                   </form>
		      	</div>
		      </div>
		  </div>
		 <div id="footer">
		 	<h2 style="text-align: center; padding-top: 30px;">&copy;2019 learning By R.SH</h2>
		 </div>
    </div>
 </body>
</html>

<?php 
if(isset($_POST['register'])){
		$ip = getIp();
		$c_name = $_POST['c_name'];
		$c_email = $_POST['c_email'];
		$c_pass = $_POST['c_pass'];
		$c_image = $_FILES['c_image']['name'];
		$c_tmp_image = $_FILES['c_image']['tmp_name'];
		$c_country = $_POST['c_country'];
		$c_city = $_POST['c_city'];
		$c_contact = $_POST['c__contact'];
		$c_addr = $_POST['c_addr'];

		move_uploaded_file($c_tmp_image, "customer/customer_images/$c_image");
		$insert_c_query = "INSERT INTO customers (customer_ip, customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_address, customer_image) VALUES('$ip','$c_name', '$c_email', '$c_pass', '$c_country', '$c_city', '$c_contact', '$c_addr', '$c_image') ";
		$c_res = mysqli_query($connection, $insert_c_query);
		if(!$c_res){
			die("Failed" . mysqli_query($connection));
		}

		$sel_cart = "SELECT * FROM cart WHERE ip_add = '$ip' ";
		$sel_res = mysqli_query($connection, $sel_cart);
		if(!$sel_res){
			die("Failed" . mysqli_query($connection));
		}
		$count = mysqli_num_rows($sel_res);
		if($count == 0){
			$_SESSION['customer_email'] == $c_email;
			
			header("Location:customer/my_account.php");
		}
		else {
			$_SESSION['customer_email'] == $c_email;
			   header("Location:checkout.php");
		}
	}
?>