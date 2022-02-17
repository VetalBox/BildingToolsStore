<?php
defined('admin23') or die('Доступ запрещен!');

mb_internal_encoding("UTF-8");
$db_host        = 'localhost';
$db_user        = 'rxlin108_db_build';
$db_pass        = 'db_build23';
$db_database    = 'rxlin108_db_build';

$link=mysqli_connect($db_host,$db_user,$db_pass, $db_database);

  // Ругаемся, если соединение установить не удалось
 if (!$link) {
echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
exit;
} else {
mysqli_set_charset($link, "utf8");
   
}	
  


?>
