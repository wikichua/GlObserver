<?php

class Book
{
	private $title,
			$author,
			$publisher;

	public function __call($name,$args)
	{
		if(preg_match('/^set/i', $name))
		{
			$property = preg_replace('/^set(.+)/i', '$1', strtolower($name));
			$this->{$property} = $args[0];
		}

		if(preg_match('/^get/i', $name))
		{
			$property = preg_replace('/^get(.+)/i', '$1', strtolower($name));
			return $this->{$property};
		}	
	}

	public function update()
	{
		file_put_contents('./newarrival.txt', 
			"New book has arrive\nTitle : " . $this->getTitle() . 
			"\nAuthor : " . $this->getAuthor() . 
			"\nPublisher : " . $this->getPublisher() . "\n", FILE_APPEND);
	}
}