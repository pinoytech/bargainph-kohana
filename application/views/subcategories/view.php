<div class="span3">
	<?php echo html::anchor('posts/add', 'Post A Free Ad', array('class' => 'btn btn-large btn-primary btn-block'));?>
	<div class="clearfix">&nbsp;</div>
	<div class="well" style="max-width: 340px; padding: 8px 0;">
		<ul class="nav nav-list">
			<li class="nav-header">Categories</li>
			<?php foreach ($categories as $category): ?>
				<li class="active"><a href="javascript:void(0)"><?php echo $category->name;?></a></li>
				<?php foreach ($category->subcategories->find_all() as $subsubcategory):?>
					<li><?php echo html::anchor("subcategories/{$subsubcategory->uri}", $subsubcategory->name); ?></li>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="span9 pull-right">
	<ul class="breadcrumb">
		<li><?php echo HTML::anchor('/', 'Bargain Philippines Home'); ?></li>
		<span class="divider">/</span>
		<li><?php echo HTML::anchor("subcategories/{$subcategory->uri}", $subcategory->name);?></li>
	</ul>
	<table class="table table-hover table-condensed table-striped">
		<?php foreach ($posts as $post): ?>
		<tr>
			<td class="">
				<div class="image_preview_container">
					<?php if ( ! empty($post->image)): ?>
						<?php echo html::image("ad_images/thumb/{$post->image}", array('width' => '180px')); ?>
					<?php else: ?>
						<?php echo html::image("http://www.placehold.it/180x100"); ?>
					<?php endif; ?>
				</div>
			</td>
			<td class="span9">
				<?php echo html::anchor("posts/{$post->uri}",$post->title); ?><br />
				<span class="label label-info"><?php echo "{$post->subcategory->name}"; ?></span>
				<small><?php echo Text::limit_words($post->description, 30);?></small>
				<div class="fb-like" data-href="<?php echo URL::site("posts/{$post->uri}") ?>" data-send="false" data-width="450" data-show-faces="false"></div>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>
<div class="clearfix">&nbsp;</div>
<?php echo $pagination; ?>