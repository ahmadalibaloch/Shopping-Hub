<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Customers';
	$hdata['page'] = 'customers';
	
	print_header($hdata);
		
	$append = 'roleId = 4 and true ';
	
	if($search = array_value($_GET, 'search'))
	{
		$append .= "and name like '%$search%'";
	}
	if($delId = array_value($_GET, 'del'))
	{
		User::delete("id = $delId");
	}
	$owners = array();
	
	$customers = User::getAll($append);
	
	$vdata['customers'] = $customers;
	print_view('customers', $vdata);

	print_footer();