<head>
	<script type="text/javascript" src="libraries/jquery.js"></script>
	<script type="text/javascript" src="libraries/mth.js"></script>
	<script type="text/javascript" src="modules/users/users.js"></script>
	<link rel="stylesheet" href="modules/users/users.css" />
</head>

<div id="register">
	<form action="" method="post">
	<div class="title">
		<span>Bilgilerimi Düzenle</span>
	</div>
	<?php
	if($_POST){
		$name = $_POST["name"];
		$email = $_POST["email"];
		if($name=="" || $email==""){
			echo '<div class="error">Lütfen boş alan bırakmayınız.</div>';	
		}else{
			$update = "UPDATE users SET name='".$name."', email='".$email."' WHERE id='".$online->id."'";
			$update = mysql_query($update);
			if($update) echo '<div class="success">Bilgileriniz başarıyla güncellendi.</div>';
			else echo '<div class="error">Bilgileriniz güncellenemedi.</div>';
		}
	}
	?>
	<div class="form">
		<div class="line">
			<label for="name">Adınız Soyadınız</label>
			<input type="text" name="name" id="name" value="<?=$online->name?>" />
		</div>
		<div class="line">
			<label for="email">Email Adresiniz</label>
			<input type="text" name="email" id="email" value="<?=$online->email?>" />
		</div>
		<div class="line">
			<input type="submit" value="Bilgileri Düzenle" />
		</div>
	</div>
	</form>
</div>