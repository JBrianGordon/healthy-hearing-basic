<?php 
	use Cake\Core\Configure;
	$learnMoreOrder = isset($stateNice) ? '12' : '8';
?>
<section class="panel panel-light blog-previews" style="order:<?= $learnMoreOrder ?>">
	<header class="panel-heading text-center">
		<h4 class="pl10 pr10">Learn more about hearing health</h4>
	</header>
	<div class="panel-body pt20 pl20 pr20 pb20">
		<p>If you're not ready to make that call, visit our <a href="/help">Hearing Help</a> pages for extensive information about <a href="/help/hearing-loss">hearing loss</a>, <a href="/help/hearing-aids">hearing aids</a>, 
		<?php if (Configure::read('country') == 'CA'): ?>
			<a href="/help/hearing-loss/tinnitus-treatment">tinnitus</a> and <a href="/help/hearing-aids/assistive-listening-devices">assistive listening devices</a>.
		<?php else: ?>
			<a href="/help/tinnitus">tinnitus</a> and <a href="/help/assistive-listening-devices">assistive listening devices</a>.
		<?php endif; ?>
		</p>
	</div>
</section>