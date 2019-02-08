<?php
require 'config/config.php';
if(isset($_SESSION['user_name'])){
    $user = $_SESSION['user_details'];
   //echo "Welcome ". $_SESSION['user_details']['User Name'] . "!!!";
}
else{
    header("Location:register.php");
}
?>

<html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Social Networking Site</title>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="asserts/js/bootstrap.js"></script>


    <link  rel="stylesheet" href="asserts/css/bootstrap.css">
    <link  rel="stylesheet" href="asserts/css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<body>

<div class="top_bar">
    <div class="logo">
        <a href="index.php">Crazji</a>
    </div>
    <nav>
        <a href="<?php
        echo $user['First Name']
        ?>"><?php
            echo $user['First Name']
            ?></a>
        <a href=""><i class="fa fa-home fa-lg"></i></a>
        <a href=""><i class="fa fa-envelope fa-lg"></i></a>
        <a href=""><i class="fa fa-bell fa-lg"></i></a>
        <a href=""><i class="fa fa-users fa-lg"></i></a>
        <a href=""><i class="fa fa-cog fa-lg"></i></a>
        <a href="logout.php"><i class="fa fa-sign-out-alt fa-lg"></i></a>
    </nav>
</div>
<div class="wrapper">