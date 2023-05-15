<?php
	// Videos
	if (!empty($location['LocationVideo'])) {
		$youtubeCode = [];
		$vimeoCode = [];
		$dailyCode = [];
		$wistiaCode = [];
		foreach ($location['LocationVideo'] as $locationVideo) {
			$videoFull = parse_url($locationVideo['LocationVideo']['video_url']);
			//Most YouTube url's, checking the "v" param
			if(!empty($videoFull['host'] == 'www.youtube.com')) {
				parse_str($videoFull['query'], $query);
				if(!empty($query['v'])){
					array_push($youtubeCode, $query['v']);
				}
			}
			//YouTube url like "https://youtu.be/jdi0Iq9NBqQ"
			elseif ($videoFull['host'] == 'youtu.be') {
				array_push($youtubeCode, $videoFull['path']);
			}
			//Vimeo url like "https://vimeo.com/76722607"
			elseif($videoFull['host'] == 'vimeo.com') {
				array_push($vimeoCode, $videoFull['path']);
			}
			//Dailymotion url like "https://www.dailymotion.com/embed/video/x7mntci"
			elseif($videoFull['host'] == 'www.dailymotion.com') {
				$dropDir = str_replace('/video/', '', $videoFull['path']);
				//drop params
				if(strpos($dropDir, "?") > 0) {
					$noParams = substr($dropDir, 0, strpos($dropDir, "?"));
					array_push($dailyCode, $noParams);
				}
				else {
					array_push($dailyCode, $dropDir);
				}
			}
			//Dailymotion url like "https://dai.ly/x7momm7"
			elseif ($videoFull['host'] == 'dai.ly') {
				array_push($dailyCode, $videoFull['path']);
			}
			//Wistia url like "https://fast.wistia.net/embed/iframe/tsghpkbeha?videoFoam=true"
			elseif($videoFull['host'] == 'fast.wistia.net') {
				$dropDir = str_replace('/embed/iframe/', '', $videoFull['path']);
				array_push($wistiaCode, $dropDir);
			}
			//Wistia url like "https://healthyhearing.wistia.com/medias/tsghpkbeha"
			elseif(strpos($videoFull['host'], '.wistia.com') !== false) {
				$dropDir = str_replace('/medias/', '', $videoFull['path']);
				array_push($wistiaCode, $dropDir);
			}
			//Wistia url like "https://wistia.com/series/low-views-high-impact?wchannelid=bs6esrksii&wvideoid=ct7wc2mqgy"
			elseif(strpos($videoFull['query'], 'wvideoid') !== false) {
				parse_str($videoFull['query'], $urlParams);
				$dropDir = $urlParams['wvideoid'];
				array_push($wistiaCode, $dropDir);
			}
		}
		$totalVids = count($youtubeCode) + count($vimeoCode) + count($dailyCode) + count($wistiaCode);
	}
?>
<?php if (isset($totalVids)): ?>
	<section id="videoGallery" class="panel panel-primary">
		<header class="panel-heading text-center">
			<h3>Videos</h3>
		</header>
		<div class="panel-body">
			<div class="panel-section expanded" style="padding:0">
			<?php if ($totalVids > 1): ?>
				<div class="video-gallery">
					<?php foreach($youtubeCode as $ytURL): ?>
						<iframe class="video-frame gallery" data-src="https://www.youtube.com/embed/<?php echo $ytURL ?>?enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php endforeach ?>
					<?php foreach($vimeoCode as $vimURL): ?>
						<iframe class="video-frame gallery" data-src="https://player.vimeo.com/video<?php echo $vimURL ?>" allow="autoplay; fullscreen" frameborder="0" allowfullscreen></iframe>
					<?php endforeach ?>
					<?php foreach($dailyCode as $dmURL): ?>
						<iframe class="video-frame gallery" frameborder="0" data-src="https://www.dailymotion.com/embed/video/<?php echo $dmURL ?>" allowfullscreen allow="autoplay"></iframe>
					<?php endforeach ?>
					<?php foreach($wistiaCode as $wiURL): ?>
						<iframe class="video-frame gallery" frameborder="0" data-src="https://fast.wistia.net/embed/iframe/<?php echo $wiURL ?>?videoFoam=true" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="100%" height="100%"></iframe>
					<?php endforeach ?>
				</div>
			<?php else: ?>
				<?php if (count($youtubeCode) == 1): ?>
					<iframe class="video-frame" data-src="https://www.youtube.com/embed/<?php echo $youtubeCode[0] ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<?php elseif (count($vimeoCode) == 1): ?>
					<iframe class="video-frame" data-src="https://player.vimeo.com/video<?php echo $vimeoCode[0] ?>" allow="autoplay; fullscreen" frameborder="0" allowfullscreen></iframe>
				<?php elseif (count($dailyCode) == 1): ?>
					<iframe class="video-frame" frameborder="0" data-src="https://www.dailymotion.com/embed/video/<?php echo $dailyCode[0] ?>" allowfullscreen allow="autoplay"></iframe>					
				<?php elseif (count($wistiaCode) == 1): ?>
					<iframe class="video-frame" data-src="https://fast.wistia.net/embed/iframe/<?php echo $wistiaCode[0] ?>?videoFoam=true" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="100%" height="100%"></iframe>
				<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>