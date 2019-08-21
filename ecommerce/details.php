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
		 	 		<li><a href="#">Sign Up</a></li>
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
		      		<?php getBrands(); ?>
		      	</ul>
		      	
		      </div>
		      <div id="content_area">
		      	<?php carts(); ?>
                <div id="shopping_cart">
                <span style="float: right; font-size: 18px; line-height: 40px; ">Welcome Guest!
                   	<b style="color:yellow;">Shoping Cart- </b> Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?> <a href="cart.php" style="color: yellow;">Go to Cart</a>
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
		      		<?php 
		      		if(isset($_GET['product_id'])){
		      			$product_id = $_GET['product_id'];
                        $pro_query = "SELECT * FROM products WHERE product_id = $product_id";
                        $pro_result = mysqli_query($connection, $pro_query);
                     if(!$pro_result){
         	            die("Failed " . mysqli_error($connection));
                       }
			         while($row = mysqli_fetch_assoc($pro_result)){
			         	   $product_id = $row['product_id'];
			         	   $product_cat = $row['product_cat'];
			         	   $product_brand = $row['product_brand'];
			         	   $product_title = $row['product_title'];
			         	   $product_price = $row['product_price'];
			         	   $product_desc = $row['product_desc'];
			         	   $product_image = $row['product_image'];
			         	   // $product_keywords = $row['product_keywords'];
                           echo "
			                   <div id='single_product'>
			                         <h3>$product_title</h3>
			                         <img src='admin_area/product_images/$product_image' width='400' height='300'>
			                         <p><b>$ $product_price</b></p>
			                         <p>$product_desc</p>
			                         <a href = 'index.php' style='float:left;'>Go Back</a>
			                         <a href = 'index.php?add_cart=$product_id'><button style='float:right;'>Add to Cart</button></a>
			                    </div>";
                               }
                         }
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