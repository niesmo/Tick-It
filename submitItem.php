<?php
session_start();


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'submitItem' :
            submitItem($_POST['name'],$_POST['description'],$_POST['price'],$_POST['discountedPrice'],$_POST['discountedDuration'],$_POST['checkEmail'],$_POST['checkPhone']);
            break;
    }
}


function submitItem( $name,$description,$price,$discountedPrice,$discountDuration, $checkEmail,$checkPhone)
{
    if(!isset($discountedPrice) || !is_numeric($discountedPrice) ){
        $discountedPrice = $price;
    }



	$con = mysqli_connect("localhost","root","","tickets");
    if($checkEmail)
        $checkEmail = 1;
    else
        $checkEmail = 0;

    if($checkPhone)
        $checkPhone = 1;
    else
        $checkPhone = 0;


    header('Content-Type: application/json');

    $query = "INSERT INTO ticket (title, description, price, discounted_price, email_shared, phone_number_shared, created_by_id) ". "VALUES ('$name', '$description', $price,$discountedPrice,$checkEmail,$checkPhone, ".$_SESSION['user_id'].")";

    $res = mysqli_query($con,$query);
    if($res == 1){
        $response = array("status"=>"success");
        echo json_encode($response, true);

        return;
    }

    $response = array("status"=>"failed", "query"=>$query);
    echo json_encode($response, true);
}

?>