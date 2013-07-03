<div class="span12">
	<div class="row">
		<div class="span7">
			<div class="well">
				<div class="row">
					<?php if (Session::instance()->get('message')): ?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<?php echo Session::instance()->get_once('message'); ?>
						</div>
					<?php endif; ?>
					<div class="span2">
						<?php foreach ($categories as $category): ?>
							<h3><?php echo $category->name; ?></h3>
							<?php foreach ($category->subcategories->find_all() as $subcategory): ?>
								<?php echo HTML::anchor("subcategories/{$subcategory->uri}", $subcategory->name); ?><br />
							<?php endforeach; ?>
						<?php endforeach; ?>
					</div>
					<div class="span2">
						<?php foreach ($categories_2 as $category): ?>
							<h3><?php echo $category->name; ?></h3>
							<?php foreach ($category->subcategories->find_all() as $subcategory): ?>
								<?php echo HTML::anchor("subcategories/{$subcategory->uri}", $subcategory->name); ?><br />
							<?php endforeach; ?>
						<?php endforeach; ?>
					</div>
					<div class="span2">
						<?php foreach ($categories_3 as $category): ?>
							<h3><?php echo $category->name; ?></h3>
							<?php foreach ($category->subcategories->find_all() as $subcategory): ?>
								<?php echo HTML::anchor("subcategories/{$subcategory->uri}", $subcategory->name); ?><br />
							<?php endforeach; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span5">
			<?php echo html::anchor('posts/add', 'Post A Free Ad', array('class' => 'btn btn-large btn-primary btn-block'));?>
			<div class="clearfix">&nbsp;</div>
			<div class="well well-large">
				<h4>Stay Connected: </h4>
				<div class="fb-like" data-href="http://bargainph.com" data-send="false" data-width="450" data-show-faces="false"></div>
			</div>
		</div>
	</div>
</div>