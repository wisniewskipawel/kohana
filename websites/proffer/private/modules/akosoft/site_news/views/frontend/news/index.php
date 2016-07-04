<div id="news_list_box" class="box primary">
	<h2><?php echo ___('news.title') ?></h2>
	<div class="content">
		<?php if(count($news)): ?>
		
		<?php echo $pager ?>

		<ul id="news_list">
		<?php foreach ($news as $n): ?>
			<li>
				<a href="<?php echo Route::url('site_news/frontend/news/show', array('id' => $n->news_id, 'title' => URL::title($n->news_title))) ?>"><?php echo $n->news_title ?></a> (<strong class="date"><?php echo Date::my($n->news_date_added, 'news') ?></strong>)
			</li>
		<?php endforeach; ?>
		</ul>
		
		<?php echo $pager ?>
		
		<?php endif; ?>
	</div>
</div>