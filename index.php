<?php 
session_start();
require_once 'database.php';
if(!isset($_SESSION['USER_CONNECTED']) || $_SESSION['USER_CONNECTED'] !== true){
    header('Location:login.php');
}
if($_SESSION['role'] === "etudiant"){
    header('Location:etuview.php');
}
$user_data = json_decode($_SESSION['user_infos'],true);
$filiere_request = $pdo-> query('SELECT * FROM filiere WHERE filiere_statut = 1');
if($filiere_request){
    $filieres = $filiere_request -> fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My School Management</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        
    </style>
    <!-- Stylesheets
    ============================================= -->

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
                <span class="text-dark font-weight-bold d-inline-block ml-1 mt-2" ><?= $user_data['1'] .' '.$user_data['0']?> <br> <small class='text-dark font-weight-bold py-1 px-4 rounded-pill'><?= $user_data['2'] ?> </small>
            </div>
        </div>
        <div class="col-md-6 my-2">
            <form action="search_check.php" method="post">
                <input type="search" class="text-center py-y px-3 rounded-pill" name="search" style="border-width : 0;font-size : 1rem;font-weight : 200;min-width: 400px ; min-height : 40px;" id="search_etu" placeholder="rechercher étudiant(s) / filière"><button type="submit" class="bg-primary text-center text-light py-y px-3 rounded-pill" style="border-width : 0;font-size : 1rem;font-weight : 200;min-height : 40px;transform:translateX(-20px);opacity : 0.8;">rechercher</button>
            </form>
        </div>
        <div class="col-md-2">
                <a href="deconnexion.php" class="btn btn-sm btn-danger rounded-pill active py-1" style="font-size : 0.7rem;!important;font-weight:500;box-shadow:-2px 0px 8px 6px rgba(0,0,0,0.09);">Deconnexion</a>
        </div>
        <div class="d-flex justify-content-end col-md-12">
            <a href="index.php" class="mr-3 text-dark font-weight-bold">HOME</a>        
            <a href="manager_filiere.php" class="mr-3 text-dark font-weight-bold">Filière(s)</a>
            <a href="waiting_list.php" class="mr-3 text-dark font-weight-bold">Liste D'Attente Insciption </a>
            <a href="etuview.php" class="mr-3 text-dark font-weight-bold">Vue Etudiant</a>
            <a href="add_etu.php" class="mr-3 text-dark font-weight-bold">Enregistrer Etudiant</a>

        </div>
    </div>

    <div class="row px-3 py-3 mx-4 pt-3 rounded" style='box-shadow : -1px 5px 10px rgba(0,0,0,0.2);transform :translateY(-50px);position : relative;z-index : 10; background-color : #fff;'>
 
    <div class="col-md-4 list-group">
        <?php foreach($filieres as $key => $filiere) : ?>
            <?php $activeClass = ($key == 0) ? ' active' : null;?>
            <a class="list-group-item list-group-item-action<?= $activeClass ?>" id="pills-filieres-<?= (int) $filiere['id'] -1 ?>" data-toggle="pill" href="#pills_filiere_<?=$filiere['id']?>" role="tab" aria-controls="pills-home" aria-selected="true" ><?= $filiere['nom'] ?>
            <span class="badge badge-pill badge-secondary d-inline-block float-right mr-2">
                <?= $filiere['Netudiants'] ?>
            </span></a>
            </a>
        <?php endforeach ?>
    </div>


    
    <div class="tab-content mb-3 py-4 col-md-8 wow fadeInUp animated" data-wow-delay="0.6s" id="pills-tabContent" style='background-color : #fff; visibility: hidden; animation-delay: 0.4s; animation-name: fadeInUp;'>    

    <div class="container mb-3">
            <span class="d-inline-block mr-2 font-weight-bold" style="width:18%;">Nom</span>
            <span class="d-inline-block mr-2 font-weight-bold" style="width:18%;">Prénom</span>
            <span class="d-inline-block mr-2 font-weight-bold text-center" style="width:10%;">sexe</span>
            <span class="d-inline-block mr-2 font-weight-bold text-center" style="width:18%;">Age</span>
            <span class="d-inline-block mr-2 font-weight-bold" style="width:25%;">email</span>

    </div>

    <?php foreach($filieres as $key => $filiere): ?>
        <?php $activeClass = ($key == 0) ? ' active' : null;?>
        <div class="tab-pane fade show<?=$activeClass?> col-md-12" role="tabpanel" aria-labelledby="pills-profile-tab" id="pills_filiere_<?=$filiere['id']?>">
            <?php $filiere_content_req = $pdo -> query('SELECT * FROM users WHERE purpose ='.$filiere['id'].'&& active_user = \'1\'') ; ?>
                <ul class="list-group list-group-flush">
                
                    <?php foreach($filiere_content_req->fetchAll(PDO::FETCH_ASSOC) as $filiere_content): ?>
                        <?php 
                            $etu_age = strtotime($filiere_content['birthday']);
                            $etu_age = floor((time() - $etu_age)/(60*60*24*30*12));
                        ?>
                        <a href="add_etu.php?etuid=<?php echo $filiere_content['id'];  ?>" class="list-group-item-action px-0 py-2">
                            <span class="d-inline-block mr-2" style="width:18%;"><?= $filiere_content['nom'] ?></span>
                            <span class="d-inline-block mr-2" style="width:18%;"><?= $filiere_content['prenom'] ?></span>
                            <span class="d-inline-block mr-2 text-center" style="width:10%;"><?= $filiere_content['sexe'] ?></span>
                            <span class="d-inline-block mr-2 text-center" style="width:18%;"><?= $etu_age ?></span>
                            <span class="d-inline-block mr-2" style="width:25%;"><?= $filiere_content['email'] ?></span>
                        </a>
                    <?php endforeach ?>    
                </ul>
            </div>    

    <?php endforeach ?>

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
