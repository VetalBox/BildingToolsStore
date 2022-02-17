<?php
define('admin23', true);

error_reporting(E_ALL & ~E_NOTICE);

$error_img=array();

if($_FILES['upload_image']['error']>0){
    //в зависимости от вида ошибки выводим сообщение
    switch ($_FILES['upload_image']['error']){
        case 1:$error_img[]='Розмір файлу перевищує допустиме значення UPLOAD_MAX_FILE_SIZE';break;
        case 2:$error_img[]='Розмір файлу перевищує допустиме значення MAX_FILE_SIZE';break;
        case 3:$error_img[]='Не вдалося загрузити частину файлу';break;
        case 4:$error_img[]='Файл не був загружений';break;
        case 6:$error_img[]='Відсутня часова папка';break;
        case 7:$error_img[]='Не вдалося записати файл на диск';break;
        case 8:$error_img[]='РНР-розширення зупинило загрузку файлу';break;     
        }
    }
    else{ 
        //проверяем расширение
        if($_FILES['upload_image']['type']=='image/jpeg' || $_FILES['upload_image']['type']=='image/jpg' || $_FILES['upload_image']['type']=='image/png' || $_FILES['upload_image']['type']=='image/webp'){
          
          $imgext=strtolower(preg_replace("#.+\.([a-z]+)$#i","$1",$_FILES['upload_image']['name']));
          //папка для загрузки
          $uploaddir='../upload_images/';
          //новое сгенерированное имя файла
          $newfilename=$_POST["form_type"].'-'.$id.rand(10,100).'.'.$imgext;
          //путь к файлу(папка.файл)
          $uploadfile=$uploaddir.$newfilename;
          //загружаем файл move-uploaded_file 
          if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploadfile)){
            $update=mysqli_query($link, "UPDATE `table-products` SET `image`='$newfilename' WHERE `products_id`='$id'");
          }
          else{
            $error_img[]="Помилка загрузки файлу";
          }
        }
        else{
            $error_img[]='Допустимі росширення: jpeg, jpg, png, webp';
        }
    }
?>