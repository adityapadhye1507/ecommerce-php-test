<?php

class DB{
	public $dbh;
	
	function __construct(){
		require_once("dbInfo.php");
	
		try{
			$this->dbh = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
			//change error reporting
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			
		} catch(PDOException $e){
			die("Bad Database Connection");
		}
	}//constructor
	
	function __autoload($class){
 		include_once($class.".class.php");
	}
	
	function isValidUser($userName,$password){
		try{
			$data = Array();
			
			$stmt = $this->dbh->prepare("select * from users where user_id = :id and password = :pass");
			$stmt->bindParam(':id', $userName, PDO::PARAM_STR);
			$stmt->bindParam(':pass', $password, PDO::PARAM_STR);
			
			$stmt->execute();
			if($row=$stmt->fetch()){
				return true;
			}
			return false;
		} catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	} //isValidUser
	
	function isAdminUser($id){
		try{
			$data = Array();
			$stmt = $this->dbh->prepare("select admin from users where user_id = :id");
			$stmt->execute(array("id"=>$id));
			if($row=$stmt->fetch()){
				if($row[0]==1)
					return true;
			}
			return false;
		} catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	} //isAdminUser
	
	public function getCount(){
	try{
			$data = $this->dbh->query("select count(*) from products");
			$rowCount = $data->fetchColumn(0);
			return $rowCount;
		} catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	}//get the total number of products present in database

	public function showData($start,$limit){

 		$sql="SELECT * FROM products LIMIT :start, :limit";
 		$q = $this->dbh->prepare($sql);
 		$q->bindValue(':limit', $limit, PDO::PARAM_INT);
		$q->bindValue(':start', $start, PDO::PARAM_INT);
		$q->execute();

 		while($r = $q->fetch(PDO::FETCH_ASSOC)){
 			$data[]=$r;
 		}
 		return $data;
 	}// get data of a table
 	
    public function showCatalog($start,$limit){

 		$sql="SELECT * FROM products WHERE sales_price='0' LIMIT :start, :limit";
 		$q = $this->dbh->prepare($sql);
 		$q->bindValue(':limit', $limit, PDO::PARAM_INT);
		$q->bindValue(':start', $start, PDO::PARAM_INT);
		$q->execute();

 		while($r = $q->fetch(PDO::FETCH_ASSOC)){
 			$data[]=$r;
 		}
 		return $data;
 	}// get data for catelog
 	
 	public function showSales(){

 		$sql="SELECT * FROM products WHERE sales_price!='0'";
 		$q = $this->dbh->prepare($sql);
		$q->execute();

 		while($r = $q->fetch(PDO::FETCH_ASSOC)){
 			$data[]=$r;
 		}
 		return $data;
 	}// get data for sale items
 	
 	public function showCart($user){
		//get cart id for user
		$cart_id = $this->getCart($user);
		
		//get cart data
 		$sql="SELECT * FROM cart_products where cart_id=:cart_id";
 		$q = $this->dbh->prepare($sql);
 		$q->bindValue(':cart_id', $cart_id, PDO::PARAM_INT);
		$q->execute();
 		$cartData = $q->fetchAll(PDO::FETCH_ASSOC);
 		
 		//get products from cart
 		foreach($cartData as $row){
 			$products[] = $this->getProductById($row['product_id']);
 		}
 		
 		
 		//get data to show in cart
 		for ($i = 0; $i < count($products); $i++) {
    		$result[$i]['name'] = $products[$i]->getName();
    		$result[$i]['quantity'] = $cartData[$i]['quantity'];
    		$result[$i]['description'] = $products[$i]->getDescription();
    		$result[$i]['image_name'] = $products[$i]->getImageName();
    		$salePrice = $products[$i]->getSalePrice();
    		if(empty($salePrice)){
				$result[$i]['price'] = $products[$i]->getPrice();
    		} else{
    			$result[$i]['price'] = $salePrice;
    		}
    	}
 		return $result;
 	}// get data for cart of a particular user
 	
