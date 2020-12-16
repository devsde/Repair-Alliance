<?php
   
    session_start();
    $type=$_SESSION['type'];
    session_unset();
    session_destroy();
    if($type=="user"){
    header("location:login.php");
    }
    else{
    header("location:companyLogin.php");
    }
  ?>