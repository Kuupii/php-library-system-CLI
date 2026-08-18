<?php
    class LibraryResource{
        protected $resource_category;

        // setter-getters
        public function getResourceCategory(){
            return $this->resource_category;
        }

        public function setResourceCategory($newCategory){
            $this->resource_category = $newCategory;
        }

        public function getDescription(){
            return "This is a general library resource.";
        }
    }
?>