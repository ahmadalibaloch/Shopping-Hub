<?php
	include('php/includes.php');

	$hdata['title'] = 'Add Owner';
	$hdata['page'] = 'owners';

	$message = '';
	$owner = '';
	if($ownerId = array_value($_GET,'id'))
	{	
		$owner = Owner::getOne("id = $ownerId");	
	}
	
	$mesasage = '';
	
	print_header($hdata);


	$vdata['message'] = $mesasage;
	
	$vdata['owner'] = $owner;
	print_view('Owner', $vdata);

	print_footer();