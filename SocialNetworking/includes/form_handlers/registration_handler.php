<?php
$fName = "";
$lName = "";
$email = "";
$pwd = "";
$pwd_confirm = "";
$date = "";
$error_array = array();
$profPict = "";
$no_posts = 0;
$no_likes = 0;
$user_closed = 0;
$friendAway = array();
$userName = '';


if(isset($_POST['reg_submit'])){


    $fName = strip_tags($_POST["fName"]); // If the fName is like <a>kiran</a>, then the strip_tags will remove the tags.
    $fName = str_replace(' ', '', $fName);
    $fName = ucfirst(strtolower($fName));
    $_SESSION['fName'] = $fName;

    $lName = strip_tags($_POST["lName"]);
    $lName = str_replace(' ', '', $lName);
    $lName = ucfirst(strtolower($lName));
    $_SESSION['lName'] = $lName;

    $email = strip_tags($_POST["email"]);
    $email = str_replace(' ', '', $email);
    $email = strtolower($email);
    $_SESSION['email'] = $email;

    $email2 = strip_tags($_POST["email2"]);
    $email2 = str_replace(' ', '', $email2);
    $email2 = strtolower($email2);
    $_SESSION['email2'] = $email2;

    $pwd = strip_tags($_POST["password"]);
    $_SESSION['password'] = $pwd;
    $pwd_confirm = strip_tags($_POST["password2"]);
    $_SESSION['password2'] = $pwd_confirm;
    $date = date("Y-m-d");
    $dob = strip_tags($_POST["dob"]);
    $_SESSION['dob'] = $dob;

    if($pwd != $pwd_confirm){
        array_push($error_array,"Passwords doesn't match<br>");
    }
    else{
        if(preg_match('/[^A-Za-z0-9]/', $pwd)){ // Regular expression
            array_push($error_array,"password should contain english or numbers<br>");
        }
    }

    if($email == $email2){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            $result = mysqli_query($connection,"select Count(Id) as cnt from user where Email='" . $email . "'");
            $res = mysqli_fetch_object($result);
            $count_of_email = $res->cnt;
            if($count_of_email > 0){
                array_push($error_array,"user already exists.<br>");
            }
        }
        else{
            array_push($error_array,"invalid format of email.<br>");
        }
    }
    else{
        array_push($error_array,"Re-check the email Id<br>");
    }

    if(empty($error_array)){
        $password = md5($pwd);
        $userName = strtolower($fName."_".$lName);
        $result = mysqli_query($connection, "select Count(Id) as cnt from user where `User Name` like'" . $userName. "%'");
        $res = mysqli_fetch_object($result);
        $count_userName = $res -> cnt;
        if($count_userName > 0){
            $userName = $userName.($count_userName + 1);
        }

        //profile pic
        $profPict = "asserts/Images/Profile_Pics/Defaults/head_alizarin.png";

        if(isset($_FILES["profile_pic"])){
            $file_folder= "asserts/Images/Profile_Pics/";
            $file_path = $file_folder. strtolower($fName."_".$lName) . "_" . basename($_FILES["profile_pic"]["name"]);
            //echo ($_FILES["profile_pic"]["name"] . ", " .$_FILES["profile_pic"]["type"]. ", " .$_FILES["profile_pic"]["tmp_name"]. ", " .$_FILES["profile_pic"]["error"]. ", " .$_FILES["profile_pic"]["size"]);
            move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $file_path);
            $profPict = $file_path;
        }


        $query = mysqli_query($connection,"insert into user values (NULL, '$fName', '$lName', '$userName',
                '$email', '$password', '$dob', '$date', '$profPict', '$no_posts', '$no_likes', '$user_closed', '')");


        array_push($error_array, "Successfully Registered.");
        $_SESSION["fName"] = "";
        $_SESSION["lName"] = "";
        $_SESSION["email"] = "";
        $_SESSION["email2"] = "";
        $_SESSION["password"] = "";
        $_SESSION["password2"] = "";
        $_SESSION["date"] = "";
        $_SESSION["dob"] = "";
    }
}

?>