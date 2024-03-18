<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
	
	include_once '../../config/Database.php';
	include_once '../../models/Author.php';
	
	$database = new Database();
	$db = $database->connect();
	
	$authors = new Author($db);
	//Author query
    $result = $authors->read();
	//Get row count
	$num = $result->rowCount();
	//Check if any authors
	if ($num > 0) {
        //Author array
		$author_arr = array();
		$author_arr = array();
		
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			
			$author_item = array(
				'id' => $id,
				'author' => $author
			);
			//push to "data
			array_push($author_arr, $author_item);
		}
		
		echo json_encode($author_arr);
	} else {
        //No posts
		echo json_encode(
			array('message' => 'No Authors Found')
		);
	}
	
?>