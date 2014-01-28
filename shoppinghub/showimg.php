<?php
	include_once("php/config.php");
	
	if($src  = urldecode($_GET['s']))
	{	
		if(!(strpos($src,"ttp://") || strpos($src,"ttps://")))
		{
			$remote = false;
			$src = APP_ROOT.$src;
		}
		else
		{
			$remote = true;
			$src = str_replace("%2F","/",$src);
			$src = str_replace(" ","%20",$src);
			$src = str_replace("+","%20",$src);
		}
	}
	else
	{
		exit("no image");
	}
	
	$ext = getExtension($src);

	if(strtolower($ext) == "gif"){
		$source = imagecreatefromgif($src);
	}
	elseif(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg"){
		$source = imagecreatefromjpeg($src);
	}
	elseif(strtolower($ext) == "png"){
		$source = imagecreatefrompng($src);
	}
	else{
		$source = imagecreatefromjpeg($src);
	}
	
	$wmax = $_GET['w']+0;
	$hmax = $_GET['h']+0;

	
	$wori = imagesx($source);
	$hori = imagesy($source);
	
	$ratio = $hori / $wori;
	
	if(isset($_GET['original']))
	{
		$resize_by = 'original';
		$wmax = $wori;
		$hmax = $hori;
	}
	elseif($wmax == 0 && $hmax == 0)
	{
		$resize_by = 'width';
		$wmax = 150;
		$hmax = $hori;
	}
	elseif($wmax == 0 && $hmax > 0)
	{
		$resize_by = 'height';
		$wmax = $wori;
		if($hmax > $hori) $hmax = $hori;
	}
	elseif($hmax == 0 && $wmax > 0)
	{
		$resize_by = 'width';
		$hmax = $hori;
		if($wmax > $wori) $wmax = $wori;
	}
	else
	{
		if($wmax > $wori) $wmax = $wori;
		if($hmax > $hori) $hmax = $hori;
		
		$resize_by = ($ratio * $wmax) > $hmax ? 'height' : 'width';		
	}


	if($resize_by == 'height')
	{
		$hres = $hmax;
		$wres = $hres / $ratio;
	}	
	elseif($resize_by == 'width')
	{
		$wres = $wmax;
		$hres = $ratio * $wres;
	}
	elseif($resize_by == 'original')
	{
		$wres = $wmax;
		$hres = $hmax;
	}
	
	$thumb = imagecreatetruecolor($wres,$hres);
	imagecopyresampled($thumb, $source,0,0,0,0,$wres,$hres,$wori,$hori);
	
	//var_dump($thumb);
	
	ob_clean();
	header("Content-type: image/jpeg");
	
	imagejpeg($thumb,'',90);
	imagedestroy($thumb);

	function getExtension($Filename){
		$Extension = explode (".", $Filename);
		$Extension_i = (count($Extension) - 1);
		return $Extension[$Extension_i];
	}
?>