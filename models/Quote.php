

<?php
    class Quote{
        //DB stuff
        private $conn;
        private $table = 'quotes';

        //Properties
        public $id;
        public $quote;
        public $author;
        public $category;
        public $author_id;
        public $category_id;

        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get quotes
        public function read(){
            // create the query

            if (isset($_GET['author_id']) && isset($_GET['category_id'])) {

                $auth_id = ($_GET['author_id']);
                $cat_id = ($_GET['category_id']);


                 $query = 'SELECT 
                 quotes.id, 
                 quotes.quote, 
                 authors.author as author_id, 
                 categories.category as category_id 
                 FROM ' . $this->table . ' 
                 INNER JOIN authors 
                 ON quotes.author_id = authors.id 
                 INNER JOIN categories 
                 ON quotes.category_id = categories.id
                 WHERE author_id = ' . $auth_id . ' 
                 AND category_id = ' . $cat_id;

                // prepare statment
                $stmt = $this->conn->prepare($query);

                //execute query
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // set properties

                if(!$row) {
                    return;
                } else {
                $this->id = $row['id'];
                $this->quote = $row['quote'];
                $this->author_id = $row['author_id'];
                $this->category_id = $row['category_id'];
                }

            } else if (isset($_GET['author_id'])) {
                $auth_id = ($_GET['author_id']);

                $query = 'SELECT 
                quotes.id, 
                quotes.quote, 
                authors.author as author_id, 
                categories.category as category_id 
                FROM ' . $this->table . ' 
                INNER JOIN authors 
                ON quotes.author_id = authors.id 
                INNER JOIN categories 
                ON quotes.category_id = categories.id 
                WHERE author_id = ' . $auth_id;

                // prepare statment
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties

            if(!$row) {
                
                return;
            } else {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            }
            } else if (isset($_GET['category_id'])) {
                $cat_id = ($_GET['category_id']);
                

                $query = 'SELECT 
                quotes.id, 
                quotes.quote, 
                authors.author as author_id, 
                categories.category as category_id 
                FROM ' . $this->table . ' 
                INNER JOIN authors 
                ON quotes.author_id = authors.id 
                INNER JOIN categories 
                ON quotes.category_id = categories.id
                WHERE category_id = ' . $cat_id;

                // prepare statment
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties

            if(!$row) {
                
                return;
            } else {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            }
            }
            
            else 

            $query = 'SELECT 
                quotes.id, 
                quotes.quote, 
                authors.author as author_id, 
                categories.category as category_id 
                FROM ' . $this->table . ' 
                INNER JOIN authors 
                ON quotes.author_id = authors.id 
                INNER JOIN categories 
                ON quotes.category_id = categories.id';
            

            // prepare statments;
            $stmt = $this->conn->prepare($query);

            // excetute
            $stmt->execute();

            return $stmt;
            /* //create query
            $query = 'SELECT
                q.id,
                q.quote,
                a.author as author,
                c.category as category
            FROM
                ' . $this->table . ' q 
            INNER JOIN authors a ON q.author_id = a.id
            INNER JOIN categories c ON q.category_id = c.id
            ORDER BY 
            q.id DESC'; 


            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt; */
        }

        //Get single Quote
        public function read_single(){
            // create query
            

            $query = 'SELECT 
            quotes.id, 
            quotes.quote, 
            authors.author as author_id, 
            categories.category as category_id 
            FROM ' . $this->table . ' 
            INNER JOIN authors 
            ON quotes.author_id = authors.id 
            INNER JOIN categories 
            ON quotes.category_id = categories.id 
            WHERE 
            quotes.id = ?';

            // prepare statment
            $stmt = $this->conn->prepare($query);

            // bind id

            $stmt->bindParam(1, $this->id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties

            if(!$row) {
                return;
            } else {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            }
            /* if (isset($_GET['id'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.id = :id
				LIMIT 1';
			
				$stmt = $this->conn->prepare($query);

				$stmt->bindParam(':id', $this->id);
				$stmt->execute();
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if (is_array($row)) {
					$this->quote = $row['quote'];
					$this->author = $row['author'];
					$this->category = $row['category'];
				}
			}
			
			if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.author_id = :author_id
				AND
					quotes.category_id = :category_id
				ORDER BY quotes.id';
			
				$this->author_id = $_GET['author_id'];
				$this->category_id = $_GET['category_id'];
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':author_id', $this->author_id);
				$stmt->bindParam(':category_id', $this->category_id);
				$stmt->execute();
			
				$quotes = [];
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					
					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}
				
				return $quotes;
			}
			
			if (isset($_GET['author_id'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.author_id = :id
				ORDER BY quotes.id';
			
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();
			
				$quotes = [];
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					
					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}
				
				return $quotes;
			}
			
			if (isset($_GET['category_id'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.category_id = :id
				ORDER BY quotes.id';
			
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();
			
				$quotes = [];
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
				
					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}
				
				return $quotes;
			} */
            
        } 

        //Create a quote
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean the data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //Execute query
            if($stmt->execute()){
                $lastId = $this->conn->lastInsertId();
            
                return $lastId;
                //return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

            if($category->category != null){
                $category_arr = array(
                    'id' => $category->id,
                    'category' => $category->category
                );
                echo json_encode($category_arr);
            }else{
                echo json_encode(
                    array('message' => 'category_id Not Found')
                );
            }
        }

        public function lastId(){
            $stmt2 = $this->conn->lastInsertId();
            $result = ($stmt2);

            return $result;
        }

        //Update Quote
        public function update(){
            //Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                WHERE 
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean the data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
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

        //Delete Quote
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