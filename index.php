
<?php
ob_start(); // Start output buffering
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$note = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if the form has been submitted
    if (isset($_POST['note'])) {
        $user_name = $user_data['user_name'];
        $note = $_POST['note'];
        $table_name = strtolower($user_name) . "_notes";
        $query = "INSERT INTO `$table_name` (note) VALUES ('$note') ";

        mysqli_query($con, $query);
        
        // Retrieve the ID of the inserted note
        $note_id = mysqli_insert_id($con);
        header("location: index.php");
        
        exit;
    }
}

// Fetch all the notes of the user
$table_name = strtolower($user_data['user_name']) . "_notes";
$query = "SELECT * FROM `$table_name` ";
$result = mysqli_query($con, $query);

$note_ids = array();
$notes = array();
while ($row = mysqli_fetch_assoc($result)) {
    $note_ids[] = $row['id'];
    $notes[] = $row['note'];
}


 if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['todo'])){
        $user_name=$user_data['user_name'];
        $todo=$_POST['todo'];
        $todo_table= strtolower($user_name)."_todo";
        $query = "INSERT INTO `$todo_table` (todo) VALUES ('$todo')";

        mysqli_query($con, $query);

        header("location: index.php");
        exit;

    }
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['navbar_color']) && isset($_POST['background_color']) && isset($_POST['top_color'])){
        $navbar_color = $_POST['navbar_color'];
        $background_color = $_POST['background_color'];
        $top_color = $_POST['top_color'];
        $user_id=$user_data['user_id'];
        
        // Query to update the color settings into the database
        $query = "UPDATE users SET navbar_color='$navbar_color', background_color='$background_color', top_color='$top_color' WHERE user_id='$user_id'";
    
        mysqli_query($con, $query);
    }
    }
     // Fetch color settings of the user
     $user_id = $_SESSION['user_id'];
    
    $query = "SELECT navbar_color, background_color, top_color FROM users WHERE user_id='$user_id' ";
    $result = mysqli_query($con, $query);
    if ($result) {
        $settings_data = mysqli_fetch_assoc($result);
        $navbar_color = $settings_data['navbar_color'];
        $background_color = $settings_data['background_color'];
        $top_color = $settings_data['top_color'];
    } else {
        // Default colors if settings are not found in the database
        $navbar_color = '#000000';
        $background_color = '#ffffff';
        $top_color = '#000000';
    }
    
$todo_table=strtolower($user_data['user_name'])."_todo";
$query="SELECT * FROM `$todo_table` ";
$result= mysqli_query($con, $query);
$todo_ids = array();
$tasks=array();

while ($row=mysqli_fetch_assoc($result)){
    $tasks[]=$row['todo'];
    $todo_ids[]=$row['id'];
}

if(isset($_POST['clear_all'])){
    $user_name = $user_data['user_name'];
    $todo_table = strtolower($user_name). "_todo";
    $query = "DELETE FROM `" . $todo_table . "`";
    mysqli_query($con,$query);
    header("location: index.php");
    exit;
}

?>


<style>
    .btn {
  background-color: <?php echo $navbar_color; ?> !important;;
    }
    .vtn {
  background-color: <?php echo $navbar_color; ?> !important;;
    }
   body {
        background-color: <?php echo $background_color; ?> !important;
    }
    #setti {
  background-color: <?php echo $navbar_color; ?> !important;;
    }
    .top {
        background-color: <?php echo $top_color; ?>  !important;
    }
    
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="css/homestyle.css">
    <link rel="stylesheet" href="css/pom.css">

    <title>Document</title>
