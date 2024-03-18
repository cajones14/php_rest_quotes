<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once ('../../config/Database.php');
	include_once ('../../models/Quote.php');

	$database = new Database();
	$db = $database->connect();

    //Instantiate Quote Object
    $quotes = new Quote($db);
    //Blog post query
    $result = $quotes->read();
    // testing to see if there are any results
    if(!$result) {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        return;
    }
    //Get row count
    $num = $result->rowCount();



    //Check if any quotes
    if($num > 0){
        //Quor=te array
        $quote_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author_id,
                'category' => $category_id
            );

            //push to "data
            array_push($quote_arr, $quote_item);
        }
        //Turn to JSON & output
        echo json_encode($quote_arr);
    }else{
        //No quotes
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }

?>