	public function insertData($name,$description,$price,$quantity,$image_name,$sales_price){

 		$sql = "INSERT INTO products SET name=:name,description=:description,price=:price,
 					quantity=:quantity,image_name=:image_name,sales_price=:sales_price";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':name'=>$name,':description'=>$description,
		':price'=>$price,':quantity'=>$quantity,':image_name'=>$image_name,
		':sales_price'=>$sales_price));
 		return true;
 	}// insert data into product table


	public function update($product_id,$name,$description,$price,$quantity,$image_name,$sales_price){

		$sql = "UPDATE products
 		SET name=:name,description=:description,price=:price,quantity=:quantity,
 		image_name=:image_name,sales_price=:sales_price WHERE product_id=:product_id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':product_id'=>$product_id,':name'=>$name,':description'=>$description,
		':price'=>$price,':quantity'=>$quantity,':image_name'=>$image_name,
		':sales_price'=>$sales_price));
 		return true;
 	} // update product data
 	
 	public function getProductById($product_id){

 		$sql="SELECT * FROM products WHERE product_id = :product_id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':product_id'=>$product_id));
 		$q->setFetchMode(PDO::FETCH_CLASS,"Products");
 		$data = $q->fetch();
 		return $data;
 	} // get content by ID

	public function deleteData($id){

 		$sql="DELETE FROM products WHERE product_id=:id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':id'=>$id));
 		return true;
 	}//delete a product from database
 	 	
 	public function getCart($user){
 		$sql="SELECT * FROM cart WHERE user_id = :user_id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':user_id'=>$user));
		$result = $q->fetchColumn();
 		return $result;
 	} //get cart id for user
 	
 	public function createCart($user){
 		$sql="INSERT INTO cart SET user_id=:user_id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':user_id'=>$user));
 		$cart_id = $this->getCart($user);
 		return $cart_id;
 	} // create a new cart if user don't have a cart
 	
 	
 	public function addToCart($user,$product_id){
 		//reduce quantity of product
 		$product = $this->getProductById($product_id);
 		$quantity = $product->getQuantity();
 		$quantity = $quantity -1;
 		if($quantity<0){
 			return false;
 		}
 		$this->setProductQuantity($product_id,$quantity);
 		//get the existing cart if any, else create a new cart
 		$cart_id = $this->getCart($user);
 		if(empty($cart_id)){
 			$cart_id = $this->createCart($user);
 			echo "\n\nEmpty cart ID";
 			die();
 		}
 		
 		//check if product is already present in cart
 		$quantity = $this->getQuantity($cart_id,$product_id);
 		//if yes, then update quantity of product
 		if(!empty($quantity)){
 			$quantity = $quantity+1;
 			$this->updateCart($cart_id,$product_id,$quantity);
 		}
 		//else, add product to cart
 		else{
			$sql = "INSERT INTO cart_products SET cart_id=:cart_id, product_id=:product_id, quantity='1'";
			$q = $this->dbh->prepare($sql);
			$q->execute(array(':cart_id'=>$cart_id,':product_id'=>$product_id));
		}
 		return true;
 	}//function to add a product to cart
 	
 	
 	public function setProductQuantity($product_id,$quantity){
 		$sql = "UPDATE products SET quantity=:quantity WHERE product_id=:product_id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':product_id'=>$product_id,':quantity'=>$quantity));
 		return true;
 	}//set new quantity for product
 	
 	public function getQuantity($cart_id,$product_id){
 		$sql="SELECT * FROM cart_products WHERE cart_id=:cart_id AND product_id=:product_id";
 		$q = $this->dbh->prepare($sql);
 		$q->execute(array(':cart_id'=>$cart_id,':product_id'=>$product_id));
		$result = $q->fetchColumn(2);
 		return $result;
 	}//get the quantity of existing product in the cart
 	
 	public function updateCart($cart_id,$product_id,$quantity){
 		$sql = "UPDATE cart_products SET quantity=:quantity WHERE cart_id=:cart_id AND product_id=:product_id";
 		$q = $this->dbh->prepare($sql);
 		$q->bindValue(':product_id', $product_id, PDO::PARAM_INT);
 		$q->bindValue(':quantity', $quantity, PDO::PARAM_INT);
 		$q->bindValue(':cart_id', $cart_id, PDO::PARAM_INT);
 		$q->execute();
 		return true;
 	}//function to update the quantity in cart if product already present in cart
 	
 	public function emptyCart($user){
 		//get cart Id
 		$cart_id = $this->getCart($user);
 		//if cart is present
 		if(!empty($cart_id)){
 			//delete products from cart_products table
 			$sql="DELETE FROM cart_products WHERE cart_id=:cart_id";
 			$q = $this->dbh->prepare($sql);
 			$q->execute(array(':cart_id'=>$cart_id));
 		}
 		return true;
 	}//function to delete the contents of the cart
 	
 	public function checkProductConstraint(){
 		$count = $this->getProductCount();
 		if($count<15){
 			$error="Product Constraint violated!! Min number of products should be 15. Please add more products!!";
 			return $error;
 		} return "";
 	}//check if the product constraint is not violated
	public function getProductCount(){
		$sql="SELECT COUNT(*) FROM products WHERE sales_price='0'";
 		$q = $this->dbh->prepare($sql);
 		$q->execute();
 		$count = $q->fetchColumn();
 		return $count;
	}//get number of products which are not on sale

	public function checkSalesContraint(){
 		$count = $this->getSalesCount();
 		if($count>5){
 			$error="Sale Constraint violated!! Max number of products on sale should be only 5!";
 			return $error;
 		} if($count<3){
 			$error="Sale Constraint violated!! Min number of products on sale should be atleast 3!";
 			return $error;
 		} 
 		return "";
 	}//check if the sale constraint is violated or not
 	public function getSalesCount(){
		$sql="SELECT COUNT(*) FROM products WHERE sales_price!='0'";
 		$q = $this->dbh->prepare($sql);
 		$q->execute();
 		$count = $q->fetchColumn();
 		return $count;
	}//get count of products on sale
}

?>