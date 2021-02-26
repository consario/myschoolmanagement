<?php 
session_start();
require_once 'database.php';
require_once 'functions.php';

if(!isset($_SESSION['USER_CONNECTED']) || $_SESSION['USER_CONNECTED'] !== true){
    header('Location:login.php');
}
if($_SESSION['role'] === "admin"){
    header('Location:index.php');
}
$user_data = json_decode($_SESSION['user_infos'],true);

$admin_pass_err = null;
$user_exist = null;

$errors = [];
$filiere_request = $pdo-> query('SELECT * FROM filiere');
if($filiere_request){
    $filieres = $filiere_request -> fetchAll(PDO::FETCH_ASSOC);
    foreach($filieres as $filiere){
        $filieres[$filiere['id']] = $filiere;
    }
}
$mois = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Septembre','Octobre','Novembre','Decembre'];
$role_admin = ['Directeur(e) Général(e)','Secretaire','Comptable','Professeur'];
$info_etu_display = ['nom','prenom','email','sexe','birthday','purpose'];

$new = null ;
if(isset($_GET['etuid']) && !empty($_GET['etuid'])){
    
    $etu_update = $pdo -> prepare('SELECT * FROM users WHERE id=:etu_id');
    $etu_update -> execute(['etu_id' => $_GET['etuid']]);
    $etu_update_data = ($etu_update -> fetchAll(PDO::FETCH_ASSOC))[0];
    $etu_matiere = $pdo -> prepare('SELECT * FROM matieres WHERE id_filiere=:fili_id');
    $etu_matiere -> execute(['fili_id' => $etu_update_data['purpose']]);
    $etu_matiere_data = ($etu_matiere -> fetchAll(PDO::FETCH_ASSOC));

} else {
    $new = 1;
    $etu_update_data = ['nom' => '','prenom' => '','email' => '','sexe' => '','birthday' => '','purpose' => ''];
    if(array_key_exists('log',$_GET) && ($_GET['log'] === 'uder')){
        $errors = !empty(empty_field_err($_SESSION['admin_add_etu'])) ? empty_field_err($_SESSION['admin_add_etu']) : null; 
    }else if (array_key_exists('log',$_GET) && ($_GET['log'] === 'eruex')){
        $user_exist = 1;
    } else if (array_key_exists('log',$_GET) && ($_GET['log'] === 'uadaufl')){
        $admin_pass_err = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Etudiant</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
               .form-control{
                border-color : rgba(0,0,0,0.1)!important;
                border-radius : 30px!important;
                font-size : 0.8rem!important;
            }
    </style>
    <!-- Stylesheets ============================================= -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
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
    <div class='container-fuide' style='position : relative;z-index : 5;'>
    <h2 class="d-flex justify-content-center py-1 text-secondary bg-warning" style="margin:0;align-items:center;">
    <img src="imgs/brand.png" class="rounded-circle" alt="brand" style="width :50px;height:50px;">
        <span class="ml-2"> My School Management</span>
    </h2>
        <div class="row bg-warning px-4 pt-3" style='padding-bottom : 80px;'>
            <div class="col-md-4">
                <div> <span class="d-inline-block mr-3" style="border-bottom : 3px solid rgba(0,0,0,0.3);">Profil</span> <small class='bg-success text-white py-1 px-4 rounded-pill'><?= $_SESSION['role'] ?></small>    
                 <small class='bg-info text-white py-1 px-4 rounded-pill'><?= $user_data['3'] ?></small> <br>
                <span class="text-dark font-weight-bold d-inline-block ml-1 mt-2" ><?= $user_data['1'] .' '.$user_data['0']?> <br>
            </div>
        </div>
        <div class="col-md-6 my-2">
            <form action="search_check.php" method="post">
                <input type="search" class="text-center py-y px-3 rounded-pill" name="search" style="border-width : 0;font-size : 1rem;font-weight : 200;min-width: 400px ; min-height : 40px;" id="search_etu" placeholder="rechercher étudiant(s)"><button type="submit" class="bg-primary text-center text-light py-y px-3 rounded-pill" style="border-width : 0;font-size : 1rem;font-weight : 200;min-height : 40px;transform:translateX(-20px);opacity : 0.8;">rechercher</button>
            </form>
        </div>
        <div class="col-md-2">
                <a href="deconnexion.php" class="btn btn-sm btn-danger rounded-pill active py-1" style="font-size : 0.7rem;!important;font-weight:500;box-shadow:-2px 0px 8px 6px rgba(0,0,0,0.09);">Deconnexion</a>
        </div>
    </div>

    <div class="row px-3 py-3 mx-4 pt-3 rounded" style='box-shadow : -1px 5px 10px rgba(0,0,0,0.2);transform :translateY(-50px);position : relative;z-index : 10; background-color : #fff;'>
    
    <div class="col-md-4 list-group">
            <h5 class="text-center">Information de L'étudiant</h5>
            <div class="rounded-circle my-3 mx-auto" style="width:200px;height:200px;box-shadow:2px 0px 6px 6px rgba(0,0,0,0.08); background: url('imgs/BN-GP883_LAB_il_M_20150126115808.jpg') center center /cover no-repeat"></div>
            <?php foreach($info_etu_display as $value) :?>
                <?php $data = ($value === 'purpose' && empty($new)) ? $filieres[(int) $etu_update_data[$value]]['nom'] : $etu_update_data[$value]; ?>
                <?php $value = ($value === 'purpose') ? 'filière' : $value; ?>

                <div class="d-flex w-100 mx-auto">
                    <div class="w-25"></div>
                    <small class="mr-3 w-25 font-weight-bold text-dark"> <?= $value ?></small> <small class="w-50"> <?= $data ?></small>    
                </div>
            <?php endforeach ?>
    </div>


    
    <div class="tab-content mb-3 py-4 col-md-8 wow fadeInUp animated" data-wow-delay="0.6s" id="pills-tabContent" style='background-color : #fff; visibility: hidden; animation-delay: 0.4s; animation-name: fadeInUp;'>    
        <div class="text-danger my-2">
            <h5 class="text-center mt-2"> Notes de l'etudiant</h5>
            <?php 
                if(isset($etu_matiere_data) && !empty($etu_matiere_data)){
                    $moy_val_req_ans = [];
                    $moy_val_req = $pdo -> prepare('SELECT * FROM notes WHERE id_etu = ?');
                    $moy_val_req -> execute([$_GET['etuid']]);
                    $moy_val_req_ans = $moy_val_req -> fetchAll(PDO::FETCH_ASSOC);
                    foreach($moy_val_req_ans as $key => $value){
                        $moy_val_req_ans[$value['matiere']] = $value['note']; 
                    }
                    foreach($etu_matiere_data as $matiere){
                        $val_cond = array_key_exists($matiere['id'],$moy_val_req_ans);
                        $val = null;
                        if($val_cond){
                            $val = $moy_val_req_ans[$matiere['id']];
                        }
                        echo '<div class="d-flex align-items-between my-2">';
                        echo '<div class="text-dark w-50">'.$matiere['nom'].'</div>';
                        echo '<div>'.$val.'</div>';
                        echo '</div>';
                    }
                }
            ?>
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