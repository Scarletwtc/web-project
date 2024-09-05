<?php

session_start();
    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
        {
            //read from database
            
            $query = "select * from users where user_name = '$user_name' limit 1 ";

            $result = mysqli_query($con, $query);

            if($result)
            {
                if($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);
                    if( $user_data ['password'] === $password )
                    {

                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: index.php");

                        die;
                    }
                }
            }

            echo " Wrong username of password!";
        }
        
        else 
        {
            echo " Wrong username or password!";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ssss.css">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Log in</title>
</head>

<body class="body" style=" background-image: url(images/R.jpg)">
    <div id="box">
        <div class="container">
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-6 text-center" >
                <h3> <i class="fa fa-user"></i> Log in</h3></h3>
                <form method="post">
                <div class="form-group">
                        <label for="user_name"><i class="fa fa-user"></i> Username</label>
                        <input type="text" name="user_name" placeholder="Username" > 
                </div>

                <div class="form-group">
                        <label for="password"><i class="fa fa-lock"></i> Password</label>
                        <input type="password" name="password" placeholder="password" > 
                </div>
                        <input type="submit" value="Login" >
                
                        <p>Already have an account? <a href="signup.php">Signup</a></p>
                  </form>

                </div>
                <div class="col-md-3">

                </div>
            </div>
        </div>

        
    </div>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>