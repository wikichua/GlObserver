<?php
require_once './Observer.php';

class Library
{
	use Observer;

	function updateRecordBooks()
	{
		$this->__notify();
	}

	function newBookEntry()
	{
		$this->__notify();
	}
}