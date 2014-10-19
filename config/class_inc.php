<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//this is the config file where we set the the database configs
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","tickets");
define("BASE_URL", "http://localhost/Tick-It");
define("BASE_PATH", "C:/Program Files (x86)/Zend/Apache2/htdocs/Tick-It");
define("PROJECT_NAME", "Tick-It");

function __autoload($class_name) {
    require_once BASE_PATH. "/classes/" .$class_name . '.php';
}

//creating connection to the database
$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);

// the class instantiations go here
// link $user = new User($db);

$MTicket = new Ticket();
?>