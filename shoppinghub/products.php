<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Products';
	$hdata['page'] = 'products';
	
	print_header($hdata);
	
	
	
	$pager = new Pager(10);
	
	$append = 'true';
	$products = array();
	$search = '';
	$category_name = '';
	if(($search = array_value($_GET, 'search')) && array_value($_GET,'search') != 'all')
	{	
		$append .= " and (search like '$search%' or search like '% $search%')";
		
		$sql = "select count(id) from _products_search where $append";
		$pager->init(db()->scalar($sql));
		
		$cols = Product::getCols();
		$sql = "select $cols from _products_search where $append limit $pager->offset, $pager->limit";	
		
		if($rs = db()->query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$products[] = new Product($row);
			}
		}
	}
	else if($owner = array_value($_GET, 'owner'))
	{
		$products = Product::getAll("ownerId = $owner",$pager);
		$category_name='Owner, '.Owner::getByPK($owner)->getName();
	}
	else if($cat = array_value($_GET, 'cat'))
	{
		$products = Product::getAll("categoryId = $cat",$pager);
		$search = Category::getByPK($cat)->getName();
		
	}
	else if(USER_ROLE == 'owner')
	{
		if($del = array_value($_GET, 'del'))
		{
			trace('deleting');
			Product::delete("id = $del");
			redirect('products.php?owner='.OWNER_ID);
		}
		elseif(($search = array_value($_GET, 'search'))=='all')
		{
			$products = Product::getAll('true', $pager);
			$search='';
		}
		else
		{
			$products = Product::getAll('ownerId = '.Owner::getOne('userId = '.USER_ID)->getId(), $pager);
			$category_name='Owner, '.USER_NAME;
		}
	}
	else
	{
		$products = Product::getAll($append, $pager);
		$search='all';
	}

	$vdata['category_name'] = $category_name;
	$vdata['products'] = $products;
	$vdata['search'] = $search;
	$vdata['pager'] = $pager;
	
	print_view('products', $vdata);

	print_footer();