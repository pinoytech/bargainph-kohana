<div class="span12 pull-right">
	<?php foreach ($posts as $post): ?>
		<div class=""><?php echo date("d M Y", strtotime($post->created_at)), ' » ', HTML::anchor("blogs/{$post->uri}", $post->post);?></div>
	<?php endforeach;?>
</div>
<div class="clearfix">&nbsp;</div>
<?php echo $pagination; ?>