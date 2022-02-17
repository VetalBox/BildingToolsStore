<?php
define('admin23', true);

error_reporting(E_ALL & ~E_NOTICE);

if($_FILES['galleryimg']['name'][0]){
    for($i=0;$i<count($_FILES['galleryimg']['name']);$i++){
        $error_gallery="";
if($_FILES['galleryimg']['name'][$i]){
    
    $galleryimgType=$_FILES['galleryimg']['type'][$i];//тип файла
    $types=array("image/gif","image/png","image/jpeg","image/pjpeg","image/x-png","image/jpg","image/webp");
        
        //проверяем расширение     
          $imgext=strtolower(preg_replace("#.+\.([a-z]+)$#i","$1",$_FILES['galleryimg']['name'][$i]));
          //папка для загрузки
          $uploaddir='../upload_images/';
          //новое сгенерированное имя файла
          $newfilename=$_POST["form_type"].'-'.$id.rand(100,500).'.'.$imgext;
          //путь к файлу(папка.файл)
		  
error_reporting(E_ALL & ~E_NOTICE);
          $uploadfile=$uploaddir.$newfilename;
          
//загружаем файл move-uploaded_file 
    if(!in_array($galleryimgType, $types)){
            $error_gallery="<p id='form-error'>Допустимі росширення файлу -.gif, .jpg, .png, .webp</p>";
            $_SESSION['answer']=$error_gallery;
            continue;
          }
          if(empty($error_gallery)){
            
            if(@move_uploaded_file($_FILES['galleryimg']['tmp_name'][$i], $uploadfile)){
               mysqli_query($link, "INSERT INTO `uploads_images`(`products_id`,`image`)   VALUES(
                '".$id."',
                '".$newfilename."'
               )");   
          }
          else{
            $_SESSION['answer']="Помилка завантаження файлу";
          }
          }
          }
          }
          }
?>