<?php echo HTML::image(URL::site('images/logo.gif', TRUE));?>
<p>
	Good Day!
</p>
<p>
	We have posted your Advertisement details at <?php echo HTML::anchor('http://www.bargainph.com/', 'BargainPH')?>.
</p>
<p>
	To be able to update or delete your advertisement, go to the link below:
	<?php echo HTML::anchor(URL::site("posts/manage/{$post->random_string}", TRUE), $post->title); ?>
</p>
<p>
Regards,
Bargain PH
</p>
