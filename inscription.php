<?php 
session_start();
require_once 'functions.php';
require_once 'database.php';
if(isset($_SESSION['USER_CONNECTED']) && $_SESSION['USER_CONNECTED'] === true){
    header('Location:index.php');
}

$errors = [];
$admin_pass_err = null;
$user_exist = null;
if(array_key_exists('log',$_GET) && ($_GET['log'] === 'uder')){
    $errors = !empty(empty_field_err($_SESSION)) ? empty_field_err($_SESSION) : null; 
}else if (array_key_exists('log',$_GET) && ($_GET['log'] === 'eruex')){
    $user_exist = 1;
} else if (array_key_exists('log',$_GET) && ($_GET['log'] === 'uadaufl')){
    $admin_pass_err = true;
}
$filiere_request = $pdo-> query('SELECT * FROM filiere');
if($filiere_request){
    $filieres = $filiere_request -> fetchAll(PDO::FETCH_ASSOC);
}
$mois = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Septembre','Octobre','Novembre','Decembre'];
$role_admin = ['Directeur(e) Général(e)','Secretaire','Comptable','Professeur'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
            .form-control{
                border-color : rgba(0,0,0,0.1)!important;
                border-radius : 30px!important;
                font-size : 0.8rem!important;
            }
    </style>

        <!-- Stylesheets
    ============================================= -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Fontawesome -->
    <link href="css/fonts/fontawesome/css/all.css" rel="stylesheet">    

    <!-- Animate css -->
    <link rel="stylesheet" href="css/animate.css">

    <!-- Owl carouser -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <!-- Main Css Files -->
    <link rel="stylesheet" href="css/element.css">
    <link rel="stylesheet" href="css/style.css">



</head>
<body>
    <div class="row d-flex justify-content-center mt-5">
        <div class="tab-content mb-3 py-4 col-md-6 wow fadeInUp animated rounded" data-wow-delay="0.6s" id="pills-tabContent" style='box-shadow : -1px 5px 10px 15px rgba(0,0,0,0.03);transform :translateY(-30px);position : relative;z-index : 10; background-color : #fff; visibility: hidden; animation-delay: 0.4s; animation-name: fadeInUp;'>
            <div class='d-flex justify-content-center'>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills_etu" role="tab" aria-controls="pills-home" aria-selected="true">Etudiant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-third" data-toggle="pill" href="#pills_parent" role="tab" aria-controls="pills-parent" aria-selected="false">Parent</a>
                    </li>          
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills_admin" role="tab" aria-controls="pills-profile" aria-selected="false">Administrateur</a>
                    </li>
                              
                </ul>
               
            </div>
            <h2 class="text-center my-3 text-warning">My School Management</h2>
            <div class="text-danger my-2 text-center">
                    <?= $user_exist ? 'Cet adresse e-mail est déjà enrégistré':'' ?>
            </div>
            <div class="tab-pane fade show active col-md-12" role="tabpanel" aria-labelledby="pills-profile-tab" id="pills_etu">
                <form action="traitement_log.php?r=hfjzgjk" method="post" class="text-center">
                    <div class="form-group">
                        <input type="text" name='nom_etu' class='form-control<?= array_key_exists('nom_etu',$errors) ? ' is-invalid' : ''?>' placeholder="nom" value="<?= $_SESSION['nom_etu'] ?? ''?>" >
                        <?php 
                            if(array_key_exists('nom_etu',$errors)){
                                echo'<div class="invalid-feedback">
                                '.$errors['nom_etu'].'
                                </div>';
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <input type="text" name='prenom_etu' class='form-control<?= array_key_exists('prenom_etu',$errors) ? ' is-invalid' : ''?>' placeholder="prenom" value="<?= $_SESSION['prenom_etu'] ?? ''?>">
                        <?php 
                            if(array_key_exists('prenom_etu',$errors)){
                                echo'<div class="invalid-feedback">
                                '.$errors['prenom_etu'].'
                                </div>';
                            }   
                        ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control<?= array_key_exists('email_etu',$errors) ? ' is-invalid' : ''?>" type="email" name="email_etu" id="email_etu" placeholder="adresse email" value="<?= $_SESSION['email_etu'] ?? ''?>">
                        <?php 
                                if(array_key_exists('email_etu',$errors)){
                                    echo'<div class="invalid-feedback">
                                    '.$errors['email_etu'].'
                                    </div>';
                                }   
                        ?>
                    </div>
                    <div class="container mt-2 mb-3 text-left">
                        <span>Date de Naissance</span>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="user_birthday_day" id="user_birthday_day" class="form-control<?= array_key_exists('user_birthday_day',$errors) ? ' is-invalid' : ''?> col" placeholder="Jours" min="1" max="31" value="<?= $_SESSION['user_birthday_day'] ?? ''?>">
                            </div>
                            <div class="col">
                                <select name="user_birthday_month" id="user_birthday_month" class="ml-2 form-control<?= array_key_exists('user_birthday_month',$errors) ? ' is-invalid' : ''?>">
                                    <option value="<?= $_SESSION['user_birthday_month'] ?? ''?>" selected disabled>mois</option>
                                    <?php foreach($mois as $key => $element): ?>
                                    <option value="<?= $key + 1 ?>"><?= $element ?></option>
                                    <?php endforeach ?>
                                </select>
                                    
                            </div>
                            <div class="col">
                                <input type="number" name="user_birthday_year" id="user_birthday_year" min="1990" max="2005" class="form-control<?= array_key_exists('user_birthday_year',$errors) ? ' is-invalid' : ''?>" placeholder="Année" value="<?= $_SESSION['user_birthday_year'] ?? ''?>">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">    
                            <div class="col">
                                <select name="etu_sexe" id="etu_sexe" class="form-control<?= array_key_exists('etu_sexe',$errors) ? ' is-invalid' : ''?> col">
                                <option selected disabled>sexe</option>
                                    <option value="F">Féminin</option>
                                    <option value="M">Masculin</option>
                                </select>
                                <?php 
                                            if(array_key_exists('etu_sexe',$errors)){
                                                echo'<div class="invalid-feedback">
                                                '.$errors['etu_sexe'].'
                                                </div>';
                                            }   
                                ?>
                            </div>
                            <div class="col">
                                <select class="form-control<?= array_key_exists('filiere_etu',$errors) ? ' is-invalid' : ''?>" name="filiere_etu" id="etu_filiere">
                                <option value="<?= $_SESSION['filiere_etu'] ?? ''?>" selected disabled>filière</option>
                                    <?php foreach($filieres as $filiere) :?>
                                        <option value="<?= $filiere['id'] ?>"><?= $filiere['nom'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php 
                                            if(array_key_exists('filiere_etu',$errors)){
                                                echo'<div class="invalid-feedback">
                                                '.$errors['filiere_etu'].'
                                                </div>';
                                            }   
                                ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="rounded-pill bg-info px-4 py-1 mt-5 btn text-light">soumettre</button>
                </form>

            </div>

            <div class="tab-pane fade col-md-12" role="tabpanel" aria-labelledby="pills-parent" id="pills_parent">
                
                <form action="traitement_log.php?r=sojqsjk" method="post" class="text-center">
                    <div class="text-danger text-center my-2">
                        <?= $admin_pass_err ? 'Le code d\'auth administracteur est erroné ' :  null ?>
                    </div>
                    <div class="form-group">
                       <input type="text" name='nom_parent' class='form-control<?= array_key_exists('nom_parent',$errors) ? ' is-invalid' : ''?>' placeholder="nom" value="<?= $_SESSION['nom_parent'] ?? ''?>">
                       <?php 
                            if(array_key_exists('nom_parent',$errors)){
                                echo'<div class="invalid-feedback">
                                '.$errors['nom_parent'].'
                                </div>';
                            }   
                        ?>                       
                    </div>
                    <div class="form-group">
                        <input type="text" name='prenom_parent' class='form-control<?= array_key_exists('prenom_parent',$errors) ? ' is-invalid' : ''?>' placeholder="prenom" value="<?= $_SESSION['prenom_parent'] ?? ''?>">
                        <?php 
                                if(array_key_exists('prenom_parent',$errors)){
                                    echo'<div class="invalid-feedback">
                                    '.$errors['prenom_parent'].'
                                    </div>';
                                }   
                            ?> 
                    </div>
                    <div class="form-group">
                        <input class="form-control<?= array_key_exists('email_parent',$errors) ? ' is-invalid' : ''?>" type="email" name="email_parent" id="email_parent" placeholder="adresse email" value="<?= $_SESSION['email_parent'] ?? ''?>">
                        <?php 
                                if(array_key_exists('email_parent',$errors)){
                                    echo'<div class="invalid-feedback">
                                    '.$errors['email_parent'].'
                                    </div>';
                                }   
                        ?> 
                    </div>
                    <div class="container">
                        <div class="row">    
                            <select name="parent_sexe" id="parent_sexe" class="form-control col<?= array_key_exists('parent_sexe',$errors) ? ' is-invalid' : ''?>">
                            <option value="<?= $_SESSION['parent_sexe'] ?? ''?>" selected disabled>sexe</option>
                                <option value="F">Féminin</option>
                                <option value="M">Masculin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" name="adresse_email_enfant" class="form-control<?= array_key_exists('adresse_email_enfant',$errors) ? ' is-invalid' : ''?>" placeholder="Adresse Email enfant" value="<?= $_SESSION['adresse_email_enfant'] ?? ''?>">
                    </div>

                    <button type="submit" class="rounded-pill bg-info px-4 py-1 mt-5 btn text-light">soumettre</button>
                </form>

            </div>

            <div class="tab-pane fade col-md-12" role="tabpanel" aria-labelledby="pills-profile-tab" id="pills_admin">
                
                <form action="traitement_log.php?r=fegzouob" method="post" class="text-center">
                    <div class="text-danger text-center my-2">
                        <?= $admin_pass_err ? 'Le code d\'auth administracteur est erroné ' :  null ?>
                    </div>
                    <div class="form-group">
                       <input type="text" name='nom_admin' class='form-control<?= array_key_exists('nom_admin',$errors) ? ' is-invalid' : ''?>' placeholder="nom" value="<?= $_SESSION['nom_admin'] ?? ''?>">
                       <?php 
                            if(array_key_exists('nom_admin',$errors)){
                                echo'<div class="invalid-feedback">
                                '.$errors['nom_admin'].'
                                </div>';
                            }   
                        ?>                       
                    </div>
                    <div class="form-group">
                        <input type="text" name='prenom_admin' class='form-control<?= array_key_exists('prenom_admin',$errors) ? ' is-invalid' : ''?>' placeholder="prenom" value="<?= $_SESSION['prenom_admin'] ?? ''?>">
                        <?php 
                                if(array_key_exists('prenom_admin',$errors)){
                                    echo'<div class="invalid-feedback">
                                    '.$errors['prenom_admin'].'
                                    </div>';
                                }   
                            ?> 
                    </div>
                    <div class="form-group">
                        <input class="form-control<?= array_key_exists('email_admin',$errors) ? ' is-invalid' : ''?>" type="email" name="email_admin" id="email_admin" placeholder="adresse email" value="<?= $_SESSION['email_admin'] ?? ''?>">
                        <?php 
                                if(array_key_exists('email_admin',$errors)){
                                    echo'<div class="invalid-feedback">
                                    '.$errors['email_admin'].'
                                    </div>';
                                }   
                        ?> 
                    </div>
                    <div class="container">
                        <div class="row">    
                            <select name="admin_sexe" id="admin_sexe" class="form-control col<?= array_key_exists('admin_sexe',$errors) ? ' is-invalid' : ''?>">
                            <option value="<?= $_SESSION['admin_sexe'] ?? ''?>" selected disabled>sexe</option>
                                <option value="F">Féminin</option>
                                <option value="M">Masculin</option>
                            </select>
                            <div class="col">
                                <select class="form-control<?= array_key_exists('role_admin',$errors) ? ' is-invalid' : ''?>" name="role_admin" id="etu_filiere">
                                <option value="<?= $_SESSION['role_admin'] ?? ''?>" selected disabled>role</option>
                                    <?php foreach($role_admin as $role) :?>
                                        <option value="<?= $role ?>"><?= $role ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="number" name="code_secret_admin" class="form-control<?= array_key_exists('code_secret_admin',$errors) ? ' is-invalid' : ''?>" placeholder="code d'authentification" value="<?= $_SESSION['code_secret_admin'] ?? ''?>">
                    </div>

                    <button type="submit" class="rounded-pill bg-info px-4 py-1 mt-5 btn text-light">soumettre</button>

                </form>

            </div>

        </div>
      
    </div>


    <!-- Scripts
    ============================================= -->

    <!-- jQuery library -->
    <script type="text/javascript" src="js/jquery.min.js"></script>

    <!-- Bootstrap Script -->
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

    <!-- Navik menu Script -->
    <script type="text/javascript" src="js/navik.menu.js"></script>

    <!-- Parallax Script -->
    <script type="text/javascript" src="js/parallaxie.js"></script>

    <!-- Appear Js -->
    <script type="text/javascript" src="js/jquery.appear.js"></script>

    <!-- Counter -->
    <script type="text/javascript" src="js/jQuerySimpleCounter.js"></script>
    
    <!-- Justified Gallery -->
    <script type="text/javascript" src="js/jquery.justifiedGallery.min.js"></script>
    
    <!-- Wow js -->
    <script type="text/javascript" src="js/wow.min.js"></script>

    <!-- Light Slider -->
    <script type="text/javascript" src="js/lightslider.min.js"></script> 

    <!-- Isotope Script -->
    <script type="text/javascript" src="js/isotope.pkgd.js"></script>
    <script type="text/javascript" src="js/imagesloaded.pkgd.js"></script>

    <!-- lineProgressbar plugin js -->
    <script type="text/javascript" src="js/jquery.lineProgressbar.js"></script>

    <!-- Circle progress -->
    <script type="text/javascript" src="js/circle-progress.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>

    <!-- Owl carouser -->
    <script type="text/javascript" src="js/owl.carousel.min.js"></script>
    
    <!-- Modal Video -->
    <script type="text/javascript" src="js/jquery-modal-video.min.js"></script>

    <!-- Point Parallax -->
    <script type="text/javascript" src="js/jquery.pointparallax.min.js"></script>

    <!-- Type Js -->
    <script type="text/javascript" src="js/typed.min.js"></script>

    <!-- TweenMax Script -->
    <script type="text/javascript" src="js/TweenMax.min.js"></script>

    <!-- Touch Swipe -->
    <script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>

    <!-- Main Script -->
    <script type="text/javascript" src="js/script.js"></script>

</body>
</html>