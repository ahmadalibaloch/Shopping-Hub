<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Purchase';
	$hdata['page'] = 'purchase';
	
	$message = '';
	
	if($_GET)check_login(5);

	$pId = '';
	if($pId = array_value($_GET,'id'))
	{
		$quantity = array_value($_POST,'quantity');
		$quantity = $quantity?$quantity:1;//------------------UPDATE AFTER FORM QUANTITY CONTROL ADDED
		if((($stock = Product::getByPK($pId)->getQuantity()) - $quantity) > -1)
			if($order = Order::open())
			{	
				$pId = array_value($_GET,'id');
				if($order->addProduct($pId,$quantity)){
					//update product quantity in table
					$p = Product::getByPK($pId);
					$p->setQuantity($stock - $quantity);
					$p->save();
					$message = 'product added to cart successfuly';
				}
				//update cart
				$_SESSION['cart_count'] = $hdata['cart_count'] = $order->getProductCount();
			}
			else
				$message = 'Order opening problem';
		else
			$message = 'Product not is out of stock';
	}
	redirect('product.php?id='.$pId);