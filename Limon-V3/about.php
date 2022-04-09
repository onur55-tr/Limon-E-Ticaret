<?php
$pageID = $_GET["id"];
if($pageID) $data = $mth->ins("about","*","WHERE id='".$pageID."'");
else $data = $mth->ins("about","*","ORDER BY title LIMIT 0,1");
?>
<div id="about">
	<div class="links">
		<?php
		$query = mysql_query("SELECT * FROM about ORDER BY title");
		while($link = mysql_fetch_assoc($query)){
		?>
		<a href="sayfa/<?=$link["id"]?>/<?=$mth->seoUrl($link["title"])?>.html" class="link"><?=$link["title"]?></a>
		<?php } ?>
	</div>
	<div class="detail">
		<h1 class="title"><?=$data["title"]?></h1>
		<div class="article"><?=$data["content"]?></div>
	</div>	
	<div class="clear"></div>
</div>
