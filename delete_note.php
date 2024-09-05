<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['note_id'])) {
    $user_name = $user_data['user_name'];
    $table_name = strtolower($user_name) . "_notes";
    $note_id = $_POST['note_id'];

    $query = "DELETE FROM `$table_name` WHERE id = '$note_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "success";
    } else {
        echo "failure";
    }
}
?>
