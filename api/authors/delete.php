<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/Database.php';
	include_once '../../models/Author.php';

	$database = new Database();
	$db = $database->connect();
	
	$authors = new Author($db);
	
    //Get raw posted data
	$data = json_decode(file_get_contents("php://input"));
	//Set id to Delete
    $authors->id = $data->id;
	//delete authoe
	if($authors->delete()) {
		echo json_encode(
			array('id'=>$authors->id)
		);
	} else {
		echo json_encode(
			array('message' => 'No Authors Found')
		);
	}

?>