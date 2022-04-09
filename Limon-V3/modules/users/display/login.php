<head>
	<script type="text/javascript" src="libraries/jquery.js"></script>
	<script type="text/javascript" src="libraries/mth.js"></script>
	<script type="text/javascript" src="modules/users/users.js"></script>
	<link rel="stylesheet" href="modules/users/users.css" media="all" />
</head>

<div id="login">
	<form action="javascript:$.users.login();">
	<div class="title">
		<span>ÜYE GİRİŞİ</span>
	</div>
	<div class="form">
		<div class="line">
			<label for="email">Email Adresiniz</label>
			<input type="text" name="email" id="email" />
		</div>
		<div class="line">
			<label for="password">Şifreniz</label>
			<input type="password" name="password" id="password" />
		</div>
		<div class="line">
			<input type="submit" value="Giriş Yap" />
		</div>
	</div>
	</form>
	<div id="users" class="login_result"></div>
</div>