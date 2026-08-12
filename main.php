<?php
    /*
    main.php
    Kieron Pang
    05/08/2026
    Skill Assessment 1: Software Design Solution
    Select and use three language data types, three operators and three expressions.
    - Use correct language syntax for one sequence, one selection and two iteration constructs.
    - Use a modular approach to implement the logic for one object operation 
    - Implement a class that uses arrays of primitive data types twice.
    - Read from and write to one text file
    - Implement two classes that each contain four instance variables
    - Implement one class that contains two options for object construction
    - Implement one class that uses user-defined object aggregation
    - Implement polymorphism once for code extensibility
    - Use at least two data structures according to organisational guidelines
    - Use at least two standard algorithms (one Search and one sort) according to organisational guidelines
    - Perform two (2) unit tests by writing the code
    */
    /* Determine Users - Two Users are Librarian and Librarian Staff
     Librarian - Managing Library Resources
               - Add, update and deleting books
               - Managing Borrower Records
               - Generating Reports
     Library Staff
               - Issuing and Returning Books
               - Assisting Users
               - Updating Borrower Information
     */
    require_once 'classes/BookClass.php';
    require_once 'classes/OtherResource.php';
    require_once 'classes/Author.php';
    require_once 'art/library.php';
    
    // Loads Information Bit by Bit
    function loadTime(){
        // Give User Time to Read
        echo "Press [ENTER] to continue.\n";
        fgets(STDIN);
    }

    // Driver Code
    // Role selection
    do {
        echo "1: Librarian\n";
        echo "2: Librarian Staff\n";
        $role = readline("Please select a role (1 or 2): ");
    } while ($role < 1 or $role > 2);

    if ($role == 1){
        $role = "Librarian";
    }
    else if ($role == 2){
        $role = "Librarian Staff";
    }

    echo "Welcome $role!\n";

    // Objects
    $books = new BookClass;

    // Art
    echo $libraryArtHalls;
    sleep(1);

    // Main
    do{
        // Welcome
        echo "\n";
        echo "----------------------------------------------------------\n";
        echo "୨୧୨୧୨୧୨୧୨୧ - Welcome to Maddington Library - ୨୧୨୧୨୧୨୧୨୧୨୧\n";
        echo "----------------------------------------------------------\n";

        // Main Loop
        /* Functionalities to consider:
        - List, Add, Delete Books
        - Modify Books
        - Search Books
        - List, Add, Delete Resources
        - Modify Resources
        - Search Resources
        - Borrower Information
        */
        // choices
        echo "1: Exit\n";
        echo "2: View all Books ({$books->getBookCount()})\n"; // ascending/descending
        echo "3: Add a Book\n";
        echo "4: Find a Book by ID\n";
        echo "5: Configure a Book by ID\n";
        echo "6: Delete a Book by ID\n";
        echo "7: Delete ALL Books\n";
        echo "\n";
        echo "8: View all Other Resources\n";
        echo "9: Add an Other Resource\n";
        echo "10: Find an Other Resource by ID\n";
        echo "11: Configure an Other Resource by ID\n";
        echo "12: Delete an Other Resource by ID\n";
        echo "13: Delete ALL Other Resources\n";
        echo "\n";
        echo "99: Delete ALL Resources\n";
        echo "\n";


        // switch
        $choice = (int)readline("Enter command number : ");
        echo "\n";
        $exit = False;
        switch ($choice){
            // List Books
            case 2:
                $books->BookList();
                echo $books->getBookCount() . " entries found.\n";
                loadTime();
                break;
                
            // Add Book
            case 3:
                // book_id, book_name, book_isbn, book_publisher, author_id, author_name
                $book_id = (int)readline("Book ID: ");
                $book_name = readline("Book Name: ");
                $book_isbn = (int)readline("Book ISBN: ");
                $book_publisher = readline("Book Publisher: ");
                $author_id = (int)readline("Author ID: ");
                $author_name = readline("Author Name: ");

                $books->Add($book_id, $book_name, $book_isbn, $book_publisher, $author_id, $author_name);
                loadTime();
                break;
                
            // Find Book
            case 4:
                $idToFind = (int)readline("Enter Book ID you would like to search for: ");
                $books->SearchBook($idToFind);
                echo "\n";
                loadTime();
                break;
                
            // Configure Book
            case 5:
                loadTime();
                break;
                
            // Delete Book
            case 6:
                // get ID
                $deleteId = readline("Book ID to delete: ");
                
                // double check
                $books->SearchBook($deleteId);
                do {
                    $check = readline("Are you sure you want to delete this book?(y/n)");
                    $check = strtolower($check);
                } while ($check != "y" && $check != "n");

                if ($check == "y"){
                    $books->DeleteBook($deleteId);
                }
                else{
                    echo "Aborting...";
                }

                echo "\n";
                loadTime();
                break;
                
            // Delete All Books
            case 7:
                // Double Check
                if ($books->Empty() == True){
                    echo "No  books to delete.\n";
                }
                else{
                    do{
                        $check = readline("Are you sure you want to delete all {$books->getBookCount()} books?(y/n): ");
                        strtolower($check);
                    } while($check != "y" && $check != "n");
                    
                    // Deletes ALL
                    if ($check == "y"){
                        $books->DeleteAll();
                    }
                    else{
                        echo "Aborting...";
                    }
                }
                loadTime();
                break;
                

            case 1:
                echo "Exiting...";
                sleep(1);
                $exit = True;
                break;
            default:
                echo "Invalid Input. Try again.\n";
                loadTime();
                break;
        }


    } while ($exit == False);
?>