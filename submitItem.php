<?php



if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'submitItem' : submitItem($_POST['name'],$_POST['description'],$_POST['price'],$_POST['discountedPrice'],$_POST['discountedDuration'],$_POST['checkEmail'],$_POST['checkPhone']);break;
      

    }
}


function submitItem( $name,$description,$price,$discountedPrice,$discountedDuration, $checkEmail,$checkPhone)
{
	$con = mysqli_connect("localhost","root","","tickets");
	
	mysqli_query($con,"INSERT INTO ticket (price, discount,email_shared,phone_number_shared,title) VALUES ('$price','$discountedPrice','$checkEmail','$checkPhone','$name')");
}

?>



