<?php
    class Category{
        //DB stuff
        private $conn;
        private $table = 'categories';

        //Properties
        public $id;
        public $category;

        
        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get categories
        public function read(){
            //create query
            $query = 'SELECT
                id,
                category
            FROM
                ' . $this->table . '
            ORDER BY
                id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }

        //Get single Category
        public function read_single(){
            //create a query
            $query = 'SELECT 
                    id,
                    category
                    FROM
                    ' . $this->table . ' 
                    WHERE
                    id = :id
                    LIMIT 1';  

                    //Prepare Statement
                    $stmt = $this->conn->prepare($query);

                    //Bind ID
                    $stmt->bindParam(':id', $this->id);

                    //Execute query
                    $stmt->execute();

                    //Ftech the array
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    
                    if(is_array($row)){
                        //Set Properties
                        $this->id = $row['id'];
                        $this->category = $row['category'];
                    }
        }

         //Create a category
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . '(category)
                Values(:category)';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean the data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data
            $stmt->bindParam(':category', $this->category);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            printf("Error: %s.\n",$stmt->error);
            return false;

            /* $row = $stmt-fetch(PDO::FETCH_ASSOC);
            if($row){
                print_r(json_encode($row, JSON_FORCE_OBJECT));
            }else{
                printf("Error: %s.\n", $stmt->error);

                return false;
            } */
            
        }

        //Update Category
        public function update(){
            //Create query
            $query = 'UPDATE ' . $this->table . '
                SET 
                    category = :category
                WHERE 
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean the data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

            echo $query;
            
        }

        //Delete Category
        public function delete(){
            //Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind id
            $stmt->bindParam(':id', $this->id);

            //Execute query
            if($stmt->execute()){
                return true;
            }
            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
            
        }

    }

?>