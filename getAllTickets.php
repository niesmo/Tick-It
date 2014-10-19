<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/18/14
 * Time: 7:55 PM
 */

require_once "config/class_inc.php";

global $db;
$tickets = new Ticket($db->select("ticket"));
header('Content-Type: application/json;charset=utf-8;');
echo json_encode($tickets);
?>