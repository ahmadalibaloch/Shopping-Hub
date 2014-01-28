<?php
class Category extends Model                                                               
{
	static $table = 'categories';
	static $cols = 'id, name, descr, image'; 
	function countProducts(){
		return Product::countAll('categoryId = '.$this->getId());
	}
	function countOwners(){
		$count = db()->assoc("SELECT COUNT(DISTINCT ownerId) as total FROM products WHERE categoryId = {$this->getId()}");
		return $count['total'];
	}
	
	function getPhoto($width = 100)
	{
		if($this->getImage())
		return SITE_URL.'showimg.php?s='.'images/categories/'.parent::getImage()."&w=$width"; 
		else
		return '';
	}
}