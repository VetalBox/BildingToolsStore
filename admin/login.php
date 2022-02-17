<?php
define('admin23', true);
session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
 
include("include/db_connect.php");
include("include/functions.php");

if( isset($_POST["submit_enter"])){
    
    $login= clear_string($_POST["input_login"]);
    $pass= clear_string($_POST["input_pass"]);
	  
    if ($login && $pass){
				
			$pass=md5(clear_string(isset($_POST["info_pass"])));
          $pass=strrev($pass);
          $pass=strtolower("9nm2rv8q".$pass."2yo6z");
        
																
        	$result=mysqli_query($link, "SELECT * FROM `reg_admin` WHERE `login`='$login' AND `pass`='$pass'");
            If (mysqli_num_rows($result) > 0){
            $row=mysqli_fetch_array($result);
            $_SESSION['auth_admin']='yes_auth';
            
            $_SESSION['admin_role']=$row["role"];
        
        //Привелегии
        //Заказы
        $_SESSION['accept_orders']=$row["accept_orders"];
        $_SESSION['delete_orders']=$row["delete_orders"];
        $_SESSION['view_orders']=$row["view_orders"];
        
        //Товары
        
        $_SESSION['delete_tovar']=$row["delete_tovar"];
        $_SESSION['add_tovar']=$row["add_tovar"];
        $_SESSION['edit_tovar']=$row["edit_tovar"];
        
        
        //Категории
        
        $_SESSION['add_category']=$row["add_category"];
        $_SESSION['delete_category']=$row["delete_category"];
        
        //Администраторы
        
        $_SESSION['view_admin']=$row["view_admin"];
            header("Location: index.php");
            }
            else{
                $msgerror="Невірний Логін і(або) Пароль";
            }
            }
            else{
                $msgerror="Заповніть усі поля!";
            }
        }       
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="utf-8"/>
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style-login.css" rel="stylesheet" type="text/css" />
	
    
    
    
    <title>Панель Управления - Вход</title>
</head>
<body>

<div id="block-pass-login">
<?php
	if (isset($msgerror)){
	   echo '<p id="msgerror">'.$msgerror.'</p>';
	}
?>
<form method="post">
<ul id="pass-login">
<li><label>Логін</label><input type="text" name="input_login" /></li>
<li><label>Пароль</label><input type="password" name="input_pass" /></li>
</ul>
<p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="Вхід" /></p>
</form>

</div>





</body>
</html>