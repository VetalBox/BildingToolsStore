<?php
// обработчик итоговой цены
if($_SERVER["REQUEST_METHOD"]=="POST"){
    define('admin23', true);
    include("db_connect.php");
    include("../functions/functions.php");
	
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	$int = isset ($int) ?? '';
  
   
  	$result = mysqli_query($link, "SELECT * FROM `cart` WHERE `cart_ip`='{$_SERVER['REMOTE_ADDR']}'");
    If (mysqli_num_rows($result) > 0){
        $row=mysqli_fetch_array($result);
   do{
    $int=$int+($row["cart_price"]*$row["cart_count"]);
   }
   while($row=mysqli_fetch_array($result));
   echo group_numerals($int);
    }
}

?>