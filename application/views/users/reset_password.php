<div class="span12 well">
	<h3>Reset Password</h3>
	<?php if (Session::instance('database')->get('message')): ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo Session::instance('database')->get_once('message'); ?>
		</div>
	<?php endif; ?>
	<?php echo Form::open('users/reset_password', array('class' => 'form-horizontal'));?>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" id="inputEmail" name="email" value="<?php echo $user->email;?>" placeholder="Email"><br />				
				<?php echo isset($errors['email']) ? "<span class='label label-important'>{$errors['email']}</span>" : '';?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<div class="clearfix">&nbsp;</div>
				<input type="submit" class="btn btn-large btn-primary span2" value="Reset Password"/>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
	</form>
</div>