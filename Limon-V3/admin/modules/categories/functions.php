<?php
/* MTH SINIRSIZ KATEGORİ */
function delete($table,$cond,$unlink=array(),$noMessage=0){
	$un = count($unlink);
	if($un!=0){
		$query = mysql_query("SELECT * FROM $table $cond");
		$d = mysql_fetch_assoc($query);
		for($i=0; $i<$un; $i++){
			if($d[$unlink[$i]]!="") @unlink("../".$d[$unlink[$i]]);
		}
	}
	if(mysql_query("DELETE FROM $table $cond")){
		if($noMessage==0) $this->message('Kayıt Başarıyla Silindi.','succes','div');	
	}else{
		if($noMessage==0) $this->message('Kayıt Silinemedi.','error','div');	
	}
}

function categoryPrefix($table,$category_id){
	global $ret;
	if($category_id!=0){
		$query = "SELECT * FROM $table WHERE id='".$category_id."'";
		$query = mysql_query($query);
		$category = mysql_fetch_assoc($query);
		categoryPrefix($table,$category["parent_id"]);
		$ret = $ret.$category["parent_id"]."/";
	}else{
		$ret = '';	
	}
	return str_replace('0/','',$ret);
}

function categoryDelete($table,$category_id){
	$query = mysql_query("SELECT * FROM $table WHERE parent_id='".$category_id."'");
	if(mysql_num_rows($query)!=0){
		while($category = mysql_fetch_assoc($query)){
			$delete = "DELETE FROM $table WHERE id='".$category["id"]."'";
			$delete = mysql_query($delete);
			$unlink = array('image','thumb');
			delete('products',"WHERE category_id='".$category["id"]."'",$unlink,1);
			categoryDelete($table,$category["id"]);
		}
	}			
}

function subCategoriesSelectbox($table,$category_id,$pre,$selected=0){
	$query = "SELECT * FROM $table WHERE parent_id='".$category_id."'";
	// echo '<option value="">'.$query.'</option>';
	$query = mysql_query($query);
	if(mysql_num_rows($query)!=0){
		while($category = mysql_fetch_assoc($query)){
			if($selected!=0){
				$select = '';
				if($selected==$category["id"]) $select = 'selected="selected"';
			}
			echo '<option value="'.$category["id"].'" '.$select.'>'.str_repeat('- ',$pre).$category["title"].'</option>';
			subCategoriesSelectbox($table,$category["id"],$pre+1,$selected);
		}
	}
}

function subCategoriesTable($table,$category_id,$pre){
	$query = mysql_query("SELECT * FROM $table WHERE parent_id='".$category_id."'");
	if(mysql_num_rows($query)!=0){
		while($category = mysql_fetch_assoc($query)){
			$data = '
				<tr id="data{id}">
                    <td><input id="data{id}" type="checkbox" name="delete[]" value="{id}" /></td> 
					<td>{title}</td>
					<td>{description}</td>
					<td>
						<a class="tips" title="Kaydı Düzenle" href="'.module_link.'/edit&id={id}">
							<img src="img/icons/sidemenu/file_edit.png" alt="" />
						</a>
						<a class="tips" title="Kaydı Sil" href="'.module_link.'/list&deleteID={id}">
							<img src="img/icons/sidemenu/trash.png" alt="" />
						</a>					
					</td>
				</tr>
			';
			$data = str_replace('{title}',str_repeat('+',$pre)." ".$category["title"],$data);
			$data = str_replace('{description}',$category["description"],$data);
			$data = str_replace('{id}',$category["id"],$data);
			echo $data;
			subCategoriesTable($table,$category["id"],$pre+1);
		}
	}
}

function idPathUpdate($table){
	$query = mysql_query("SELECT * FROM $table");
	while($category = mysql_fetch_assoc($query)){
		$id_path = categoryPrefix($category["id"]).$category["id"];
		$update = "UPDATE $table SET id_path='".$id_path."' WHERE id='".$category["id"]."'";
		$update = mysql_query($update);
	}
}

idPathUpdate('categories');
/* MTH SINIRSIZ KATEGORİ */
?>