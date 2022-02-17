<?php
session_start();
if($_SESSION['auth_admin'] == "yes_auth"){

define('admin23', true);

if(isset($_GET["logout"])){
    unset($_SESSION['auth_admin']);
    header("Location: login.php");
}

error_reporting(E_ALL & ~E_NOTICE);

$_SESSION['urlpage']="<a href='index.php'>Головна</a> \ <a href='orders.php'>Замовлення</a>";

include("include/db_connect.php");
include("include/functions.php");

$id=clear_string($_GET["id"]);
$sort=$_GET["sort"];

switch ($sort){
    
    case 'all-orders':
    $sort="order_id DESC";
    $sort_name='От А до Я';
    break;
    
      case 'confirmed':
    $sort="order_confirmed='yes' DESC";
    $sort_name='Обработанные';
    break;
    
      case 'no-confirmed':
    $sort="order_confirmed='no' DESC";
    $sort_name='Не обработаные';
    break;
    
    default:
    $sort="order_id DESC";
    $sort_name='От А до Я';
    break;
    
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
	
    <title>Панель управління - Замовлення</title>
</head>

<body>
<div id="block-body">
<?php
	include("include/block-header.php");
    
        $all_count=mysqli_query($link, "SELECT * FROM `orders`");
        $all_count_result=mysqli_num_rows($all_count);
        
        $buy_count=mysqli_query($link, "SELECT * FROM `orders` WHERE `order_confirmed`='yes'");
        $buy_count_result=mysqli_num_rows($buy_count);

        $no_buy_count=mysqli_query($link, "SELECT * FROM `orders` WHERE `order_confirmed`= ''");
        $no_buy_count_result=mysqli_num_rows($no_buy_count);

?>
<div id="block-content">
<!--Вывод списка с категориями-->
<div id="block-parameters">
<ul id="options-list">
<li>Сортувати</li>
<li><a id="select-links" href="#"><? echo $sort_name;?></a>
<ul id="list-links-sort">
<li><a href="orders.php?sort=all-orders">Від А до Я</a></li>
<li><a href="orders.php?sort=confirmed">Оброблені</a></li>
<li><a href="orders.php?sort=no-confirmed">Не оброблені</a></li>
</ul>
</li>
</ul>
</div>
<!--конец вывод списка с категориями-->
<div id="block-info">
<ul id="review-info-count">
<li>Всього замовлень - <strong><? echo $all_count_result;?></strong></li>
<li>Оброблених - <strong><? echo $buy_count_result;?></strong></li>
<li>Не оброблених - <strong><? echo $no_buy_count_result;?></strong></li>
</ul>
</div>

<?php

$result=mysqli_query($link, "SELECT * FROM `orders` ORDER BY $sort");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
     if($_SESSION['view_orders']=='1'){
        do{
            
            if($row["order_confirmed"]=='yes'){
                $status='<span class="green">Оброблені</span>';
            }
            else{
                $status='<span class="green">Не оброблені</span>';
            }
            echo '
            
            <div class="block-order">
                <p class="order-datetime">'.$row["order_datetime"].'</p>
                <p class="order-number">Замовлення № '.$row["order_id"].' - '.$status.'</p>
                <p class="order-link"><a class="green" href="view_order.php?id='.$row["order_id"].'">Докладніше</a></p>
            </div>
            ';

    } 
    while($row=mysqli_fetch_array($result));
    
    }
    else{
        echo '
        <p align="center" id="admincik">У Вас немає прав на огляд докладнішої інформацї про замовлення!</p>
        ';
        
    }       
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