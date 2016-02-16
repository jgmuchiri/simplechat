<?php echo form_open('login/reset_pass', 'class="form-signin"'); ?>
<h2 class="form-signin-heading">Reset password</h2>

<input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>

<div class="spacer"></div>

<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>

<div class="spacer"></div>


<a href="#" onclick="login()">Login</a>
|
<a href="#" onclick="register()">Register</a>

<?php echo form_close(); ?>