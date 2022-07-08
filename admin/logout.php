<?php 

    include('../config/constants.php');
    //1. Destroy the session 
    session_destroy(); //unsets $-SESSION['user']

    //2. Redirect to login page
    header('location:'.SETURL.'admin/login.php');
?>