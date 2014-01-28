<?php
	include('php/includes.php');

	$hdata['title'] = 'Add Product';
	$hdata['page'] = 'products';
	print_header($hdata);
	
	$message = '';
	$product = '';

	$append = 'false ';	
	
	if($_POST)
	{
		$id = array_value($_POST,'id');
		$name = $_POST['name'];
		$ownerId = Owner::getOne('userId = '.USER_ID)->getId();
		$quantity = $_POST['quantity'];
		$categoryName = $_POST['categoryId'];
		$price = $_POST['price'];
		
		if(!trim($name)){
			$message = 'Please enter a category name';
		}
		
		$p = new Product();
		if($image = array_value($_FILES,'image'))
		{
			if($image['error']==0 && preg_match('/image/',$image['type']))
			{
				if(move_uploaded_file($image['tmp_name'],APP_ROOT.'images/products/'.$image['name']))
				{
					$p->setImage($image['name']);
				}
				else
					$message = 'image not uploaded successfully';
			}
			else if($image['error']==2 || $image['error']==3) 
			{
				$message = 'image size is too large, limit is 2MB.';
			}
		}
		
		$p->setId($id);
		$p->setName($name);
		$p->setOwnerId($ownerId);
		$categoryId = Category::getOne("name = '$categoryName'")->getId();
		$p->setCategoryId($categoryId);
		$p->setPrice($price);
		$p->setQuantity($quantity);
		
		//check total categories
		$sql = "SELECT COUNT(DISTINCT(c.name)) FROM categories c INNER JOIN products p ON p.categoryId = c.id AND p.ownerId  = $ownerId";		
		$categoryCount = db()->scalar($sql);
		if($categoryCount > 4)
		$message = 'you are using 5 categories already. You cant add product to a new category.';
		
		//check total products in this category.
		$productCount = Product::countAll("ownerId = $ownerId AND categoryId = $categoryId");
		if($productCount > 9)
			$message = 'you have already added 10 products in this category';
		

		
		if($message == '')
		{
			if($p->save()){
				$message = 'Product added successfully';
			}
			else {
				$message = 'Product adding failed';
			}
		}
	}
	if($editId = array_value($_GET,'edit'))
	{
		$append = "id = $editId";
	}
		
	



	$vdata['message'] = $message;
	$vdata['categories']=Category::getAll();
	$vdata['products']=Product::getAll($append);

	print_view('addProduct', $vdata);

	print_footer();