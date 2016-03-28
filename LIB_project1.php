<?php
function sanitize($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
}

function alphaNumericSpace($value) {
	$reg = "/^[A-Za-z0-9 ]+$/";
	return preg_match($reg,$value);
}

function numbers($value) {
	$reg = "/^[0-9]+$/";
	return preg_match($reg,$value);
}

function validateInput(){
 
  if (empty($_POST["name"])) {
    $error .= "\nName is required!";
  } else {
    $name = sanitize($_POST["name"]);
    if(!alphaNumericSpace($name))
    $error .= "\nInvalid Name!";
  }

  if (empty($_POST["description"])) {
    $error .= "\nDescription is required!";
  } else {
    $description = sanitize($_POST["description"]);
    if(!alphaNumericSpace($description))
    $error .= "\nInvalid description!";
  }

  if (empty($_POST["quantity"])) {
    $error .= "\nQuantity is required!";
  } else {
    $quantity = sanitize($_POST["quantity"]);
    if(!numbers($quantity))
    $error .= "\nInvalid Quantity!";
  }

  if (empty($_POST["image_name"])) {
    $error .= "\nImage needs to be uploaded first!";
  } else {
    $image_name = sanitize($_POST["image_name"]);
  }
  
  if (empty($_POST["price"])) {
    $error .= "\nPrice is required!";
  } else {
    $price = sanitize($_POST["price"]);
    if(!numbers($price))
    $error .= "\nInvalid Price!";
  }
  
  if(!empty($_POST["sales_price"])){
  	$sales_price = sanitize($_POST["sales_price"]);
  	if(!numbers($sales_price))
    $error .= "\nInvalid Sale Price!";
  	if($sales_price>$price){
  		$error .= "\nSale Price should be less than Original price!";
  	}
   
  }
  return $error;

}

?>