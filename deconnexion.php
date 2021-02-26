<?php 
session_start();
unset($_SESSION['USER_STATE']);
foreach($_SESSION as $key){
    unset($_SESSION[$key]);
}
session_destroy();
header('Location:login.php');