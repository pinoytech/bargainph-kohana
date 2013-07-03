<div class="span3">
	<?php echo html::anchor('posts/add', 'Post A Free Ad', array('class' => 'btn btn-large btn-primary btn-block'));?>
	<div class="clearfix">&nbsp;</div>
</div>
<div class="span9">
	<?php if (isset($search_errors) AND isset($search_errors['search'])): ?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $search_errors['search']; ?>
		</div>
	<?php endif;?>
	<ul class="breadcrumb">
		<li><?php echo HTML::anchor('/', 'Bargain Philippines Home'); ?>
		<span class="divider">/</span>
		<li><?php echo HTML::anchor("posts/search?search={$search}", "Search results for: {$search}");?>
	</ul>
	<table class="table table-hover table-condensed table-striped">
		<?php foreach ($posts as $post): ?>
		<tr>
			<td class="">
				<?php echo html::image("http://www.placehold.it/180x100"); ?>
			</td>
			<td class="span8">
				<?php echo html::anchor("posts/{$post->uri}",$post->title); ?><br />
				<span class="muted"><?php echo "{$post->subcategory->name}"; ?></span>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
	<?php echo $pagination; ?>
</div>