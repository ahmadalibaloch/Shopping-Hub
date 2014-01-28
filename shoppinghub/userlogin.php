<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Login';
	$hdata['page'] = 'login';
	
	 $message = '';
	
	
	print_header($hdata);
	$vdata['message'] = '';
	if($id = array_value($_GET,'id'))
	{
		$vdata['message'] = Message::getByPK($id)->getText();
	}
	if( ($username = array_value($_POST,'username')) &&  ($password = array_value($_POST,'password') ))
	{
		$query = 'username = \''.$username.'\' and password = \''.$password.'\'';
		if( $user = User::getOne($query))
		{
			trace('loggin user in'.$user->getId());
			$_SESSION['uid'] = $user->getId();
			$user->setLastLogin(get_sql_date());
			$user->save();
			
			if($o = Order::getOne("status = 'cart' AND customerId = ".$_SESSION['uid']))
			{
				$_SESSION['cart_count'] = $o->getProductCount();
			}
			
			if($url = array_value($_SESSION,'from_url'))
				unset($_SESSION['from_url']);
			else 
				$url='index.php';
				
			redirect($url);
		}
		else{
			$message = 'Wrong username and or password.';
		}
		
	}
	$vdata['message'] = $message;
	print_view('userlogin', $vdata);

	print_footer();