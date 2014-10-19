<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/19/14
 * Time: 7:32 AM
 */

require_once "config/class_inc.php";

//print_r($_POST);
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $ticket = new Ticket($id);
    $res = $ticket->updateDiscount($_POST['newPrice'], $_POST['duration']);
    print_r($res);
}


?>