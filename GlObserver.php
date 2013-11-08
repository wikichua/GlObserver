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
		if(!$this->__isset($Observer))
			$this->__Observers[$this->__getName($Observer)] = [ $Observer, $map, $args ];
	}

	public function __detach($Observer = null)
	{
		if(is_null($Observer))
		{
			if($this->__isset($Observer))
				unset($this->__Observers[$this->__getName($Observer)]);
		}else{
			$this->__Observers = [];
		}
	}

	public function __notify($Observer = null)
	{
		if(is_null($Observer))
		{
			if(count($this->__Observers) > 0)
			{
				foreach ($this->__Observers as $key => $Obs) {
					list($obj, $map, $args) = $Obs;
					$this->__callback($obj, $map, $args);
				}
			}
		}else{
			if($this->__isset($Observer))
			{
				list($obj, $map, $args) = $this->__Observers[$this->__getName($Observer)];
				$this->__callback($obj, $map, $args);
			}
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
			if(!is_null($map))
				call_user_func_array([$obj,$map],$args);
			else
				call_user_func_array([$obj,'update'],$args);
		else
			call_user_func_array($map,$args);
	}

}