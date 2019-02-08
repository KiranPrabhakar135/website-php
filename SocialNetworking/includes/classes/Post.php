<?php
class Post{
    private $user_obj;
    private $connection;

    public function __construct($connection, $user_name)
    {
        $this->connection = $connection;
        $this->user_obj = new User($connection, $user_name);
    }

    public function submitPost($body, $to_user){
    $body = strip_tags($body); // removes html tags
        $body = mysqli_real_escape_string($this->connection, $body); // Takes care of the "'" in the text
        $body = trim($body);

        if($body != ''){
            $current_date = date('Y-m-d H:i:s');
            $added_by = $this->user_obj->getUserName();

            if($to_user == $added_by){
                $to_user = 'None';
            }

            //inset post
            $query = mysqli_query($this->connection, "insert into posts values (NULL, '$body','$added_by','$to_user','$current_date', 0,0,0)");
            $returned_id = mysqli_insert_id($this->connection);

            //insert notification


            //update notification count for user
            $postsCount = $this->user_obj->getPostsCount();
            $postsCount++;
            $updatePostsQuery = mysqli_query($this->connection, "update users set `Number Of Posts` = $postsCount, where `User Name` = '$added_by'");


        }


    }

    public function getPosts($request_data, $limit){
        $page = $request_data['page'];
        $skip = ($page -1) * $limit;

        $str = "";
        $result = mysqli_query($this->connection, "select * from posts where deleted=0 order by date_added desc limit $skip, $limit");

        $count_result = mysqli_query($this->connection, "select * from posts where deleted=0" );
        $count = mysqli_num_rows($count_result);
        if($page == 1){
            $str = $str. "<div class='posts_count'> The total number of posts is: $count </div>";
        }

        while ($row = mysqli_fetch_array($result)){
            $id = $row['id'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_added = $row['date_added'];

            if($row['user_to'] = 'None'){
                $user_to = "";
            }
            else{
                $user_to_obj = new User($this->connection, $row['user_to']);
                $user_to = "<a href='". $row['user_to'] ."'>" . $user_to_obj->getFirstAndLastName() ."</a>";
            }
            $added_by_obj = new User($this->connection, $row['added_by']);
            $profile_picture = $added_by_obj->getProfilePicture();
            $name = $added_by_obj->getFirstAndLastName();
            if($added_by_obj->isClosed()){
                continue;
            }
            if(!$this->user_obj -> isFriend($row['added_by'])){
                continue;
            }



            //Time frame
            $current_date = date('Y-m-d H:i:s');
            $start_date = new DateTime($date_added);
            $end_date = new DateTime($current_date);
            $time_span = $start_date->diff($end_date);
            if($time_span->y >= 1){
                if($time_span->y == 1){
                    $time_span_text = "a year ago";
                }
                else{
                    $time_span_text = $time_span->y . " years ago";
                }
            }
            if($time_span->m >= 1){
                if($time_span->d == 0){
                    $days = " ago";
                }
                else if($time_span->d == 1){
                    $days = $time_span->d. " day ago";
                }
                else{
                    $days = $time_span->d. " days ago";
                }

                if($time_span->m == 1){
                    $time_span_text = $time_span->m . " month" . $days;
                }
                else{
                    $time_span_text = $time_span->m . " months" . $days;
                }
            }
            else if($time_span->d >= 1){
                if($time_span->d == 1){
                    $time_span_text = " Yesterday";
                }
                else{
                    $time_span_text = $time_span->d. " days ago";
                }
            }
            else if($time_span->h >= 1){
                if($time_span->h == 1){
                    $time_span_text = $time_span->h. " hour ago";
                }
                else{
                    $time_span_text = $time_span->h. " hours ago";
                }
            }
            else if($time_span->i >= 1){
                if($time_span->i == 1){
                    $time_span_text = $time_span->i. " minute ago";
                }
                else{
                    $time_span_text = $time_span->i. " minutes ago";
                }
            }
            else {
                if($time_span->s < 30){
                    $time_span_text =  " just now";
                }
                else{
                    $time_span_text = $time_span->s. " seconds ago";
                }
            }
            $str = $str. "<div class= 'status_post'>
                            <div class='post_profile_pic'>
                                <img src='$profile_picture' width='50'>
                             </div>
                             <div class='posted_by' style='color:#acacac'>
                                <a href='$added_by'>$name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_span_text
                             </div> 
                             <div id='post_body'>$body</div>
                           </div>
                           <hr>
                           ";
                            

        }
        if($count > ($page*$limit))
            $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
        else
            $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: center;'> No more posts to show! </p>";

        echo $str;

    }
}
?>