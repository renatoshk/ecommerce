<?php require_once("../functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inserting Product</title>
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>tinymce.init({selector:'textarea'});</script>
</head>
<body bgcolor="skyblue">
	<form action="insert_product.php" method="post" enctype="multipart/form-data">
		<table align="center" width="700" border="2" bgcolor="orange">
			<tr align="center">
				<td colspan="7"><h2>Insert new Product!</h2></td>
			</tr>
			<tr>
				<td align="right"><b>Product title:</b></td>
				<td><input type="text" name="product_title" required></td>
			</tr>
			<tr>
				<td align="right"><b>Product Category:</b></td>
				<td>
					<select name="product_cat" required>
						<option>Select Category</option>
		            <?php
						$cat_query = "SELECT * FROM categories ";
                        $cat_result = mysqli_query($connection, $cat_query);
                    if(!$cat_result){
         	            die("Failed query" . mysqli_error($cat_result));
                      } 
                  while($row = mysqli_fetch_assoc($cat_result)){
			         	$cat_id = $row['cat_id'];
			         	$cat_title = $row['cat_title'];
			             echo "<option value='$cat_id'>$cat_title</option>";
                     } 
		            ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right"><b>Product Brand:</b></td>
				<td>
					<select name="product_brand" required>
						<option>Select Brand</option>
                     <?php 
                        $brand_query = "SELECT * FROM brands ";
                        $brand_result = mysqli_query($connection, $brand_query);
                        if(!$connection){
                        	die("Failed" . mysqli_error($connection));
                        }
                        while($row = mysqli_fetch_assoc($brand_result)){
                        	$brand_id = $row['brand_id'];
                        	$brand_title = $row['brand_title'];
                        	echo "<option value='$brand_id'>$brand_title</option>";
                        }

                      ?>  

					</select>
				</td>
			</tr>
			<tr>
				<td align="right"><b>Product Image:</b></td>
				<td><input type="file" name="product_image" required></td>
			</tr>
			<tr>
				<td align="right"><b>Product Price:</b></td>
				<td><input type="text" name="product_price" required></td>
			</tr>
			<tr>
				<td align="right"><b>Product Description:</b></td>
				<td>
					<textarea name="product_desc" cols="30" rows="10"></textarea>
				</td>
			</tr>
			<tr>
				<td align="right"><b>Product Keywords:</b></td>
				<td><input type="text" name="product_keywords" required></td>
			</tr>
			<tr align="center">
			    <td colspan="7"><input type="submit" name="insert_product" value="Insert Now"></td>
			</tr>
		</table>
	</form>
 </body>
</html>
<?php 
if(isset($_POST['insert_product'])){
		 $product_title = $_POST['product_title'];
		 $product_cat = $_POST['product_cat'];
		 $product_brand = $_POST['product_brand'];
		 $product_price = $_POST['product_price'];
		 $product_desc = $_POST['product_desc'];
		 $product_keywords = $_POST['product_keywords'];
		 $product_image = $_FILES['product_image']['name'];
	     $product_image_tmp = $_FILES['product_image']['tmp_name'];
	     move_uploaded_file($product_image_tmp, "product_images/$product_image");
   $insert_query = "INSERT INTO products(product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) ";
   $insert_query.= "VALUES('$product_cat', '$product_brand', '$product_title', '$product_price', '$product_desc','$product_image', '$product_keywords') ";
   $result_insert_query = mysqli_query($connection, $insert_query);
   if($result_insert_query){
      echo "<script>alert('Product has been inserted')</script>";
      echo "<script>window.open('insert_product.php','_self')</script>";
   }

}



 ?>