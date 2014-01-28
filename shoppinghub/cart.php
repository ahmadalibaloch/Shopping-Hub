<?php
	include('php/includes.php');

	$hdata['title'] = 'Add Product';
	$hdata['page'] = 'products';
	

	$message = '';
	$order = Order::open();
	
	if(isset($_POST['update']))
	{
		$c = count($_POST['id']);
		for($i = 0; $i < $c; $i++)
		{
			$pId = $_POST['id'][$i];
			$quantity = $_POST['quantity'][$i];
			$order->addProduct($pId,$quantity,true);
		}
		$message = 'cart updated successfully';
		
	}
	//update cart count 
	$_SESSION['cart_count'] = $hdata['cart_total'] =  $order->getProductCount();
	
	print_header($hdata);
	

	$append = 'true ';

	

	$vdata['message'] = $message;
	$vdata['totalPrice'] = $order->getTotalPrice();
	$products = array();
	
	$products = $order->getProducts();
		
	$vdata['products'] = $products;
	
	

	print_view('cart', $vdata);

	print_footer();