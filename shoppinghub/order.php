<?php
	include('php/includes.php');

	$hdata['title'] = 'Order';
	$hdata['page'] = 'Order';

	$message = '';
	$product = '';

	$append = 'false ';	
	
	if($_POST)
	{
		$custId = array_value($_POST,'custId');
		$orderId = array_value($_POST,'orderId');
		$shippingAddress = $_POST['shippingAddress'];

		$o = new Order();
		$o->setShippingAddress($shippingAddress);
		$o->setId($orderId);
		$o->setOrderDate(get_sql_date());
		$o->setStatus("Processing");
		$_SESSION['cart_count'] = 0;
		if($message == '')
		{
			if($o->save()){
				$message = 'Ordered your cart products successfully';
			}
			else {
				$message = 'order failed';
			}
		}
	 }
	
	print_header($hdata);


	$vdata['message'] = $message;
	$vdata['customer']=User::getByPK(USER_ID);
	$vdata['order']=Order::open();

	print_view('order', $vdata);

	print_footer();