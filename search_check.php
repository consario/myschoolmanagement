<?php
session_start();
require_once 'database.php';
$filiere_request = $pdo-> query('SELECT * FROM filiere');
if($filiere_request){
    $filieres = $filiere_request -> fetchAll(PDO::FETCH_ASSOC);
}
$filieres_list = [];
foreach ($filieres as $value) {
    $filieres_list[] = trim($value['nom']);
}

if(isset($_POST['search']) && !empty($_POST['search'])){
    $search_key = $_POST['search'];
    $_SESSION['search_request_data'] = $_POST['search']; 
    $search_key = htmlentities($search_key);
    $search_request = $pdo -> query('SELECT * FROM users WHERE ( nom LIKE '.'\'%'.$search_key.'%\''.' OR prenom LIKE '.'\'%'.$search_key.'%\''.' OR email LIKE '.'\'%'.$search_key.'%\''.') && ( statut = \'etudiant\' && active_user = \'1\' )');
    $search_request_data = $search_request -> fetchAll(PDO::FETCH_ASSOC);
    if(empty($search_request_data)){
        $search_request_data = [];
    }
    $_SESSION['search_data_found'] = $search_request_data;
    header('Location:display_search.php');
}