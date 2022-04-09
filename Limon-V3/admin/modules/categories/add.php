<?php
include("settings.php");
require("functions.php");
$mth->editor();
$data = $_REQUEST;
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
	<?php
	if($_POST){
		$title = $_POST["title"];
		$description = $_POST["description"];
		$parent_id = $_POST["parent_id"];
		
		$insert = mysql_query("
			INSERT INTO ".module_table." 
			(parent_id,title,description) VALUES 
			('".$parent_id."','".$title."','".$description."')");
		if($insert){
			$insertID = mysql_insert_id();
			$id_path_prefix = categoryPrefix(module_table,$insertID);
			$id_path = $id_path_prefix.$insertID;
			$id_path_add = mysql_query("UPDATE ".module_table." SET id_path='".$id_path."' WHERE id='".$insertID."'");
			if($id_path_add){
				echo '<div class="albox succesbox">Kategori başarıyla oluştu.</div>';
				unset($data);
			}else{
				echo '<div class="albox errorbox">Kayıt Eklenemedi.</div>';	
			}
		}
	}
	?>
	<div class="simplebox grid740">
		<div class="titleh">
			<h3><?=module_keyword?> İşlemleri</h3>
		</div>
		<div class="body">		
			<form method="post" action="" enctype="multipart/form-data">		  
				<div class="st-form-line">	
					<span class="st-labeltext">Başlık</span>	
					<select class="uniform" name="parent_id" style="width: 225px;">
						<option value="0">Üst Kategori</option>
						<?php
						$query = mysql_query("SELECT * FROM ".module_table." WHERE parent_id='0' ORDER BY title");
						while($cat = mysql_fetch_assoc($query)){
						?>
							<option value="<?=$cat["id"]?>"><strong><?=$cat["title"]?></strong></option>
							<?php subCategoriesSelectbox(module_table,$cat["id"],1); ?>
						<?php } ?>
					</select>				
					<div class="clear"></div>
				</div>
				<div class="st-form-line">	
					<span class="st-labeltext">Başlık</span>	
					<input name="title" type="text" class="st-forminput" style="width: 210px;" value="<?=$data["title"]?>" /> 
					<div class="clear"></div>
				</div>
				<div class="st-form-line">	
					<span class="st-labeltext">Açıklama</span>	
					<input name="description" type="text" class="st-forminput" style="width: 510px;" value="<?=$data["description"]?>" /> 
					<div class="clear"></div>
				</div>
				<input type="hidden" name="date" value="<?=date("Y-m-d");?>" />
				<input type="submit" style="margin-right: 0; border-radius: 0; width: 100%; cursor: pointer;" value="Formu Kaydet" class="st-button" />
			</form>
		</div>
	</div>
</div>