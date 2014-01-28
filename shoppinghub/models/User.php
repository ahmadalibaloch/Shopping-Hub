<?php
class User extends Model
{

	static $table = 'users';
	static $cols = 'id, username, name, password, email, phone, address, joinDate, leaveDate, lastLogin, image, roleId';
	
	private static $loggedIn = false;
		
	function getRole()
	{
		return Role::getByPK($this->getRoleId())->getName();
	}
	
	function login()
	{
		$_SESSION['uid'] = $this->getId();
	}
	
	function logout()
	{
		unset($_SESSION['uid']);
	}
	
	static function getLoggedIn()
	{
		if(self::$loggedIn === false)
			self::$loggedIn = User::getByPK(arr($_SESSION, 'uid'));
		
		return self::$loggedIn;
	}
	
	function getRating()
	{
		if($o = Owner::getOne("userId = {$this->getId()}"))
		{
			return $o->getRating();
		}
	}
	
	function isGuest(){
		return $this->getId()==1;
	}
	
	function printName(){
		echo $this->getName();
	}
	
	function getPhoto($width = 100)
	{
		if($this->getImage())
		return SITE_URL.'showimg.php?s='.'images/users/'.parent::getImage()."&w=$width"; 
		else
		return '';
	}
}
