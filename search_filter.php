<?php
define('admin23', true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
//include("include/auth_cookie.php");

// Включение сообщений о всех ошибках
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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


	<title>Гуртівня будівельних і господарських товарів</title> 
</head>

<body>
<div id="block-body">

	<div id="block-header">
		<?php
			include("include/block-header.php");	
		?>
	</div>
	
	 <div id="block-sorting">

		<div class="header-flex-container">
			
			<div class="header-flex-block">				
				<ul>
					<li><img id="style-grid" src="/images/table.png"/></li>
					<li><img id="style-list" src="/images/list.png"/></li>
				</ul>
			</div>
			

			
			<div class="header-flex-block">				
				<ul>
					<li><p align="right" id="block-basket"><img src="/images/cart.png"/><a href="cart.php?action=oneclick">Кошик порожній</a></p></li>
				</ul>
			</div>
			

			
		</div>
		


<p id="nav-breadcrumbs"><a href="index.php">Головна сторінка</a> \ <span>Пошук по параметрам</span></p>
</div>

	<div id="block-right">
		<?php
			include("include/block-category.php");
			include("include/block-parameter.php");
			include("include/block-contact-right.php");
		?>
	</div>

<div id="block-content">


<ul id="block-tovar-grid">
       
<?php
    
    $start_price=(int)$_GET["start_price"];
    $end_price=(int)$_GET["end_price"];
    
    if (!empty($check_brand) OR !empty($end_price)){
        
        if (!empty($check_brand)) $query_brand="AND brand_id IN($check_brand)";
        if (!empty($end_price)) $query_price=" AND price BETWEEN $start_price AND $end_price";
    }


	$result=mysqli_query($link, "SELECT * FROM `table-products` WHERE visible='1' $query_price ORDER BY products_id DESC");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
        // функция по подгонке изображения на главной странице
        do{
            
            if($row["image"] !=""&& file_exists("./upload_images/".$row["image"])){
            $img_path='./upload_images/'.$row["image"];
            $max_width=150;
            $max_height=150;
            list($width, $height)=getimagesize($img_path);
            $ratioh=$max_height/$height;
            $ratiow=$max_width/$width;
            $ratio=min($ratioh, $ratiow);
            $width=intval($ratio*$width);
            $height=intval($ratio*$height);
            }
            else{
                $img_path="/images/no-images.jpg";
                $width=150;
                $height=150;
            }        
        //______________________________________________________________
        

          //---------------------------------------------    
                       
            echo '
				<li>

					<div class="cart-tovar-grid">
						<div class="block-images-grid">
							<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
						</div>	
							</br>            
						<p class="style-tittle-grid" ><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
							</br>
						<p class="style-price-grid" ><strong>'.group_numerals($row["price"]).'</strong> грн.</p>
							</br>
						<a class="add-cart-style-grid" tid="'.$row["products_id"].'">купити</a>
			
					</div>
					
				</li>
            ';
            
        }
        while($row=mysqli_fetch_array($result));
    }

?>
</ul>

<!--конец табличного вывода товаров*/-->

<!--списочный вывод товара-->

<ul id="block-tovar-list">
<?php
	$result=mysqli_query($link, "SELECT * FROM `table-products` WHERE visible='1' $query_price ORDER BY products_id DESC");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
        
        do{
            // функция по подгонке изображения на главной странице
            if ($row["image"] !=""&& file_exists("./upload_images/".$row["image"])){
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
                $img_path="/images/no-images.jpg";
                $width=100;
                $height=100;
            }        
        //-------------------------------------  

                       
            echo '
                        <li>

					<div class="cart-tovar-list">
						<div class="flex-tovar-list">
						<div class="block-images-list">
							<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
						</div>
						</div>

						<div class="flex-tovar-list">
						          
						<p class="style-tittle-list" ><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>


						</div>
						
						<div class="flex-tovar-list">

						<p class="style-price-list" ><strong>'.group_numerals($row["price"]).'</strong> грн.</p>

						</div>
						
						<div class="flex-tovar-list">

						<a class="add-cart-style-list" tid="'.$row["products_id"].'">купити</a>
						
						</div>
					</div>
					
				</li>
				</br>
            ';
            
        }
        while($row=mysqli_fetch_array($result));
    }
    echo '</ul>';

    

    
   
?>

<!--конец списочного вывода товаров-->
</div>


<div id="block-random">
	<?php
		include("include/block-random.php");
	?>
</div>

<div id="block-footer">
	<?php
		include("include/block-footer.php");	
	?>
</div>
</div>


</body>
</html>