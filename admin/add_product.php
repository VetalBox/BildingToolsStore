<?php
session_start();
if($_SESSION['auth_admin'] == "yes_auth"){

define('admin23', true);

error_reporting(E_ALL & ~E_NOTICE);

if(isset($_GET["logout"])){
    unset($_SESSION['auth_admin']);
    header("Location: login.php");
}
$_SESSION['urlpage']="<a href='index.php'>Головна</a> \ <a href='tovar.php'>Товари</a> \ <a>Додавання товару</a>";

include("include/db_connect.php");
include("include/functions.php");

if ($_POST["submit_add"]){
    
    if($_SESSION['add_tovar']=='1'){
        
    $error=array();
    //проверка полей
    if(!$_POST["form_title"]){
        $error[]="Вкажіть назву товару";
    }
    if(!$_POST["form_price"]){
        $error[]="Вкажіть ціну";
    }
       
    
    if(!$_POST["form_category"]){//проверка ввода модели автомобиля
        $error[]="Вкажіть категорію";
    }
    else{
        $result=mysqli_query($link, "SELECT * FROM `category` WHERE id='{$_POST["form_category"]}'");
        $row=mysqli_fetch_array($result);
        $selectbrand=$row["brand"];
		$selectbrand2=$row["type"];		
    }
    
    
    //определение id автомобиля из таблицы zap для таблицы table-products
        $id=mysqli_query($link, "SELECT id FROM `category` WHERE brand='$selectbrand'");
    
        $result_id=mysqli_fetch_array($id);



    
    //Проверка чекбоксов
    if($_POST["chk_visible"]){
        $chk_visible="1";
    }
    else{
        $chk_visible="0";
    }
    
     if($_POST["chk_new"]){
        $chk_new="1";
    }
    else{
        $chk_new="0";
    }
    
     if($_POST["chk_leader"]){
        $chk_leader="1";
    }
    else{
        $chk_leader="0";
    }
    
     if($_POST["chk_sale"]){
        $chk_sale="1";
    }
    else{
        $chk_sale="0";
    }
    
    if(count($error)){
        $_SESSION['message']="<p id='form-error'>".implode('<br />', $error)."</p>";
    }
    else{
		
		mysqli_query($link, "INSERT INTO `table-products`(`products_id`, `title`, `price`, `brand`, `seo_words`, `image`, `description`, `features`, `new`, `leader`, `sale`, `visible`, `type_tovara`, `brand_id`)
		VALUES (
		NULL,
		 '".$_POST["form_title"]."',
		'".$_POST["form_price"]."',
		'".$selectbrand."',
		'".$_POST["form_seo_words"]."',
		'',
		 '".$_POST["txt2"]."',
		'".$_POST["txt4"]."',
		'".$chk_new."',
		'".$chk_leader."',
		'".$chk_sale."',
		'".$chk_visible."',
		 '".$selectbrand2."',
		'".$result_id["id"]."'
		)");
		
		
		$id=mysqli_insert_id($link);
		

      $_SESSION['message']="<p id='form-success'>Товар успішно доданий!</p>";
					
					
			
							$id=mysqli_insert_id($link);

      
      if(empty($_POST["upload_image"])){
        include("actions/upload-image.php");
        unset($_POST["upload_image"]);
      } 
      
      if(empty($_POST["galleryimg"])){
        include("actions/upload-gallery.php");
        unset($_POST["galleryimg"]);
      } 
    }
  }
  else{
    $msgerror='У Вас немає прав на додавання товару';
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
    
	<title>Панель управління</title>
</head>

<body>
<div id="block-body">
<?php
	include("include/block-header.php");

?>
<div id="block-content">

<div id="block-parameters">
<p id="title-page">Додавання товару</p>
</div>
<?php

if(isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
	if(isset($_SESSION['message'])){
	   echo $_SESSION['message'];
       unset($_SESSION['message']);
	}
	if(isset($_SESSION['answer'])){
	   echo $_SESSION['answer'];
       unset($_SESSION['answer']);
	}
?>

<form enctype="multipart/form-data" method="post">
<ul id="edit-tovar">

<li>
<label>Назва товару</label>
<input type="text" name="form_title" />
</li>

<li>
<label>Ціна</label>
<input type="text" name="form_price" />
</li>

<li>
<label>Ключові слова</label>
<input type="text" name="form_seo_words" />
</li>

<li>
<label>Категорія</label>
<select name="form_category" size="10">
<?php
$category=mysqli_query($link, "SELECT * FROM `category`");
    if (mysqli_num_rows($category) > 0)
        {
        $result_category=mysqli_fetch_array($category);
        
        
        do{
            echo '
            <option value="'.$result_category["id"].'">'.$result_category["brand"].'</option>
            ';
        }
        while($result_category=mysqli_fetch_array($category));
}
?>
</select>
</li>

</ul>
<label class="stylelabel">Основне зображення</label>

<div id="baseimg-upload">
<input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
<input type="file" name="upload_image" />
</div>



<h3 class="h3click">Опис товару</h3>
<div class="div-editor2">
<textarea id="editor2" name="txt2" cols="100" rows="20"></textarea>
    <script type="text/javascript">
    var ckeditor1=CKEDITOR.replace("editor2");
    AjexFileManager.init({
        returnTo:"ckeditor",
        editor: ckeditor1
        });
    </script>
</div>


<h3 class="h3click">Характеристики</h3>
<div class="div-editor4">
<textarea id="editor4" name="txt4" cols="100" rows="20"></textarea>
    <script type="text/javascript">
    var ckeditor1=CKEDITOR.replace("editor4");
    AjexFileManager.init({
        returnTo:"ckeditor",
        editor: ckeditor1
        });
    </script>
</div>

<label class="stylelabel">Галерея зображень</label>

<div id="objects">
<div id="addimage1" class="addimage">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
<input type="file" name="galleryimg[]" />
</div>
</div>

<p id="add-input">Добавити</p>

<h3 class="h3title">Налаштування товару</h3>
<ul>
<li><input type="checkbox" name="chk_new" id="chk_chk_new" /><label for="chk_chk_new">Новий товар</label></li>
<li><input type="checkbox" name="chk_leader" id="chk_leader" /><label for="chk_leader">Популярний товар</label></li>
<li><input type="checkbox" name="chk_sale" id="chk_sale" /><label for="chk_sale">Товар зі знижкою</label></li>
<li><input type="checkbox" name="chk_visible" id="chk_visible" /><label for="chk_visible">Показувати товар</label></li>
</ul>

<p align="right"><input type="submit" id="submit_form" name="submit_add" value="Додати товар" /></p>

</form>



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