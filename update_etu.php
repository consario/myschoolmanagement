<?php 
session_start();
require_once 'functions.php';
require_once 'database.php';
$etu_cur_data_tab = ['nom','prenom','email','birthday','sexe','purpose'];
$etu_data = $pdo -> prepare('SELECT * FROM users WHERE id = :id');
$etu_data -> execute(['id' => $_GET['etuid']]);
$check_user_uni = $etu_data -> fetchAll(PDO::FETCH_ASSOC);
$check_user_uni_data = $check_user_uni[0];

if(empty($_POST['nom_etu'])){
    $nom = $check_user_uni_data['nom'];
} else {
    $nom = $_POST['nom_etu'] ;
}
if(empty($_POST['prenom_etu'])){
    $prenom = $check_user_uni_data['prenom'];
} else {
    $prenom = $_POST['prenom_etu'] ;
}
if(empty($_POST['email_etu'])){
    $email = $check_user_uni_data['email'];
} else {
    $email = $_POST['email_etu'] ;
}

if(empty($_POST['user_birthday_year']) || empty($_POST['user_birthday_month']) || empty($_POST['user_birthday_day'])){
    $birthday = $check_user_uni_data['birthday'];
} else {
    $birthday = $_POST['user_birthday_year'].'/'.$_POST['user_birthday_month'].'/'.$_POST['user_birthday_day'];
}
if(empty($_POST['etu_sexe'])){
    $sexe = $check_user_uni_data['sexe'];
} else {
    $sexe = $_POST['etu_sexe'];
}

if(empty($_POST['filiere_etu'])){
    $purpose = $check_user_uni_data['purpose'];
} else {
    $purpose = $_POST['filiere_etu'] ;
}




$data_check_tab = ['nom' => $nom,'prenom' =>$prenom,'email' =>$email,'birthday'=> $birthday,'purpose' =>$purpose,'sexe' =>$birthday,'sexe' =>$sexe];

$check = 1;
foreach($etu_cur_data_tab as $element){
    if(!isset($data_check_tab[$element]) || empty($data_check_tab[$element])){
        $check = null;
        echo $element.'<br>';
    }
}
if($check){
        $etu_data_fields_updated = [];
        foreach($etu_cur_data_tab as $index => $field){
            if(!($check_user_uni_data[$field] === $data_check_tab[$field])){
                $etu_data_fields_updated[] = $field;
            } 
        }
        $filiereID = ( (int)$_POST['filiere_etu'] !== (int)$check_user_uni_data['purpose'] ) ? $check_user_uni_data['purpose'] : null; 
        if(!empty($filiereID)){
            upadateFiliere( $_GET['etuid'],-1,$pdo);
            upadateFiliere_2($_POST['filiere_etu'],1,$pdo);

        }
        if(!empty($etu_data_fields_updated)){
            foreach($etu_data_fields_updated as $field){
                $update_etu = $pdo -> prepare('UPDATE users SET ' .$field.'= :value ,active_user = 1 WHERE id = :id');
                $update_etu -> execute([
                    'value' => $data_check_tab[$field],
                    'id' => (int) $_GET['etuid']
                ]);
            }
        }
        header('Location:add_etu.php?etuid='.$_GET['etuid']);

}
else{
        fill_tab($etu_cur_data_tab,$_POST);
        header('Location:add_etu.php?etuid='.$_GET['etuid'].'&log=uder');    
}




