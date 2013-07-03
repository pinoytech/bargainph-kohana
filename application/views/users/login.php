<div class="span12 well">
	<h3>Login...</h3>
	<div class="span5">
		<p>...with Username and Password</p>
		<?php echo Form::open('users/login', array('class' => 'form-horizontal'));?>
			<div class="control-group">
				<label class="control-label" for="inputUsername">Username</label>
				<div class="controls">
					<input type="text" id="inputUsername" name="username" value="<?php echo $user->username;?>" placeholder="Username"><br />				
					<?php echo isset($errors['username']) ? "<span class='label label-important'>{$errors['username']}</span>" : '';?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password</label>
				<div class="controls">
					<input type="password" id="inputPassword" name="password" placeholder="Password">
					<br />
					<?php echo isset($errors['password']) ? "<span class='label label-important'>{$errors['password']}</span>" : '';?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<?php echo Html::anchor("users/reset_password", 'Forgot Password?');?>
					<div class="clearfix">&nbsp;</div>
					<input type="submit" class="btn btn-large btn-primary span2" value="Login"/>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
		</form>
	</div>
	<div class="span5 offset1">
		<p>...with Facebook</p>
		<?php echo HTML::anchor($login_url, HTML::image('images/button-fb-connect.png'));?>
	</div>
</div>