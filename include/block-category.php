<?php
	defined('admin23') or die('Доступ запрещен!');
?>
<div id="block-category">
<p class="header-title">Товари</p>

<ul>
<li><a id="index1"><img src="/images/odyg-img.jpg" id="tovar-images"/>Спеціальний одяг</a>
<ul class="category-section">
<li><a href="view_cat.php?type=Спеціальний одяг"><strong>Усі товари</strong></a></li>
<?php
	$result=mysqli_query($link, "SELECT * FROM `category` WHERE type='Спеціальний одяг'");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        do{                     
            echo '
            <li><a href="view_cat.php?cat='.mb_strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
            ';
            
        }
        while($row=mysqli_fetch_array($result));
   } 
?>
</ul>
</li>

<li><a id="index2"><img src="/images/instrument-img.jpg" id="tovar-images"/>Будівельні інструменти</a>
<ul class="category-section">
<li><a href="view_cat.php?type=Будівельні інструменти"><strong>Усі товари</strong></a></li>
<?php
	$result=mysqli_query($link, "SELECT * FROM `category` WHERE type='Будівельні інструменти'");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        do{                     
            echo '
            <li><a href="view_cat.php?cat='.mb_strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
            ';
            
        }
        while($row=mysqli_fetch_array($result));
   } 
?>
</ul>
</li>

<li><a id="index3"><img src="/images/zaxist-img.jpg" id="tovar-images"/>Засоби захисту</a>
<ul class="category-section">
<li><a href="view_cat.php?type=Засоби захисту"><strong>Усі товари</strong></a></li>
<?php
	$result=mysqli_query($link, "SELECT * FROM `category` WHERE type='Засоби захисту'");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        do{                     
            echo '
            <li><a href="view_cat.php?cat='.mb_strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
            ';
            
        }
        while($row=mysqli_fetch_array($result));
   } 
?>
</ul>
</li>

<li><a id="index3"><img src="/images/gospodar-img.jpg" id="tovar-images"/>Господарські товари</a>
<ul class="category-section">
<li><a href="view_cat.php?type=Господарські товари"><strong>Усі товари</strong></a></li>
<?php
	$result=mysqli_query($link, "SELECT * FROM `category` WHERE type='Господарські товари'");
    if (mysqli_num_rows($result) > 0)
        {
        $row=mysqli_fetch_array($result);
        do{                     
            echo '
            <li><a href="view_cat.php?cat='.mb_strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
            ';
            
        }
        while($row=mysqli_fetch_array($result));
   } 
?>
</ul>
</li>

</ul>
</div>