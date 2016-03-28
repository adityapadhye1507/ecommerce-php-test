<?php
class Products{
	private $product_id;
	private $name;
	private $description;
	private $quantity;
	private $image_name;
	private $price;
	private $sales_price;


	
	public function getProductId(){
		return $this->product_id;
	}
	public function getName(){
		return $this->name;
	}
	public function getDescription(){
		return $this->description;
	}
	public function getQuantity(){
		return $this->quantity;
	}
	public function getImageName(){
		return $this->image_name;
	}
	public function getPrice(){
		return $this->price;
	}
	public function getSalePrice(){
		return $this->sales_price;
	}
}

?>