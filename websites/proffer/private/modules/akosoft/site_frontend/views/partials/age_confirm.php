<div class="box primary">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">
		<div style="margin-bottom: 20px;">
			<?php echo $document->document_content ?>
		</div>

		<form action="" method="post">
			<div style="text-align:center; margin-bottom: 20px;">
				<p>
					<label><strong><?php echo ___('age_confirm.remember') ?></strong><input style="margin-left: 15px;" type="checkbox" name="remember" value="1" /></label>
				</p>
			</div>
			<div style="text-align: center;">
				<p style="width: 49%; float: left;">
					<input type="submit" name="y" value="<?php echo ___('age_confirm.yes') ?>" />
				</p>
				<p style="width: 49%; float: right;">
					<input type="submit" name="n" value="<?php echo ___('age_confirm.no') ?>" />
				</p>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>