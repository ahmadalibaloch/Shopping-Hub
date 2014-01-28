<?php
class Model extends Object
{
	protected $data = array();
	
	function __call($n, $a)
	{
		if(preg_match('/^(([g|s])et)(.)(.+)/', $n, $m))
		{
			$n = strtolower($m[3]).$m[4];
			if($m[1] == 'get') return $this->data[$n];
			if($m[1] == 'set') $this->data[$n] = $a[0];
		}
    }
	
	function __construct(array $data = array())
	{
		
		foreach($data as $k=>$v){
			$this->data[$k] = $v;
		}
	}
	
	function save()
	{
		$pk = isset($this->data['id']) ? intval($this->data['id']) : 0;
		unset($this->data['id']);
		$q = $pk === 0 ? 'insert into '.$this::$table.' set ' : 'update '.$this::$table.' set ';
		foreach($this->data as $k=>$v) $q .= $k.' = \''.addslashes($v).'\', ';
		$this->data['id'] = $pk;
		$q = substr($q, 0, -2);
		$q .= $pk > 0 ? ' where id = '.$pk : '';
		$db = db();
		if(($r = $db->query($q)) && $pk == 0) $this->data['id'] = $db->insert_id;
		return $r;
	}
	
	static function delete($sql_append = 'false')
	{
		$m = get_called_class();
		$q = 'delete from '.$m::$table.' where '.$sql_append;
		return db()->query($q);
	}
	
	static function getCols($alias = null)
	{
		if($alias) $alias .= '.';		
		$m = get_called_class();		
		return $alias.str_replace(',', ', '.$alias, str_replace(', ', ',', $m::$cols));
	}
	
	static function getByPK($id)
	{
		if(($id = intval($id)) == 0) return null;
		$m = get_called_class();
		$q = 'select '.$m::$cols.' from '.$m::$table.' where id = '.$id;
		if($row = db()->assoc($q))	return new $m($row);
		return null;
	}
	
	static function getOne($sql_append = 'true')
	{
		$m = get_called_class();
		$q = 'select '.$m::$cols.' from '.$m::$table.' where '.$sql_append;
		if($row = db()->assoc($q))	return new $m($row);
		return null;
	}
	
	static function countAll($sql_append = 'true')
	{
		$ms = array();
		$m = get_called_class();		
		$q = 'select count(id) from '.$m::$table.' where '.$sql_append;		
		$count = 0;
		
		if(strpos($sql_append, 'group by'))
		{
			if($rs = db()->query($q)) $count = $rs->num_rows;
		}
		else $count = db()->scalar($q);
		
		return $count;
	}
	
	static function getAll($sql_append = 'true', $pager = null)
	{
		$m = get_called_class();
		
		if($pager && get_class($pager) == 'Pager')
		{
			$pager->init($m::countAll($sql_append));
			$limit_append = 'limit '.$pager->offset.', '.$pager->limit;
		}
		else $limit_append = '';
		
		$ms = array();		
		$q = 'select '.$m::$cols.' from '.$m::$table." where $sql_append $limit_append";		
		if($rs = db()->query($q)) while($row = $rs->fetch_assoc()) $ms[] = new $m($row);		
		return $ms;
	}
	
	static function getKeyValue($column, $sql_append = 'true')
	{
		$m = get_called_class();
		$q = 'select id, '.$column.' from '.$m::$table." where $sql_append";
		return db()->key_value($q);
	}
}