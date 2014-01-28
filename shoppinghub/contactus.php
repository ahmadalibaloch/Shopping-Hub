<?php
	include('php/includes.php');
	
	$hdata['title'] = USER_NAME;
	$hdata['page'] = 'contactus';
	$message = '';
	if($_POST)
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$topic = $_POST['topic'];
		$messageDetail = $_POST['message'];
		if(
		($message = validate($name)) == '' &&
		($message = validate($topic)) == ''
		)
		{
			$contact = new Message();
			$contact->setName($name);
			$contact->setEmail($email);
			$contact->setTopic($topic);
			$contact->setMessage($messageDetail);
			
			if($contact->save())
			{
				$message = "your message was recorded successfully. Thank you for feedback ";
			}
			else
			{
				$message = "error";
			}
		}
	}
	print_header($hdata);

	$vdata['message'] = $message;
	
	print_view('contactus', $vdata);

	print_footer();