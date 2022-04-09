<?php
class users extends mth {
	function online($data){
		if($data["userID"]=="" || $data["userEmail"]=="" || $data["userPassword"]==""){
			return false;	
		}else{
			$query = $this->query("SELECT id,email,password FROM users WHERE email='".$data["userEmail"]."' AND password='".$data["userPassword"]."'");	
			$rows = $this->rows($query);
			if($rows==1) return true; else return false;
		}
	}
}
?>