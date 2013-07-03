	<div class="span8 content">
		<div>
			<table class="posts_table">
				<?php foreach($posts as $post):?>
				<tr class="<?php echo text::alternate('odd', 'even');?>">
					<?php if (Session::instance()->get('logged_in')):?>
						<td><?php echo html::anchor("posts/delete/".$post['id'], 'Delete')?></td>
					<?php endif;?>
					<td class="date"><?php echo date('M jS, Y', strtotime($post['created']));?></td>
					<td class="image"><?php echo ($post['image_count']) ? html::image('images/camera_32.png') : '';?></td>
					<td class="title"><?php echo html::anchor("posts/view/{$post['uri']}", $post['title']);?></td>
					<td class="price"><?php echo number_format($post['price'], 2, '.', ' '), ' Php' ;?></td>
					<td><?php echo text::limit_chars($post['description']);?></td>
				</tr>
				<?php endforeach;?>
			</table>
			<?php echo $pagination;?>
		</div>
	</div>