<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo ___('errors.404.title') ?></title>
		
		<style>
			body {
				font: 14px Tahoma, Arial, Helvetica, sans-serif;
				padding: 0; margin: 0; color: #5C5C5C; background: #fafafa;
			}
			
			a { text-decoration: none; color: #0067C0; }
			a:hover { text-decoration: underline; }
			
			.wrapper { width: 990px; margin: 0 auto; }
			.header-wrapper { 
				border-top: 5px solid #e1e1e1; border-bottom: 1px solid #ededed;
				position: relative; 
			}

			.header { 
				height: 108px; overflow: hidden; position: relative; 
				border-top: 5px solid #00366F; margin-top: -5px;
			}

			.header #logo { margin-top: 30px; float: left; overflow: hidden; }
			.header #logo a { display: block; }
			.header #logo a img { border: none; }

			.header h1 { float: right; font-size: 20px; }

			#main { padding: 80px 0; background: white; }
			#main h2 { font-size: 60px; margin: 0 0 40px 0; }

			#footer-wrapper { 
				border-top: 1px solid #e1e1e1; padding: 30px 0; text-align: center; 
				clear: both; font-size: 80%; 
			}
		</style>
		
	</head>
	<body>
		<div class="header-wrapper">
			<div class="wrapper">
				
				<div class="header">

					<div id="logo">
						<a href="<?php echo URL::site('/', 'http') ?>">
							<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
						</a>
					</div>

					<?php if($home_text = Kohana::$config->load('global.layout.home_header_text')): ?>
					<h1><?php echo $home_text ?></h1>
					<?php endif; ?>

				</div>

			</div><!-- /.wrapper -->
		</div><!-- /.header-wrapper -->
		
		<div id="main">
			<div class="wrapper">
				
				<h2><?php echo ___('errors.404.title') ?></h2>
				
				<?php echo ___('errors.404.info') ?>

				<ul class="actions_list">
					<li><a href="javascript:window.history.go(-1);"><?php echo ___('errors.404.back_btn') ?></a></li>
					<li><a href="<?php echo URL::site('/', 'http') ?>"><?php echo ___('errors.404.home_btn') ?></a></li>
				</ul>
			
			</div>
		</div>
		
		
		<div id="footer-wrapper">
			<div class="footer wrapper">
				&copy; Copyright 
				<?php 
				if($copyright_text = Kohana::$config->load('global.layout.copyright_text')) 
				{
					echo $copyright_text;
				}
				else 
				{
					echo '2008-'.date('Y').' AkoPortal';
				}
				?>
				<br />
				<?php echo ___('realization') ?>: <a href="http://www.akosoft.pl"><strong>AkoSoft</strong></a>
			</div>
		</div>
		
		<?php if($google_analytics_account = Kohana::$config->load('global.layout.google_analytics_account')): ?>
		<script>
		var _gaq=[['_setAccount','<?php echo $google_analytics_account ?>'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
		<?php endif; ?>
	</body>
</html>