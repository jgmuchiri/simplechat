<?php echo form_open('login/doLogin', 'class="form-signin"'); ?>
<h2 class="form-signin-heading">Please sign in</h2>

<input type="email" name="email" class="form-control" placeholder="Email address" required="" autofocus/>

<input type="password" name="password" class="form-control" placeholder="Password" required=""/>

<!--
<label class="checkbox">
	<input type="checkbox" name="remember" value="remember-me"> Remember me
</label>
-->
<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

<div class="spacer"></div>


<a href="#" onclick="register()">Register</a>
|
<a href="#" onclick="forgotPass()">Reset password</a>

<?php echo form_close(); ?>

