<?php
  require "includes/header.php"; // Will raise error if the file is not found
  include("includes/classes/User.php"); // Will include the file and return true if the file exists else false.
    include("includes/classes/Post.php");
  //session_destroy()
    if(isset($_POST["post"])){
        $post = new Post($connection, $user['User Name']);
        $post->submitPost($_POST["post_text"], 'None');
    }

?>
    <div class="user_details column">

        <a href="
            <?php
            echo $user['First Name']
        ?>
        ">
            <img src="<?php
            echo $user['Profile Picture']
            ?>">
        </a>

        <div class="user_details_left_right">
            <a href="<?php
            echo $user['First Name']
            ?>"><?php
                echo $user['First Name']. " ". $user['Last Name']
                ?></a>
            <div>
                <?php
                echo "Posts: " . $user['Number Of Posts']
                ?>
            </div>
            <div>
                <?php
                echo "Likes: " . $user['Number Of Likes']
                ?>
            </div>
        </div>

    </div>

    <div class ="main_column column">
        <form action="index.php" method="post" class="post_form">
            <textarea name="post_text" placeholder="write your post" id="post_text"></textarea>
            <input type="submit" name="post" id="post_btn" value="post" >
        </form>
<!--        --><?php
//            $post = new Post($connection, $user['User Name']);
//            $post->getPosts();
//        ?>
        <div class="posts_area"></div>
        <img id="loading" src="asserts/Images/icons/loading.gif">
    </div>
    <script>
        var userloggedIn = '<?php echo $user['User Name']?>'

        $(document).ready(function () {
            $("#loading").show();
        });

        $.ajax({
            url:"includes/handlers/ajax_load_posts.php",
            type:"POST",
            data:"page=1&userLoggedIn=" + userloggedIn,
            cache:false,
            success:function (response) {
                $("#loading").hide();
                $(".posts_area").html(response);
            }
        });

        $(window).scroll(function () {
            var height = $(".posts_area").height();
            var scroll_top = $(this).scrollTop();
            var page = $('.posts_area').find('.nextPage').val();
            var noMorePosts = $('.posts_area').find('.noMorePosts').val();
            if(noMorePosts == 'true'){
                $('#loading').hide();
            }
            debugger;

            if ($(window).scrollTop() + $(window).height() - 100 == $(document).height() && noMorePosts == 'false'){
                console.log("Came inside the if condition");
                $("#loading").hide();
                $.ajax({
                    url:"includes/handlers/ajax_load_posts.php",
                    data:"page=" + page +"&userLoggedIn=" + userloggedIn,
                    type:"POST",
                    success:function (response) {
                        $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
                        $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage

                        $('#loading').hide();
                        $('.posts_area').append(response);
                    }
                });
            }
            return false;
        });
        

    </script>
    </div>
  </body>
</html>
