<?php  
    /*
    unit_test.php
    Kieron Pang
    Skill Assessment 1: Software Design Solution    
    */

    use PHPUnit\Framework\TestCase;

    require 'classes/BookClass.php';

    class BookClassTest extends TestCase{

        public function testSearchBook(){ // Returns True/False if Book Found
            echo "testSearchBook\n";
            $books = new BookClass();

            $this->assertTrue($books->SearchBook(2534));
            $this->assertFalse($books->SearchBook(999999));
        }

        public function testGetCount(){ // Returns a numerical integer
            echo "testGetCount";
            $books = new BookClass();

            $count = $books->getCount();

            $this->assertIsInt($count); // Check is Int Value
            $this->assertGreaterThanOrEqual(0, $count); // Check Greater Than or Equal to Zero
        }
    }
    // .\vendor\bin\phpunit .\unit_test\BookClassTest.php
?>

