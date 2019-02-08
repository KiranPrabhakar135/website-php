<?php
$login_emailId = '';
$login_password = '';
$user_name = '';


//if(isset($_SESSION['user_details'])){
//    header("Location:index.php");
//}

if(isset($_POST['login_submit'])){
    $login_emailId = $_POST['login_emailId'];
    $_SESSION['login_emailId'] = $_POST['login_emailId'];
    $filtered_email = filter_var($login_emailId, FILTER_SANITIZE_EMAIL);
    if($filtered_email)    {
        $login_emailId = $filtered_email;
    }
    $_SESSION['login_password'] = $_POST['login_password'];
    $login_password = md5($_POST['login_password']) ;

    $query = "select * from user where Email='$login_emailId' and Password = '$login_password'";

    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);
    if($count == 1){
        $result_obj = mysqli_fetch_array($result);
        $_SESSION['user_details'] = $result_obj;

        $user_name = $result_obj['User Name'];
        $_SESSION['user_name'] = $user_name;
        $is_account_closed = $result_obj['User Closed'];
        if($is_account_closed){
            $update_query = "update user set `User Closed` = 0 where `User Name` = '$user_name'";
            $update_response = mysqli_query($connection, $update_query);
        }
        header("Location:index.php");
    }
    else{
        array_push($error_array, "Login failed");
    }
}
?>