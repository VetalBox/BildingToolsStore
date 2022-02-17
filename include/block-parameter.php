<?php
	defined('admin23') or die('Доступ запрещен!');
?>

<div id="block-parameter">

	<p class="header-title">Пошук по параметрам</p>

	<p class="title-filter">Вартість</p>

		<form method="GET" action="search_filter.php">

			<div id="block-input-price">
				<ul>
					<li><p>від</p></li>
					<li><input type="text" id="start-price" name="start_price" value="0"/></li>
					<li><p>до</p></li>
					<li><input type="text" id="end-price" name="end_price" value="5000"/></li>
					<li><p>грн</p></li>
				</ul>
			</div>

		<center><input type="submit" name="submit" id="button-param-search" value="Пошук"/></center>

		</form>

</div>







