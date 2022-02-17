<?php
	defined('admin23') or die('Доступ запрещен!');
?>

<div id="block-random">

<h2>Ми рекомендуємо:</h2>

<ul>

<?php

$query_random = mysqli_query($link, "SELECT DISTINCT * FROM `table-products` WHERE visible='1' ORDER by RAND() LIMIT 5");
if (mysqli_num_rows($query_random) > 0)
{
    $res_query = mysqli_fetch_array($query_random);


    do
    {

        $query_reviews = mysqli_query($link, "SELECT * FROM `table_reviews` WHERE products_id={$res_query["products_id"]} AND moderat='1'");
        $count_reviews = mysqli_num_rows($query_reviews);

        if (strlen($res_query["image"]) > 0 && file_exists("./upload_images/" . $res_query["image"]))
        {
            $img_path = './upload_images/' . $res_query["image"];
            $max_width = 120;
            $max_height = 150;
            list($width, $height) = getimagesize($img_path);
            $ratioh = $max_height / $height;
            $ratiow = $max_width / $width;
            $ratio = min($ratioh, $ratiow);
            $width = intval($ratio * $width);
            $height = intval($ratio * $height);
        } else
        {
            $img_path = "/images/no-images.jpg";
            $width = 120;
            $height = 150;
        }


        echo '
            <li>
			<div class="cart-tovar-random">
			<div class="block-images-random">
            <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
            </div>
			<a class="style-tittle-random" href="view_content.php?id='.$res_query["products_id"].'" align="center">'.$res_query["title"].'</a>

            <p class="style-price-random" align="center">'.group_numerals($res_query["price"]).'</p>
            <a class="add-cart-style-random" tid="'.$res_query["products_id"].'" >купити</a>
            </div>
			</li>
            
            ';
    } while ($res_query = mysqli_fetch_array($query_random));

}

?>
</ul>
<hr>
</div>

