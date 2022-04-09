<?php
$email = $_POST["email"];
$fPassword = $_POST["password"];
$password = $mth->password($_POST["password"]);
if($email==''){
	$mth->alert('Email alanı boş bırakılamaz !');	
}elseif($fPassword==''){
	$mth->alert('Şifre alanı boş bırakılamaz !');
}else{
	$query = $mth->query("SELECT id,email,password FROM users WHERE email='".$email."' AND password='".$password."'");
	$rows = $mth->rows($query);
	if($rows==1){
		$user = $mth->assoc($query);
		$_SESSION["userID"] = $user["id"];
		$_SESSION["userEmail"] = $user["email"];
		$_SESSION["userPassword"] = $user["password"];
		$mth->parentLocation('index.php');
	}else{
		$mth->alert('Giriş Yapılamadı.');	
	}
}
?>