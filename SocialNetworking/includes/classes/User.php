<?php
class User{
    private $user;
    private $connection;

    public function __construct($connection, $user)
    {
        $this->connection = $connection;
        $query_result = mysqli_query($connection, "select * from user where `User Name` = '$user'");
        $this->user = mysqli_fetch_array($query_result);
    }

    public function getFirstAndLastName(){
        return $this->user['First Name'] . " " .  $this->user['Last Name'];
    }

    public function getPostsCount(){
        return $this->user['Number Of Posts'];
    }
    public function getUserName(){
        return $this->user["User Name"];
    }
    public function isClosed(){
        return $this->user["User Closed"];
    }
    public function getFirstName(){
        return $this->user["First Name"];
    }
    public function getLastName(){
        return $this->user["Last Name"];
    }
    public function getProfilePicture(){
        return $this->user["Profile Picture"];
    }
    public function getUserObject(){
        return $this->user;
    }

    public function  isFriend($user_name){
        if(strstr($this->user['Friend Array'], $user_name) || $this->getUserName() == $user_name){
            return true;
        }
        return false;
    }
}
?>