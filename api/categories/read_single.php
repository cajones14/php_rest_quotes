<?php
    header('Content-Type: application/json');
	
	include_once '../../config/Database.php';
	include_once '../../models/Category.php';
	
	$database = new Database();
	$db = $database->connect();

    //Instantiate Category Object
    $categories = new Category($db);
    //Get ID from url
    $categories->id = isset($_GET['id']) ? $_GET['id'] : die(); //ternary operator

    //Get post by calling read_single
    $categories->read_single();

    if($categories->category != null){
        $category_arr = array(
            'id' => $categories->id,
            'category' => $categories->category
        );
        echo json_encode($category_arr);
    }else{
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }

?>