<div class="well span12">
	<h3>Advertisements</h3>
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post): ?>
			<tr>
				<td>
					<?php echo $post->title;?><br/>
					<small class="muted"><?php echo $post->subcategory->name; ?></small>
				</td>
				<td><?php echo Text::limit_words($post->description);?></td>
				<td><?php echo Html::anchor("posts/edit/{$post->uri}", 'edit');?></td>
				<td>
					<?php echo Html::anchor("posts/destroy/{$post->uri}", 'delete', array('class' => 'confirmation'));?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>