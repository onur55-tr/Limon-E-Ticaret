$.users = {
	
	login: function(){
		var email = $('#login #email').val();
		var password = $('#login #password').val();
		if($.trim(email)==''){
			alert('Email alanını doldurmalısınız !');
		}else if(! $.mth.emailControl(email)){
			alert('Geçersiz email adresi girdiniz !');	
		}else if($.trim(password)==''){
			alert('Parola alanını doldurmalısınız !');	
		}else{
			$.ajax({
				type: 'POST',
				data: 'email='+email+'&password='+password,
				url: 'process.php?dispatch=users.login',
				success: function(ret){
					$('#users.login_result').html(ret);	
				}
			});
		}
	},
	
	logout: function(){
		$.get('process.php?dispatch=users.logout','',function(res){
				$('#users.process').html(res);
			}
		);
	},
	
	register: function(){
		var email = $('#register #email').val();
		var password = $('#register #password').val();
		var password_2 = $('#register #password_2').val();
		var name = $('#register #name').val();
		if($.trim(name)==''){
			alert('Adı Soyadı alanını doldurmalısınız !');
		}else if($.trim(email)==''){
			alert('Email alanını doldurmalısınız !');	
		}else if(! $.mth.emailControl(email)){
			alert('Geçersiz email adresi girdiniz !');	
		}else if(password==''){
			alert('Parola alanını doldurmalısınız !');
		}else if(password_2==''){
			alert('Parola Tekrarı alanını doldurmalısınız !');	
		}else if(password!=password_2){
			alert('Parola ve Parola tekrarı uyuşmuyor !');	
		}else{
			$.ajax({
				type: 'POST',
				data: 'email='+email+'&password='+password+'&password_2='+password_2+'&name='+name,
				url: 'process.php?dispatch=users.register',
				success: function(ret){
					$('#users.register_result').html(ret);	
				}
			});						
		}
	}
	
}