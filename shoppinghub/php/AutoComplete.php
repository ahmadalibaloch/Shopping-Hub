<?php
class AutoComplete
{
	private $sql, $match_column, $limit;
	
	static function init($sql, $match_column, $limit = 50, $name = '')
	{
		if(self::isCalled())
		{
			if($term = self::getTerm($name))
			{
				$ac = new AutoComplete($sql, $match_column, $limit);
				$ac->render($term);
			}
			
			exit;
		}
	}
	
	private function __construct($sql, $match_column, $limit)
	{
		$this->sql = $sql;
		$this->match_column = $match_column;
		$this->limit = $limit;		
	}
	
	private function render($term)
	{		
		$r = '[';
		
		if($rs = $this->getResult($term))
		{
			while($row = $rs->fetch_assoc())
			{
				$r .= $this->toJason($row, $term);					
			}
			
			$r = substr($r,0,-1);
		}
		
		echo $r.']';
	}
	
	static function isCalled()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($_GET['autocomp']);
	}
	
	private function toJason($data, $term)
	{
		if(false == isset($data['id'])) $data['id'] = $data['value'];
		if(false == isset($data['label'])) $data['label'] = $data['value'];
		if(false == isset($data['_label'])) $data['_label'] = '';
		//return '{"id":"'.$data['id'].'","label":"'.preg_replace('/\b('.str_replace('/','\/',$term).')\.*/i','<b>$1</b>', $data['label']).' '.$data['_label'].'","value":"'.$data['value'].'"},';
		return '{"id":"'.$data['id'].'","label":"'.$data['label'].' '.$data['_label'].'","value":"'.$data['value'].'"},';
	}
	
	static function getTerm($name)
	{		
		return isset($_GET['term']) && ($name ? (isset($_GET['autocomp']) && $name == $_GET['autocomp'] ? true : false) : true) ? $_GET['term'] : null;		
	}
	
	private function getResult($term)
	{
		$db = db();
		return ($rs = $db->query($this->sql.(strpos($this->sql, 'where') ? ' and' : ' where ')."($this->match_column like '".$db->escape($term)."%' or $this->match_column like '% ".$db->escape($term)."%') order by $this->match_column limit $this->limit")) && $rs->num_rows > 0 ? $rs : null;
	}
}