<?php
	include('php/includes.php');
	
	$hdata['title'] = USER_NAME;
	$hdata['page'] = 'aboutus';
	
	print_header($hdata);

	$vdata['user'] =array();
	
	print_view('aboutus', $vdata);

	print_footer();