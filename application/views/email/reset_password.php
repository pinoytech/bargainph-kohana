<?php echo HTML::image(URL::site('images/logo.gif', TRUE));?>
<p>
	Good Day!
</p>
<p>
	We have received request for your password at <?php echo HTML::anchor('http://www.bargainph.com/', 'BargainPH')?>.
</p>
<p>
	To be able to retrieve your password click the link below:
	<?php echo HTML::anchor(URL::site("users/send_password/{$user->random_string}", TRUE)); ?>
</p>
<p>
Regards,
Bargain PH
</p>
