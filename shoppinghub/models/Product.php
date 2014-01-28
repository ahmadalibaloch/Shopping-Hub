<?php
class Product extends Model
{
	static $table = 'products';
	static $cols = 'id, name, ownerId, quantity, categoryId, price, image';
	
	function getCategory()
	{
		return Category::getByPK($this->getCategoryId());
	}
	
	function getOwner()
	{
		return Owner::getByPK($this->getOwnerId());
	}
	
	function getPhoto($width = 200)
	{
		if($this->getImage($width))
		{
		return SITE_URL.'showimg.php?s='.'images/products/'.parent::getImage($width)."&w=$width"; 
		}
		else
		return '';
	}
	
}