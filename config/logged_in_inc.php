<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/19/14
 * Time: 6:50 AM
 */
session_start();
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
    require_once("class_inc.php");
    include("inc/header.php");
}
else{
    header('Location: signin.php');
}

