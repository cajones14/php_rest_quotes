<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	
	include_once '../../config/Database.php';
	include_once '../../models/Quote.php';
	
	$database = new Database();
	$db = $database->connect();

    //Instantiate Category Object
    $quotes = new Quote($db);
    
    // get id 
    if(isset($_GET['id'])) {
        $quotes->id = $_GET['id'];
    }

    // get author 
    $quotes->read_single();



    //create array
    $quote_arr = array(
        'id' => $quotes->id,  
        'quote' => $quotes->quote, 
        'author' => $quotes->author_id, 
        'category' => $quotes->category_id
    );

    if(!$quotes->quote) {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    } else {

    // make json
    print_r(json_encode($quote_arr));
    }

    /* if(isset($_GET['id'])){
        //Get ID from url
        $quotes->id = $_GET['id']

        //Get post by calling read_single
        $quotes->read_single();

        $quote_arr = array(
            'id' => $quotes->id,
            'quote' => $quotes->quote,
            'author' => $quotes->author,
            'category' => $quotes->category
        );

        if($quotes->quote !== null){
            //Change to JSON
            print_r(json_encode($quote_arr, JSON_NUMERIC_CHECK));
        }else{
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }
    if(isset($_GET['author_id']) !== null){
        $quotes->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
        $quote_arr = $quotes->read_single();
    }
    if(isset($_GET['category_id'])){  
        $quotes->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
        $quote_arr = $quotes->read_single();
    }
    if(isset($_GET['author_id']) && isset($_GET['category_id'])){
        $quotes->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
        $quotes->read_single();
    }

    echo json_encode($quote_arr); */


?>