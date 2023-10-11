<?php 
require '../conn/conn.php';
$db = new DatabaseHandler();

if($db->loginUser($_POST['email'],$_POST['pass'])){
    echo '200';
}else{
    echo '404';
}
