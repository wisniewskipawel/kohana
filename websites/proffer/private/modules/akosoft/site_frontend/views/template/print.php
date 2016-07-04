<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<?php if(isset($meta_tags))
			foreach($meta_tags as $m) 
				echo "<meta".HTML::attributes($m).">\n";
		?>
		
		<title><?php echo Security::escape_text($meta_title) ?></title>
		
		<?php
		//assets
		Media::css('reset.css', NULL, array('minify' => TRUE));
		Media::css('print.css', NULL, array('minify' => TRUE));
		
		Media::js('jquery.min.js', 'js/libs/');
		
		echo Media::css() ?>
		
		<!--[if lt IE 9]>
			<?php echo HTML::script('media/js/html5.js') ?>
		<![endif]-->
		
		<?php echo Media::js() ?>
		
	</head>
	<body>
		
		<header>
			<div class="wrapper">

				<div id="logo">
					<a href="<?php echo URL::site('/') ?>">
						<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
					</a>
				</div>
				
			</div>
		</header>
		
		<div id="content">
			<div class="wrapper">
				
				<?php echo $content; ?>
			
			</div>
		</div>
		
		<script>
		(function() {
			window.print();
		 })();
		</script>
	</body>
</html>

