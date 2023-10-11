<?php 
require '../conn/conn.php';
$db = new DatabaseHandler();

if (isset($_POST["email"])){
    $tableName='user';
    
    $data = array(
        'name' => $_POST["name"],
        'email' => $_POST["email"],            
        'password' => $_POST["password"],         
        'position' => $_POST["position"]         
    );
    
        if($db->insertData($tableName,$data)){
            echo 200;
        }else{
            echo 403;
        }    
    }