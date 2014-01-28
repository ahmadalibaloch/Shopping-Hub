<?php
	include('php/includes.php');

	$hdata['title'] = 'Upload Draft';
	$hdata['page'] = 'orders';

	$message = '';
	$product = '';

	$append = 'true ';	
	
	if($_POST)
	{
		$orderId = array_value($_POST,'orderId');
		$order = Order::getByPK($orderId);
		if($image = array_value($_FILES,'image'))
		{
			if($image['error']==0 && preg_match('/image/',$image['type']))
			{
				if(move_uploaded_file($image['tmp_name'],APP_ROOT.'images/drafts/'.$image['name']))
				{
					$order->setImage($image['name']);
				}
				else
					$message = 'image not uploaded successfully';
			}
			else if($image['error']==2 || $image['error']==3) 
			{
				$message = 'image size is too large, limit is 2MB.';
			}
		}
		
		if($message == '')
		{
			if($order->save()){
				$message = 'draft added successfully';
				redirect('orders.php');
			}
			else {
				$message = 'draft adding failed';
			}
		}
	}
	$vdata = array();
	if($orderId = array_value($_GET,'upload'))
	{
		$append = "id = $orderId";
		$order = Order::getOne($append);
		$vdata['orderId'] = $order->getId();
		$vdata['orderDate']=$order->getOrderDate();
	}
		
	
	print_header($hdata);

	$vdata['message'] = $message;

	print_view('draft', $vdata);

	print_footer();