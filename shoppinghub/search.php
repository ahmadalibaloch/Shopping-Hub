<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Search';
	$hdata['page'] = 'products';
	
	
	
	print_header($hdata);
	
	$append = 'true ';
	
	if($search = array_value($_GET, 'search'))
	{
		$append .= "and name like '%$search%'";
	}
		
	$pager = new Pager(10);

	$vdata['products'] = Product::getAll($append,$pager);
	$vdata['pager'] = $pager;
	
	print_view('products', $vdata);

	print_footer();