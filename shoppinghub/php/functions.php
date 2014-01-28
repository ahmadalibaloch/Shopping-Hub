<?php
function __autoload($class_name)
{
	$file1 = PHP.$class_name.'.php';
	$file2 = MODELS.$class_name.'.php';
		
	if(is_file($file1)) require($file1);
	elseif(is_file($file2)) require($file2);	
}

function db()
{
	return Database::getInstance();
}

function fdate($date, $time = false)
{
	$tf = $time ? ' h:i:s A' : '';
	return date('d F, Y'.$tf, strtotime($date));
}

function trace($v)
{
	echo '<pre style="text-align:left">';
	if($v && !is_bool($v)) print_r($v);
	else var_dump($v);
	echo '</pre>';
}

function rand_limit_rows(array &$rows, $limit=0, $mix = true)
{
	if(($cnt = count($rows)) == 0) return $rows;

	if($limit == 0 || $limit > $cnt) $limit = $cnt;

	$keys = array_rand($rows, $limit);
	$r_rows = array();

	if(is_array($keys))
	{
		foreach($keys as $key)
		{
			$r_rows[] = $rows[$key];
		}

		if($mix) shuffle($r_rows);
	}
	else
	{
		$r_rows[] = $rows[$keys];
	}

	return $r_rows;
}

function group_by_property($obj_arr, $property)
{
	$r = array();
	$curr = '';
	$prev = '';

	foreach($obj_arr as $obj)
	{
		if($obj->$property == false) continue;
		$curr = $obj->$property;
		if($curr != $prev) $r[$curr] = '';
		if(isset($r[$curr])) $r[$curr][] = $obj;
		$prev = $curr;
	}

	return $r;
}

function check_url($url)
{
	if(preg_match('/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)+/i', $url)) return true;
	return false;
}

function array_value($arr, $key, $def = null)
{
	return isset($arr[$key]) ? $arr[$key] : $def;
}

function print_header(array $data = array())
{
	foreach($data as $key=>$value) $$key = $value;
	
	include(VIEWS.'header.phtml');
}

function print_footer(array $data = array())
{
	foreach($data as $key=>$value) $$key = $value;
	
	include(VIEWS.'footer.phtml');
}

function print_view($view_name, array $data = array())
{
	foreach($data as $key=>$value) $$key = $value;
	
	include(VIEWS.$view_name.'.phtml');
}
function redirect($pageName){
		header('location: '.SITE_URL.$pageName);
		exit;
}
function check_login($message_id){
	if(USER_ROLE == 'guest'){
		$_SESSION['from_url'] = substr($_SERVER['REQUEST_URI'],13);
		redirect('userlogin.php?id='.$message_id);
	}
} 
function get_sql_date()
{	
	return date('Y-m-d h:i:s');
}
function validate($field,$type = 'name'){
		$field = trim($field);
		if(!$field)
		 return $field.' is empty';
		switch($type)
		{
			case 'name':
				if(strlen($field) < 3)
				return 'name must be greater than 3 characters';
			case 'password':
				if(strlen($field) < 3)
				return 'passwrod must be greater than 3 characters';
			case 'username':
			if(strlen($field) < 3)
				return 'username must be greater than 3 characters';
			else if(User::countAll("username = '$field'")>0)
				return 'username already exists';
			case 'number':
				return '';
			
		}
		return '';
}