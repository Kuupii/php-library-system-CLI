<?php
    class Author{
        private $author_id;
        private $author_name;

        public function __construct(int $author_id= -1, string $author_name="UNKNOWN"){
            $this->author_id = $author_id;
            $this->author_name = $author_name;
        }

        // getters
        public function getAuthorId(){
            return $this->author_id;
        }

        public function getAuthorName(){
            return $this->author_name;
        }

        public function getArray(){
            return ['author_id' => $this->getAuthorId(),
                    'author_name'=> $this->getAuthorName(),
                    ];
        }
    }
?>

