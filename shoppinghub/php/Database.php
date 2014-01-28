<?php
class Database extends mysqli
{
	private static $instance =  null;
	
	
	private function Database()
	{
		parent::mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}

	function query($sql)
	{
		$rs = parent::query($sql);
		$this->check_error($sql);
		return $rs;
	}

	function assoc_all($sql)
	{
		$rt = array();
		
		if($rs = $this->query($sql))
		{
			while($rw = $rs->fetch_assoc()) $rt[] = $rw;			
			$rs->close();
		}
	
		return $rt;
	}

	function assoc($sql)
	{
		$rt = array();
		
		if($rs = $this->query($sql))
		{
			$rt = $rs->fetch_assoc();
			$rs->close();
		}
		
		return $rt;
	}

	function scalar($sql)
	{
		$rt = '';
		
		if($rs = $this->query($sql))
		{
			if(($row = $rs->fetch_row()) && isset($row[0])) $rt = $row[0];
			$rs->close();
		}
		
		return $rt;
	}

	function key_value($sql)
	{
		$rt = array();
		
		if($rs = $this->query($sql))
		{
			while($rw = $rs->fetch_row()) $rt[$rw[0]] = $rw[1];
			$rs->close();
		}
		
		return $rt;
	}

	function exists($table, $column, $value, $append='true')
	{
		return $value == $this->scalar("select $column from $table where $append and $column = '".$this->escape($value)."'");
	}
	
	function sp_query($sp_name, $params)
	{
		$sql = $this->sp_sql($sp_name, $params);
		$rs = parent::query($sql);
		$this->check_error($sql);
		return $rs;
	}

	function sp_assoc_all($sp_name, $params)
	{
		$rt = array();
		
		if($rs = $this->sp_query($sp_name, $params))
		{
			while($rw = $rs->fetch_assoc()) $rt[] = $rw;			
			$rs->close();
			$this->next_result();
		}
		
		return $rt;
	}

	function sp_assoc($sp_name, $params)
	{
		$rt = array();
		
		if($rs = $this->sp_query($sp_name, $params))
		{
			$rt = $rs->fetch_assoc();
			$rs->close();
			$this->next_result();
		}
		
		return $rt;
	}

	function sp_scalar($sp_name, $params)
	{
		$rt = '';
		
		if($rs = $this->sp_query($sp_name, $params))
		{
			if(($row = $rs->fetch_row()) && isset($row[0])) $rt = $row[0];
			$rs->close();
			$this->next_result();
		}
		
		return $rt;
	}

	function sp_key_value($sp_name, $params)
	{
		$rt = array();
		
		if($rs = $this->sp_query($sp_name, $params))
		{
			while($rw = $rs->fetch_row()) $rt[$rw[0]] = $rw[1];
			$rs->close();
			$this->next_result();
		}
		
		return $rt;
	}

	function escape(& $var)
	{
		if(is_string($var))	return $this->real_escape_string(trim($var));
		return $var;
	}

	static function getInstance()
	{
		if(self::$instance == null) self::$instance = new Database();
		return self::$instance;
	}

	private function sp_sql($sp_name, $params)
	{
		return 'call '.$sp_name.'('.implode(',', $params).')';
	}
	
	private function check_error($sql)
	{		
		if($this->error && (APP_ENV == 'testing' || APP_ENV == 'development'))
		{
			$trace = debug_backtrace();
			preg_match('/syntax to use near(.*)/', $this->error, $matches);
				
			$error = (isset($matches[1]) ? 'syntax error'. $matches[1].'\'' : $this->error)." in query : \n<font color=\"blue\">".$sql."</font>\non page ".$trace[2]['file'].' line '.$trace[2]['line'];
			
			switch(APP_ENV )
			{
				case 'testing':
					echo '<script type="text/javascript">';
					echo 'console || console.error(\''.strip_tags($error).'\');';
					echo '</script>';
					break;
				case 'development':
					trace($error);
			}
		}
	}
}