<?php 
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    if($_SESSION['user']==2){
        header("Location:admin/index.php");
    }
}else{
    header("Location:login.php");
}


?>