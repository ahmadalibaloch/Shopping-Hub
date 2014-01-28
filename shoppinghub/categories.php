<?php
	include('php/includes.php');
	
	$hdata['title'] = 'Product Categories';
	$hdata['page'] = 'categories';
	
	print_header($hdata);
	
	$append = 'true ';
	
	$categories = array();
		
	$pager = new Pager(10);
	if($ownerId = array_value($_GET, 'owner'))
	{			
		$sql = "SELECT COUNT(DISTINCT c.name) FROM categories c INNER JOIN products p ON p.categoryId=c.id AND ownerId = $ownerId";
		$pager->init(db()->scalar($sql));
		
		$sql = "SELECT DISTINCT c.id, c.name, c.descr, c.image FROM categories c INNER JOIN products p ON p.categoryId=c.id AND ownerId = $ownerId limit $pager->offset, $pager->limit"	;
		if($rs = db()->query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$categories[] = new Category($row);
			}
		}
	}
	else
	{
		$categories = Category::getAll($append,$pager);
	}	
	$vdata['categories'] = $categories;
	
	$vdata['pager'] = $pager;
	
	print_view('categories', $vdata);

	print_footer();