</head>
<body >
       <!-- FONT -->
       <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">




    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <!-- ICONS -->
    <script src="https://kit.fontawesome.com/765e6b772f.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6f3103b13c.js" crossorigin="anonymous"></script>
    <div class="top">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="images/moon.png" alt="" class="icon">
                </div>

                <div class="col-md-7">
                                    

                    <ul class="info navbar">
                        <li><button class="btn btn-blue" id="notesbtn">Notes</button></li>
                        <li><button class="btn btn-blue" id="todobtn">Todo</button></li>
                        <li><button class="btn btn-blue" id="pombtn">Pomodoro</button></li>
                        <li><button class="btn btn-blue" id="calbtn">Chooser</button></li>
                    </ul>
                   
                </div>
                
                <div class="col-md-1">
                <button id="setti">
                    settings
                </button>
                </div>



                <div class="col-md-2">
                    <form action="logout.php" method="post" id="logout"> 
                    <button class="vtn ">
  
                    <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
                    
                    <div class="text">Logout</div>
                    </button>


                </form>
                
                </div>
               
            </div>
        </div>
    </div>

 <!-- //srttings -->
 <div class="setter">
    <div class="container" >
        <div class="col">
    <div id="settings" style="display:none;">
    <h1>Settings</h1>
    <form method="POST" action="">
        <h4>personalize:</h4> <br>
        <label for="navbar_color">Buttons Color:</label><br>
        <input type="color" id="navbar_color" name="navbar_color" value="<?php echo $navbar_color; ?>"><br><br>
        <label for="background_color">Background Color:</label><br>
        <input type="color" id="background_color" name="background_color" value="<?php echo $background_color; ?>"><br><br>
        <label for="top_color">Top Bar Color:</label><br>
        <input type="color" id="top_color" name="top_color" value="<?php echo $top_color; ?>"><br><br>
        <input type="submit" value="Save">
    </form>
    </div>
</div>
</div>
</div>


        <div class="about float-up" style="display:block;" id="about"> 
            <div class="container">
                <div class="row">
                    <div class="col-6" >
                        
                        <div class="txts ">
                        <h3>
                            Hello <?php  echo $user_data['user_name']; ?>
                        </h3>
                        <p>Thanks for choosing our application! <br> Goodluck with your study session.</p>
                    </div>
                    </div>
                    <div class="col-6" >
                        <img src="images/stud2.jpg" alt="" style="height:450px; width:auto;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <img src="images/stud.jpg" alt="" style="height:450px; width:auto;">
                    </div>
                    <div class="col-6">
                        <div class="txts2 ">
                        <p>
                            The application was created for students hoping to make their lives easier. Please use our to do section to plan your day. Make use of the pomodoro timer to keep track of the time you study. Add important notes in the notes section. And lastly if you dont know what to so use one of the choosers of the app. 
                            <br><br><br>
                            Have fun!
                        </p>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="bocs">

                        <p id="quotes"></p>
                        <br>
                        <p id="next"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></p>


                    </div>
                </div>
            </div>
        </div>






    <div id="clock" style="display: none;  background-image:url('images/giphy3.gif');  background-size: cover important!;
                                                        background-position: center; padding-top:-10px; margin-top:0px; background-repeat: no-repeat; ">


    <div class="backg">
        <button class="btn" id="bac"><i class="fa fa-paint-brush" aria-hidden="true"></i></button>
    </div>


    <div class="spinner_box">
        <div class="circle_box">    
            <div class="circle_core">
               
                    <div class="timer">
                        <h1 id="timer">25:00</h1>
                    <div class="btns">    
                        <button id="startBtn"><i class="fas fa-play"></i></button>
                        <button id="resetBtn"><i class="fas fa-redo-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        

        <br><br><br>
        <div class="music" id="music">
        <button class="btn"><i class="fa fa-music" aria-hidden="true"></i></button>

        <div class="songs" id="songs" style="display:none;">
        <h3>Playlists:</h3>
            <ul class="song-list">
                <li class="song-list-item" id="lofi" onclick="playSong('lofi')">Lofi</li>
                <li class="song-list-item" id="just" onclick="playSong('just')">Just</li>
            </ul>
        
                <audio id="audioPlayer" controls>
                Your browser does not support the audio element.
                </audio>
            </div>
    </div>

    
    </div>           
   

       
    
    
    <div id="todo" style="display:none;">
        <div class="container">
            <div class="col">
                <div class="row">
                    <div class="box">
                        
                        <div class="items">
                            <div class="three">
                                <span class="active" id="all">All </span>
                                <span id="pending">Pending </span>
                                <span id="completed">Completed </span>
                            </div>

                         <hr id='line1'>   
                            <div class="input">
                            <form action="index.php" method="post">
                            <input type="text" name="todo"  placeholder="Add a new task" required>
                            <input type="submit" id='task_submit' class="btn" >
                            </form>
                        </div>
                        </div>
                        
                        <hr id="line2">
                        <ul class="tasks" >
                        <?php
                             if(!empty($tasks)){
                                for($i=0; $i < count($tasks); $i++)
                                echo  "<li style='appearance:none;' ><div class='todo-item'><input type='checkbox' name='todo[]' id='$todo_ids[$i]'><label id='lalalala'>$tasks[$i]</label> </div> <hr></li>";
                                 }
                                        
                            ?>
                        </ul> 

                        <hr id="line3">
                        <div class="clearbottom">
                        <form action="index.php" method="POST">
                        <input type="hidden" name="clear_all" value="1">
                            <button type="submit" name="submit" class="btn" id="btnclear">
                            <i class="fas fa-trash"></i> 
                            </button>
                        </form>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="notes" style="display: none;" id="notes">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="noteup">
                <form action="index.php" method="post" id="myForm">
                    <div class="inputnote">
                     <input class="inputx" type="text" name="note" placeholder="Add a new" required>

                     <input type="submit" class="btn" >
                </form> 
                </div> 
  </div>
            

                </div>
            </div>
        </div>
       
        <div class="container" style="width:1200px;">
        <?php
    if (!empty($notes)) {
    
        echo "<div class='note-container'>"; // Added a container for notes
        for ($i = 0; $i < count($notes); $i++) {
            echo "<div class='note-item'> $i- $notes[$i] <button class='delete-note' data-note-id='$note_ids[$i]'>X</button> </div>";
        }
        echo "</div>"; // Closing the container
    }     
