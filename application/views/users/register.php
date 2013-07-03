<div class="span12 well">
	<h3>User Registration</h3>
	<?php echo form::open('users/register', array('class' => 'form-horizontal'));?>
		<div class="control-group">
			<label class="control-label" for="inputUsername">Username</label>
			<div class="controls">
				<input type="text" id="inputUsername" name="username" value="<?php echo $user->username;?>" placeholder="Username"><br />
				<?php echo isset($errors['username']) ? "<span class='label label-important'>{$errors['username']}</span>" : '';?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" id="inputEmail" name="email" value="<?php echo $user->email;?>" placeholder="Email"><br />
				<?php echo isset($errors['email']) ? "<span class='label label-important'>{$errors['email']}</span>" : '';?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="password" id="inputPassword" name="password" placeholder="Password"><br />
				<?php echo isset($errors['password']) ? "<span class='label label-important'>{$errors['password']}</span>" : '';?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<input type="submit" class="btn btn-large btn-primary span2" value="Register"/>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
	</form>
</div>