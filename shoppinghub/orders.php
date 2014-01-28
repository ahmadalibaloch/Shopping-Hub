<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Orders';
	$hdata['page'] = 'order';
	print_header($hdata);
	
	$message = '';
	if(isset($_POST['id'])){
		$c = count($_POST['id']);
		for($i = 0; $i < $c; $i++)
		{
			$orderId = $_POST['id'][$i];
			$checked = isset($_POST[$orderId])?true:false;
			$order = Order::getByPK($orderId);
			if($checked)
				$order->setStatus('Processed');
			else
				$order->setStatus('Processing');
			$order->save();
		}
		$message = 'orders updated successfully';
	}
	
	
	$pager = new Pager(5);
	$append = 'true ';
	if(USER_ROLE == 'customer')
	$append =  "customerId=".USER_ID." AND status = 'processing' OR status='processed'";
	
	$vdata['message'] = $message;
	$vdata['orders'] = Order::getAll($append,$pager);
	$vdata['pager'] = $pager;
	print_view('orders', $vdata);

	print_footer();