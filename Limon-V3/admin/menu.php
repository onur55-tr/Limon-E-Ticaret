<?php
$module = $_GET["module"];
$comment = mysql_query("SELECT * FROM comments WHERE statu='0'");
?>
<ul>
	<li <? if($module=="" || $module=="main/main") echo 'class="active"'; ?>>
		<a href="index.php">
			<img src="img/icons/button/home.png" width="16" height="16" alt="icon"/>Başlangıç
		</a>
	</li>
	<li <? if(substr($module,0,7)=="orders/") echo 'class="active"'; ?>>
		<a href="index.php?module=orders/list">
			<img src="img/icons/button/shopping-cart2.png" width="16" height="16" alt="icon"/>Siparişler
			<!-- span class="ballon">9</span -->
		</a>
	</li>
	<li <? if(substr($module,0,9)=="products/" || $_GET["top"]=='products') echo 'class="active"'; ?>>
		<a href="index.php?module=products/list">
			<img src="img/icons/button/create.png" width="16" height="16" alt="icon"/>Ürünler
		</a>
	</li>
	<li <? if(substr($module,0,6)=="users/") echo 'class="active"'; ?>>
		<a href="index.php?module=users/list">
			<img src="img/icons/button/user.png" width="16" height="16" alt="icon"/>Üyeler
		</a>
	</li>
	<li <? if(substr($module,0,15)=="checkout_types/") echo 'class="active"'; ?>>
		<a href="index.php?module=checkout_types/list">
			<img src="img/icons/button/money.png" width="16" height="16" alt="icon"/>Ödeme Seçenekleri
		</a>
	</li>
	<li <? if(substr($module,0,5)=="news/") echo 'class="active"'; ?>>
		<a href="index.php?module=news/list">
			<img src="img/icons/button/megaphone.png" width="16" height="16" alt="icon"/>Haberler
		</a>
	</li>
	<li <? if(substr($module,0,16)=="social_networks/") echo 'class="active"'; ?>>
		<a href="index.php?module=social_networks/list">
			<img src="img/icons/button/dribble.png" width="16" height="16" alt="icon"/>Sosyal Ağlar
		</a>
	</li>
	<li <? if(substr($module,0,6)=="about/") echo 'class="active"'; ?>>
		<a href="index.php?module=about/list">
			<img src="img/icons/button/info.png" width="16" height="16" alt="icon"/>Sayfalar
		</a>
	</li>
	<li <? if(substr($module,0,5)=="menu/") echo 'class="active"'; ?>>
		<a href="index.php?module=menu/list">
			<img src="img/icons/button/arrow-right.png" width="16" height="16" alt="icon"/>Menü
		</a>
	</li>
	<!-- li <? if($_GET["gallery"]=='slideshow') echo 'class="active"'; ?>>
		<a href="index.php?module=gallery/gallery&gallery=slideshow">
			<img src="img/icons/button/slide.png" width="16" height="16" alt="icon"/>Slideshow
		</a>
	</li -->
	<li <? if($module=="standart/thumbs") echo 'class="active"'; ?>>
		<a href="index.php?module=standart/thumbs">
			<img src="img/icons/button/alert.png" width="16" height="16" alt="icon" /> Thumbları Güncelle
		</a>
	</li>
</ul>