<?php

session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    
    
    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        
        $query = "SELECT * FROM users WHERE user_name = '$user_name'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result)>0){
            echo "taken";
        }else{
        
        //save to database
        $user_id = random_num(20);
        $query = "insert into users (user_id,user_name, password) values ('$user_id','$user_name','$password')";

        mysqli_query($con, $query);

        // Create a table with the user's name to store their notes
        $table_name = strtolower($user_name) . "_notes";
        $create_table_query = "CREATE TABLE `$table_name` (
            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `note` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        mysqli_query($con, $create_table_query);

            //create todo table
            $todo_table= strtolower($user_name) . "_todo";
            $create_table_query_todo ="CREATE TABLE `$todo_table`(
                `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `todo` TEXT NOT NULL
            )";
        mysqli_query($con, $create_table_query_todo);

        header("Location: login.php");

        die;
            }
    } else {
        echo "Please enter valid information!";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/ssss.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="bootstrap.css">
   
</head>
<body style="background-image: url(images/R.jpg);">
    <div id="box">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
    
                </div>
                <div class="col-md-6 text-center">
                    <h3><i class="fa fa-user"></i> Sign Up</h3>
                    <form method="post">
                        <div class="form-group">
                            <label for="user_name"><i class="fa fa-user"></i> Username</label>
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="fa fa-lock"></i> Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
                        </div>
                        <input type="submit" value="Sign up" class="btn btn-primary">
                        <p>Already have an account? <a href="login.php">Login</a></p>
                     </form>
                </div>
                <div class="col-md-3">

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous">
    /*provides a collection of scalable vector icons that can be customized and 
    easily added to a website or application */</script>
</body>
</html>