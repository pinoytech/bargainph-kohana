<div class="span12 content">
	<div class="well">
		<h2><?php echo $post->title;?></h2>
		<?php if ( ! empty($post->image)): ?>
			<?php echo html::image("ad_images/$post->image"); ?>
		<?php endif; ?>
		<div class="clearfix">&nbsp;</div>
		<?php echo text::auto_p($post->description);?>
	</div>
</div>