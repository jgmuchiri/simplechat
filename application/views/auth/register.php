<div class="register form-signin">
	<h2 class="form-signin-heading">Account registration</h2>

	<input id="username" type="text" name="username" class="form-control" placeholder="Username" required autofocus>

	<input id="email" type="email" name="email" class="form-control" placeholder="Email address" required="">

	<input id="pass" type="password" name="password" class="form-control" placeholder="Password" required="">

	<button class="btn btn-lg btn-primary btn-block register" onclick="doRegister()" type="submit">Register</button>

	<div class="spacer"></div>

	<a href="#" onclick="login()">Login</a>
	|
	<a href="#" onclick="forgotPass()">Reset password</a>
</div>

<script>
	function doRegister(){
		var fd = new FormData();

		var username = $('#username').val();
		var email = $('#email').val();
		var pass = $('#pass').val();

		fd.append('username', username);
		fd.append('email', email);
		fd.append('pass',pass);
		// fd.append('card', card_id);
		fd.append('data', event.target.result);
		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('login/doRegister'); ?>',
			data: fd,
			processData: false,
			contentType: false
		}).done(function (data) {
			var json = JSON.parse(data);
			if(json.success==1){
				window.location.reload();
			}
			if(json.error==1){
				msg('danger','Unable to create account!');
			}

		});
	}



</script>