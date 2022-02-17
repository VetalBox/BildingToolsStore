<?php
error_reporting(E_ALL & ~E_NOTICE);

 session_start();

require_once('src/Delivery/NovaPoshtaApi2.php');
require_once('src/Delivery/NovaPoshtaApi2Areas.php');

$np = new \LisDev\Delivery\NovaPoshtaApi2(
    '46e43797a5c84a4ef140cce7d5af148b',
    'ru', // Язык возвращаемых данных: ru (default) | ua | en
    FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
    'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
);

 
 
if($_POST['warehouses']) {
	
	
    $wh = $np->getWarehouses($_POST['warehouses']);
	
    
	
	foreach ($wh['data'] as $warehouse) {
		
        echo '<option value="'.$warehouse['DescriptionRu'].'">'.$warehouse['DescriptionRu'].'</option>';
    }
	
				


} else {
    $cities = $np->getCities();
	
		
	
    foreach ($cities['data'] as $city) {
        echo '<option value="'.$city['Ref'].'">'.$city['DescriptionRu'].'</option>';
		

    }
	//$_SESSION['city_city'] = $city$city['DescriptionRu'];

}

?>
