<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/Database.php';
	include_once '../../models/Category.php';
    
	$database = new Database();
	$db = $database->connect();
	//new category object
	$categories = new Category($db);
	//Get raw posted data
	$data = json_decode(file_get_contents("php://input"));

	if(!isset($data->category)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}
	//Assign data to posts
	$categories->category = $data->category;
	//Create Category
	if($categories->create()) {
		echo json_encode(
			array('id'=>$categories->id, 'category'=>$categories->category)
		);
	} else {
		echo json_encode(
			array('message' => 'No Category Found')
		);
	}
?>