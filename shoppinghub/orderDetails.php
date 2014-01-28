<?php
	include('php/includes.php');

	$hdata['title'] = 'Order Details';
	$hdata['page'] = 'orders';
	
	print_header($hdata);
	
	$message = '';
	$order = '';
	
	if($orderId = array_value($_GET,'id'))
	{
		$order = Order::getByPK($orderId);
	}

	$append = 'true ';
	
	

	$vdata['message'] = $message;

	
	$vdata['orderStatus'] = $order->getStatus();
	$vdata['orderId'] = $order->getId();
	$vdata['orderDate'] = $order->getOrderDate();
	$vdata['totalPrice'] = $order->getTotalPrice();
	$vdata['draft'] = $order->getDraft(400);
	$vdata['orderDetails'] = OrderDetail::getAll('orderId = '.$orderId);
	
	print_view('orderDetails', $vdata);

	print_footer();