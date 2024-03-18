<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/Category.php';

	$database = new Database();
	$db = $database->connect();
     //Instantiate Category Object
    $categories = new Category($db);
    //Blog post query
    $result = $categories->read();
    //Get row count
    $num = $result->rowCount();

    //Check if any quotes
    if($num > 0){
        //category array
        $category_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            //push to "data
            array_push($category_arr, $category_item);
        }
        //Turn to JSON & output
        echo json_encode($category_arr);
    }else{
        //No posts
        echo json_encode(
            array('message' => 'No Category Found')
        );
    } 

?>