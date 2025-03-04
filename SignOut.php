<?php
    session_start();
    setcookie('UID',$_SESSION['UID'],60);
    unset($_SESSION['UID']);
    header('location: SignIn.php');
    die();
?>