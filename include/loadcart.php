<?php

// обработчик loadcart высвечивания на кнопке корзины крличества товаров и общей суммы
if($_SERVER["REQUEST_METHOD"]=="POST"){
    define('admin23', true);
    include('db_connect.php');
    include('../functions/functions.php');
	$count = isset ($count) ?? '';
	$int = isset ($int) ?? '';

  	$result = mysqli_query($link, "SELECT * FROM `cart`,`table-products` WHERE `cart`.`cart_ip`='{$_SERVER['REMOTE_ADDR']}' AND `table-products`.`products_id`=`cart`.`cart_id_product`");
    If (mysqli_num_rows($result) > 0){
        $row=mysqli_fetch_array($result);
		
        do{

            $count=$count+$row["cart_count"];
            $int=$int+($row["price"] * $row["cart_count"]);
		
		}

        while($row=mysqli_fetch_array($result));
    If($count==1 or $count==21 or $count==31 or $count==41 or $count==51 or $count==61 or $count==71 or $count==81)($str=' товар ');    
    If($count==2 or $count==3 or $count==4 or $count==22 or $count==23 or $count==24 or $count==32 or $count==33 or $count==34 or $count==43 or $count==44 or $count==52 or $count==53 or $count==54 or $count==62 or $count==63 or $count==64 or $count==72 or $count==73 or $count==74 or $count==82 or $count==83 or $count==84)($str=' товару '); 
    If($count==5 or $count==6 or $count==7 or $count==8 or $count==9 or $count==10 or $count==11 or $count==12 or $count==13 or $count==14 or $count==15 or $count==16 or $count==17 or $count==18 or $count==19 or $count==20 or $count==25 or $count==26 or $count==27 or $count==28 or $count==29 or $count==30 or $count==35 or $count==36 or $count==37 or $count==38 or $count==39 or $count==40 or $count==55 or $count==56 or $count==57 or $count==58 or $count==59 or $count==60 or $count==65 or $count==66 or $count==67 or $count==68 or $count==69 or $count==70 or $count==75 or $count==76 or $count==77 or $count==78 or $count==79 or $count==80 or $count==85 or $count==86 or $count==87 or $count==88 or $count==89 or $count==90)($str=' товарів '); 
    
       
    echo '<span>'.$count.$str.'</span>на суму <span>'.group_numerals($int).'</span> грн';
}
else{
    echo '0';
}
}
?>