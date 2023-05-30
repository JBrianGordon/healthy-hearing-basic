<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

$slug = isset($wiki->slug) ? $wiki->slug : '';
$navigation = $this->Wiki->findNavBySlug($slug);
$here = $_SERVER['REQUEST_URI'];
?>
<?php if (isset($navigation['parent'])): ?>
	<?php
	$links = [];
	if(!preg_match('~/help/hearing-loss~', $here)) {
		$links[] = [
			'text' => 'hearing loss',
			'link' => '/help/hearing-loss'
		];
	}
	if(!preg_match('~/help/hearing-aids~', $here)) {
		$links[] = [
			'text' => 'hearing aids',
			'link' => '/help/hearing-aids'
		];
	}
	if (Configure::read('showManufacturers')) {
		if (!preg_match('~/hearing-aid-manufacturers~', $here)) {
			$links[] = [
				'text' => 'hearing aid brands',
				'link' => '/hearing-aid-manufacturers'
			];
		}
	}
	if (Configure::read('showAssistiveListening')) {
		if (!preg_match('~/help/assistive-listening-devices~', $here)) {
			$links[] = [
				'text' => 'assistive devices',
				'link' => '/help/assistive-listening-devices'
			];
		}
	}
	if (Configure::read('showTinnitus')) {
		if (!preg_match('~/help/tinnitus~', $here)) {
			$links[] = [
				'text' => 'tinnitus',
				'link' => '/help/tinnitus'
			];
		}
	}
	?>

	<div class="col-xs-12 text-left">
		<p>
			You are reading about: <br />
			<?php
				if ($here == Router::url($navigation['parent']->hh_url)) {
					echo $navigation['parent']->name;
				} else {
					echo $this->Html->link($navigation['parent']->name, $navigation['parent']->hh_url, ['escape' => false]);
				}

				foreach ($navigation['children'] as $child) {
					if ($child->slug == $slug) {
						echo ' / ' . $child->name;
					}
				}
			?>
		</p>
		<p><strong>Related topics</strong></p>
		<ul>

			<?php foreach($navigation['children'] as $child): ?>
				<?php
				if ($child->slug != $slug) {
					echo '<li>' . $this->Html->link($child->name, $child->hh_url, ['escape' => false]) . '</li>';
				}
				?>
			<?php endforeach ;?>
			<?php if (Configure::read('showManufacturers')): ?>
				<?php if (strtolower(substr($slug, 0, 12)) == 'hearing-aids'): ?>
					<li><?php echo $this->Html->link('Hearing aid manufacturers', ['admin' => false, 'controller' => 'corps', 'action' => 'index'], ['escape' => false]); ?></li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
		<p>
			More information about
			<?php
				$endLink = count($links);
				$linkCount = 0;
				foreach($links as $link) {
					$linkCount++;
					echo $this->Html->link($link['text'], $link['link']);
					if($linkCount == $endLink - 1) {
						echo ' and ';
					}
					elseif($linkCount < $endLink) {
						echo ', ';
					}
				}
			?>.
		</p>
	</div>
<?php endif; ?>
