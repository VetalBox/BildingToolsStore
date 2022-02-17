<?php
	defined('admin23') or die('Доступ запрещен!');
	
?>

<div id="block-header">

	<div id="header-phone">	
	<ul>
		<li><a>+38 097 249 79 46</a></li>
		<li><a>+38 067 294 52 47</a></li>
	</ul>
	</div>

		<h1>Гуртівня Будівельних і господарських товарів</h1>
			</br>
		<h2>від виробника PRUSPOL RX LINE Польща</h2>

	<div id="block-search">
		<form method="GET" action="search.php?q=">
			<span></span>
				<input type="text" id="input-search" name="q" placeholder="Пошук серед 10000 найменувань" value="<?php $search = $search ?? ''; echo $search; ?>" />
				<input type="submit" id="button-search" value="Пошук"/>
		</form>
	</div>

</div>