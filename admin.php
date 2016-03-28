<?php

include_once("session.php");
if(!isset($_SESSION['admin_user'])){
	header("location:login.php");
}
$error = $db->checkProductConstraint();
$error .= $db->checkSalesContraint();

if(isset($_REQUEST['status'])){
 $msg = "Your Data Successfully Updated!";
}

if(isset($_REQUEST['status_insert'])){
 $msg = "Your Data Successfully Inserted!";
}

if(isset($_REQUEST['del_id'])){
	$product = $db->getProductById($_REQUEST['del_id']);
	if($product->getPrice()==0){
		if($db->getSalesCount()<=3){
			$error .= "Cannot Delete!!! Min products on sale should be 3!!!";
		}
	}else if($db->getProductCount()<=15){
			$error .= "Cannot Delete!!! Min products in catelog should be 15!!!";
		}
	

if(empty($error)){
	if($db->deleteData($_REQUEST['del_id'])){
		$msg = "Your Data Successfully Deleted!";
	}
}
}

$title = "Admin";
include("header.php");
include("adminButtonGroup.php");
?>
 <h3 >Products</h3>
 <table class="table table-striped">
 <tr class="success">
 <th scope="col">Name</th>
 <th scope="col">Description</th>
 <th scope="col">Price</th>
 <th scope="col">Quantity</th>
 <th scope="col">Image Name</th>
 <th scope="col">Sale Price</th><th></th><th></th>
 </tr>
 <?php

 if (isset($_GET["page"])){ 
 		$page  = $_GET["page"];
 		$page = $page+1;
 	} 
 	else{
 		$page=1;
 	};
 
 $rec_limit = 5;
 $start_from = ($page-1) * $rec_limit; 	
 $data = $db->showData($start_from, $rec_limit);
 if(isset($data)){
 	foreach($data as $value){
 	extract($value);
echo @<<<show
 	<tr class="success">\n
 	<td>$name</td>\n
 	<td>$description</td>\n
 	<td>$price</td>\n
	<td>$quantity</td>\n
 	<td>$image_name</td>\n
 	<td>$sales_price</td>\n
 	<td><a href="update.php?id=$product_id" class="btn btn-default btn-lg" role="button">Edit</a>\n
	&nbsp;&nbsp;<a href="admin.php?del_id=$product_id" class="btn btn-default btn-lg" role="button">Delete</a></td>\n
 	</tr>\n
show;
 	}
 }else{
 	
 }
 
 echo "</table>";
echo '<div class="pagination">';
 
	$total_records = $db->getCount();
	$total_pages = ceil($total_records / $rec_limit); 
 	if($total_pages>1){
	for ($i=1; $i<=$total_pages; $i++) {
				$pageId = $i-1;
				echo "<a href='admin.php?page=".$pageId."'";
				echo " class='btn btn-default btn-lg' role='button'>";
				echo "".$i."</a>"; 
	}; }
if( $page > 1 && $page < $total_pages ) {
$prev = $page - 2;
$next = $page;
echo "<a href=\"$_PHP_SELF?page=$prev\" class='btn btn-default btn-lg' role='button'>Last 5 Records</a>";
echo "<a href=\"$_PHP_SELF?page=$next\" class='btn btn-default btn-lg' role='button'>Next 5 Records</a>";
}else if( $page == 1  && $total_pages!=1) {
	echo "<a href=\"$_PHP_SELF?page=$page\" class='btn btn-default btn-lg' role='button'>Next 5 Records</a>";
}else if( $page == $total_pages and $page!=1) {
	$prev = $page - 2;
	echo "<a href=\"$_PHP_SELF?page=$prev\" class='btn btn-default btn-lg' role='button'>Last 5 Records</a>";
}
echo "</div>";
include("footer.php");
?>