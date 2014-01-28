<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Sign Up';
	$hdata['page'] = 'register';
	$message = '';
	$role = '';
	if($role = array_value($_GET,'reg')){
		if($role == 'customer')
			$role='addCustomer';
		else if($role == 'owner')
			$role = 'addOwner';
			
	}
	if($_POST)
	{
		//same data for owner and customer and admin
		$role = $_POST['role'];
		if($role == 'customer')
			$role='addCustomer';
		else if($role == 'owner')
			$role = 'addOwner';
			
		$name = $_POST['name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password1 = $_POST['password1'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		if($password != $password1)
		{
			$message = 'password confirmation failed. passwords do not match';
		}
		else if(
			($message = validate($username,'username')) == '' &&
			($message = validate($password,'password')) == '' &&
			($message = validate($name,'name')) == ''
		)
		{
			$u = new User();
			if($image = array_value($_FILES,'image'))
			{
				if($image['error']==0 && preg_match('/image/',$image['type']))
				{
					if(move_uploaded_file($image['tmp_name'],APP_ROOT.'images/users/'.$image['name']))
					{
						$u->setImage($image['name']);
					}
					else
					$message = 'image not uploaded successfully';
				}
				else if($image['error']==2 || $image['error']==3) 
				{
					$message = 'image size is too large, limit is 2MB.';
				}
			}
			$u->setName($name);
			$u->setUsername($username);
			$u->setPassword($password);
			$u->setEmail($email);
			$u->setPhone($phone);
			$u->setAddress($address);
			$u->setJoinDate(get_sql_date());
			//different for owner and customer
			if($role == 'addCustomer')
			{
				$u->setRoleId(4);
				if($message == '')
				{
					if($u->save()){
						$message = 'registration successfull';
					}
					else {
						$message = 'registration failed';
					}
				}
			}
			else if($role == 'addOwner')
			{
				$business = $_POST['business'];
				$u->setRoleId(3);
				$u->save();
				
				$o = new Owner();
				
				$o->setUserId($u->getId());
				$o->setBusiness($business);
				
				if($message == '')
				{
					if($o->save()){
						$message = 'registration successfull';
					}
					else {
						$message = 'registration failed';
					}
				}
			}
		}

	}
	
	print_header($hdata);
	$vdata['message'] = $message;
	if($role)
		print_view($role, $vdata);
	else
		print_view('register', $vdata);
		
	print_footer();