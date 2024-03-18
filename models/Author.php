<?php
    class Author{
        //DB stuff
        private $conn;
        private $table = 'authors';

        //Properties
        public $id;
        public $author;

        
        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get authors
        public function read(){
            //create query
            $query = 'SELECT
                id,
                author
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

        //Get single Author
        public function read_single(){
            //create a query
            $query = 'SELECT 
                    id,
                    author
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
                        $this->id = $row['id'];
                        $this->author = $row['author'];
                    }
                    
                    /* if($row){
                        //Set Properties
                        $this->id = $row['id'];
                        $this->author = $row['author'];
                    }else{
                        $this->id = false;
                        $this->author = false;
                    }
                    if($row>0){
                        return true;
                    }else{
                        return false;
                    } */
        }

        //Create an author
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . ' (author)
                VALUES(:author)';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean the data
            $this->author = htmlspecialchars(strip_tags($this->author));

            //Bind data
            $stmt->bindParam(':author', $this->author);

            //Execute query
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;


            
        }

        //Update Author
        public function update(){
            //Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    author = :author
                WHERE 
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean the data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            //Bind data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            //Execute query
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;

            echo $query;
        }

        //Delete Author
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

       /*  public function isValidAutId($model){
            $result = $model->read_single();
            if($model->id && $model->author){
                return true;
            }else{
                return false;
            }
        }

        public function lastId(){
            $stmt2 = $this->conn->lastInsertId();
            $result = ($stmt2);
            return $result;
        }

        public function isValid($model, $id){
            $model->id = $this->id;
            $result = $model->read_single();
            return $result;
        } */
    }
?>