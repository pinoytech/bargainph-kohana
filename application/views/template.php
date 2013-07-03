<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Buy and Sell in the Philippines - Buy and Sell</title>
<?php echo HTML::style('bootstrap/css/bootstrap.css', array('media' => 'screen')); ?>
<?php echo HTML::style('css/style.css', array('media' => 'screen')); ?>
<?php if (Request::instance()->controller === 'categories'):?>
	<meta property="og:image" content="http://www.bargainph.com/images/logo.gif"/>
	<meta property="og:title" content="Bargain Philippines, a Buy and Sell portal in the Philippines"/>
	<meta property="og:url" content="http://www.bargainph.com"/>
<?php elseif (isset($post) AND Request::instance()->controller === 'posts' AND Request::instance()->action === 'view'): ?>
	<meta property="og:image" content="<?php echo empty($post->image) ? 'http://bargainph.com/images/logo.gif' : url::site("ad_images/{$post->image}")?>"/>
	<meta property="og:title" content="<?php echo $post->title; ?>"/>
	<meta property="og:url" content="<?php echo url::site("post/{$post->uri}"); ?>"/>
<?php endif; ?>
<meta property="og:site_name" content="Bargain Philippines"/>
</head>
<body>
<!-- end .container_12 -->
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<li class="active"><?php echo html::anchor('/', 'Buy And Sell');?></li>
				<li><?php echo html::anchor('posts/add', 'Post New Ad');?></li>
				<?php if (Session::instance('database')->get('user_id')):?>
					<li class="active"><?php echo html::anchor('posts/advertisements', 'Manage Advertisements');?></li>
				<?php endif; ?>
			</ul>
			<ul class="nav pull-right">
				<?php if (Session::instance('database')->get('user_id')): ?>
					<li class="active"><?php echo Html::anchor('logout', 'Logout');?></li>
				<?php else: ?>
					<li class="active"><?php echo Html::anchor('login', 'Login');?></li>
					<li class="active"><?php echo Html::anchor('register', 'Register');?></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="span4 header">
			<h1><?php echo html::anchor('/', html::image('images/logo.gif'));?></h1>
		</div>
		<div class="span8 header">
			<?php if ( ! Request::instance()->controller === 'blogs'):?>
				<?php echo form::open('posts/search/', array('method' => 'get', 'class' => 'navbar-form pull-right'));?>
					<input class="search_input span4" type="text" value="" name="search" id="inputSearch" placeholder="What are you looking for?">
					<?php echo Form::select('category', $categories->as_array('id', 'name'),'', array('class' => 'span2 search_select'));?>
					<button type="submit" class="btn search_button btn-warning">Go</button>
				</form>
	   		<?php endif;?>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="span12 navbar">
			<div class="navbar-inner">
				<?php echo Html::anchor('/', 'Buy and Sell in the Philippines', array('class' => 'brand'));?>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<?php echo $content;?>
		<div class="clearfix">&nbsp;</div>
		<div class="span12 navbar navbar-inverse footer">
			<div class="navbar-inner">
				<div class="container">
					<ul class='nav'><li><?php echo Html::anchor('/', 'Buy and Sell is a classifieds ads websites focused on bringing the latest ads by sellers to buyers.');?></li></ul>
					<ul class='nav pull-right'><li><small class="muted">Powered by Kohana <?php echo Kohana::VERSION;?>  <?php echo Kohana::CODENAME;?> using <?php echo number_format(memory_get_usage() / 1048576, 2) . ' MB';?></small></li></ul>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- end .container_16 -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-661176-23");
pageTracker._trackPageview();
} catch(err) {}</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=208923119204563";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php if (Kohana::$environment !== Kohana::PRODUCTION): ?>
<?php echo View::factory('profiler/stats');?>
<?php endif;?>
<?php echo HTML::script('http://code.jquery.com/jquery-1.8.2.min.js'); ?>
<?php echo HTML::script('bootstrap/js/bootstrap.min.js'); ?>
<script type="text/javascript">
(function() {
  var dgh = document.createElement("script"); dgh.type = "text/javascript";dgh.async = true;
  dgh.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cakephp_stats.local/visitors/tracker.js?tracker=PcuJktowHVZtVpB&referer=' + encodeURIComponent(document.referrer);
  var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(dgh, s);
})();
</script>
</body>
</html>