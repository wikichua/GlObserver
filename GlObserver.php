<?php

trait GlObserver
{

	private $__Observers = [];

	public function __isset($Observer)
	{
		foreach (array_keys($this->__Observers) as $key) {
			if($key == $this->__getName($Observer))
				return TRUE;
		}
		return FALSE;
	}

	public function __attach($Observer, $map = null, $args = [])
	{
		$map = is_null($map)? 'update':$map;
		
		if(!$this->__isset($Observer))
			$this->__Observers[$this->__getName($Observer)] = [ $Observer, $map, $args ];
	}

	public function __detach($Observer = null)
	{
		if(is_null($Observer))
		{
			$this->__Observers = [];
		}else{
			if($this->__isset($Observer))
				unset($this->__Observers[$this->__getName($Observer)]);
		}
	}

	public function __notify($Observer = null)
	{
		if(is_null($Observer))
		{
			if(count($this->__Observers) > 0)
			{
				$this->__doAllCallback($this->__Observers);
			}
		}else{
			if(is_array($Observer))
			{
				foreach ($Observer as $Obs) {
					$this->__doSingleCallback($Obs);
				}
			}else{
				$this->__doSingleCallback($Observer);
			}			
		}
	}

	protected function __doSingleCallback($Observer)
	{
		list($obj, $map, $args) = $this->__Observers[$this->__getName($Observer)];
		$this->__callback($obj, $map, $args);
	}

	protected function __doAllCallback($Observer)
	{
		foreach ($Observer as $Obs) {
			list($obj, $map, $args) = $Obs;
			$this->__callback($obj, $map, $args);
		}
	}

	protected function __getName($Observer)
	{
		$name = $Observer;
		
		if(is_object($Observer))
		{
			$name = spl_object_hash ( $Observer );
		}

		return $name;
	}

	protected function __callback($obj, $map, $args)
	{
		if(is_object($obj))
			call_user_func_array([$obj,$map],$args);
		else
			call_user_func_array($map,$args);
	}

}