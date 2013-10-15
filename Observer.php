<?php

trait Observer
{

	private $__Observers = [];

	public function __isset($Observer)
	{
		foreach ($this->__Observers as $key => $value) {
			if($value[0] == $Observer)
				return $key;
		}
		return FALSE;
	}

	public function __attach($Observer, $map = null, $args = [])
	{
		if(!$this->__isset($Observer))
			$this->__Observers[] = [ $Observer, $map, $args ];
	}

	public function __detach($Observer)
	{
		if(!($key = $this->__isset($Observer)))
			unset($this->__Observers[$key]);
	}

	public function __notify()
	{
		foreach ($this->__Observers as $Observer) {
			list($obj, $map, $args) = $Observer;
			
			if(is_object($obj))
				if(!is_null($map))
					call_user_func_array([$obj,$map],$args);
				else
					call_user_func_array([$obj,'update'],$args);
			else
				call_user_func_array($map,$args);
		}
	}

}