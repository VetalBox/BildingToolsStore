<?php
session_start();

define('admin23', true);

error_reporting(E_ALL & ~E_NOTICE);

if($_SESSION['auth_admin'] == "yes_auth"){



if(isset($_GET["logout"])){
    unset($_SESSION['auth_admin']);
    header("Location: login.php");
}
$_SESSION['urlpage']="<a href='index.php'>Головна</a> \ <a href='tovar.php'>Товари</a>";

include("include/db_connect.php");
include("include/functions.php");

//Начало сортировки

$cat=$_GET["cat"];
$type=$_GET["type"];
$id= isset ($_GET["id"]);

if(isset($cat)){
    
    switch ($cat){
        
        case 'all':
        $cat_name='Усі товари';
        $url="cat=all&";
        $cat="";
        break;
        
        case 'Спеціальний одяг':
        $cat_name='Спеціальний одяг';
        $url="cat=Спеціальний одяг&";
        $cat="WHERE `type_tovara`='Спеціальний одяг'";
        break;
        
        case 'Будівельні інструменти':
        $cat_name='Будівельні інструменти';
        $url="cat=Будівельні інструменти&";
        $cat="WHERE `type_tovara`='Будівельні інструменти'";
        break;
		
		case 'Засоби захисту':
        $cat_name='Засоби захисту';
        $url="cat=Засоби захисту&";
        $cat="WHERE `type_tovara`='Засоби захисту'";
        break;
        
        case 'Господарські товари':
        $cat_name='Господарські товари';
        $url="cat=Господарські товари&";
        $cat="WHERE `type_tovara`='Господарські товари'";
        break;
        
        default:
        $cat_name=$cat;
        $url="type=".clear_string($type)."&cat=".clear_string($cat)."&";
        $cat="WHERE `type_tovara`='".clear_string($type)."' AND brand='".clear_string($cat)."'";
        break;
        }
    }
//конец сортировки



$action= $_GET["action"];//удаление товара из базы данных

if(isset($action)){
	
    $id = (int)$_GET["id"];

    switch ($action){
        case 'delete':
        if ($_SESSION['delete_tovar']=='1'){
        $delete=mysqli_query($link, "DELETE FROM `table-products` WHERE products_id='$id'");
        break;
        }
        else{
            $msgerror='У Вас немає прав доступу на видалення товару';
        }
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
    <script type="text/javascript" src="jquery-confirm/js/jquery-confirm.js"></script>
	<title>Панель управления</title>
</head>

<body>
<div id="block-body">
<?php
	include("include/block-header.php");

    $all_count=mysqli_query($link, "SELECT * FROM `table-products`");
    $all_count_result=mysqli_num_rows($all_count);
?>
<div id="block-content">
<!--Вывод списка с категориями-->
<div id="block-parameters">
<ul id="options-list">
<li>Товари</li>
<li><a id="select-links" href="#">Товари - <? if (isset($cat_name)) echo $cat_name;?></a>
<div id="list-links">
<ul>
<li><a href="tovar.php?cat=all"><strong>Усі товари</strong></a></li>
<li><a href="tovar.php?cat=Спеціальний одяг"><strong>Спеціальний одяг</strong></a></li>
<?php

$result1=mysqli_query($link, "SELECT * FROM `category` WHERE type='Спеціальний одяг'");
    if (mysqli_num_rows($result1) > 0)
        {
        $row1=mysqli_fetch_array($result1);
        
        
        do{
            echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
            }
            while ($row1=mysqli_fetch_array($result1));
            }
?>
</ul>
<ul>
<li><a href="tovar.php?cat=Будівельні інструменти"><strong>Будівельні інструменти</strong></a></li>
<?php

$result1=mysqli_query($link, "SELECT * FROM `category` WHERE type='Будівельні інструменти'");
    If (mysqli_num_rows($result1) > 0)
        {
        $row1=mysqli_fetch_array($result1);
        
        
        do{
            echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
            }
            while ($row1=mysqli_fetch_array($result1));
            }
?>
</ul>

<ul>
<li><a href="tovar.php?cat=Засоби захисту"><strong>Засоби захисту</strong></a></li>
<?php

$result1=mysqli_query($link, "SELECT * FROM `category` WHERE type='Засоби захисту'");
    If (mysqli_num_rows($result1) > 0)
        {
        $row1=mysqli_fetch_array($result1);
        
        
        do{
            echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
            }
            while ($row1=mysqli_fetch_array($result1));
            }
?>
</ul>


<ul>
<li><a href="tovar.php?cat=Господарські товари"><strong>Господарські товари</strong></a></li>
<?php

$result1=mysqli_query($link, "SELECT * FROM `category` WHERE type='Господарські товари'");
    If (mysqli_num_rows($result1) > 0)
        {
        $row1=mysqli_fetch_array($result1);
        
        
        do{
            echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
            }
            while ($row1=mysqli_fetch_array($result1));
            }
?>
</ul>
</div>
</li>
</ul>
</div>
<!--конец вывод списка с категориями-->
<div id="block-info">
<p id="count-style">Усього товарів - <strong><?php echo $all_count_result; ?></strong></p>
<p align="right" id="add-style"><a href="add_product.php">Добавити товар</a></p>
</div>



<ul id="block-tovar">
<?php

if(isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

$num=8;

//$page=(int)$_GET['page'];
 if(!isset($cat))
            $cat='';

$count=mysqli_query($link, "SELECT COUNT(*) FROM `table-products` $cat");
$temp=mysqli_fetch_array($count);
$post=$temp[0];
//находим общее число страниц
$total=(($post-1)/$num)+1;
$total=intval($total);
//oпределяем начало сообщений для текущей страницы

 if(isset($_GET['page']))
            $page=(int)$_GET['page'];
//$page=intval($page);
//если значение $page меньше единицы или отрицательно переходим на новую страницы
//a усли слишком большое, то переходим на последнюю	
if (empty($page) or $page<0) $page=1;
if($page>$total) $page=$total;
//вычисляем начиная с какого номера
//следует выводить сообщение
$start=$page*$num-$num;
if($temp[0]>0){
$result=mysqli_query($link, "SELECT * FROM `table-products` $cat ORDER BY products_id DESC LIMIT $start, $num");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
        // функция по подгонке изображения на главной странице
        do{
            
            if(strlen($row["image"]) >0 && file_exists("../upload_images/".$row["image"])){
            $img_path='../upload_images/'.$row["image"];
            $max_width=160;
            $max_height=160;
            list($width, $height)=getimagesize($img_path);
            $ratioh=$max_height/$height;
            $ratiow=$max_width/$width;
            $ratio=min($ratioh, $ratiow);
            $width=intval($ratio*$width);
            $height=intval($ratio*$height);
            }
            else{
                $img_path="./images/no-images.jpg";
                $width=90;
                $height=164;
            }
			
			if(!isset($url)) {$url = '';}
    echo '
            
            <li>
            <p>'.$row["title"].'</p>
            <center>
            <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
            </center>

			
            <p align="center" class="link-action"><a class="green" href="edit_product.php?id='.$row["products_id"].'">Змінити</a> | <a rel="tovar.php?'.$url.'id='.$row["products_id"].'&action=delete" class="delete">Видалити</a></p>
            </li>
            ';       
        }
        while($row=mysqli_fetch_array($result));
        echo '
        </ul>
        ';
    }        
}
  //нижняя навигация по страницам
    if($page!=1){$pervpage='<li><a class="pstr-prev" href="tovar.php?'.$url.'page='.($page-1).'">&lt;</a></li>';}
    if($page!=$total) $nextpage='<li><a class="pstr-next" href="tovar.php?'.$url.'page='.($page+1).'">&gt;</a></li>';
    
    if($page-5>0) $page5left='<li><a href="tovar.php?'.$url.'page='.($page-5).'">'.($page-5).'</a></li>';
    if($page-4>0) $page4left='<li><a href="tovar.php?'.$url.'page='.($page-4).'">'.($page-4).'</a></li>';
    if($page-3>0) $page3left='<li><a href="tovar.php?'.$url.'page='.($page-3).'">'.($page-3).'</a></li>';
    if($page-2>0) $page2left='<li><a href="tovar.php?'.$url.'page='.($page-2).'">'.($page-2).'</a></li>';
    if($page-1>0) $page1left='<li><a href="tovar.php?'.$url.'page='.($page-1).'">'.($page-1).'</a></li>';
    
    if($page+5<=$total) $page5right='<li><a href="tovar.php?'.$url.'page='.($page+5).'">'.($page+5).'</a></li>';
    if($page+4<=$total) $page4right='<li><a href="tovar.php?'.$url.'page='.($page+4).'">'.($page+4).'</a></li>';
    if($page+3<=$total) $page3right='<li><a href="tovar.php?'.$url.'page='.($page+3).'">'.($page+3).'</a></li>';
    if($page+2<=$total) $page2right='<li><a href="tovar.php?'.$url.'page='.($page+2).'">'.($page+2).'</a></li>';
    if($page+1<=$total) $page1right='<li><a href="tovar.php?'.$url.'page='.($page+1).'">'.($page+1).'</a></li>';
    
    
    if($page+5<$total){
        $strtotal='<li><p class="nav-point">...</p></li><li><a href="tovar.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
    }
    else{
        $strtotal="";
    }
  ?>
  <div id="footerfix"></div>
  <?php  
    if($total>1){
        echo '
        <center>
        <div class="pstrnav">
        <ul>
        ';
		
				if(!isset($pervpage))
			$pervpage = '';
		if(!isset($page5left))
			$page5left = '';
		if(!isset($page4left))
			$page4left = '';
		if(!isset($page3left))
			$page3left = '';
		if(!isset($page2left))
			$page2left = '';
		if(!isset($page1left))
			$page1left = '';
		if(!isset($page1right))
			$page1right = '';
		if(!isset($page2right))
			$page2right = '';
		if(!isset($page3right))
			$page3right = '';
		if(!isset($page4right))
			$page4right = '';
		if(!isset($page5right))
			$page5right = '';
		if(!isset($nextpage))
			$nextpage = '';
        
        echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='tovar.php?".$url."page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
       echo '
        </center>
        </ul>
        </div>
        ';
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