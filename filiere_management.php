<?php
require_once 'database.php';
$query = $pdo-> prepare('SELECT nom FROM filiere WHERE id= :id ');
$query -> execute(['id' => $_GET['fid']]);
$query_ans = $query -> fetch();
$filiere_name = $_POST['filiere_name'] ?? $query_ans['nom'];
if(isset($_GET['flmg']) && !empty($_GET['flmg'])){
    $user_active = 0;
    if($_GET['flmg'] === 'del'){
        $user_active = -1;        
    } else if($_GET['flmg'] === 'upd') {
        $user_active = 2;                
    } else if($_GET['flmg'] === 'disbl') {
        $user_active = 0;                
    } else if ($_GET['flmg'] === 'actf') {
        $user_active = 1;
    }

    if($user_active === 2){
        $query = $pdo-> prepare('UPDATE filiere SET nom = :value WHERE id= :id ');
        $query -> execute([
            'value' => $filiere_name,
            'id' => $_GET['fid']
        ]);
        
    } else  {
        $query = $pdo-> prepare('UPDATE filiere SET filiere_statut = :value WHERE id= :id ');
        $query -> execute([
            'value' => $user_active,
            'id' => $_GET['fid']
        ]);
    }
    header('Location:index.php');
}