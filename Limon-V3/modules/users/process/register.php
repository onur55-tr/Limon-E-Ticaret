<?php
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$password_2 = $_POST["password_2"];
$register_date = date("Y-m-d");

if($name=='') $mth->alert('Ad Soyad alanını doldurmalısınız.');
else if($email=='') $mth->alert('Email alanını doldurmalısınız.');
else if($password=='') $mth->alert('Şifre alanını doldurmalısnız.');
else if($password_2=='') $mth->alert('Şifre Tekrarı alanını doldurmalısınız.');
else{
	$password = $mth->password($password);
	$query = $mth->query("SELECT * FROM users WHERE email='".$email."'");
	$rows = $mth->rows($query);
	if($rows!=0){
		$mth->alert('Bu email adresi sistemde kayıtlıdır.');	
	}else{
		$insert = mysql_query("
			INSERT INTO users
			(name,email,password,register_date) VALUES
			('".$name."','".$email."','".$password."','".$register_date."')
		");
		if($insert){
			$user = $mth->ins("users","*","WHERE id='".mysql_insert_id()."'");
			$_SESSION["userID"] = $user["id"];
			$_SESSION["userEmail"] = $user["email"];
			$_SESSION["userPassword"] = $user["password"];

			include("libraries/mailer/class.phpmailer.php"); $mailer = new PHPMailer;
			include("libraries/mailer/phpmailer.lang-tr.php");
			$url = $site->link.'display.php?dispatch=users.register_mail&id='.$user["id"];

			$mailData = $mth->connectFile($url);
			$mailer->IsSMTP();
			$mailer->SMTPDebug  = 1;  
			$mailer->SMTPAuth   = true;                 
			$mailer->Host       = $site->mail_host; 
			$mailer->Username   = $site->mail_username; 
			$mailer->Password   = $site->mail_password;  
			$mailer->SetFrom(mailUser, $site->title.' - Üyelik Bilgisi');
			$mailer->AddReplyTo(mailUser, $site->title.' - Üyelik Bilgisi');	
						
			$mailer->AddAddress($email, $name);
			
			$mailer->AddAddress($site->email, $site->title);		
			
			$mailer->Subject    = $site->title." | Üyelik Bilgisi";
			$mailer->MsgHTML($mailData);

			if($mailer->Send()){
				$mth->alert('Kaydınız başarıyla tamamlandı.');	
			}else{
				$mth->alert('Kaydınız başarıyla tamamlandı. Mail gönderilemedi.');					
			}
			$mth->parentLocation('index.php');
		}else{
			$mth->alert('Kaydınız belirlenemeyen bir sorundan ötürü tamamlanamadı. Lütfen daha sonra tekrar deneyiniz.');	
		}
	}
}
?>