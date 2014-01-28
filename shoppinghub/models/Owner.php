<?php
class Owner extends Model
{
	static $table = 'owners';
	static $cols = 'id, userId, rating, business';
	
	function countProducts(){
		return Product::countAll("ownerId = {$this->getId()}");
	}
	function countCategories(){
		$result = db()->assoc("SELECT COUNT(DISTINCT c.id) AS total FROM categories c 
		INNER JOIN products p ON p.categoryId = c.id 
		WHERE p.ownerId = {$this->getId()}");
		return $result['total'];
	}	
	function getName(){
		return User::getOne("id = {$this->getUserId()}")->getName();
	}
	function getPhone(){
		return User::getOne("id = {$this->getUserId()}")->getPhone();
	}
	function getEmail(){
		return User::getOne("id = {$this->getUserId()}")->getEmail();
	}
	function getAddress(){
		return User::getOne("id = {$this->getUserId()}")->getAddress();
	}
	
	function getCategories(){
		return Category::getAll("ownerId = {$this->getId()}");
	}
	function getPhoto($width){
		return User::getOne("id = {$this->getUserId()}")->getPhoto($width);
	}
}
