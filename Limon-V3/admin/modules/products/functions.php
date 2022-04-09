<?php

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
?>