<?php
session_start();
if($_SESSION['auth_admin'] == "yes_auth"){

define('admin23', true);

error_reporting(E_ALL & ~E_NOTICE);

if(isset($_GET["logout"])){
    unset($_SESSION['auth_admin']);
    header("Location: login.php");
}
$_SESSION['urlpage']="<a href='index.php'>Головна</a> \ <a href='tovar.php'>Товары</a> \ <a>Внесення змін</a>";

include("include/db_connect.php");
include("include/functions.php");


$id=clear_string($_GET["id"]);


$action=clear_string($_GET["action"]);
    if (isset($action)){
        switch($action){
            case 'delete':
            
            if($_SESSION['edit_tovar']=='1'){
                
            
                if(file_exists("../upload_images/".$_GET["img"])){
                    unlink("../upload_images/".$_GET["img"]);
                }
                }
                else{
                    $msgerror='У Вас немає права на зміну товару!';
                }
                break;
        }
    }

if ($_POST["submit_save"]){
    
    if($_SESSION['edit_tovar']=='1'){
    
    $error=array();
    //проверка полей
    if(!$_POST["form_title"]){
        $error[]="Вкажіть назву товару";
    }
    if(!$_POST["form_price"]){
        $error[]="Вкажіть ціну";
    }

    
    
    if(!$_POST["form_category"]){//выбор модели автомобиля
        $error[]="Вкажіть категорію";
    }
    else{
        $result=mysqli_query($link, "SELECT * FROM `category` WHERE id='{$_POST["form_category"]}'");
        $row=mysqli_fetch_array($result);
        $selectbrand=$row["brand"];
			$selectbrand2=$row["type"];
    }
   

    
       //определение id автомобиля из таблицы zap для таблицы table-products
        $id_brand_id=mysqli_query($link, "SELECT id FROM `category` WHERE brand='$selectbrand'");
    
        $result_id=mysqli_fetch_array($id_brand_id);
    

    if(empty($_POST["upload_image"])){
        include("actions/upload-image.php");
        unset($_POST["upload_image"]);
      } 
      
      if(empty($_POST["galleryimg"])){
        include("actions/upload-gallery.php");
        unset($_POST["galleryimg"]);
      } 
    
    //Проверка чекбоксов
    if(isset($_POST["chk_visible"])){
        $chk_visible="1";
    }
    else{
        $chk_visible="0";
    }
    
     if(isset($_POST["chk_new"])){
        $chk_new="1";
    }
    else{
        $chk_new="0";
    }
    
     if(isset($_POST["chk_leader"])){
        $chk_leader="1";
    }
    else{
        $chk_leader="0";
    }
    
     if(isset($_POST["chk_sale"])){
        $chk_sale="1";
    }
    else{
        $chk_sale="0";
    }
    
    if(count($error)){
        $_SESSION['message']="<p id='form-error'>".implode('<br />', $error)."</p>";
    }
    else{
        
        $querynew="title='{$_POST["form_title"]}', price='{$_POST["form_price"]}',brand='$selectbrand',seo_words='{$_POST["form_seo_words"]}', description='{$_POST["txt2"]}',features='{$_POST["txt4"]}', new='$chk_new', leader='$chk_leader', sale='$chk_sale', visible='$chk_visible', type_tovara='$selectbrand2', brand_id='{$result_id["id"]}'";

        $update="UPDATE `table-products` SET `title`='{$_POST["form_title"]}',`price`='{$_POST["form_price"]}',`brand`='$selectbrand',`seo_words`='{$_POST["form_seo_words"]}',`description`='{$_POST["txt2"]}',`features`='{$_POST["txt4"]}',`new`='$chk_new',`leader`='$chk_leader',`sale`='$chk_sale',`visible`='$chk_visible',`type_tovara`='$selectbrand2',`brand_id`='{$result_id["id"]}' WHERE `products_id`='$id'";

      if (mysqli_query($link, $update)) {
					echo "Record updated successfully";
					} else {
						echo "Error updating record: " . mysqli_error($link);

						}
	  
	  
	  
	  
	  $_SESSION['message']="<p id='form-success'>Товар успішно змінено!</p>";   
  
    }
    }
                else{
                    $msgerror='У Вас немає прав на зміну товару!';
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

<?php
	$result=mysqli_query($link, "SELECT * FROM `table-products` WHERE `products_id`='$id'");

        if(mysqli_num_rows($result)>0){
            $row=mysqli_fetch_array($result);
                do{
                    echo '
                    <form enctype="multipart/form-data" method="post">
                    <ul id="edit-tovar">

                    <li>
                    <label>Назва товару</label>
                    <input type="text" name="form_title" value="'.$row["title"].'" />
                    </li>

                    <li>
                    <label>Ціна</label>
                    <input type="text" name="form_price" value="'.$row["price"].'" />
                    </li>

                    <li>
                    <label>Ключові слова</label>
                    <input type="text" name="form_seo_words" value="'.$row["seo_words"].'" />
                    </li>


                <li>
                <label>Категорія</label>
                <select name="form_category" size="10">
            ';

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
             echo '
                </select>
                </li>
                </ul>
';

            if(strlen($row["image"]) > 0 && file_exists("../upload_images/".$row["image"])){
            $img_path='../upload_images/'.$row["image"];
            $max_width=110;
            $max_height=110;
            list($width, $height)=getimagesize($img_path);
            $ratioh=$max_height/$height;
            $ratiow=$max_width/$width;
            $ratio=min($ratioh, $ratiow);
            $width=intval($ratio*$width);
            $height=intval($ratio*$height);
            
            echo '
            <label class="stylelabel">Загальне зображення</label>
            <div id="baseimg">
            <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
            <a href="edit_product.php?id='.$row["products_id"].'&img='.$row["image"].'&action=delete"></a>
            </div>
            ';
            }
            else{
                echo '
                <label class="stylelabel">Загальне зображення</label>

                <div id="baseimg-upload">
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
                <input type="file" name="upload_image" />
                </div>
                ';
                
            }


            echo '
                

                <h3 class="h3click">Oпис товару</h3>
                <div class="div-editor2">
                <textarea id="editor2" name="txt2" cols="100" rows="20">'.$row["description"].'</textarea>
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
                <textarea id="editor4" name="txt4" cols="100" rows="20">'.$row["features"].'</textarea>
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

                <p id="add-input">Додати</p>
                
                <ul id="gallery-img">
                
                ';
$query_img=mysqli_query($link, "SELECT * FROM `uploads_images` WHERE products_id='$id'");
    
    if (mysqli_num_rows($query_img) > 0)
        {
        $result_img=mysqli_fetch_array($query_img);
        
        
        do{
            if(strlen($result_img["image"]) > 0 && file_exists("../upload_images/".$result_img["image"])){
            $img_path='../upload_images/'.$result_img["image"];
            $max_width=110;
            $max_height=110;
            list($width, $height)=getimagesize($img_path);
            $ratioh=$max_height/$height;
            $ratiow=$max_width/$width;
            $ratio=min($ratioh, $ratiow);
            $width=intval($ratio*$width);
            $height=intval($ratio*$height);
            
        }
        else{
            $img_path="./images/noimages.png";
            $width=80;
            $height=70;
        }
    echo '
    <li id="del'.$result_img["id"].'">
    <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" title="'.$result_img["image"].'" />
    <a class="del-img" img_id="'.$result_img["id"].'"></a>
    </li>
    ';
        
}        
        while($result_img=mysqli_fetch_array($query_img));
}
        
  
                
echo '
        </ul>
        ';
        if($row["visible"]=='1') $checked1="checked";
        if($row["new"]=='1') $checked2="checked";
        if($row["leader"]=='1') $checked3="checked";
        if($row["sale"]=='1') $checked4="checked";
        
        
        echo '
                <h3 class="h3title">Настройки товара</h3>
                <ul id="chkbox">
                <li><input type="checkbox" name="chk_visible" id="chk_visible" '.(isset($checked1)).' /><label for="chk_visible">Показувати товар</label></li>
                <li><input type="checkbox" name="chk_new" id="chk_chk_new" '.(isset($checked2)).' /><label for="chk_chk_new">Новий товар</label></li>
                <li><input type="checkbox" name="chk_leader" id="chk_leader" '.(isset($checked3)).' /><label for="chk_leader">Популярний товар</label></li>
                <li><input type="checkbox" name="chk_sale" id="chk_sale" '.(isset($checked4)).' /><label for="chk_sale">Товар зі скидкою</label></li>
                </ul>

                <p align="right"><input type="submit" id="submit_form" name="submit_save" value="Зберегти" /></p>

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