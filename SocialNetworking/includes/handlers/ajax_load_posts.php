<?php
    include ("../../config/config.php");
    include("../classes/Post.php");
    include("../classes/User.php");
    $limit = 100;
    $posts = new Post($connection, $_REQUEST['userLoggedIn']);
    $posts->getPosts($_REQUEST, $limit);
?>