<?php
define('admin23', true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
//include("include/auth_cookie.php");

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);


error_reporting(E_ALL & ~E_NOTICE);

//$id = $id ?? '';
    $id = clear_string($_GET["id"]);


$action= clear_string($_GET["action"]);
$all_price = isset ($all_price);

switch ($action){
    
    case 'clear':
    $clear=mysqli_query($link, "DELETE FROM `cart` WHERE `cart_ip` ='{$_SERVER['REMOTE_ADDR']}'");
	header("Location: index.php");
    break;
    
    case 'delete':
    $delete=mysqli_query($link, "DELETE FROM `cart` WHERE `cart_id`='$id' AND `cart_ip` ='{$_SERVER['REMOTE_ADDR']}'");
    break;
}

if (isset($_POST["submitdata"])){
    
    if ($_SESSION['auth']!='yes_auth'){
		
        
        mysqli_query($link, "INSERT INTO `orders`(`order_id`,`order_datetime`,`order_confirmed`,`order_dostavka`,`order_pay`,`order_fio`,`order_address`,`order_phone`,`order_note`,`order_email`)
            VALUES(
			
			NULL,
            NOW(),
				'',
                '".$_POST["order_delivery"]."',
				'accepted',
                '".$_POST['order_fio']."',
				'".$_POST['order_city'].' '.$_POST['warehous']."',
               
                '".$_POST['order_phone']."',
                '".$_POST['order_note']."',
                '".$_POST['order_email']."'
                )");
                
						$_SESSION["order_delivery"]=$_POST["order_delivery"];
                        $_SESSION["order_fio"]=$_POST["order_fio"];
                        $_SESSION["order_email"]=$_POST["order_email"];
                        $_SESSION["order_phone"]=$_POST["order_phone"];
                        $_SESSION["warehous"]=$_POST["warehous"]; $_SESSION["order_city"]=$_POST["order_city"];
                        $_SESSION["order_note"]=$_POST["order_note"];
						
						
				
				
				}
				   
									$_SESSION["order_id"]=mysqli_insert_id($link);
									
									
    
$result=mysqli_query($link, "SELECT * FROM `cart` WHERE `cart_ip` ='{$_SERVER['REMOTE_ADDR']}'");
    If (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
           do{
            
               mysqli_query($link, "INSERT INTO `buy_products`(`buy_id_order`,`buy_id_product`,`buy_count_product`)
            VALUES(
           
                '".$_SESSION['order_id']."',
                '".$row["cart_id_product"]."',
                '".$row["cart_count"]."'
                )"); 
            }
            while($row=mysqli_fetch_array($result));
            }
   
    header("Location: cart.php?action=completion");
	
}

$result=mysqli_query($link, "SELECT * FROM `cart`,`table-products` WHERE `cart`.`cart_ip` ='{$_SERVER['REMOTE_ADDR']}' AND `table-products`.`products_id`=`cart`.`cart_id_product`");
    If (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
           do{
            $int=$row["cart_price"]*$row["cart_count"];
            }
            while($row=mysqli_fetch_array($result));
         $itogpricecart=$int;
		 
		 
     }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=0.5">
 	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-3.1.1.min"></script>
    <script type="text/javascript" src="/js/ji.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="/js/textchange.js"></script>
    <script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
    
	<title>Кошик замовлень</title> 
</head>

<body>
<div id="block-body">

	<div id="block-header">
		<?php
			include("include/block-header.php");	
		?>
	</div>

<p id="nav-breadcrumbs-cart"><a href="index.php">Головна сторінка</a> \ <span>Кошик товарів</span></p>

<div id="block-content-cart">

<?php
$action=clear_string($_GET["action"]);

switch($action){
    
case 'oneclick';
    
    echo '
    <div id="block-step">
    <div id="name-step">
    <ul>
    <li><a class="active">1. Кошик товарів</a></li>
    <li><span>&rarr;</span></li>
    <li><a>2. Контактна інформація</a></li>
    <li><span>&rarr;</span></li>
    <li><a>3. Завершення</a></li> 
    </ul>
    </div>
	</br>
	</br>
    <p>Крок 1 із 3</p>
	</br>
	</br>
    <a href="cart.php?action=clear">Очистити</a>
	</br>
	</br>
    </div>
		<div class="table-cart">
		<table>
    ';
	
      
    	$result=mysqli_query($link, "SELECT * FROM `cart`,`table-products` WHERE `cart`.`cart_ip` ='{$_SERVER['REMOTE_ADDR']}' AND `table-products`.`products_id`=`cart`.`cart_id_product`");
    If (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
    echo '
	 
   <tr>
    <td>Зображення</td>
    <td>Найменування</td>
	<td>Кількість</td>
	<td>Ціна</td>
   </tr>
   

    ';

        do{
            $int=$row["cart_price"]*$row["cart_count"];

            $all_price=$all_price+$int;
            
            if(strlen($row["image"])>0 && file_exists("./upload_images/".$row["image"])){
                $img_path='./upload_images/'.$row["image"];
                $max_width=100;
                $max_height=100;
                list($width, $height)=getimagesize($img_path);
                $ratioh=$max_height/$height;
                $ratiow=$max_width/$width;
                $ratio=min($ratioh, $ratiow);
                
                $width=intval($ratio*$width);
                $height=intval($ratio*$height);
            }
            else{
                $img_path="/images/noimages.png";
                $width=120;
                $height=105;
            }
            
            echo '
			<tr>
    <div class="block-list-cart">


    <td><div class="img-cart"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></div></td>


    <td><div class="title-carts"><p>'.$row["title"].'</p><div></td>

   
    
    <div class="count-cart">
	<td>
  <ul class="input-count-style">
    
    <li>
    <p align="center" iid="'.$row["cart_id"].'" class="count-minus"><img src="images/cart_minus.png"/></p>
    </li>
    
    <li>
    <p align="center"><input id="input-id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'"></p>
    </li>
    
    <li>
    <p align="center" iid="'.$row["cart_id"].'" class="count-plus"><img src="images/cart_plus.png"/></p>
    </li>
    
    </ul>
		</td>
    </div>
    
   <td> <div id="tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.group_numerals($int).' грн</p></div></td>
    <td><div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="/images/delete.png"/></a></div></td>
    
    
    </div>
	
    ';
     }
            while($row=mysqli_fetch_array($result));
            echo '
			</tr>
	</table>
	</div> 
		</br>
            <h2 class="itog-price" align="right">Всього: <strong>'.group_numerals($all_price).'</strong> грн.</h2>
			</br>
            <p align="center" class="button-next"><a href="cart.php?action=confirm">далі</a></p>
			</br>
            ';
     }
     else{
        echo '<h3 id="clear-cart" align="center">Кошик пустий</h3>';
		
		
     }
    break;


  
case 'confirm';
    echo '
 <div id="block-step">
    <div id="name-step">
    <ul>
    <li><a class="active">1. Кошик товарів</a></li>
    <li><span>&rarr;</span></li>
    <li><a>2. Контактна інформація</a></li>
    <li><span>&rarr;</span></li>
    <li><a>3. Завершення</a></li> 
    </ul>
    </div>
	</br>
	</br>
    <p>Крок 2 із 3</p>
	</br>
	</br>
    <!--<a href="cart.php?action=clear">Очистити</a>-->
	</br>
	</br>
    </div> 
    ';
	
	
	$action_posta=clear_string($_GET["action_posta"]);

			switch($action_posta){
    
				case 'nova_posta';
				
									if ($_SESSION['order_delivery']=="Нова пошта") $chck4="checked";
    
										echo '
											<h3 class="title-h3-dost">Способи доставки</h3>
												<form method="post">
													<ul id="info-radio">

														<li>
															<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery4" value="Нова пошта"'.$chck4.'/>
															<label class="label_delivery" for="order_delivery4">Нова пошта</label>
														</li>

													</ul> 
    
											<h3 class="title-h3-dost">Інформація для доставки</h3>
		
									<ul id="info-order">
										';
									if($_SESSION['auth']!='yes_auth'){
										echo '
										<li><input type="text" name="order_fio" placeholder="Іванов Іван Іванович" id="order_fio"  value="'.$_SESSION["order_fio"].'" /><span class="order_span_style">*ФІО</span></li>
										<li><input type="text" name="order_email" placeholder="ivanov@gmail.com" id="order_email" value="'.$_SESSION["order_email"].'" /><span class="order_span_style">*Email</span></li>
										<li><input type="text" name="order_phone" placeholder="+38 097 249 79 46" id="order_phone" value="'.$_SESSION["order_phone"].'" /><span class="order_span_style">Телефон</span></li>
										<li><input type="text" name="order_city" placeholder="Київ" id="order_city" value="'.$_SESSION["order_city"].'" /><span class="order_span_style">Населенний пункт</span></li>
										
										
										<!--Подключение Новой почты-->
										</br>
										<h3 id="select_otdelen">Вибір почтового відділення</h3>
										</br>
											<span id="nas_punkt">Виберіть із списку населенний пункт</span></li>
											</br>
											<li><select id="cities" action="" name="city"><option></option></select></li>
											</br>
											<span id="nas_punkt">Виберіть із списку номер відділення</span>
											</br>											
											<li><select id="warehouses" name="warehous"><option></option></select></li>
											</br>
										';        

										

									echo '
										<li><textarea name="order_note" id="order_prim">'.$_SESSION["order_note"].'</textarea><span>Примітка</span></li>
										</ul>
										</br>
										 <!--<p align="center" class="button-next"><a href="cart.php?action=completion">Далі</a></p>-->
										<p align="center"><input type="submit" name="submitdata" id="confirm-button-next" value="Продовжити замовлення"/></p>
										</br>
										</br>
										</br>
										</form>
									';
    							
									}								
						 break;
						
				case 'all_posta';
    
									if ($_SESSION['order_delivery']=="По почте") $chck1="checked";
									if ($_SESSION['order_delivery']=="Курьером") $chck2="checked";
									if ($_SESSION['order_delivery']=="Самовывоз") $chck3="checked";
    
										echo '
											<h3 class="title-h3-dost">Способи доставки</h3>
												<form method="post">
													<ul id="info-radio">

														<li>
															<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="Поштою"'.$chck1.'/>
															<label class="label_delivery" for="order_delivery1">Поштою</label>
														</li>
														
														<li>
															<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Кур`єром"'.$chck2.'/>
															<label class="label_delivery" for="order_delivery2">Кур`єром</label>
														</li>
														
														<li>
															<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовивіз"'.$chck3.'/>
															<label class="label_delivery" for="order_delivery3">Самовивіз</label>
														</li>

													</ul> 
    
											<h3 class="title-h3-dost">Інформація для доставки</h3>
		
									<ul id="info-order">
										';
									if($_SESSION['auth']!='yes_auth'){
										echo '
										<li><input type="text" name="order_fio" placeholder="Іванов Іван Іванович" id="order_fio"  value="'.$_SESSION["order_fio"].'" /><span class="order_span_style">*ФІО</span></li>
										<li><input type="text" name="order_email" placeholder="ivanov@gmail.com" id="order_email" value="'.$_SESSION["order_email"].'" /><span class="order_span_style">*Email</span></li>
										<li><input type="text" name="order_phone" placeholder="+38 097 249 79 46" id="order_phone" value="'.$_SESSION["order_phone"].'" /><span class="order_span_style">Телефон</span></li>
										<li><input type="text" name="order_city" placeholder="м. Львів, вул. Прокоповича, 2" id="order_city" value="'.$_SESSION["order_city"].'" /><span>Адреса доставки</span></li>
										';        
									}
									echo '
										<li><textarea name="order_note" id="order_prim">'.$_SESSION["order_note"].'</textarea><span>Примітка</span></li>
										</ul>
										</br>
										<p align="center"><input type="submit" name="submitdata" id="confirm-button-next" value="Продовжити замовлення"/></p>
										</br>
										</br>
										</br>
										</form>
									'; 
						 break;
						 
						 default:
									echo'
									<h3 id="sposib_dost">Виберіть спосiб доставки<h3>
									</br>
									<p align="center" class="button-next_one"><a href="cart.php?action=confirm&action_posta=nova_posta"><img src="images/nova.png"> Нова пошта</a></p>
									</br>
									</br>
									</br>
									<p align="center" class="button-next_two"><a href="cart.php?action=confirm&action_posta=all_posta">Інші способи</a></p>
									</br>
									</br>
									</br>
									</br>
									</br>
									</br>
									</br>
									</br>
									</br>
									';						 
						 break;
						 	
			};
		
    break;
    
    case 'completion';
    echo '
    <div id="block-step">
    <div id="name-step">
    <ul>
    <li><a href="cart.php?action=oneclick">1. Кошик товарів</a></li>
    <li><span>&rarr;</span></li>
    <li><a href="cart.php?action=confirm">2. Контактна інформація</a></li>
    <li><span>&rarr;</span></li>
    <li><a class="active">3. Завершення</a></li> 
    </ul>
    </div>
    <p>Крок 1 із 3</p>
    </div>
    <h3 id="kon">Кінцева інформація:</h3>  
    ';
	

if($_SESSION['auth']!='yes_auth'){
        echo '
        <ul id="list-info">
        <li><strong>Способ доставки:</strong>'.$_SESSION['order_delivery'].'</li>
        <li><strong>Email:</strong>'.$_SESSION['order_email'].'</li>
        <li><strong>ФІО:</strong>'.$_SESSION['order_fio'].' </li>
        <li><strong>Адреса доставки:</strong>'.$_SESSION['order_city'].','.$_SESSION['warehous'].'</li>
        <li><strong>Телефон:</strong>'.$_SESSION['order_phone'].'</li>
        <li><strong>Примітка:</strong>'.$_SESSION['order_note'].'</li>

        </ul>
        ';

        }
        else{
/* 		echo '
        <ul id="list-info">
        <li><strong>Способ доставки:</strong>'.$_SESSION['order_delivery'].'</li>
        <li><strong>Email:</strong>'.$_SESSION['order_email'].'</li>
        <li><strong>ФІО:</strong>'.$_SESSION['order_fio'].'</li>
        <li><strong>Адреса доставки:</strong>'.$_SESSION['order_address'].'</li>
        <li><strong>Телефон:</strong>'.$_SESSION['order_phone'].'</li>
        <li><strong>Примітка:</strong>'.$_SESSION['order_note'].'</li>
        </ul>
        ';
*/		
        }
        echo '

		<!--<h2 class="itog-price" align="right">Всього: <strong>'.group_numerals($all_price).'</strong> грн.</h2>-->
		</br>
		</br>
		<!--<p align="center"><input type="submit" name="submitdata" id="confirm-button-next" value="Замовити"/></p>-->
		<p align="center" class="button-next"><a href="index.php">Замовити</a></p>
		</br>
		</br>
		</br>
        ';
        
    break;
    
    default:
    echo '
     <div id="block-step">
    <div id="name-step">
    <ul>
    <li><a class="active">1. Кошик товарів</a></li>
    <li><span>&rarr;</span></li>
    <li><a>2. Контактна інформація</a></li>
    <li><span>&rarr;</span></li>
    <li><a>3. Завершення</a></li> 
    </ul>
    </div>
	</br>
	</br>
    <p>Крок 1 із 3</p>
	</br>
	</br>
    <a href="cart.php?action=clear">Очистити</a>
	</br>
	</br>
    </div>
		<div class="table-cart">
		<table>
    ';

    
    	$result=mysqli_query($link, "SELECT * FROM `cart`,`table-products` WHERE `cart`.`cart_ip` ='{$_SERVER['REMOTE_ADDR']}' AND `table-products`.`products_id`=`cart`.`cart_id_product`");
        If (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
    echo '
	 
   <tr>
    <td>Зображення</td>
    <td>Найменування</td>
	<td>Кількість</td>
	<td>Ціна</td>
   </tr>
   

    ';
        
        do{
            $int=$row["cart_price"]*$row["cart_count"];
            $all_price=$all_price+$int;
            
            if(strlen($row["image"])>0 && file_exists("./upload_images/".$row["image"])){
                $img_path='./upload_images/'.$row["image"];
                $max_width=100;
                $max_height=100;
                list($width, $height)=getimagesize($img_path);
                $ratioh=$max_height/$height;
                $ratiow=$max_width/$width;
                $ratio=min($ratioh, $ratiow);
                
                $width=intval($ratio*$width);
                $height=intval($ratio*$height);
            }
            else{
                $img_path="/images/noimages.png";
                $width=120;
                $height=105;
            }
            
            echo '
			<tr>
    <div class="block-list-cart">


    <td><div class="img-cart"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></div></td>


    <td><div class="title-carts"><a href="">'.$row["title"].'</a><div></td>

   
    
    <div class="count-cart">
	<td>
  <ul class="input-count-style">
    
    <li>
    <p align="center" iid="'.$row["cart_id"].'" class="count-minus">-</p>
    </li>
    
    <li>
    <p align="center"><input id="input-id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'"></p>
    </li>
    
    <li>
    <p align="center" iid="'.$row["cart_id"].'" class="count-plus">+</p>
    </li>
    
    </ul>
		</td>
    </div>
    
   <td> <div id="tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.group_numerals($int).' грн</p></div></td>
    <td><div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="/images/delete.png"/></a></div></td>
    
    
    </div>
	
    ';
     }
            while($row=mysqli_fetch_array($result));
            echo '
			</tr>
	</table>
	</div> 
		</br>
            <h2 class="itog-price" align="right">Всього: <strong>'.group_numerals($all_price).'</strong> грн.</h2>
			</br>
            <p align="center" class="button-next"><a href="cart.php?action=confirm">Далі</a></p>
			</br>
            ';
     }
     else{
        echo '<h3 id="clear-cart" align="center">Кошик пустий</h3>';
     }
    break;   
}		
?>
</div>

<div id="block-footer">
<?php
include("include/block-footer.php");	
?>
</div>
</div>

									
			<script type="text/javascript">
						// load cities
					$("#cities").load( "file.php" );

					// get warehouses
					$('#cities').change(function(){
					var wh = $(this).val();

					$.ajax({
				url : 'file.php',
						type : 'POST',
						data : {
					'warehouses' : wh,
							},
						success : function(data) {
			$('#warehouses').html(data);
							},
			error : function(request,error)
				{
				$('#warehouses').html('<option>-</option>');
					}
				});
			})
			</script>
			

																
																

</body>
</html>