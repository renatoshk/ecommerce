<?php 
function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $ip;
}

function carts(){
   if(isset($_GET['add_cart'])){
    global $connection;
    $ip = getIp();
    $pro_id = $_GET['add_cart'];
    $check_pro = "SELECT * FROM cart WHERE ip_add = '$ip' AND p_id = $pro_id ";;
    $check_res = mysqli_query($connection, $check_pro);
    if(!$check_pro){
        die("Failed" . mysqli_error($connection));

      }
     $count = mysqli_num_rows($check_res);
     if($count > 0){
        
       header("Location:index.php");
     } 
     else {
            $insert_product = "INSERT INTO cart (p_id, ip_add) VALUES ('$pro_id', '$ip') ";
            $insert_result = mysqli_query($connection, $insert_product);
        if(!$insert_result){
            die("Failed" . mysqli_error($connection));
        }
      // echo "<script>alert('Product Added')</script>";
      // echo "<script>window.open('index.php','_self')</script>";
      header("Location:index.php");

     }
   }
}

function total_items(){
    if(isset($_GET['add_cart'])){
        global $connection;
        $p_id = $_GET['add_cart'];

        $ip = getIp();
        $get_items = "SELECT * FROM cart WHERE ip_add = '$ip' ";
        $get_result = mysqli_query($connection, $get_items);
        if(!$get_result){
            die("Failed" . mysqli_error($connection));
        }
        $count = mysqli_num_rows($get_result);

    }
    else {
        global $connection;
        $ip = getIp();
        $get_items = "SELECT * FROM cart WHERE ip_add = '$ip' ";
        $get_result = mysqli_query($connection, $get_items);
        if(!$get_result){
            die("Failed" . mysqli_error($connection));
        }
        $count = mysqli_num_rows($get_result);
    }
    echo $count;
}

function total_price(){
    $total = 0;
    global $connection;
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
            $values = array_sum($product_price);
            $total +=$values;

        }
    }
    echo "$".$total;
}


function getCats(){
	     global $connection;
         $cat_query = "SELECT * FROM categories ";
         $cat_result = mysqli_query($connection, $cat_query);
         if(!$cat_result){
         	die("Failed query" . mysqli_error($cat_result));
         } 
         while($row = mysqli_fetch_assoc($cat_result)){
         	$cat_id = $row['cat_id'];
         	$cat_title = $row['cat_title'];
          echo "<li><a href = 'index.php?cat=$cat_id'>$cat_title</a></li>";
        }
}
function getBrands(){
	     global $connection;
         $brand_query = "SELECT * FROM brands ";
         $brand_result = mysqli_query($connection, $brand_query);
         if(!$brand_result){
         	die("Failed query" . mysqli_error($brand_result));
         } 
         while($row = mysqli_fetch_assoc($brand_result)){
         	   $brand_id = $row['brand_id'];
         	   $brand_title = $row['brand_title'];
            echo "<li><a href = 'index.php?brand=$brand_id'>$brand_title</a></li>";
        }
}
function getPro(){
	if(!isset($_GET['cat'])){
		if(!isset($_GET['brand'])){
         global $connection;
         $pro_query = "SELECT * FROM products ORDER BY rand() LIMIT 0,6 ";
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
                         <img src='admin_area/product_images/$product_image' width='180' height='180'>
                         <p><b>Price: $ $product_price</b></p>
                         <a href = 'details.php?product_id=$product_id' style='float:left;'>Details</a>
                         <a href = 'index.php?add_cart=$product_id'><button style='float:right;'>Add to Cart</button></a>
                    </div>";
           }
        }
     }
 }

function getCatPro(){
	if(isset($_GET['cat'])){
		$cat_id = $_GET['cat'];
		 global $connection;
         $pro_cat_query = "SELECT * FROM products WHERE product_cat = $cat_id ";
         $pro_cat_result = mysqli_query($connection, $pro_cat_query);
         if(!$pro_cat_result){
         	   die("Failed " . mysqli_error($connection));
             }
         $count = mysqli_num_rows($pro_cat_result);
         if($count == 0){
         	echo "<h1 style='color:black; padding:50px;'>NO PRODUCTS HERE!</h1>";
         }
         else {
             while($row = mysqli_fetch_assoc($pro_cat_result)){
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
                         <img src='admin_area/product_images/$product_image' width='180' height='180'>
                         <p><b>$ $product_price</b></p>
                         <a href = 'details.php?product_id=$product_id' style='float:left;'>Details</a>
                         <a href = 'index.php?product_id=$product_id'><button style='float:right;'>Add to Cart</button></a>
                    </div>";
          }
       }
    }
 }

 function getBrandPro(){
	if(isset($_GET['brand'])){
		$brand_id = $_GET['brand'];
		 global $connection;
         $pro_brand_query = "SELECT * FROM products WHERE product_brand = $brand_id ";
         $pro_brand_result = mysqli_query($connection, $pro_brand_query);
         if(!$pro_brand_result){
         	   die("Failed " . mysqli_error($connection));
             }
         $count = mysqli_num_rows($pro_brand_result);
         if($count == 0){
         	echo "<h1 style='color:black; padding:50px;'>NO PRODUCTS HERE!</h1>";
         }
         else {
             while($row = mysqli_fetch_assoc($pro_brand_result)){
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
                         <img src='admin_area/product_images/$product_image' width='180' height='180'>
                         <p><b>$ $product_price</b></p>
                         <a href = 'details.php?product_id=$product_id' style='float:left;'>Details</a>
                         <a href = 'index.php?product_id=$product_id'><button style='float:right;'>Add to Cart</button></a>
                    </div>";
          }
       }
    }
 }











   ?>