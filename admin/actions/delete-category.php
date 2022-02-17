<?php


error_reporting(E_ALL & ~E_NOTICE);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    define('admin23', true);
    include("../include/db_connect.php");
    
            $delete=mysqli_query($link, "DELETE FROM `category` WHERE id='{$_POST["id"]}'");
            echo "delete";
            }
?>