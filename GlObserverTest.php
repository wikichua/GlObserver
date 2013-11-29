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

 		// attach or subscribe foo
 		$Subscriber->__attach('foo', function($a,$b){
 			echo 'notify from foo ' . $a .','. $b . "\n";
 		},[1,2]);

 		// attach or subscribe bar
 		$Subscriber->__attach('bar', function($a,$b){
 			echo 'notify from bar ' . $a .','. $b . "\n";
 		},['a','b']);

 		// attach or subscribe object testing as key
 		$testing = new testing;
 		$Subscriber->__attach($testing,'testtest',['abc','123']);

		$Subscriber->__notify(); // notify all
 		$Subscriber->__notify($testing); // notify just testing method
 		$Subscriber->__notify('foo'); // notify just foo key
 		$Subscriber->__notify(['bar','foo']); // notify specific keys and by its order

 		$Subscriber->__detach('foo'); // detach foo
 		$Subscriber->__notify(); // as already detach foo, so only notify bar and testing

 		$Subscriber->__detach($testing); // detach testing object
		$Subscriber->__notify(); // only left bar in the observer

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