<?php 
session_start();
require_once 'functions.php';
if(isset($_SESSION['USER_CONNECTED']) && $_SESSION['USER_CONNECTED'] === true){
    header('Location:index.php');
}
$errors = [];
if(array_key_exists('log',$_GET) && ($_GET['log'] === 'uder')){
    $errors = !empty(empty_field_err($_SESSION)) ? empty_field_err($_SESSION) : []; 
} else if(array_key_exists('log',$_GET) && ($_GET['log'] === 'erunex')){
    $user_not_exist = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>connexion</title>
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
        <div class="mx-auto my-5 py-4 col-md-6 wow fadeInUp animated rounded" data-wow-delay="0.6s" id="pills-tabContent" style='box-shadow : -1px 5px 10px 15px rgba(0,0,0,0.03);transform :translateY(-30px);position : relative;z-index : 10; background-color : #fff; visibility: hidden; animation-delay: 0.4s; animation-name: fadeInUp;'>
            <h2 class="text-center my-3 text-warning">My School Management</h2>
            <div class="tab-pane fade show active col-md-12" role="tabpanel" aria-labelledby="pills-profile-tab" id="pills_etu">
                <form action="traitement_log.php?r=loginusr" method="post" class="text-center">
                    <div class="text-danger my-2"><?= isset($user_not_exist) ? 'Adresse email non enregistré':''  ?></div>
                    <div class="form-group">
                        <input class="form-control<?= array_key_exists('email',$errors) ? ' is-invalid' : ''?>" type="email" name="email" id="email_etu" placeholder="email" value="<?= $_SESSION['email'] ?? ''?>">
                        <?php 
                                if(array_key_exists('email',$errors)){
                                    echo'<div class="invalid-feedback">
                                    '.$errors['email'].'
                                    </div>';
                                }   
                        ?>
                    </div>
                    
                    
                    <button type="submit" class="rounded-pill bg-info px-4 py-1 mt-5 btn text-light">connexion</button>
                </form>

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