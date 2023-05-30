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
<footer class="panel-footer text-center btn-set share-footer noprint">
	<?php
	echo $this->Share->facebook([
		'linkOptions' => [
			'class' => 'btn btn-share btn-facebook',
			'target' => '_blank',
			'rel' => 'noopener',
			'escape' => false,
			'onclick' => false
		],
		'label' => '<span class="hh-icon-facebook"></span> Share'
	]);
	?>
	<?php
	echo $this->Share->twitter([
		'linkOptions' => [
			'class' => 'btn btn-share btn-twitter',
			'target' => '_blank',
			'rel' => 'noopener',
			'escape' => false,
			'onclick' => false
		],
		'label' => '<span class="hh-icon-twitter"></span> Tweet'
	]);
	?>
	<?php
	echo $this->Share->linkedin([
		'linkOptions' => [
			'class' => 'btn btn-share btn-linkedin',
			'target' => '_blank',
			'rel' => 'noopener',
			'escape' => false,
			'onclick' => false
		],
		'label' => '<span class="hh-icon-linkedin"></span> Share'
	]);
	?>
	<?php
	if(empty($hidePinterest)) {
		echo $this->Share->pinterest([
			'linkOptions' => [
				'class' => 'btn btn-share btn-pinterest',
				'target' => '_blank',
				'rel' => 'noopener',
				'escape' => false,
				'onclick' => false
			],
			'label' => '<span class="hh-icon-pinterest"></span> Pin',
			'text' => $description,
			'image' => $image
		]);
	}
	?>
	<button class="btn btn-print btn-light noprint" onclick="window.print()"><span class="icon hh-icon-printer"></span> Print</button>
</footer>