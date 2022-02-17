<?php
session_start();
if($_SESSION['auth_admin'] == "yes_auth"){

define('admin23', true);

error_reporting(E_ALL & ~E_NOTICE);

if(isset($_GET["logout"])){
    unset($_SESSION['auth_admin']);
    header("Location: login.php");
}

$_SESSION['urlpage']="<a href='index.php'>Головна</a> \ <a href='edit_administrators.php'>Зміна адміністратора</a>";

include("include/db_connect.php");
include("include/functions.php");

$id=clear_string($_GET["id"]);

if ($_POST["submit_edit"]){
    
    $error=array();
    
   if (!$_POST["admin_login"])$error[]="Вкажіть логін!";
      
    if($_POST["admin_pass"]){
        $pass=md5(clear_string($_POST["info_pass"]));
        $pass=strrev($pass);
        $pass="pass='".strtolower("9nm2rv8q".$pass."2yo6z")."',";    
    }
    if(!$_POST["admin_fio"]) $error[]="Вкажіть ФІО!";
    if(!$_POST["admin_role"]) $error[]="Вкажіть посаду!";
    if(!$_POST["admin_email"]) $error[]="Вкажіть E-mail!";
    
    if(count($error)){
        $_SESSION['message']="<p id='form-error'>".implode('<br />',$error)."</p>";
    }
    else{
        $update=mysqli_query($link, "UPDATE `reg_admin` SET `login`='{$_POST["admin_login"]}',`fio`='{$_POST["admin_fio"]}',`role`='{$_POST["admin_role"]}',`email`='{$_POST["admin_email"]}',`phone`='{$_POST["admin_phone"]}',`view_orders`='{$_POST["view_orders"]}',`accept_orders`='{$_POST["accept_orders"]}',`delete_orders`='{$_POST["delete_orders"]}',`add_tovar`='{$_POST["add_tovar"]}',`edit_tovar`='{$_POST["edit_tovar"]}',`delete_tovar`='{$_POST["delete_tovar"]}',`add_category`='{$_POST["add_category"]}',`delete_category`='{$_POST["delete_category"]}',`view_admin`='{$_POST["view_admin"]}' WHERE `id`='$id'");
        $_SESSION['message']="<p id='form-success'>Користувача успішно змінено!</p>";
    }

}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="jquery-confirm/jquery-confirm.css" rel="stylesheet" type="text/css" />
    <link href="jquery-confirm/jquery-confirm.less" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="./ckeditor/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="jquery-confirm/js/jquery-confirm.js"></script>
	
    <title>Панель управління - Зміна адміністратора</title>
</head>

<body>
<div id="block-body">
<?php
	include("include/block-header.php");
    
?>
<div id="block-content">
<div id="block-parameters">

<p id="title-page">Зміна адміністратора</p>
</div>
<?php
	if(isset($_SESSION['message'])){
	   echo $_SESSION['message'];
       unset($_SESSION['message']);
	}
    
    $result=mysqli_query($link, "SELECT * FROM `reg_admin` WHERE id='$id'");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
        do{
            
            if($row["view_orders"]=="1") $view_orders="checked";
            if($row["accept_orders"]=="1") $accept_orders="checked";
            if($row["delete_orders"]=="1") $delete_orders="checked";
            if($row["add_tovar"]=="1") $add_tovar="checked";
            if($row["edit_tovar"]=="1") $edit_tovar="checked";
            if($row["delete_tovar"]=="1") $delete_tovar="checked";
            if($row["view_admin"]=="1") $view_admin="checked";
            if($row["add_category"]=="1") $add_category="checked";
            if($row["delete_category"]=="1") $delete_category="checked";
            
               
    echo '
    <form method="post" id="form-info">
<ul id="info-admin">
<li><label>Логін</label><input type="text" name="admin_login" value="'.$row["login"].'" /></li>
<li><label>Пароль</label><input type="password" name="admin_pass" /></li>
<li><label>ФІО</label><input type="text" name="admin_fio" value="'.$row["fio"].'" /></li>
<li><label>Посада</label><input type="text" name="admin_role" value="'.$row["role"].'" /></li>
<li><label>E-mail</label><input type="text" name="admin_email" value="'.$row["email"].'" /></li>
<li><label>Телефон</label><input type="text" name="admin_phone" value="'.$row["phone"].'" /></li>
</ul>

<h3 id="title-privilege">Привілеї</h3>

<p id="link-privilege"><a id="select-all">Выбрати все</a> | <a id="remove-all">Зняти все</a></p>

<div class="block-privilege">

<ul class="privilege">
<li><h3>Замовлення</h3></li>

<li>
<input type="checkbox" name="view_orders" id="view_orders" value="1" '.$view_orders.' />
<label for="view_orders">Перегляд замовлень</label>
</li>

<li>
<input type="checkbox" name="accept_orders" id="accept_orders" value="1" '.$accept_orders.' />
<label for="accept_orders">Обробка замовлень</label>
</li>

<li>
<input type="checkbox" name="delete_orders" id="delete_orders" value="1" '.$delete_orders.' />
<label for="delete_orders">Видалення замовлень</label>
</li>
</ul>

<ul class="privilege">
<li><h3>Товари</h3></li>

<li>
<input type="checkbox" name="add_tovar" id="add_tovar" value="1" '.$add_tovar.' />
<label for="add_tovar">Додавання товарів</label>
</li>

<li>
<input type="checkbox" name="edit_tovar" id="edit_tovar" value="1" '.$edit_tovar.' />
<label for="edit_tovar">Зміна товарів</label>
</li>

<li>
<input type="checkbox" name="delete_tovar" id="delete_tovar" value="1" '.$delete_tovar.' />
<label for="delete_tovar">Видалення товарів</label>
</li>
</ul>

</div>

<div class="block-privilege">

<ul class="privilege">
<li><h3>Категорії</h3></li>

<li>
<input type="checkbox" name="add_category" id="add_category" value="1" '.$add_category.' />
<label for="add_category">Додавання категорії</label>
</li>

<li>
<input type="checkbox" name="delete_category" id="delete_category" value="1" '.$delete_category.' />
<label for="delete_category">Видалення категорії</label>
</li>
</ul>
</div>

<div class="block-privilege">
<ul class="privilege">
<li><h3>Адміністратори</h3></li>

<li>
<input type="checkbox" name="view_admin" id="view_admin" value="1" '.$view_admin.' />
<label for="view_admin">Перегляд адміністраторів</label>
</li>
</ul>
</div>

<p align="right"><input type="submit" name="submit_edit" id="submit_form" value="Зберегти" /></p>

</form>
    ';
    }
    while ($row=mysqli_fetch_array($result));
} 
?>


</div>
</div>

</body>
</html>
<?php
	}
    else{
        header("Location: login.php");
    }
?>