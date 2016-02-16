<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

	<title>SimplyChat</title>

	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


	<!-- Custom styles for this template -->
	<link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet">


	<style type="text/css" id="holderjs-style"></style>

	<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
</head>

<body>

<div class="wrapper"><!--container-->
	<div class="row">
		<div class="col-lg-12">
			<img class="pull-left" src="<?php echo base_url(); ?>assets/images/logo.png"/>
			<h4 style="font-family: monospace">SimplyChat</h4>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<?php if($this->set->is_login()): ?>
						<button class="btn btn-info" onclick="openChat()">
							<span class="fa fa-home"></span>
						</button>
						<button class="btn btn-info" onclick="openSettings()">
							<span class="fa fa-wrench"></span>
						</button>
						<button class="btn btn-info" onclick="openUsers()">
							<span class="fa fa-group"></span>
						</button>
						<button style="float: right" class="btn btn-danger" onclick="logout()">
							<span class="glyphicon glyphicon-log-out"></span>
						</button>
					<?php endif; ?>
				</div>
				<div class="panel-body">
					<?php echo $this->session->flashdata('message'); ?>
					<div class="msg"></div>
					<div class="chat"></div>


				</div>

			</div>
		</div>
	</div>

	<script>

		//div to load pages
		var myDiv = '.chat';

		//what to load initially
		<?php if($this->set->is_login()==true): ?>
		window.onload = landing();
		<?php else: ?>
		window.onload = login();
		<?php endif; ?>

		function landing(){
			$(myDiv).load("<?php echo site_url('chat/landing'); ?>");
		}
		//chatbox
		function openChat() {
			$(myDiv).load("<?php echo site_url('chat/chatBox'); ?>");
		}

		//chat settings
		function openSettings() {
			$(myDiv).load("<?php echo site_url('chat/settings'); ?>");
		}

		//users i chat with
		function openUsers() {
			$(myDiv).load("<?php echo site_url('users'); ?>");
		}

		//login
		function login() {
			$(myDiv).load("<?php echo site_url('login'); ?>");
		}

		//register
		function register() {
			$(myDiv).load("<?php echo site_url('login/register'); ?>");
		}

		//forgot password
		function forgotPass() {
			alert('coming soon');
			//$(myDiv).load("<?php echo site_url('login/password'); ?>");
		}

		//logout
		function logout() {
			window.location.href = "<?php echo site_url('logout'); ?>";
		}

		//chat with user
		function chatWithUser(id) {
			alert('Function not implemented for user ' + id);
		}

		function msg(type,msg){
			$('.msg').html('<div class="alert alert-'+type+'">'+msg+'</div>');
		}
		setTimeout( "jQuery('.msg').slideUp('slow');",4000 );

	</script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/docs.js"></script>
</body>
</html>