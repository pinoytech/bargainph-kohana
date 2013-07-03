<div class="span11 well">
	<h3>Reset Password</h3>
	<?php if (isset($errors['random_string'])):?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $errors['random_string']; ?>
		</div>
	<?php else:?>
		<p>Your User Details have been sent to your email</p>
	<?php endif; ?>
</div>