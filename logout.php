<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/19/14
 * Time: 6:37 AM
 */

session_start();
session_unset();
session_destroy();
header("Location: buy.php");
?>