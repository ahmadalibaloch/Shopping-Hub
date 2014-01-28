<?php
	include('php/includes.php');

	$hdata['title'] = 'Product Detail';
	$hdata['page'] = 'product';

	$message = '';
	$product = '';
	
	if($productId = array_value($_GET,'id'))
	{	
		$product = Product::getOne("id = $productId");	
	}
		
	if(array_value($_POST, 'purchase') && $productId)
	{
		$quantity = array_value($_POST,'quantity');
		$quantity = $quantity?$quantity:1;//------------------UPDATE AFTER FORM QUANTITY CONTROL ADDED
		if((($stock = Product::getByPK($productId)->getQuantity()) - $quantity) > -1)
			if($order = Order::open())
			{
				if($order->addProduct($productId,$quantity)){
					//update product quantity in table
					$p = Product::getByPK($productId);
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
			$message = 'Product is out of stock';
	}
	
	
	print_header($hdata);


	$vdata['message'] = $message;	
	$vdata['product'] = $product;
	
	print_view('Product', $vdata);

	print_footer();