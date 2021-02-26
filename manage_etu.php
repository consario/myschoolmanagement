<?php 
require_once 'database.php';
require_once 'functions.php';
if(isset($_GET['urcn']) && !empty($_GET['urcn'])){
    $user_active = 0;
    if($_GET['urcn'] === 'del'){
        $user_active = -1;        
        upadateFiliere( $_GET['etuid'],-1,$pdo);
    } else if($_GET['urcn'] === 'unld') {
        $user_active = 0;                
        upadateFiliere( $_GET['etuid'],-1,$pdo);
    } else if($_GET['urcn'] === 'actv'){
        $user_active = 1;        
        upadateFiliere( $_GET['etuid'],1,$pdo);
    }

    $query = $pdo-> prepare('UPDATE users SET active_user = :value WHERE id= :id ');
    $query -> execute([
        'value' => $user_active,
        'id' => $_GET['etuid']
    ]);
    header('Location:index.php');
}

