
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
                   	<b style="color:yellow;">Shoping Cart- </b> Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?> <a href="index.php" style="color: yellow;">Back to shop</a>
                   	<?php 
                        if(!isset($_SESSION['customer_email'])){
                            echo "<a href = 'checkout.php' style= 'color:white;'>Login</a>";
 						}
 						else {
 							echo "<a href = 'logout.php' style='color:white;'>Logout</a>";
 						}
 				    ?>
                   </span>

                </div>
                <div id="products_box">
		      		<form action="" method="post" enctype="multipart/form-data">
		      			<table align="center" width="700" bgcolor="skyblue">
		      				<tr align="center">
		      					<th>Remove</th>
		      					<th>Product (S)</th>
		      					<th>Quantity</th>
		      					<th>Total Price</th>
		      		 		</tr>
                      <?php
                        $total = 0;
					   
					    $ip = getIp();
					    $price_query = "SELECT * FROM cart WHERE ip_add = '$ip' ";
					    $price_res = mysqli_query($connection, $price_query);
					    if(!$price_res){
					        die("Failed" . mysqli_error($connection));
					    }
					    while($row = mysqli_fetch_assoc($price_res)){
					        $pro_id = $row['p_id'];
					        $pro_query = "SELECT * FROM products WHERE product_id = '$pro_id' ";
					        $pro_res = mysqli_query($connection, $pro_query);
					        if(!$pro_res){
					            die("Failed" . mysqli_error($connection));
					        }
					        while($row1 = mysqli_fetch_assoc($pro_res)){
					            $product_price = array($row1['product_price']);
					            $product_title = $row1['product_title'];
					            $product_image = $row1['product_image'];
					            $single_price = $row1['product_price'];

					            $values = array_sum($product_price);
					            $total +=$values;
					    ?>
					    <tr>
					    	<td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>"></td>
					    	<td><?php echo $product_title; ?><br>
                             <img src="admin_area/product_images/<?php echo $product_image ?>" width="60" height="60">

					    	</td>
					 <td><input type="text" size="4" name="qty"></td>
							<?php 
							// if(isset($_POST['update_cart'])){
							// 	$qty = $_POST['qty'];
							// 	$qty_update = "UPDATE cart SET qty = '$qty' ";
							// 	$qty_res = mysqli_query($connection, $qty_update);
							// 	if(!$qty_res){
							// 		die("Failed" . mysqli_error($connection));
							// 	}
							// 	$_SESSION['qty'] = $qty;
							// 	$total = $total*$qty;
							// }

						?>
                        <td><?php echo "$".$single_price; ?></td>
					    </tr>
					    
                       <?php }}?>
                       <tr align="right">
					    	<td colspan="5"><b>Sub Total: <b></td>
					    	<td><?php echo $total ?></td>
					    </tr>
					    <tr align="center">
					    	<td colspan="2"><input type="submit" name="delete_cart" value="DELETE"></td>
					    	<td colspan="2"><input type="submit" name="update_cart" value="Update Cart"></td>
					    	<td><input type="submit" name="continue" value="Continue Shopping"></td>
					    	<td><button><a href="checkout.php" style="text-decoration: none; color: black">Checkout</a></button></td>
					    </tr>
					</table>
		      	</form>
		      	<?php 
		      	    function delete(){
		      	    	global $connection;
		      	     $ip = getIp();
                     if(isset($_POST['delete_cart'])){
                             foreach ($_POST['remove'] as $remove_id) {
                             	      $delete_query = "DELETE  FROM cart WHERE p_id = '$remove_id' AND ip_add = '$ip' ";
                             	      $del_res = mysqli_query($connection, $delete_query);
                             	       // echo "<script>window.open('cart.php','_self')</script>";
                             	      if(!$del_res){
                             	      	die("Failed" . mysqli_error($connection));
                             	         }
                             	      header("Location:cart.php");
                             	  }
                        }
                if(isset($_POST['continue'])){
                         header("Location: index.php");
                    } 
                  
                }
                echo @$del_cart = delete();
		      	 ?>
		      </div>
		    </div>
		</div>
		 <div id="footer">
		 	<h2 style="text-align: center; padding-top: 30px;">&copy;2019 learning By R.SH</h2>
		 </div>

    </div>
 </body>
</html>