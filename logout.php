<?php
    session_start();
    include 'db_config.php';
    
    if(isset($_POST['logout']) && !empty($_POST['logout'])){
        session_destroy();
        header('location: index.php');
    }
?>