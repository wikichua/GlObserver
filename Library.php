<?php
require_once './GlObserver.php';

class Library
{
	use GlObserver;

	function updateRecordBooks()
	{
		$this->__notify();
	}

	function newBookEntry()
	{
		$this->__notify();
	}
}