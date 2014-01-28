<?php
class Object
{
	protected $events;
	
	function __call($n, $a)
	{
		if(preg_match('/^(([g|s])et)(.)(.+)/', $n, $m))
		{
			$n = strtolower($m[3]).$m[4];
			if($m[1] == 'get') return $this->$n;
			if($m[1] == 'set') $this->$n = $a[0];
		}
    }

	function __toString()
	{
		return get_class($this);
	}
	
	function bind($event, $callback, $object = null)
	{
		if(!isset($this->events[$event])) $this->events[$event] = array();
		$this->events[$event][] = ($object === null)  ? $callback : array($object, $callback);
	}
	
	function raise($event, array $args = array())
	{
		$m = 'on'.ucfirst($event);
		if(method_exists($this, $m)) $this->$m($agrs);
		if(isset($this->events[$event])) foreach($this->events[$event] as $callback) call_user_func_array($callback, $args);
	}
}