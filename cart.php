<?php
include_once("session.php");
$user = $_SESSION['login_user'];

if(isset($_REQUEST['emptyCart'])){
	$db->emptyCart($user);
}
$title = "Cart";
include("header.php");
include("indexButtonGroup.php");
?>
 <h3 >Your Shopping Cart</h3>
<p>Are you sure you don't want more??</p>
 <form action="cart.php" method="post">
 <table class="table table-striped">
 <tr class="success">
 <th scope="col">Name</th>
 <th scope="col">Description</th>
 <th scope="col">Quantity</th>
 <th scope="col">Price</th>
 </tr>
 <?php

 $data = $db->showCart($user);
 $amount = 0;
 
 if(isset($data)){
 	foreach($data as $value){
 	extract($value);
echo @<<<show
 	<tr class="success">\n
 	<td>$name</td>\n
 	<td>$description</td>\n
	<td>$quantity</td>\n
 	<td>$price</td>\n
 	</tr>\n
show;
	$amount += ($quantity*$price);

 	}
 	echo "<tr><td></td><td></td><td><input type='submit' name='emptyCart' value='Empty Cart' class='btn'></td>";
 	echo "<td>Total amount:".$amount."</td></tr>";
 }else{
 	$error .= "Cart is Empty!!! What are you waiting for?? Buy 'em NOW!! Chika-Chikaaaa!!!";
 }
 
 echo "</table></form>";
include("footer.php");
?>