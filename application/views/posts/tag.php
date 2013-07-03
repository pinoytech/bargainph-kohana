	<div class="grid_16 content">
		<div>
			<h2>Ads tagged &ldquo;<?php echo $tag;?>&rdquo;</h2>
			<table class="posts_table">
				<?php foreach($posts as $post):?>
				<tr class="<?php echo text::alternate('odd', 'even');?>">
					<td class="date"><?php echo date('M jS Y', strtotime($post['created']));?></td>
					<td class="image"><?php echo ($post['image'] == '') ? '' : Html::image('images/camera_32.png');?></td>
					<td class="title"><?php echo html::anchor("posts/view/{$post['uri']}", $post['title']);?></td>
					<td class="price"><?php echo number_format($post['price'], 2, '.', ' '), ' Php' ;?></td>
					<td><?php echo Text::limit_chars($post['description']);?></td>
				</tr>
				<?php endforeach;?>
			</table>
			<?php echo $pagination;?>
		</div>
	</div>