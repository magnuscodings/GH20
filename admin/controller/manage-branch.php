<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
$tableName='user';
if (isset($_POST["email"]) && $_POST['type']=="add" ){
    
    $data = array(
        'name' => $_POST["name"],
        'email' => $_POST["email"],            
        'password' => $_POST["password"],
        'position' => 1,
                 
    );
    
        if($db->insertData($tableName,$data)){
            echo 200;
        }else{
            echo 403;
        }    
    }

else if(isset($_POST["update"])){
        $data = [];
        $rows = $db->getAllColumnsByColumnValue('user', 'id', htmlentities($_POST['update']));
        if ($rows) {
        // Iterate over each row using foreach
        foreach ($rows as $row) {
            $data[] = $row; // Append the current row to the $data array
            }
        } 
        
        echo json_encode($data);
        }
        
        
else if (isset($_POST["email"]) && $_POST['type']=="update" ){

$data = array(
    'name' => $_POST["name"],
    'email' => $_POST["email"],            
    'password' => $_POST["password"],            
);

$whereClause = array(
    'id' => $_POST['id']
);
    if($db->updateData($tableName,$data,$whereClause)){
        echo 200;
    }else{
        echo 403;
    }   

}
else if ( $_POST['type']=="delete" ){

    $data = array(
        'status' => 1
    );
    
    $whereClause = array(
        'id' => $_POST['id']
    );
        if($db->updateData($tableName,$data,$whereClause)){
            echo 200;
        }else{
            echo 403;
        }   
    
    }

else{
    echo 403;
}