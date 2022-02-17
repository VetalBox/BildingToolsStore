<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);

if($_SESSION['auth_admin'] == "yes_auth"){

define('admin23', true);



if(isset($_GET["logout"])){
    unset($_SESSION['auth_admin']);
    header("Location: login.php");
}
$_SESSION['urlpage']="<a href='index.php'>Головна</a> \ <a href='view_order.php'>Огляд завмовлень</a>";

include("include/db_connect.php");
include("include/functions.php");

$id=clear_string($_GET["id"]);
$action= $_GET["action"];
//$action=$_GET["action"];

$price= isset($price);
$index_count= isset($index_count);

if (isset($action)){
    switch($action){
        
        case 'accept':
        if($_SESSION['accept_orders']=='1'){
        $update=mysqli_query($link, "UPDATE `orders` SET `order_confirmed`='yes' WHERE `order_id`='$id'");
         }
        else{
           $msgerror='У Вас немає прав на підтвердження замовлення!'; 
        }
        break;
        
        case 'delete':
        if($_SESSION['delete_orders']=='1'){
        $delete=mysqli_query($link, "DELETE FROM `orders` WHERE `order_id`='$id'");
        header("Location: orders.php");
        }
        else{
           $msgerror='У Вас немає прав на видалення замовлення!'; 
        }
        break;
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
	
    <title>Панель управління - Огляд замовлень</title>
</head>

<body>
<div id="block-body">
<?php
	include("include/block-header.php");
    
       
?>
<div id="block-content">

<div id="block-parameters">
<p id="title-page">Огляд замовлень</p>
</div>

<?php

if(isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

$result=mysqli_query($link, "SELECT * FROM `orders` WHERE order_id='$id' ");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
     
        do{
            
            if($row["order_confirmed"]=='yes'){
                $status='<span class="green">Оброблені</span>';
            }
            else{
                $status='<span class="green">Не оброблені</span>';
            }
            echo '
                <p class="order-link"><a class="green" href="view_order.php?id='.$row["order_id"].'&action=accept">Підтвердити замовлення</a> | <a class="delete" rel="view_order.php?id='.$row["order_id"].'&action=delete">Удалить</a></p>
                <p class="order-datetime">'.$row["order_datetime"].'</p>
                <p class="order-number">Замовлення № '.$row["order_id"].' - '.$status.'</p>
                
            
            <TABLE align="center" CELLPADDING="10" WIDTH="100%">
            <TR>
            <TH>№</TH>
            <TH>Найменування товару</TH>
            <TH>Ціна</TH>
            <TH>Кількість</TH>
            </TR>
            ';
            
$query_product=mysqli_query($link, "SELECT * FROM `buy_products`,`table-products`  WHERE `buy_products`.`buy_id_order`='$id' AND `table-products`.`products_id`=`buy_products`.`buy_id_product`");
    
        $result_query=mysqli_fetch_array($query_product);
        
        do{
            $price=$price+$result_query["price"] * $result_query["buy_count_product"];
            $index_count=$index_count+1;
            
            echo '
                <TR>
                <TD align="CENTER">'.$index_count.'</TD>
                <TD align="CENTER">'.$result_query["title"].'</TD>
                <TD align="CENTER">'.$result_query["price"].' грн.</TD>
                <TD align="CENTER">'.$result_query["buy_count_product"].'</TD>
                </TR>
            ';
        }
        while ($result_query=mysqli_fetch_array($query_product));
        
    if ($row["order_pay"]=="accepted"){
        $statpay='<span class="green">Оплачено</span>';
    }
    else{
        $statpay='<span class="red">Не оплачено</span>';
    }
    
    echo '
        </TABLE>
        <ul id="info-order">
        <li>Загальна ціна - <span>'.$price.'</span> грн.</li>
        <li>Спосіб доставки - <span>'.$row["order_dostavka"].'</span></li>
        <!--
		<li>Статус оплати - '.$statpay.'</li>
        
		-->
        <li>Дата замовлення - <span>'.$row["order_datetime"].'</span></li>        
        </ul>
        
        <TABLE align="center" CELLPADDING="10" WIDTH="100%">
        <TR>
        <TH>ФІО</TH>
        <TH>Адреса</TH>
        <TH>Контакти</TH>
        <TH>Примітка</TH>
        </TR>
        
        <TR>
        <TD align="CENTER">'.$row["order_fio"].'</TD>
        <TD align="CENTER">'.$row["order_address"].'</TD>
        <TD align="CENTER">'.$row["order_phone"].'</br>'.$row["order_email"].'</TD>
        <TD align="CENTER">'.$row["order_note"].'</TD>
        </TR>
        </TABLE>
    ';
    } 
    while($row=mysqli_fetch_array($result));       
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