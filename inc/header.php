<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tick-It</title>
    <link rel="stylesheet" href="http://bootswatch.com/journal/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/components/flipclock/flipclock.css" type="text/css" />
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo BASE_URL;?>">Tick-It</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo BASE_URL . "/buy.php";?>">Buy</a></li>
                <li><a href="<?php echo BASE_URL . "/sellItem.php";?>">Sell</a></li>
            </ul>
            <form class="navbar-form navbar-left">
                <input id="search-query" type="text" class="form-control col-lg-8" placeholder="Search">
            </form>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
                ?>
                    <li><a href="<?php echo BASE_URL;?>/logout.php">Logout</a></li>
                <?
                }
                else{
                ?>
                    <li><a href="<?php echo BASE_URL;?>/signin.php">Login/Sign Up</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>