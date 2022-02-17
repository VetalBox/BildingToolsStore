<?php
define('admin23', true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
//include("include/auth_cookie.php");

$cat= clear_string( isset($_GET["cat"])) ?? '';
$type= clear_string( isset($_GET["type"])) ?? '';
$id= clear_string($_GET["id"]);

if(!isset($seoquery))
    $seoquery = '';
$seoquery=mysqli_query($link, "SELECT `seo_words`, `seo_description` FROM `table-products` WHERE `products_id`='$id' AND `visible`='1'");

If (mysqli_num_rows($seoquery)>0){
    $resquery=mysqli_fetch_array($seoquery);
}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=0.5">
 	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <meta name="Description" content="<? echo $resquery["seo_description"];?>" />
    <meta name="keywords" content="<? echo $resquery["seo_words"];?>" />
    
    
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-3.1.1.min"></script>
    <script type="text/javascript" src="/js/ji.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="/js/textchange.js"></script>
    <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox.css" />
    <script type="text/javascript" src="fancyBox/jquery.fancybox.js"></script>
       
    <script type="text/javascript" src="/jTabs/addclasskillclass.js"></script>
    <script type="text/javascript" src="/jTabs/attachevent.js"></script>
    <script type="text/javascript" src="/jTabs/addcss.js"></script>
    <script type="text/javascript" src="/jTabs/tabtastic.js"></script>

 
	<title>Гуртівня Будівельних і господарських товарів</title>
    
		<script type="text/javascript">
			$(document).ready(function(){   
			$(".image-modal").fancybox();
			$(".send-review").fancybox();
			});
		</script>
    
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

				</ul>
			</div>
			
			<div class="header-flex-block">				
				<ul>
					<li><p align="right" id="block-basket"><img src="/images/cart.png"/><a href="cart.php?action=oneclick">Кошик порожній</a></p></li>
				</ul>
			</div>
			
		</div>
		</div>

	<div id="block-right">
		<?php
			include("include/block-category.php");
			//include("include/block-parameter.php");
			include("include/block-contact-right.php");


		?>
	</div>


<div id="block-content">
<?php
	$result1=mysqli_query($link, "SELECT * FROM `table-products` WHERE products_id='$id' AND visible='1'");
    if (mysqli_num_rows($result1) > 0)
        {
        $row1=mysqli_fetch_array($result1);
        
        
        do{
            
            if(strlen($row1["image"])>0 && file_exists("./upload_images/".$row1["image"])){
            $img_path='./upload_images/'.$row1["image"];
            $max_width=300;
            $max_height=300;
            list($width, $height)=getimagesize($img_path);
            $ratioh=$max_height/$height;
            $ratiow=$max_width/$width;
            $ratio=min($ratioh, $ratiow);
            $width=intval($ratio*$width);
            $height=intval($ratio*$height);
            }
            else{
                $img_path="/images/no-images.jpg";
                $width=300;
                $height=300;
            }
            
            
            echo '
            <div id="block-breadcrumbs-and-rating">
				<p id="nav-breadcrumbs" align="left"><a href="index.php">Головна сторінка</a> \ <span>'.$row1["brand"].'</span></p>             
            </div>
            
            <div id="block-content-info">
            <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
            
            <div id="block-mini-description">
            <p id="content-title">'.$row1["title"].'</p>

            <p id="style-price">'.group_numerals($row1["price"]).' грн.</p>
            
            <a class="add-cart" id="add-cart-view" tid="'.$row1["products_id"].'">Купити</a>
            
            </div>
                       
            </div>
            ';
            }
             while($row1=mysqli_fetch_array($result1));
                       
   	$result=mysqli_query($link, "SELECT * FROM `uploads_images` WHERE `products_id`='$id'");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        
        echo '
        <div id="block-img-slide">
        <ul>';
        
        do{
            $img_path='./upload_images/'.$row["image"];
            $max_width=70;
            $max_height=70;
            list($width, $height)=getimagesize($img_path);
            $ratioh=$max_height/$height;
            $ratiow=$max_width/$width;
            $ratio=min($ratioh, $ratiow);
            $width=intval($ratio*$width);
            $height=intval($ratio*$height);
			
			 
            
            echo '
            <li>
            <a class="image-modal" href="#image'.$row["id"].'"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
            </li>
            <a style="display:none;" class="image-modal" rel="group" id="image'.$row["id"].'" ><img src="./upload_images/'.$row["image"].'" /></a>  
            ';
           } 
           while($row=mysqli_fetch_array($result));
           echo '
           </ul>
           </div>
           ';   
              
 }
        $result=mysqli_query($link, "SELECT * FROM `table-products` WHERE products_id='$id' AND visible='1'");
        $row=mysqli_fetch_array($result);
 
 echo '
 
  <div id="pagecontent">

     <h2 class="tabset_label">Таблица содержимого</h2> 
     <ul class="tabset_tabs">
         <li class="firstchild">
             <a href="#tab1" class="preActive active">Описание</a>
         </li>
         <li>
             <a class="preActive postActive" href="#tab2">Характеристики</a>
         </li>
         
     </ul>


     <div id="tab1" class="tabset_content tabset_content_active">
         <h2 class="tabset_label">Вкладка #1</h2>
         <p>'.$row["description"].'</p>
     </div>
    
     <div id="tab2" class="tabset_content">
         <h2 class="tabset_label">Вкладка #2</h2>
         <p>'.$row["features"].'</p>
     </div>
    
 

</div>


 '; 
 }
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