<?php
include_once("session.php");

if(isset($_GET['addToCart'])){
	$prodcut_id = $_GET['addToCart'];
	$user = $_SESSION['login_user'];
	if($db->addToCart($user,$prodcut_id)){
		$msg .= "\nItem added to cart!!!";
	} else{
		$error .="Sorry, Item cannot be added!!! Looks like We are out of Stock!!";
	}
}

$error = $db->checkProductConstraint();
$errorSales .= $db->checkSalesContraint();
$title = "Index";
include("header.php");
include("indexButtonGroup.php");
?>
 <h3 >Catalog</h3>
 <p>Buy Online the posters of your favourite SuperHero "Deadpool"</p>
 <table class="table table-striped">
 <tr class="success">
 <th scope="col">Name</th>
 <th scope="col">Description</th>
 <th scope="col">Quantity Left in Stock</th>
 <th scope="col">Image</th>
 <th scope="col">Price</th><th></th>
 </tr>
 <?php
if(empty($error)){
 if (isset($_GET["page"])){ 
 		$page  = $_GET["page"];
 		$page = $page+1;
 	} 
 	else{
 		$page=1;
 	};
 
 $rec_limit = 5;
 $start_from = ($page-1) * $rec_limit; 	
 $data = $db->showCatalog($start_from, $rec_limit);
 if(isset($data)){
 	foreach($data as $value){
 	extract($value);
echo @<<<show
 	<tr class="success">\n
 	<td>$name</td>\n
 	<td>$description</td>\n
	<td>$quantity</td>\n
	<td><img src="images/$image_name" height="100" width="100" alt=$image_name></td>\n
 	<td>$price</td>\n
	<td><a href="index.php?addToCart=$product_id" class="btn btn-default btn-lg" role="button">Add To Cart</a></td>\n
 	</tr>\n
show;
 	}
 }else{
 	
 }
 
 echo "</table>";
echo '<div class="pagination">';
 
	$total_records = $db->getProductCount();
	$total_pages = ceil($total_records / $rec_limit); 
 	if($total_pages>1){
	for ($i=1; $i<=$total_pages; $i++) {
				$pageId = $i-1;
				echo "<a href='index.php?page=".$pageId."'";
				echo " class='btn btn-default btn-lg' role='button'>";
				echo "".$i."</a>";
	}; }
if( $page > 1 && $page < $total_pages ) {
$prev = $page - 2;
$next = $page;
echo "<a href=\"$_PHP_SELF?page=$prev\" class='btn btn-default btn-lg' role='button'>Last 5 Records</a>";
echo "<a href=\"$_PHP_SELF?page=$next\" class='btn btn-default btn-lg' role='button'>Next 5 Records</a>";
}else if( $page == 1  && $total_pages!=1) {
	echo "<a href = \"$_PHP_SELF?page=$page\" class='btn btn-default btn-lg' role='button'>Next 5 Records</a>";
}else if( $page == $total_pages and $page!=1) {
	$prev = $page - 2;
	echo "<a href=\"$_PHP_SELF?page=$prev\" class='btn btn-default btn-lg' role='button'>Last 5 Records</a>";
}
echo "</div>";

 }
 if(!empty($msg))
 echo "<div class='alert alert-success'>
	<strong>Success!</strong>$msg
	</div>";
if(!empty($error))
 echo "<div class='alert alert-danger'>
	<strong>Error!</strong>$error
	</div>";
 ?>
</div>

<div class="container">
<h3 >Products on Sale</h3>
<p>Check out our Sale section!!! Grab them all till the stock lasts!!</p>
 <table class="table table-striped">
 <tr class="success">
 <th scope="col">Name</th>
 <th scope="col">Description</th>
 <th scope="col">Quantity Left in stock</th>
 <th scope="col">Image</th>
 <th scope="col">Original Price</th>
 <th scope="col">Discounted Price</th><th></th>
 </tr>
 <?php
if(empty($errorSales)){
 $data = $db->showSales();
 if(isset($data)){
 	foreach($data as $value){
 	extract($value);
echo @<<<show
 	<tr class="success">\n
 	<td>$name</td>\n
 	<td>$description</td>\n
	<td>$quantity</td>\n
 	<td><img src="images/$image_name" height="100" width="100" alt=$image_name></td>\n
 	<td>$price</td>\n
 	<td>$sales_price</td>\n
 	<td><a href="index.php?addToCart=$product_id" class="btn btn-default btn-lg" role="button">Add To Cart</a></td>\n
 	</tr>\n
show;
 	}
 }
 }
 
 echo "</table>";

if(!empty($errorSales))
 echo "<div class='alert alert-danger'>
	<strong>Error!</strong>$errorSales";
 ?>

</div>
</body>
</html>