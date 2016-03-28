<?php
include_once("session.php");
require("LIB_project1.php");

if(isset($_REQUEST['update'])){

//validate data coming from request
$error = validateInput();

if(empty($error)){
	 extract($_REQUEST);
	 if($db->update($product_id,$name,$description,$price,$quantity,$image_name,$sales_price)){
	 header("location:admin.php?status=success");
	 }
 }else{
 	$error .="\nCannot Update!!";
 	}
}
$title = "Update";
include("header.php");
include("adminButtonGroup.php");


$data = $db->getProductById($_REQUEST['id']);
if($data){
//extract($data);
$product_id = $data->getProductId();
$name = $data->getName();
$description = $data->getDescription();
$quantity = $data->getQuantity();
$image_name = $data->getImageName();
$price =  $data->getPrice();
$sales_price = $data->getSalePrice();
}
echo @<<<show
 
 <h3>Edit Your Data</h3>
 <form action="update.php" method="post">
 <table class="table table-striped">
 <tr>
 <th scope="row">Id</th>
 <td><input type="text" name="product_id" value="$product_id" readonly="readonly"></td>
 </tr>
 <tr>
 <th scope="row">Name</th>
 <td><input type="text" name="name" value="$name"></td>
 </tr>
 <tr>
 <th scope="row">Description</th>
 <td><input type="text" name="description" value="$description"></td>
 </tr>
 <tr>
 <th scope="row">Price</th>
 <td><input type="text" name="price" value="$price"></td>
 </tr>
 <tr>
 <th scope="row">Quantity</th>
 <td><input type="text" name="quantity" value="$quantity"></td>
 </tr>
  <tr>
 <th scope="row">Image</th>
 <td><input type="text" name="image_name" value="$image_name" readonly="readonly"></td>
 </tr>
  <tr>
 <th scope="row">Sale Price</th>
 <td><input type="text" name="sales_price" value="$sales_price"></td>
 </tr>
 <tr>
 <th scope="row">&nbsp;</th>
 <td><input type="submit" name="update" value="Update" class="btn"></td>
 </tr>
 </table>
 </form>
show;
include("footer.php");
?>