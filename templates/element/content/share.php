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
	<div class="fb-share-button btn btn-share btn-facebook" data-href="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])?>">
		<span class="hh-icon-facebook"></span>
		<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://<?= htmlspecialchars($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])?>&src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
	</div>
	<?= $this->Share->twitter([
		'linkOptions' => [
			'class' => 'btn btn-share btn-twitter twitter-share-button',
			'id' => 'twitter-wjs',
			'target' => '_blank',
			'rel' => 'noopener',
			'escape' => false,
			'onclick' => false
		],
		'label' => '<span class="hh-icon-x"></span> Tweet'
	])
	?>
	<!-- X JS -->
	<script>window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);

	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };

	  return t;
	}(document, "script", "twitter-wjs"));</script>
	<!-- LinkedIN JS -->
	<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
	<script type="IN/Share" data-url="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') ?>"></script>
	<?php
	if(empty($hidePinterest)) {
		echo $this->Share->pinterest([
			'linkOptions' => [
				'class' => 'btn btn-share btn-pinterest',
				'target' => '_blank',
				'rel' => 'noopener',
				'escape' => false,
				'onclick' => false,
				'data-pin-do' => 'buttonPin',
				'media' => $image
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