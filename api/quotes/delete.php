<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/Database.php';
	include_once '../../models/Quote.php';

	$database = new Database();
	$db = $database->connect();

    //Instantiate Author Object
    $quotes = new Quote($db);
    // get raw posted data
    $data = json_decode(file_get_contents("php://input"));
    
    
    //Set id to UPDATE
    $quotes->id = $data->id;

    //Delete post
    if($quotes->delete()){
        echo json_encode(
            array('id' => $quotes->id)
        );
    } else{
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
?>