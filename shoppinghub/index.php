<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Home';
	$hdata['page'] = 'home';
	
	print_header($hdata);

	$vdata = array();
	
	if(USER_ID != 1)
	{
		$vdata['products'] = rand_limit_rows(Product::getAll(), 5);
		$vdata['categories'] = rand_limit_rows(Category::getAll(), 5);
	}
	
	print_view('index', $vdata);

	print_footer();