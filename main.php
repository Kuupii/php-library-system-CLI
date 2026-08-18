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
    } while ($role != 1 && $role != 2 && $role != 9218);

    if ($role == 1){
        $role = "Librarian";
    }
    else if ($role == 2){
        $role = "Librarian Staff";
    }
    else if ($role == 9218){
        $role = "ADMIN";
    }

    echo "Welcome $role!\n";

    // Objects
    $books = new BookClass;
    $resource = new OtherResource;

    // Art
    echo $libraryArtHalls;
    sleep(1);   

    // Main
    do{
        // Screen Clear & Fixes Top Left
        echo "\e[H\e[2J"; 
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
        echo "You are a [{$role}].\n\n";
        // choices
        if ($role == "Librarian"){
            echo "2: View all Books ({$books->getCount()})\n"; 
            echo "3: Add a Book\n";
            echo "4: Find a Book by ID\n";
            echo "5: Delete a Book by ID\n";
            echo "6: Delete ALL Books\n";
            echo "\n";
            echo "7: View all Other Resources ({$resource->getCount()})\n";
            echo "8: Add an Other Resource\n";
            echo "9: Find an Other Resource by ID\n";
            echo "10: Delete an Other Resource by ID\n";
            echo "11: Delete ALL Other Resources\n";
            echo "\n";
            echo "1: Exit\n";
            echo "\n";
        }
        else if ($role == "Librarian Staff"){
            echo "2: View all Books\n";
            echo "4: Find a Book by ID\n";            
        }
        else{
            echo "2: View all Books ({$books->getCount()})\n"; 
            echo "3: Add a Book\n";
            echo "4: Find a Book by ID\n";
            echo "5: Delete a Book by ID\n";
            echo "6: Delete ALL Books\n";
            echo "\n";
            echo "7: View all Other Resources ({$resource->getCount()})\n";
            echo "8: Add an Other Resource\n";
            echo "9: Find an Other Resource by ID\n";
            echo "10: Delete an Other Resource by ID\n";
            echo "11: Delete ALL Other Resources\n";
            echo "\n";
            echo "90: POLYMORPHISM EXAMPLE\n";
            echo "88: ADD TEST DEBUG DATA\n";
            echo "99: DELETE ALL\n";
            echo "\n";
            echo "1: Exit\n";
            echo "\n";            
        }

        // switch
        $choice = (int)readline("Enter command number : ");
        echo "\n";
        $exit = False;

        // Screen Clear & Fixes Top Left
        echo "\e[H\e[2J"; 

        switch ($choice){
            // List Books
            case 2:
                $books->BookList();
                echo $books->getCount() . " entries found.\n";
                echo "\n";
                loadTime();
                break;
                
            // Add Book
            case 3:
                if ($role == "Librarian" || $role == "ADMIN"){
                    // book_id, book_name, book_isbn, book_publisher, author_id, author_name
                    $book_id = (int)readline("Book ID: ");
                    $book_name = readline("Book Name: ");
                    $book_isbn = (int)readline("Book ISBN: ");
                    $book_publisher = readline("Book Publisher: ");
                    $author_id = (int)readline("Author ID: ");
                    $author_name = readline("Author Name: ");
                    
                    $author = new Author($author_id, $author_name);

                    $books->Add($book_id, $book_name, $book_isbn, $book_publisher, $author);
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;
                
            // Find Book
            case 4:
                $idToFind = (int)readline("Enter Book ID you would like to search for: ");
                $books->SearchBook($idToFind);
                echo "\n";
                loadTime();
                break;                
            // Delete Book
            case 5:
                if ($role == "Librarian" || $role == "ADMIN"){
                    // get ID
                    $deleteId = (int)readline("Book ID to delete: ");
                    
                    // double check
                    $books->SearchBook($deleteId);
                    do {
                        $check = readline("Are you sure you want to delete this book?(y/n): ");
                        $check = strtolower($check);
                    } while ($check != "y" && $check != "n");

                    if ($check == "y"){
                        $books->DeleteBook($deleteId);
                    }
                    else{
                        echo "Aborting...";
                    }
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;
                
            // Delete All Books
            case 6:
                if ($role == "Librarian" || $role == "ADMIN"){
                    // Double Check
                    if ($books->getCount() == 0){
                        echo "No books to delete.\n";
                    }
                    else{
                        do{
                            $check = readline("Are you sure you want to delete all {$books->getCount()} books?(y/n): ");
                            $check = strtolower($check);
                        } while($check != "y" && $check != "n");
                        
                        // Deletes ALL
                        if ($check == "y"){
                            $books->DeleteAll();
                        }
                        else{
                            echo "Aborting...";
                        }
                    }
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;
            // View Other Resources
            case 7:
                $resource->ResourceList();
                echo $resource->getCount() . " entries found.\n";                
                
                echo "\n";
                loadTime();
                break;
            // Add Other Resource
            case 8:
                if ($role == "Librarian" || $role == "ADMIN"){
                    // resource_id, resource_name, resource_description, resource_brand
                    $resource_id = (int)readline("Resource ID: ");
                    $resource_name = readline("Resource Name: ");
                    $resource_description = readline("Book Description: ");
                    $resource_brand = readline("Resource Brand: ");

                    $resource->Add($resource_id, $resource_name, $resource_description, $resource_brand);
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;         
            // Find Resource
            case 9:
                $idToFind = (int)readline("Enter Other Resource ID you would like to search for: ");
                $resource->SearchResource($idToFind);
                echo "\n";
                loadTime();
                break;      
            // Delete Resource
            case 10:
                if ($role == "Librarian" || $role == "ADMIN"){
                    // get ID
                    $deleteId = (int)readline("Other Resource ID to delete: ");
                    
                    // double check
                    if ($resource->SearchResource($deleteId)){
                        do {
                            $check = readline("Are you sure you want to delete this Other Resource?(y/n): ");
                            $check = strtolower($check);
                        } while ($check != "y" && $check != "n");

                        if ($check == "y"){
                            $resource->DeleteResource($deleteId);
                        }
                        else{
                            echo "Aborting...";
                        }
                    }
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;  
            // Delete ALL Other Resources
            case 11:
                if ($role == "Librarian" || $role == "ADMIN"){
                    // Double Check
                    if ($books->getCount() == 0){
                        echo "No Other Resource to delete.\n";
                    }
                    else{
                        do{
                            $check = readline("Are you sure you want to delete all {$resource->getCount()} Other Resources?(y/n): ");
                            $check = strtolower($check);
                        } while($check != "y" && $check != "n");
                        
                        // Deletes ALL
                        if ($check == "y"){
                            $resource->DeleteAll();
                        }
                        else{
                            echo "Aborting...";
                        }
                    }
                }
                echo "\n";
                loadTime();
                break;        
            // Delete Everything (Hidden)
            case 99:
                if ($role == "ADMIN"){
                    // Double Check
                    if ($books->getCount() == 0){
                        echo "No books to delete. Skipping...\n";
                    }

                    if ($resource->getCount() == 0){
                        echo "No Other Resource to delete. Skipping...\n";
                    }
                    
                    if ($resource->getCount() > 0 || $books->getCount() > 0){
                        do{
                            $check = readline("Are you sure you want to delete all {$resource->getCount()} Other Resources and all {$books->getCount()} books?(y/n): ");
                            $check = strtolower($check);
                        } while($check != "y" && $check != "n");
                        
                        // Deletes ALL
                        if ($check == "y"){
                            if (!empty($books)){
                                $books->DeleteAll();
                            }
                            if (!empty($resource)){
                                $resource->DeleteAll();
                            }
                        }
                        else{
                            echo "Aborting...";
                        }
                    }
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;                 
            // Exit
            case 1:
                echo "Exiting...";
                sleep(1);
                $exit = True;
                break;
            
            // Polymorphism Test (Hidden)
            case 90:
                if ($role == "ADMIN"){
                    $description1 = $books->getDescription();
                    $description2 = $resource->getDescription();

                    echo "Book - getDescription(): " . $description1 . "\n" . "Other Resource - getDescription(): " . $description2 . "\n";
                }
                else{
                    echo "Access Denied\n";
                }
                echo "\n";
                loadTime();
                break;
            // Debug (Hidden)
            case 88:
                if ($role == "ADMIN"){
                    $newBook = new BookClass;

                    $author1 = new Author(1, "Yuho Kobayashi");
                    $author2 = new Author(2, "Christopher Paolini");
                    $author3 = new Author(3, "Christopher Paolini");
                    $author4 = new Author(4, "Jeo-nyeok LEE");
                    $author5 = new Author(5, "Kazu Kibuishi");

                    $newBook->Add(2534, "Ao Ashi", 928399928, "Shogakukan", "NA", $author1);                
                    $newBook->Add(6752, "Eragon", 201922919, "Alfred A. Knopf", "Borrowed by User1", $author2);                
                    $newBook->Add(9203, "I know what you did last Wednesday", 291929392, "Walker Books", "Borrowed by User2", $author3);                
                    $newBook->Add(2918, "Happy Face", 222919112, "Naver Webtoon", "NA", $author4);                
                    $newBook->Add(3292, "Amulet", 220098796, "Graphix", "NA", $author5);

                    $newResources = new OtherResource;
                    $newResources->Add(2293, "Television", "QLED, 8K Ultra HD", "Samsung", "Borrowed by User1");
                    $newResources->Add(2931, "Piano", "CA701 Digital Piano 88-keys", "Kawai", "Borrowed by User1");
                    $newResources->Add(723, "Camera", "7500 DSLR 18-140mm Lens", "Nikon", "NA");    
                }
                else{
                    echo "Access Denied\n";
                }                
                echo "\n";
                loadTime();
                break;
            // Default retries
            default:
                echo "Invalid Input. Try again.\n";
                loadTime();
                break;
        }
    } while ($exit == False);
?>