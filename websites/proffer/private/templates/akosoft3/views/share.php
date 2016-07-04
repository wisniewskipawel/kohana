<?php Media::css('stackicons.min.css', 'stackicons/css'); ?>
<nav class="nav-social st-single-color-brand">
	<a title="Twitter" class="st-icon-twitter" href="http://twitter.com/?status=<?php echo urlencode($url) ?>" target="_blank">Twitter</a>

	<a title="Facebook" class="st-icon-facebook" href="https://www.facebook.com/sharer/sharer.php<?php 
		$fb_params = array(
			's' => 100,
			'p' => array(
				'url' => $url,
				'title' => $title,
				'summary' => $description,
			),
		);

		if(!empty($image_url))
			$fb_params['p']['images'][0] = $image_url;

		echo URL::query($fb_params, FALSE) ?>" title="<?php echo ___('share.fb') ?>" target="_blank">Facebook</a>

	<a title="Google+" class="st-icon-googleplus" href="https://plus.google.com/share?url=<?php echo urlencode($url) ?>" onclick="javascript:window.open(this.href,
'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Google+</a>

	<a title="LinkedIn" class="st-icon-linkedin" href="http://www.linkedin.com/shareArticle<?php echo URL::query(array(
		'mini' => 'true',
		'url' => $url,
		'title' => $title,
	)); ?>" target="_blank">LinkedIn</a>

	<a title="Pinterest" class="st-icon-pinterest" href="https://www.pinterest.com/pin/create/button/<?php echo URL::query(array(
		'url' => $url,
		'media' => !empty($image_url) ? $image_url : NULL,
		'description' => $title,
	)); ?>" target="_blank"><span></span>Pinterest</a>
	
	<?php if(!empty($send_friend_url) OR !empty($send_friend_form)): ?>
	<a title="Email" class="st-icon-email show_dialog_btn" href="<?php $send_friend_url ? $send_friend_url : '#' ?>" target="_blank" data-dialog-target="#dialog_share"><span></span>Email</a>

	<?php if(!empty($send_friend_form)): ?>
	<div id="dialog_share" class="dialog hidden box">
		<div class="dialog-title box-header"><?php echo $send_friend_title ?></div>
		<?php echo $send_friend_form ?>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</nav>