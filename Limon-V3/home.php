<div id="slideshow">
	<ul>
		<li class="slider1">
			<span class="slider-text" data-unislider-settings='{ "left" : 40, "top" : "50", "width" : "960"}'>Hoşgeldiniz...</span>
			<span class="slider-text" data-unislider-settings='{ "left" : 40, "top" : "90", "width" : "960"}'>ÜRÜN TANITIM SCRİPTİ V3</span>
			<span class="slider-text" style="font-size: 40px;" data-unislider-settings='{ "left" : 40, "top" : "120", "width" : "960"}'>YAYINDA..</span>
		</li>
		<li class="slider2">
			<span class="slider-text" style="font-size: 40px; background: #FFF; border-radius: 5px; padding: 4px; color: #333;" data-unislider-settings='{ "left" : 40, "top" : "40"}'>PHP & Mysql ile kodlandı...</span>
			<span class="slider-text" style="font-size: 30px; background: #FFF; border-radius: 5px; padding: 4px; color: #333;" data-unislider-settings='{ "left" : 40, "top" : "100"}'>jQuery ile güzelleştirildi...</span>
			<span class="slider-text" style="font-size: 30px; background: #FFF; border-radius: 5px; padding: 4px; color: #333;" data-unislider-settings='{ "left" : 40, "top" : "150"}'>Sade ve kullanışlı tasarımı ile satışa sunuldu...</span>
		</li>
		<li class="slider3">
			<span class="slider-text" data-unislider-settings='{ "right" : 20, "top" : "50", "width" : "940"}'>Bu yazılıma sponsor olanlar ise;</span>
			<img src="style/images/slider/sponsor2.png" alt="" data-unislider-settings='{ "right" : 860, "top" : "100"}' />
			<img src="style/images/slider/sponsor1.png" alt="" data-unislider-settings='{ "right" : 620, "top" : "100"}' />
			<img src="style/images/slider/sponsor3.png" alt="" data-unislider-settings='{ "right" : 420, "top" : "100"}' />
			<span class="slider-text" data-unislider-settings='{ "right" : 20, "top" : "220", "width" : "940"}'>Ve Dönerci Yakup Usta'ya...</span>
			<span class="slider-text" data-unislider-settings='{ "right" : 20, "top" : "260", "width" : "940"}'>Teşekkürlerimi bir borç bilirim... :)</span>
		</li>
	</ul>
</div>
<div id="newsBar">
	<h2>Duyurular : </h2>
	<div class="news">
		<?php
		$query = mysql_query("SELECT * FROM news ORDER BY id DESC");
		while($new = mysql_fetch_assoc($query)){
		?>
		<div class="new" style="width: 720px;"><?=$new["title"]?> - <?=$new["description"]?></div>
		<?php } ?>
	</div>
	<div class="socaials">
		<?php
		$query = mysql_query("SELECT * FROM social_networks ORDER BY title ASC");
		while($social = mysql_fetch_assoc($query)){
		?>
		<a target="_blank" href="<?=$social["link"]?>"><img src="<?=$social["image"]?>" height="26" alt="" /></a>
		<?php } ?>
	</div>
	<div class="clear"></div>
</div>
<div id="products">
	<?php
	$i = 0;
	$query = mysql_query("SELECT * FROM products ORDER BY id DESC");
	while($product = mysql_fetch_assoc($query)){ $i++; 
	?>
	<div class="product product<?=$i?>">
		<div class="img">
			<a href="urun/<?=$product["id"]?>/<?=$mth->seoUrl($product["title"])?>.html" style="display: block; text-align:center">
				<img src="<?=$product["thumb"]?>" alt="<?=$product["title"]?>" height="400" style="margin: 0 auto;" />
				<div class="clear"></div>
			</a>
		</div>
		<a class="title" href="urun/<?=$product["id"]?>/<?=$mth->seoUrl($product["title"])?>.html"><?=$product["title"]?></a>
		<span class="desc"><?=$product["description"]?></span>
		<div class="bottom">
			<div class="price">
				<?=$product["price"]?> TL
			</div>
			<div class="buttons">
				<a onclick="$.orders.add_to_cart(<?=$product["id"]?>);" class="button green">Sepete At</a>
				<a href="urun/<?=$product["id"]?>/<?=$mth->seoUrl($product["title"])?>.html" class="button black">İncele</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php if($i==3){$i=0;} } ?>
	<div class="clear"></div>
</div>