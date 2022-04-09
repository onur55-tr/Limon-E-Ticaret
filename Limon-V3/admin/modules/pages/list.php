<?php
require("settings.php");
$totals = $mth->in(module_table,'*',$cond); $total = $mth->inRows;
$pager->pager_set(module_link.'/list&no=',$total,10,20,$_GET["no"],'class="active"','Önceki','Sonraki','','','');
?>
<div class="page-title">
	<div class="in">
		<div class="titlebar">
			<h2><?=module_title?></h2>
			<p><?=module_description?></p>
		</div>
			
		<div class="shortcuts-icons">
			<a class="shortcut tips" onclick="javascript:location.reload();" title="Sayfayı Yenile">
				<img src="img/icons/shortcut/refresh.png" width="25" height="25" alt="icon" />
			</a>
			<a class="shortcut tips" href="#" title="<?=module_big_description?>">
				<img src="img/icons/shortcut/question.png" width="25" height="25" alt="icon" />
			</a>
		</div>
		
		<div class="clear"></div>
	</div>
</div>

<div class="content">
	
	<div class="simplebox grid740">
		<div class="titleh">
            <h3><?=module_keyword?> Listesi</h3>
            <div class="shortcuts-icons">
                
            </div>
		</div>
		<form action="" name="list" id="list" method="post">
        <table class="tablesorter list"> 
            <thead> 
                <tr> 
                    <th>Sayfa Başlığı</th> 
                    <th width="10%">İşlemler</th> 
                </tr> 
            </thead> 
            <tbody> 
			<?php
			$query = mysql_query("SELECT * FROM ".module_table." ORDER BY id DESC LIMIT ".$pager->start.", ".$pager->per_page."");
			if(mysql_num_rows($query)==0) echo '<tr><td colspan="5">Henüz İçerik Girilmemiş.</td></tr>';
			while($list = mysql_fetch_assoc($query)){
			?>
                <tr id="data<?=$list["id"]?>"> 
                    <td><?=$list["title"]?></td> 
                    <td>
						<a class="tips" title="Kaydı Düzenle" href="<?=module_link?>/edit&id=<?=$list["id"]?>">
							<img src="img/icons/sidemenu/file_edit.png" alt="" />
						</a>
						<a class="tips" title="Kaydı Sil" href="<?=module_link?>/list&deleteID=<?=$list["id"]?>">
							<img src="img/icons/sidemenu/trash.png" alt="" />
						</a>
					</td> 
                </tr> 
			<?php } ?>
            </tbody> 
        </table>
		</form>
	</div>
	
	<ul class="pagination">
		<?php		
		echo $pager->previous_page;
		echo $pager->page_links;
		echo $pager->next_page;
		?>
	</ul>

</div>