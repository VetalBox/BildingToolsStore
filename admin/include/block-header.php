<?php

//define('admin23', true);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

   $result1=mysqli_query($link, "SELECT * FROM `orders` WHERE order_confirmed='no'");
   $count1=mysqli_num_rows($result1);
   
   if ($count1 > 0){
    $count_str1='<p>+'.$count1.'</p>';
   }
   else{
    $count_str1='';
   }
   

?>
<div id="block-header">

<div id="block-header1">
<h3>Панель управління</h3>
<p id="link-nav"><?php echo $_SESSION['urlpage'];?></p>
</div>

<div id="block-header2">
<p align="right"><a href="administrators.php">Адміністратор</a> | <a href="?logout">Вихід</a></p>
<p align="right">Ви - <span><?php echo $_SESSION['admin_role']; ?></span></p>
</div>

</div>

<div id="left-nav">
<ul>
<li><a href="orders.php">Замовлення</a><?php echo $count_str1; ?></li>
<li><a href="tovar.php">Товари</a></li>
<li><a href="category.php">Категорії</a></li>
</ul>
</div>