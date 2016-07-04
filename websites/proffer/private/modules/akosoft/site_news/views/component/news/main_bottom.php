<div id="news_box" class="box gray news half">
	<div class="box-header">
		<span><?php echo ___('news.boxes.main_bottom.title') ?></span>
		<a class="more_btn" href="<?php echo Route::url('site_news/frontend/news/index') ?>"><?php echo ___('news.boxes.main_bottom.browse_archive') ?></a>
	</div>
	<div class="content">
		<ul>
		<?php foreach ($news as $n): ?>
			<li>
				<a href="<?php echo Route::url('site_news/frontend/news/show', array(
					'id' => $n->news_id, 
					'title' => URL::title($n->news_title)
				)) ?>" title="<?php echo $n->news_title ?>"><?php echo Text::limit_chars($n->news_title, 42) ?></a> 
				<span class="datetime"><?php echo Date::my($n->news_date_added, 'news') ?></span>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>