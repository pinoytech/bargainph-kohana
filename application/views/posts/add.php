<div class="span12 content">
	<div>
		<h2>Add Post</h2>
		<?php echo form::open(request::instance()->uri(), array('enctype' => 'multipart/form-data', 'autocomplete' => 'off', 'class' => 'form-horizontal'));?>
		<div class="well">
			<?php if (Session::instance()->get('message')): ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<?php echo Session::instance()->get_once('message'); ?>
				</div>
			<?php endif; ?>
			<h3>Ad Information</h3>
			<div class="control-group">
				<label class="control-label" for="inputTitle">Title</label>
				<div class="controls">
					<input class="span5" type="text" name="title" value="<?php echo $post->title;?>" id="inputTitle" placeholder="Title">
					<br />
					<?php echo isset($post_errors['title']) ? "<span class='label label-important'>{$post_errors['title']}</span>" : '';?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputCategory">Categorization</label>
				<div class="controls">
					<?php if (Session::instance()->get('subcategory')): ?>
						<?php echo Form::select('subcategory_id', $subcategories, Session::instance()->get('subcategory')->id);?>
					<?php else: ?>
						<?php echo Form::select('subcategory_id', $subcategories);?>
					<?php endif; ?>
					<br />
					<?php echo isset($post_errors['subcategory_id']) ? "<span class='label label-important'>{$post_errors['subcategory_id']}</span>" : '';?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPrice">Price</label>
				<div class="controls">
					<div class="input-prepend input-append">
						<span class="add-on">Php</span>
						<input class="span3" name="price" value="<?php echo $post->price;?>" type="text" id="inputPrice" placeholder="Price">
						<span class="add-on">.00</span>
					</div>
					<br />
					<?php echo isset($post_errors['price']) ? "<span class='label label-important'>{$post_errors['price']}</span>" : '';?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPhoto">Photo</label>
				<div class="controls">
					<input class="span3" name="userfile" type="file" id="inputFile" placeholder="File">
					<br />
					<?php echo isset($file_errors['userfile']) ? "<span class='label label-important'>{$file_errors['userfile']}</span>" : '';?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputDescription">Description</label>
				<div class="controls">
					<textarea class="span5" rows="5" name="description"><?php echo $post->description;?></textarea>
					<br />
					<?php echo isset($post_errors['description']) ? "<span class='label label-important'>{$post_errors['description']}</span>" : '';?></span>
				</div>
			</div>
			<h3>Seller Information</h3>
			<div class="control-group">
				<label class="control-label" for="inputTitle">I am</label>
				<div class="controls">	
					<label class="radio">
						<input type="radio" id="optionsRadios1" name="occupation" value="professional" checked>
						a professional
					</label>
					<label class="radio">
						<input type="radio" id="optionsRadios2" name="occupation" value="business owner">
						a business owner
					</label>
					<br />
					<?php echo isset($post_errors['occupation']) ? "<span class='label label-important'>{$post_errors['occupation']}</span>" : '';?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputemail">Email</label>
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input class="span3" type="text" value="<?php echo $post->email;?>" name="email" id="inputEmail" placeholder="Email">
					</div>
					<br />
					<?php echo isset($post_errors['email']) ? "<span class='label label-important'>{$post_errors['email']}</span>" : '';?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPhone">Phone Number</label>
				<div class="controls">
					<input class="span5" type="text" name="phone" value="<?php echo $post->phone;?>" id="inputPhone" placeholder="Phone">
					<br />
					<?php echo isset($post_errors['phone']) ? "<span class='label label-important'>{$post_errors['phone']}</span>" : '';?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputAddress">Address</label>
				<div class="controls">
					<input class="span5" type="text" name="address" id="inputAddress" value="<?php echo $post->address;?>" placeholder="Address">
					<br />
					<?php echo isset($post_errors['address']) ? "<span class='label label-important'>{$post_errors['address']}</span>" : '';?></span>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-large btn-primary span2" value="Post"/>
				</div>
			</div>
			<div class="alert alert-info">
				<small>If you are not logged in, you will be sent details regarding your updating and deleting your advertisement</small>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
		</form>
	</div>
</div>