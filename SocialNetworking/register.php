<?php
require 'config/config.php';
require 'includes/form_handlers/registration_handler.php';
require 'includes/form_handlers/login_handler.php';
function test_file_operations(){
    $file = fopen("asserts/files/sample.txt", 'r');
    $str = "<ul>";
    while(!feof($file)) {
        $line = fgets($file);

        $str.= "<li>" .$line . "</li>";
        # do same stuff with the $line
    }
    echo $str .="</ul>";
}

?>

<html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="asserts/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="asserts/js/register.js"></script>
</head>
<body>

<div class="wrapper">
    <?php
    echo"
    <script>
        $(document).ready(function(e){
            $('#Login').hide();
            $('#Registration').show();
        })
    </script>
    ";
    ?>
    <div class="login_box">
        <div class="login_header">
            <h1>Crazji</h1>
            <div>Login or Sign Up!!</div>
        </div>
        <div id="Login">
            <form action="register.php" method="post">
                <div>
                    <span>Email: </span>
                    <input type="email" name="login_emailId" value="<?php
                    if(isset($_SESSION["login_emailId"])){
                        echo $_SESSION["login_emailId"];
                    }
                    ?>" required>
                </div>
                <div>
                    <span>Password: </span>
                    <input type="password" name="login_password" value="<?php
                    if(isset($_SESSION["login_password"])){
                        echo $_SESSION["login_password"];
                    }
                    ?>" required>
                </div>
                <div>
                    <input type="submit" value="Login" name="login_submit">
                    <?php
                    if(in_array("Login failed", $error_array)){
                        echo "<span style='color:indianred'>Login failed for email Id: " . $_SESSION['login_emailId']."</span>";
                    }
                    ?>
                </div>
            </form>
            <div><a id="signup" class="signup" >Don't have an account yet? Signup here!</a></div>
        </div>


        <div id="Registration">
            <form id="RegistrationForm" action="register.php" method="post" enctype="multipart/form-data">
                <div>
                    <span>First Name: </span>
                    <input type="text" name="fName" placeholder="Enter your first name" value="<?php
                    if(isset($_SESSION['fName'])){
                        echo $_SESSION['fName'];
                    }
                    ?>" required>

                </div>
                <div>
                    <span>Last Name: </span>
                    <input type="text" name="lName" placeholder="Enter your last name" value='<?php
                    if(isset($_SESSION['lName'])){
                        echo $_SESSION['lName'];
                    }
                    ?>' required>
                </div>
                <div>
                    <span>Email Id: </span>
                    <input type="email" name="email" placeholder="Enter your email Id" value='<?php
                    if(isset($_SESSION['email'])){
                        echo $_SESSION['email'];
                    }
                    ?>' required>

                </div>
                <div>
                    <span>ReType Email Id: </span>
                    <input type="email" name="email2" placeholder="Re enter your email Id" value='<?php
                    if(isset($_SESSION['email2'])){
                        echo $_SESSION['email2'];
                    }
                    ?>' required>
                    <?php
                    if(in_array("user already exists.<br>", $error_array)) {
                        echo "<div style='color: indianred'>user already exists.<br></div>";
                    }
                    if(in_array("invalid format of email.<br>", $error_array)) {
                        echo "<div style='color: indianred'>invalid format of email<br></div>";
                    }
                    if(in_array("Re-check the email Id<br>", $error_array)) {
                        echo "<div style='color: indianred'>Re-check the email Id.<br></div>";
                    }
                    ?>
                </div>
                <div>
                    <span>Password: </span>
                    <input type="password" name="password" placeholder="Enter your password" value='<?php
                    if(isset($_SESSION['password'])){
                        echo $_SESSION['password'];
                    }
                    ?>' required>

                </div>
                <div>
                    <span>Confirm Password: </span>
                    <input type="password" name="password2" placeholder="Confirm your password" value='<?php
                    if(isset($_SESSION['password2'])){
                        echo $_SESSION['password2'];
                    }
                    ?>' required>
                    <?php
                    if(in_array("Passwords doesn't match<br>", $error_array)) {
                        echo "<div style='color: indianred'>Passwords doesn't match<br></div>";
                    }
                    if(in_array("password should contain english or numbers<br>", $error_array)) {
                        echo "<div style='color: indianred'>password should contain english or numbers<br></div>";
                    }
                    ?>
                </div>
                <div>
                    <span>Date Of Birth:</span>
                    <input type="date" name="dob" value='<?php
                    if(isset($_SESSION['dob'])){
                        echo $_SESSION['dob'];
                    }
                    ?>' dataformatas="dd-mm-YYYY" required>

                </div>
                <div>
                    <span>Gender:</span>
                    <input type="radio" name="gender" value="male"> Male
                    <input type="radio" name="gender" value="female"> Female

                </div>
                <div>
                    <span>Profile Picture:</span>
                    <input type="file" name="profile_pic">

                </div>
                <div>
                    <input type="submit" name="reg_submit" value="Register">
                    <?php
                    if(in_array("Successfully Registered.", $error_array)){
                        echo "<p style='color: darkgreen;'>Successfully Registered and your user Id is: . $userName</p>";
                    }
                    ?>
                </div>


            </form>
            <div>
                <a id="signin" class="signin">Already an user? Sigh in here!</a>
            </div>

        </div>
    </div>

</div>

</body>

</html>
