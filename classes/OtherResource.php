<?php
    require_once 'classes/LibraryResource.php';
    
    class OtherResource extends LibraryResource{
        private $id;
        private $res_name;
        private $res_des;
        private $res_brand;

        // static properties
        private static $otherResourceList = [];

        // set resource type
        public function __construct(){
            parent::setResourceCategory("OTHER-RESOURCE");   
        }

        public function Add(){
        }
        public function ResourceList(){
        }
        public function DeleteResource(){
        }      
    }
?>