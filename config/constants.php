<?php

    //start session
    session_start();


    //create constants to store Non Repeating values
    define('SETURL', 'http://localhost/food-order/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food-order');

     $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());  //Database Connection
     $db_select = mysqli_select_db($conn, 'food-order') or die(mysqli_error()); //Selecting Database
     //$res = mysqli_query($cnn, $sql) or die(mysqli_error());

?>