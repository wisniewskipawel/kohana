<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<rss version="2.0">
	<channel>
		<title><![CDATA[<?php echo HTML::chars(Arr::get($info, 'title')) ?>]]></title>
		<description><![CDATA[<?php echo HTML::chars(Arr::get($info, 'description')) ?>]]></description>
		<link><?php echo URL::site(Arr::get($info, 'link'), 'http') ?></link>
		<pubDate><?php echo date('r', Arr::get($info, 'pubDate', time())) ?></pubDate>
		<lastBuildDate><?php echo date('r', Arr::get($info, 'lastBuildDate', time())) ?></lastBuildDate>

		<?php foreach ($items as $item): ?>
		<item>
			<title><![CDATA[<?php echo HTML::chars(Arr::get($item, 'title')) ?>]]></title>
			<description><![CDATA[<?php echo HTML::chars(Arr::get($item, 'description')) ?>]]></description>
			<link><?php echo URL::site(Arr::get($item, 'link'), 'http') ?></link>
			<pubDate><?php echo date('r', Arr::get($item, 'pubDate', time())) ?></pubDate>
		</item>
		<?php endforeach ?>

	</channel>
</rss>