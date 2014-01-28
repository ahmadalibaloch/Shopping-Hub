<?php
class OrderDetail extends Model
{
	static $table = 'orderDetails';
	static $cols = 'id, orderId, productId,quantity,price';
	
	function getTotalPrice(){
		return $this->getQuantity()*$this->getPrice();
	}
	function getProductName(){
		return Product::getByPK($this->getProductId())->getName();
	}
}