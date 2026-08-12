<?php
    require_once 'classes/LibraryResource.php';
    require_once 'classes/Author.php';

    class BookClass extends LibraryResource{
        private $id;
        private $book_name;
        private $book_isbn;
        private $book_publisher;
        private $author;

        // defining constant file path
        private const FILE_PATH = "data\\bookList.json";

        // set resource type
        public function __construct(){
            parent::setResourceCategory("BOOK");   
        }

        // Read and Write JSON
        private static function readData(){
            if(!file_exists(self::FILE_PATH)){
                return [];
            }
            $file = file_get_contents(self::FILE_PATH);
            return json_decode($file, true) ?? []; // Associative Array, fallsback to empty list []
        }

        private static function writeData($book){
            $file = json_encode($book, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT makes it easier for humans to read
            file_put_contents(self::FILE_PATH, $file);
        }

        // Public Methods
        public function Add(int $id, string $book_name, int $book_isbn, string $book_publisher, int $author_id, string $author_name){
            // Parameters Set
            $this->id = $id;
            $this->book_name = $book_name;
            $this->book_isbn = $book_isbn;
            $this->book_publisher = $book_publisher;
            $this->author = new Author($author_id, $author_name);
        
            // Read data
            $books = self::readData();

            if(isset($books[$id])){ // check dupe
                echo "Error: Book with ID $id already exists!\n";
                return;
            }

            // Add new book
            $books[$id] = [
                'book_name' => $book_name,
                'book_isbn' => $book_isbn,
                'book_publisher' => $book_publisher,
                'author' => $this->author->getArray(),
            ];

            // Write
            self::writeData($books);

            // Confirm
            echo "Book added successfully.\n";
        }

        public function DeleteBook($id){
            // Read Data
            $books = self::readData();

            // Check empty
            if (empty($books)){
                echo "No books available!\n!!!Failed\n\n";
            }

            else{                
                // Removal
                if(isset($books[$id])){
                    unset($books[$id]);
                    self::writeData($books); // rewrites newly changed list of books to existing file
                    echo "Book with ID [$id] deleted successfully.\n";
                } else {
                    echo "Book with ID [$id] not found.\n";
                }
            }

        }

        public function DeleteAll(){
            $num = $this->getBookCount(); // record number of books before deletion
            $books = [];
            self::writeData($books);
            echo "All $num books deleted successfully.\n";
        }
        public function BookList(){
            // Read Data
            $books = self::readData();
            
            // Check empty
            if (empty($books)){
                echo "No books available!\n!!!Failed\n\n";
            }

            else{
                // Display every entry
                echo "         --- List of Books ---\n";
                foreach ($books as $id => $book){
                    echo "* ID ($id)\n* [Name]: {$book['book_name']}\n* [ISBN]: {$book['book_isbn']}\n* [Publisher]: {$book['book_publisher']}\n* [Author]: {$book['author']['author_name']}\n";
                    echo "\n";
                }
            }

        }

        public function getBookCount(){
            // Read Data
            $books = self::readData();

            // Count
            return count($books);
        }

        public function SearchBook($bookID){
            // Read Data
            $books = self::readData();

            // empty check
            if (empty($books)){
                echo "No books available!\n!!!Failed\n\n";
            }

            else{
                $found = False;
                foreach($books as $id=>$book){
                    if ($id == $bookID){
                        echo "BOOK FOUND!\n";
                        $found = True;
                        echo "ID [$bookID]\n* Name: {$book['book_name']}\n* ISBN: {$book['book_isbn']}\n* Publisher: {$book['book_publisher']}\n* Author Name: {$book['author']['author_name']}\n* Author ID: {$book['author']['author_id']}\n";
                    }
                }
                if ($found == False){
                    echo "!!! Book with ID [$bookID] could not be found.\n";
                }
            }

        }

        public function SortBook(){
            // Read Data
            $books = self::readData();
            
            // empty check
            if(empty($books)){
                echo "No books available!\n!!!Failed\n\n";
                return;
            }

            else{
                // sort and write
                ksort($books);
                self::writeData($books);

                // confirm
                echo "Books sorted by ID (ascending) successfully.\n";
            }

        }

        public function SortBookDes(){
            // Read Data
            $books = self::readData();
            
            // empty check
            if(empty($books)){
                echo "No books available!\n!!!Failed\n\n";
                return;
            }

            else{
                // sort and write
                krsort($books);
                self::writeData($books);

                // confirm
                echo "Books sorted by ID (descending) successfully.\n";
            }
        }

        public function Empty(){
            $books = self::readData();
            if (empty($books)){
                return True;
            }
            else{
                return False;
            }
        }
    }
    // test
    // book_id, book_name, book_isbn, book_publisher, author_id, author_name
    // $test = new BookClass;
    // $test->Add(2534, "Ao Ashi", 928399928, "Shogakukan", 1, "Yugo Kobayashi");
    // $test->Add(6752, "Eragon", 201922919, "Alfred A. Knopf", 2, "Christopher Paolini");
    // $test->Add(9203, "I know what you did last Wednesday", 291929392, "Walker Books", 3, "Anthony Horowitz");
    // $test->Add(2918, "Happy Face", 222919112, "Naver Webtoon", 4, "Jeo-nyeok LEE");
    // $test->Add(3292, "Amulet", 220098796, "Graphix", 5, "Kazu Kibuishi");
?>