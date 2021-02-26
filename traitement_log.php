<?php 
session_start();
require_once 'functions.php';
define('USER_CONNECTED',true);
if(session_status() === PHP_SESSION_ACTIVE){
    if(isset($_SESSION['USER_CONNECTED']) && $_SESSION['USER_CONNECTED'] === true){
        header('Location:index.php');
    }
}
require_once 'database.php';
$etu_ele = ['nom_etu','prenom_etu','email_etu','filiere_etu','user_birthday_day','user_birthday_month','user_birthday_year','etu_sexe'];
$admin_ele = ['nom_admin','prenom_admin','email_admin','role_admin','admin_sexe','code_secret_admin'];
$parent_ele = ['nom_parent','prenom_parent','email_parent','parent_sexe','adresse_email_enfant'];


if(isset($_GET['r']) && $_GET['r'] === 'hfjzgjk'){
    $check = 1;
    foreach($etu_ele as $element){
        if(!isset($_POST[$element]) || empty($_POST[$element])){
            $check = null;
        }
    }
    if($check){
        // verifier si l'utilisateur n'a pas déjà été enrégistrer 
        $check_user_uni = $pdo -> prepare('SELECT email FROM users WHERE email = :email');
        $check_user_uni -> execute(['email' => $_POST['email_etu']]);
        if(!($check_user_uni -> fetch())){
            $birthday = $_POST['user_birthday_year'].'/'.$_POST['user_birthday_month'].'/'.$_POST['user_birthday_day'];
            
            $data = $pdo -> prepare('INSERT INTO users VALUES (null,:nom_etu,:prenom_etu,:email,:birthday,:sexe,"etudiant",:filiere_etu,"0")');
            $data -> execute([
                'nom_etu' => $_POST['nom_etu'],
                'prenom_etu' => $_POST['prenom_etu'],
                'email' => $_POST['email_etu'],
                'filiere_etu' => $_POST['filiere_etu'],
                'birthday' => $birthday,
                'sexe' => $_POST['etu_sexe']
            ]);
            if($_SESSION['USER_CONNECTED'] === USER_CONNECTED && $_SESSION['role'] === 'admin'){
                $etuid_req = $pdo -> prepare ('SELECT id FROM users WHERE email = :email') ;
                $etuid_req -> execute(['email' => $_POST['email_etu']]);
                $etuid = $etuid_req -> fetch();
                header('Location:add_etu.php?mes=etscc&etuid='.$etuid['id']);
            } else {
                $_SESSION['user_infos'] = json_encode([$_POST['nom_etu'],$_POST['prenom_etu'],'etudiant',$_POST['email_etu'],$_POST['filiere_etu'],'',$birthday,$_POST['email_etu'],$_POST['etu_sexe']]);
                $_SESSION['role'] = 'etudiant';
                $_SESSION['USER_CONNECTED'] = USER_CONNECTED ;
                header('Location:index.php');
            }

        }
        else{
            //Envoie une valeur eruex pour dire error user exis
            if($_SESSION['USER_CONNECTED'] === USER_CONNECTED && $_SESSION['role'] === 'admin'){
                fill_tab_2($etu_ele,$_POST);
                header('Location:add_etu.php?log=eruex');    
            } else {
                fill_tab($etu_ele,$_POST);
                header('Location:add_etu.php?log=eruex');
            }
        }
        
    }
    else{
        //Envoie une valeur uder pour dire user data error 
        if($_SESSION['USER_CONNECTED'] === USER_CONNECTED && $_SESSION['role'] === 'admin'){
            fill_tab_2($etu_ele,$_POST);
            header('Location:add_etu.php?log=uder');    
        } else {
            fill_tab($etu_ele,$_POST);
            header('Location:inscription.php?log=uder');
        }
    }
}



