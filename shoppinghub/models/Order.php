<?php
class Order extends Model
{
	static $table = 'orders';
	static $cols = 'id, customerId, orderType, orderDate, shippingAddress, status, image';
	
	static function open(){
		if(USER_ROLE == 'customer'){
			if($o = Order::getOne("status = 'cart' AND customerId = ".USER_ID));
			else 
			{
				$data['customerId'] = USER_ID;
				$data['orderType'] = 'check';
				$data['orderDate'] = get_sql_date();
				$data['shippingAddress'] = '';
				$data['status'] = 'cart';
				
				$o = new Order($data);
				$o->save();
				}
			return $o;
		}
	}
	
	function addProduct($pId,$quantity,$update = false)
	{
		if($od = OrderDetail::getOne("orderId = {$this->getId()} and productId = $pId"))
		{
			$od->setPrice(Product::getByPK($pId)->getPrice());
			if($update==false)
			{
				$od->setQuantity($od->getQuantity()+$quantity);
			}
			else
			{
				//if adding 
				if($quantity > 0)
					$od->setQuantity($quantity);
				else
				{
					OrderDetail::delete('id = '.$od->getId());
					return true;
				}
			}
			$od->save();
		}
		else if($quantity >0)
		{
			$data['orderId'] = $this->getId();
			$data['productId'] = $pId;
			$data['quantity'] = $quantity;
			$od = new OrderDetail($data);
			$od->save();
		}
		return $od ? $od->getId() : true;
	}
	
	function getProductCount(){
		$query = "SELECT SUM(quantity) FROM orderDetails where orderId = {$this->getId()}";
		return db()->scalar($query)+0;	
	}

	function getTotalPrice(){
		$query = "SELECT SUM(od.price*od.quantity) FROM products p INNER JOIN orderDetails od ON p.id = od.productId where od.orderId = {$this->getId()}";
		return intval(db()->scalar($query));
	}
		
	function getProducts()
	{
		$ps = array();
		$cols = Product::getCols('p');
		$query = "select $cols, od.quantity, od.quantity*od.price as totalPrice  from products p inner join orderDetails od on p.id = od.productId where orderId = {$this->getId()}";
		
		if($rs = db()->query($query))
		{
			while($row = $rs->fetch_assoc())
			{
				$p = new Product($row);
				$p->quantity = $row['quantity'];
				$p->totalPrice = $row['totalPrice'];
				$ps[] = $p;
			}
		}
		
		return $ps;
	}
	function getDraft($width)
	{
		if($this->getImage())
			return SITE_URL.'showimg.php?s='.'images/drafts/'.parent::getImage($width)."&w=$width"; 
		else
			return '';
	}
}