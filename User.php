<?php

class User
{
	private $name,
			$Book;

	public function __construct(Book $Book,$name) {
		$this->name = $name;
		$this->Book = $Book;
	}

	public function borrow($title,$author,$publisher)
	{
		$this->Book->setTitle($title);
		$this->Book->setAuthor($author);
		$this->Book->setPublisher($publisher);
	}

	public function updateLibrary()
	{
		file_put_contents('./records.txt', $this->name . 
			" has borrow a book\nTitle : " . $this->Book->getTitle() . 
			"\nAuthor : " . $this->Book->getAuthor() . 
			"\nPublisher : " . $this->Book->getPublisher() . "\n", FILE_APPEND);
	}
}