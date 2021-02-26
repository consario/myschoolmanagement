<?php 
function empty_field_err(array $fieldsTab):array{
    $err_tab = [];
    if($fieldsTab){
        foreach($fieldsTab as $name => $field){
            if(empty($field)){
                $err_tab[$name] = 'Veuillez bien renseigner le champs '.$name;
            }
        }
    }
    return $err_tab;
}

function fill_tab(array $tab1 , array $tab2):void{
    foreach($_SESSION as $key => $value){
        unset($_SESSION[$key]);
    }
    foreach($tab1 as $value){
        if(array_key_exists($value,$tab2)){
            $_SESSION[$value] = $tab2[$value];
        }
        else {
            $_SESSION[$value] = '';
        }
    }
}
function fill_tab_2(array $tab1 , array $tab2):void{
    if($_SESSION['USER_CONNECTED'] === true){
        $_SESSION['admin_add_etu'] = [];
        foreach($tab1 as $value){
            if(array_key_exists($value,$tab2)){
                $_SESSION['admin_add_etu'][$value] = $tab2[$value];
            }
            else {
                $_SESSION['admin_add_etu'][$value] = '';
            }
        }
    } else {
        foreach($tab1 as $value){
            if(array_key_exists($value,$tab2)){
                $_SESSION[$value] = $tab2[$value];
            }
            else {
                $_SESSION[$value] = '';
            }
        }
    }

}

function upadateFiliere(string $id,int $user_active,object $pdo):void{
    $etu_filiere_req = $pdo -> prepare('SELECT purpose FROM users WHERE id = :id');
    $etu_filiere_req -> execute(['id' => $id]);
    $etu_filiere = ($etu_filiere_req->fetch())['purpose'];
    $filiere_stat_cur_req = $pdo -> prepare('SELECT Netudiants FROM filiere WHERE id=:purpose');
    $filiere_stat_cur_req -> execute(['purpose' => $etu_filiere]);
    $filiere_stat_cur = $filiere_stat_cur_req -> fetch()['Netudiants'];
    $filiere_update_req = $pdo -> prepare('UPDATE filiere SET Netudiants = :stat WHERE id= :id');
    $filiere_update_req -> execute([
        'stat' => (int) $filiere_stat_cur + $user_active,
        'id' => $etu_filiere
    ]);
}

function upadateFiliere_2(int $fid,int $user_active,object $pdo):void{
    $filiere_stat_cur_req = $pdo -> prepare('SELECT Netudiants FROM filiere WHERE id=:purpose');
    $filiere_stat_cur_req -> execute(['purpose' => $fid]);
    $filiere_stat_cur = $filiere_stat_cur_req -> fetch()['Netudiants'];
    $filiere_update_req = $pdo -> prepare('UPDATE filiere SET Netudiants = :stat WHERE id= :id');
    $filiere_update_req -> execute([
        'stat' => (int) $filiere_stat_cur + $user_active,
        'id' => $fid
    ]);
}