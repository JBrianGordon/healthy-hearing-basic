<?php
use Cake\Routing\Router;

if (isset($wiki)) {
	$description = empty($wiki->facebook_description) ? '' : $wiki->facebook_description;
	$image = empty($wiki->facebook_image) ? '/img/hh-symbol.png' : $wiki->facebook_image;
} elseif (isset($content)) {
	$description = empty($content->facebook_description) ? '' : $content->facebook_description;
	$image = empty($content->facebook_image) ? '/img/hh-symbol.png' : $content->facebook_image;
} else {
	$description = '';
	$image = '/img/hh-symbol.png';
}
$image = Router::url($image, true);
?>
<footer class="panel-footer text-center btn-set noprint">
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0" nonce="8cB2VAXE"></script>
	<div id="fbBtn" class="btn btn-share btn-facebook ml0">
		<span class="hh-icon-facebook"></span>Share
	</div>
	<script>
	document.getElementById('fbBtn').onclick = function(e) {
	  e.preventDefault();
	  FB.ui({
	    display: 'popup',
	    method: 'share',
	    href: window.location.href,
	  }, function(response){});
	}
	</script>
	<a href="https://x.com/intent/tweet?url=<?= urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" class="btn btn-share btn-twitter twitter-share-button ml15" id="twitter-wjs" target="_blank" rel="noopener"><span class="hh-icon-x"></span> Tweet</a>
	<!-- LinkedIN JS -->
	<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
	<script type="IN/Share" data-url="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') ?>"></script>
	<?php
	if(empty($hidePinterest)) {
		echo $this->Share->pinterest([
			'linkOptions' => [
				'class' => 'btn btn-share btn-pinterest ml15',
				'target' => '_blank',
				'rel' => 'noopener',
				'escape' => false,
				'onclick' => false,
				'data-pin-do' => 'buttonPin',
				'media' => $image,
				'href' => '#'
			],
			'label' => '<span class="hh-icon-pinterest"></span> Pin',
			'text' => $description,
			'image' => $image
		]);
	}
	?>
	<button class="btn btn-print btn-light noprint ml15" onclick="window.print()"><span class="icon hh-icon-printer"></span> Print</button>
	<!-- Pinterest button JS -->
	<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js" data-pin-custom="true"></script>
</footer>