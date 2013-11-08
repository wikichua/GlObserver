<?php
require_once './GlObserver.php';
require_once './Book.php';
require_once './User.php';
require_once './Library.php';
/**
 * ObserverTest
 *
 */
class GlObserverTest extends \PHPUnit_Framework_TestCase
{
 	public function testInitiate()
 	{
 		$Subscriber = new Library;

 		$Subscriber->__attach('foo', function($a,$b){
 			echo 'notify from foo ' . $a .','. $b . "\n";
 		},[1,2]);

 		$testing = new testing;
 		$Subscriber->__attach($testing,'testtest',['abc','123']);

		$Subscriber->__notify();

 		$Subscriber->__notify($testing);

 		$Subscriber->__detach('foo');
 		$Subscriber->__detach($testing);


 		$Subscriber->__notify();

 	}

 	public function testCanCallMagicSetterAndGetterInBook()
 	{
 		$Book = new Book;
 		$Book->setTitle('PHP');
 		$this->assertSame('PHP', $Book->getTitle());
 	}

 	public function testUserCanBorrowBookFromLibrary()
 	{
 		$User = new User(new Book, 'Wiki');
 		$User->borrow('PHP','Wiki','Pai');

 		$Library = new Library;
 		$Library->__attach($User,'updateLibrary');

 		$Library->updateRecordBooks();
 	}

 	public function testNewBookAriveAndNotifyUser()
 	{
 		$Book = new Book;
 		$Book->setTitle('PHP Design Patterns');
 		$Book->setAuthor('WikiChua');
 		$Book->setPublisher('PaiPai');

 		$Library = new Library;
 		$Library->__attach($Book);

 		$Library->newBookEntry();
 	}

 	public function testPutAllTogether()
 	{
 		$User = new User(new Book, 'Wiki');
 		$User->borrow('MySQL','Wiki','Pai');

 		$Book = new Book;
 		$Book->setTitle('MySQL Design Patterns');
 		$Book->setAuthor('WikiChua');
 		$Book->setPublisher('PaiPai');

		$Library = new Library;
 		$Library->__attach($User,'updateLibrary');
 		$Library->__attach($Book);
 		$Library->__notify();

 	}

 	public function testPutAllTogetherWithMoreUsersAndNewBooks()
 	{
 		$User = new User(new Book, 'Wiki');
 		$User->borrow('MongoDB','Wiki','Pai');
 		$User1 = new User(new Book, 'Wiki');
 		$User1->borrow('Redis','Wiki','Pai');
 		$User2 = new User(new Book, 'Wiki');
 		$User2->borrow('Apache','Wiki','Pai');

 		$Book = new Book;
 		$Book->setTitle('MongoDB Design Patterns');
 		$Book->setAuthor('WikiChua');
 		$Book->setPublisher('PaiPai');
 		$Book1 = new Book;
 		$Book1->setTitle('Redis Design Patterns');
 		$Book1->setAuthor('WikiChua');
 		$Book1->setPublisher('PaiPai');
 		$Book2 = new Book;
 		$Book2->setTitle('Apache Design Patterns');
 		$Book2->setAuthor('WikiChua');
 		$Book2->setPublisher('PaiPai');

		$Library = new Library;
 		$Library->__attach($User,'updateLibrary');
 		$Library->__attach($User1,'updateLibrary');
 		$Library->__attach($User2,'updateLibrary');
 		$Library->__attach($Book);
 		$Library->__attach($Book1);
 		$Library->__attach($Book2);
 		$Library->__notify();

 	}
}

class testing
{
	function testtest($a,$b)
	{
		echo 'notify from testing ' . $a .','. $b  . "\n";
	}
}