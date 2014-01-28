<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Owners';
	$hdata['page'] = 'owners';
	
	print_header($hdata);
		
	$append = 'true ';
	
	if($search = array_value($_GET, 'search'))
	{
		$append .= "and name like '%$search%'";
	}
	
	$owners = array();
	
	if($categoryId = array_value($_GET, 'category'))
	{
		$sql = ("SELECT distinct o.id,o.userId,o.rating FROM owners o JOIN products p WHERE p.ownerId = o.id AND categoryId = $categoryId");
		if($rs = db()->query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$owners[] = new Owner($row);
			}
		}
	}
	if($delId = array_value($_GET, 'del'))
	{
		User::delete('id = '.Owner::getOne($delId)->getUserId());
		Owner::delete('id ='.$delId);
	}
	else
	{
		$owners = Owner::getAll($append);
	}
	
	$vdata['owners'] = $owners;
	print_view('owners', $vdata);

	print_footer();