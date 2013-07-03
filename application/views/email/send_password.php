<?php echo HTML::image(URL::site('images/logo.gif', TRUE));?>
<p>
	Good Day!
</p>
<p>
	We have reset your password at <?php echo HTML::anchor('http://www.bargainph.com/', 'BargainPH')?>.
</p>
<p>
	Your user details as as follows:
	Username: <?php echo $user->username;?>
	Password: <?php echo $user->tmp_password;?>
</p>
<p>
	Login at <?php echo HTML::anchor(URL::site("users/login", TRUE)); ?>
</p>
<p>
Regards,
Bargain PH
</p>
