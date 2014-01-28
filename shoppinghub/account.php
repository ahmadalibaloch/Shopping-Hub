<?php
	include('php/includes.php');
	
	$hdata['title'] = USER_NAME;
	$hdata['page'] = 'account';
	
	print_header($hdata);

	$vdata['user'] = User::getByPK(USER_ID);
	
	print_view('account', $vdata);

	print_footer();