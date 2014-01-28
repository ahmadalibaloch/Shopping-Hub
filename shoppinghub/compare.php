<?php
	include('php/includes.php');

	$hdata['title'] = 'Compare Products';
	$hdata['page'] = 'compare';

	print_header($hdata);
			
	if($pid_1 = array_value($_POST, 'pid_1'))
	{
		$p1 = Product::getByPK($pid_1);
		$vdata['p1'] = $p1;	
	}
	
	if($pid_2 = array_value($_POST, 'pid_2'))
	{
		$p2 = Product::getByPK($pid_2);
		$vdata['p2'] = $p2;	
	}
		
	$products = Product::getAll();
	$vdata['products'] = $products;
	
	if(!$_POST && $products)
	{
		$vdata['p1'] = $vdata['p2'] = $products[0];	
	}
	
	print_view('compare', $vdata);

	print_footer();