?>

                
    </div>         
    </div>



    <div id="chooser" style="display:none;">
        <div class="choose">
            <div class="coin" >
                    <button class="btn" id="clickcoin">
                        Flip a coin <i class="fa-solid fa-coins"></i>
                    </button>
                    <div class="coinflip" id="coinflip" style="display: none;">
                        <div class="coincontainer">
                            <div class="status">
                                <p id="heads"> Heads: 0</p>
                                <p id="tails"> Tails: 0</p>
                            </div>
                            <div class="thecoin">
                                <div class="headscoin">
                                    <img src="images/heads.svg" alt="">
                                </div>
                                <div class="tailscoin">
                                    <img src="images/tails.svg" alt="">
                                </div>
                            </div>
                            <div class="buttons">
                                <button id="flipcoin" class="btn">Flip coin</button>
                                <button id="resetflip" class="btn">Reset</button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="yesno">
                <button class="btn" id="yesnobtn">
                    Yes/no? <i class="fa-solid fa-thought-bubble"></i>
                </button>
                <div class="askme" style="display:none;" id="askme">
                    <input type="text" placeholder="ask a yes or no question" id="question">
                    
                   
                    <br><br>
                    <p id="theanswer"> </p>
                </div>
            </div>
            
        </div>

    </div>
    <script>
    function playSong(songId) {
        var audioPlayer = document.getElementById('audioPlayer');
        audioPlayer.src = 'music/' + songId + '.mp3';
        audioPlayer.play();

        var songListItems = document.getElementsByClassName('song-list-item');
        for (var i = 0; i < songListItems.length; i++) {
            songListItems[i].classList.remove('current-song');
        }
        document.getElementById(songId).classList.add('current-song');
    }
    document.addEventListener('DOMContentLoaded', () => {
    let music = document.getElementById('music');
    let songs = document.getElementById('songs');

    music.addEventListener('click', () => {
      if (songs.style.display === 'none') {
        songs.style.display = "block";
      } else {
        songs.style.display = "none";
      }
    });
  });


</script>
   <script src="index.js">
     
   </script>

</body>
</html>
