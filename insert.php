<?php
include_once("session.php");
include_once("LIB_project1.php");

if(isset($_REQUEST['insert'])){

//validate data coming from request
$error = validateInput();

if(empty($error) && $_POST['sales_price']!=0){
	if($db->getSalesCount()>=5)
		$error .= "\nMax Limit reached for sales items!!";
	}

if(empty($error))
 {	
 	//get data from request
 	extract($_REQUEST);
  	//insert data into db
 	if($db->insertData($name,$description,$price,$quantity,$image_name,$sales_price)){
 		header("location:admin.php?status_insert=success");
 	}
 }else{
 	$error .="\nCannot Insert!!";
 	}
}

if(isset($_REQUEST['upload'])){
	include_once("upload.php");
}

$title = "Insert";
include("header.php");
include("adminButtonGroup.php");
?>

<div class="row">
	<div class="col-lg-12">
		<form class="well" action="insert.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
			<label for="fileToUpload">Select a file to upload</label>
			<input type="file" name="fileToUpload" id="fileToUpload">
				<p class="help-block">Only jpg,jpeg,png and gif file with maximum size of 1 MB is allowed.</p>
			</div>
			<input type="submit" name="upload" class="btn btn-lg btn-primary" value="Upload">
		</form>
	</div>
</div>

<?php 
echo @<<<show
 <h3>Insert Your Data</h3>
 <form action="insert.php" method="post">
 <table class="table table-striped">
 <tr>
 <th scope="row">Id</th>
 <td><input type="text" name="id" value="$id" readonly="readonly"></td>
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
 <td><input type="text" name="image_name" readonly="readonly" value="$image_name"></td>
 </tr>
  <tr>
 <th scope="row">Sale Price</th>
 <td><input type="text" name="sales_price" value="$sales_price"></td>
 </tr>
 <tr>
 <th scope="row">&nbsp;</th>
 <td><input type="submit" name="insert" value="Insert" class="btn"></td>
 </tr>
 </table>
 </form>
show;
include("footer.php"); 
?>
 