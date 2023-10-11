<?php 
$title = 'GH20';

include('../conn/conn.php');
$db = new DatabaseHandler();

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $ClientName = $_SESSION['name'];
    if($user !=2){
        header("Location:../login.php");
    }
}else{
    header("Location:../login.php");
}

?>