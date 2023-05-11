<?php
use Cake\Routing\Router;	

$this->Html->script('dist/content.min', ['block' => true]); 
if (isset($search)) {
	$pageUrl = ['controller' => 'content', 'action' => 'search', $search];
} elseif (isset($tag) && strpos($_SERVER['REQUEST_URI'], 'tag') !== false) {
	$pageUrl = ['controller' => 'content', 'action' => 'tag', $tag];
} else {
	$pageUrl = ['controller' => 'content', 'action' => 'report_index'];
}
//Pagination in head
/*** TODO: can we remove this? Not sure it's being used ***/
if ($this->Paginator->hasNext() || $this->Paginator->hasPrev()) {
	$paginatorParams = $this->Paginator->params();
	$this->start('paginator_head');
	if ($this->Paginator->hasNext()) {
		echo $this->Html->tag('link', null, ['rel' => 'next', 'link' => Router::url($this->Paginator->url(['page' => $paginatorParams['page'] + 1]), true)]);
	}
	if ($this->Paginator->hasPrev()) {
		if ($paginatorParams['page'] == 2) {
			echo $this->Html->tag('link', null, ['rel' => 'prev', 'link' => Router::url(['controller' => 'content', 'action' => 'report_index'], true)]);
		} else {
			echo $this->Html->tag('link', null, ['rel' => 'prev', 'link' => Router::url($this->Paginator->url(['page' => $paginatorParams['page'] - 1]), true)]);
		}
	}
	$this->end();
}
?>
<div class="container-fluid site-body blog">
	<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
	</div>
	<div class="container">
		<div class="row">
		<div class="col-md-9 float-start">
			<?php if(isset($pageContent)) : ?>
				<section class="panel">
					<div class="panel-body">
						<header class="panel-section expanded"><?php echo $pageContent; ?></header>
					</div>
				</section>
			<?php endif; ?>
			<section class="panel">
				<div class="panel-body">
					<div class="row blog-posts">
						<div class="col-sm-12 left-posts">
							<?php foreach ($reports as $report): ?>
							<!--- *** TODO: uncomment when contenthelper built out ***
								<?php //$this->Content->set($report); ?>
							--->
								<div class="blog-post">
									<div class="p10">
										<span class="subtitle text-light mobile"><?= $report->type; ?></span>
										<h3 class="blog-title mobile"><?= $this->Html->link($report->title, $report->hh_url, $options = ['class' => 'text-link']) ?></h3>
										<p class="text-caption blog-byline mobile"><?= date_format($report->modified, 'F j, Y') ?></p>
										<!--- *** TODO: uncomment when contenthelper built out ***
										<p class="blog-image"><?php //echo $this->Content->image($report); ?></p>
										--->
										<p class="blog-intro mobile" style="clear: both"><?= $report->short; ?></p>
									</div>
									<div class="p10 right-content">
										<span class="subtitle text-light"><?= $report->type; ?></span>
										<h3 class="blog-title"><?= $this->Html->link($report->title, $report->hh_url, $options = ['class' => 'text-link']) ?></h3>
										<p class="text-caption blog-byline"><?= date_format($report->modified, 'F j, Y') ?></p>
										<p class="blog-intro" style="clear: both"><?= $report->short; ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<footer class="panel-section expanded blog-pagination">
						<ul class="pagination">
						    <?=
						        $this->Paginator->options([
						            'url' => $pageUrl,
						            'escape' => false
						        ]);
						    ?>
						    <?= $this->Paginator->first("« First"); ?>
						    <?= $this->Paginator->prev("« Previous"); ?>
						    <?= $this->Paginator->numbers(['modulus' => 6]); ?>
						    <?= $this->Paginator->next("Next »"); ?>
						    <?= $this->Paginator->last("Last »"); ?>
						</ul>
						<p class="text-primary text-small text-uppercase"><strong><?= $this->Paginator->counter(__('Page {{page}} of {{pages}} - {{count}} results')) ?></strong></p>
					</footer>
				</div>
			</section>
		</div>
		<?= $this->element('side_panel') ?>
		</div>
	</div>
</div>