if(isset($_GET['r']) && $_GET['r'] === 'sojqsjk'){
    $check = 1;
    foreach($parent_ele as $element){
        if(!isset($_POST[$element]) || empty($_POST[$element])){
            $check = null;
        }
    }
    if($check){
        // verifier si l'utilisateur n'a pas déjà été enrégistrer 
        $check_user_uni = $pdo -> prepare('SELECT email FROM users WHERE email = :email');
        $check_user_uni -> execute(['email' => $_POST['email_parent']]);
        if(!($check_user_uni -> fetch())){
            $check_user_uni = $pdo -> prepare('SELECT email FROM users WHERE email = :email AND statut = \'etudiant\' ');
            $check_user_uni -> execute(['email' => $_POST['adresse_email_enfant']]);
            if($check_user_uni -> fetch()){
                $data = $pdo -> prepare('INSERT INTO users VALUES (null,:nom_parent,:prenom_parent,:email,null,:sexe,"parent",:purpose,"0")');
                $data -> execute([
                    'nom_parent' => $_POST['nom_parent'],
                    'prenom_parent' => $_POST['prenom_parent'],
                    'email' => $_POST['email_parent'],
                    'sexe' => $_POST['parent_sexe'],
                    'purpose' => $_POST['adresse_email_enfant']
                ]);
                session_start();
                $_SESSION['alert'] = 'Bienvenue sur notre plateforme';
                $_SESSION['user_infos'] = json_encode([$_POST['nom_parent'],$_POST['prenom_parent'],$_POST['adresse_email_enfant'],$_POST['email_parent']]);
                $_SESSION['role'] = 'parent';
                $_SESSION['USER_CONNECTED'] = USER_CONNECTED;
                header('Location:etuview.php');                
            } 

            //Envoie une valeur uder pour dire user data error 
            fill_tab($parent_ele,$_POST);
            header('Location:inscription.php');
        } else{
            //Envoie une valeur eruex pour dire error user exist
            fill_tab($parent_ele,$_POST);
            header('Location:inscription.php?log=eruex');
        }
        
    }
    else{
        //Envoie une valeur uder pour dire user data error 
        fill_tab($parent_ele,$_POST);
        header('Location:inscription.php?log=uder');
    }
}

if(isset($_GET['r']) && $_GET['r'] === 'fegzouob'){
    $check = 1;
    foreach($admin_ele as $element){
        if(!isset($_POST[$element]) || empty($_POST[$element])){
            $check = null;
        }
    }

    if($check){
        // verifier si l'utilisateur n'a pas déjà été enrégistrer 
        $check_user_uni = $pdo -> prepare('SELECT email FROM users WHERE email = :email');
        $check_user_uni -> execute(['email' => $_POST['email_admin']]);
        if(!($check_user_uni -> fetch())){
            if($_POST['code_secret_admin'] == '451265'){
                $data = $pdo -> prepare('INSERT INTO users VALUES (null,:nom_admin,:prenom_admin,:email,null,:sexe,"admin",:role_admin,"0")');
                $data -> execute([
                    'nom_admin' => $_POST['nom_admin'],
                    'prenom_admin' => $_POST['prenom_admin'],
                    'email' => $_POST['email_admin'],
                    'sexe' => $_POST['admin_sexe'],
                    'role_admin' => $_POST['role_admin']
                ]);
                session_start();
                $_SESSION['alert'] = 'Bienvenue sur notre plateforme';
                $_SESSION['user_infos'] = json_encode([$_POST['nom_admin'],$_POST['prenom_admin'],$_POST['role_admin'],$_POST['email_admin']]);
                $_SESSION['role'] = 'admin';
                $_SESSION['USER_CONNECTED'] = USER_CONNECTED;
                header('Location:index.php');
            }
            else{
                //Envoie une valeur uadaufl user_admin_auth_fail
                fill_tab($admin_ele,$_POST);
                header('Location:inscription.php?log=uadaufl');

            }
        }
       
        else{
            //Envoie une valeur eruex pour dire error user exist
            fill_tab($admin_ele,$_POST);
            header('Location:inscription.php?log=eruex');
        }
        
    }
    else{
        //Envoie une valeur uder pour dire user data error 
        fill_tab($admin_ele,$_POST);
        header('Location:inscription.php?log=uder');
    }
}

if(isset($_GET['r']) && ($_GET['r'] === 'loginusr')){
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $verif_user_email = $pdo -> prepare('SELECT * FROM users WHERE email=:email');
        $verif_user_email -> execute(['email' => $_POST['email']]);
        $data = $verif_user_email -> fetchAll(PDO::FETCH_ASSOC);
        $data = $data['0'];
        if($data){
                if($data['statut'] === 'admin'){
                    $_SESSION['role'] = 'admin';
                    $_SESSION['user_infos'] = json_encode([$data['nom'],$data['prenom'],$data['purpose'],$data['email']]);
                    $_SESSION['USER_CONNECTED'] = USER_CONNECTED;
                    header('Location:index.php');
                } else if($data['statut'] === 'etudiant') {
                    $_SESSION['role'] = 'etudiant';
                    $_SESSION['user_infos'] = json_encode([$data['nom'],$data['prenom'],$data['purpose'],$data['email'],$data['age']]);
                    $_SESSION['USER_CONNECTED'] = USER_CONNECTED;
                    header('Location:etuview.php');
                }
                
        }
        else{
            //Envoie une valeur eruex pour dire error user not exist
            fill_tab(['email'],$_POST);
            header('Location:login.php?log=erunex');
        }

    }
    else{
        //Envoie une valeur uder pour dire user data error 
        fill_tab(['email'],$_POST);
        header('Location:login.php?log=uder');
    }

}