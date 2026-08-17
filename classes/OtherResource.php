<?php
    require_once 'classes/LibraryResource.php';
    
    class OtherResource extends LibraryResource{
        private $id;
        private $res_name;
        private $res_des;
        private $res_brand;

        // static properties
        private const FILE_PATH = "data/otherResourceList.json";

        // set resource type
        public function __construct(){
            parent::setResourceCategory("OTHER-RESOURCE");   
        }

        private static function readData(){
            if(!file_exists(self::FILE_PATH)){
                return [];
            }
            $file = file_get_contents(self::FILE_PATH);
            return json_decode($file, true) ?? []; // Associative Array, fallsback to empty list []
        }
        private static function writeData($resource){
            $file = json_encode($resource, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT makes it easier for humans to read
            file_put_contents(self::FILE_PATH, $file);
        }

        public function Add(int $id, string $res_name, string $res_des, string $res_brand){
            // Read data
            $resource = self::readData();

            if(isset($resource[$id])){ // check dupe
                echo "Error: Other Resource with ID $id already exists!\n";
                return;
            }

            // Add new Other Resource
            $resource[$id] = [
                'res_name' => $res_name,
                'res_des' => $res_des,
                'res_brand' => $res_brand,
                'resource_category' => $this->getResourceCategory(),
            ];

            // Write
            self::writeData($resource);

            // Confirm
            echo "Other Resource added successfully.\n";   
        }
        public function ResourceList(){
            // Read Data
            $resource = self::readData();
            
            // Check empty
            if (empty($resource)){
                echo "No Other Resources available!\n!!!Failed\n\n";
            }

            else{
                // Display every entry
                echo "         --- List of Other Resources ---\n";
                foreach ($resource as $id => $aResource){
                    echo "* ID ($id)\n* [Resource Name]: {$aResource['res_name']}\n* [Resource Description]: {$aResource['res_des']}\n* [Resource Brand]: {$aResource['res_brand']}\n";
                    echo "\n";
                }
            }
        }
        public function DeleteResource($id){
            // Read Data
            $resource = self::readData();

            // Check empty
            if (empty($resource)){
                echo "No Other Resources available!\n!!!Failed\n\n";
            }

            else{                
                // Removal
                if(isset($resource[$id])){
                    unset($resource[$id]);
                    self::writeData($resource); // rewrites newly changed list of Other Resources to existing file
                    echo "Other Resource with ID [$id] deleted successfully.\n";
                } else {
                    echo "Other Resource with ID [$id] not found.\n";
                }
            }            
        }  
        public function DeleteAll(){
            $num = $this->getCount(); // record number of Other Resources before deletion
            $resources = [];
            self::writeData($resources);
            echo "All $num Other Resources deleted successfully.\n";
        }    
        public function getCount(){
            // Read Data
            $resource = self::readData();

            // Count
            return count($resource);
        }
        public function SearchResource($resourceID){
            // Read Data
            $resource = self::readData();

            // empty check
            if (empty($resource)){
                echo "No Other Resources available!\n!!!Failed\n\n";
                return False;
            }

            else{
                $found = False;
                foreach($resource as $id=>$aResource){
                    if ($id == $resourceID){
                        echo "OTHER RESOURCE FOUND!\n";
                        $found = True;
                        echo "ID [$resourceID]\n* Name: {$aResource['res_name']}\n* Resource Description: {$aResource['res_des']}\n* Resource_Brand: {$aResource['res_brand']}\n* Resource Type: {$aResource['resource_category']}\n";
                    }
                }
                if ($found == False){
                    echo "!!! Resource with ID [$resourceID] could not be found.\n";
                    return False;
                }
                return True;
            }

        }
        public function SortResource(){
            // Read Data
            $resource = self::readData();
            
            // empty check
            if(empty($resource)){
                echo "No Other Resource available!\n!!!Failed\n\n";
                return;
            }

            else{
                // sort and write
                ksort($resource);
                self::writeData($resource);

                // confirm
                echo "Other Resources sorted by ID (ascending) successfully.\n";
            }

        }
        public function SortResourceDes(){
            // Read Data
            $resource = self::readData();
            
            // empty check
            if(empty($resource)){
                echo "No Other Resources available!\n!!!Failed\n\n";
                return;
            }

            else{
                // sort and write
                krsort($resource);
                self::writeData($resource);

                // confirm
                echo "Other Resources sorted by ID (descending) successfully.\n";
            }
        }
    }
?>