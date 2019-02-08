<?php
ob_start();
session_start();
$timeZone = date_default_timezone_set('Asia/Kolkata');
$connection = mysqli_connect("localhost", "sa", "password","socialnetwork");
if(!$connection){
    echo "Failed to connect " . mysqli_connect_errorno();
}
?>