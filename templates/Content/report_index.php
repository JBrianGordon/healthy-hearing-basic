<?php
use Cake\Routing\Router;	

$this->Html->script('dist/content.min', ['block' => true]);
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'The Healthy Hearing Report', 'url' => ''],
]);
?>
<div class="container-fluid site-body blog">
	<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
	</div>
	<div class="container">
		<header class="col-md-12 inverse">
			<?= $this->Breadcrumbs->render() ?>
		</header>
		<div class="row">
		<div class="col-lg-9 float-start">
			<?php if (!empty($reportIntro)): ?>
				<section class="panel">
					<div class="panel-body">
						<header class="panel-section expanded"><?php echo $reportIntro; ?></header>
					</div>
				</section>
			<?php endif; ?>
			<section class="panel">
				<div class="panel-body">
					<div class="row blog-posts">
						<div class="col-sm-12 left-posts">
							<?php foreach ($reports as $report): ?>
								<div class="blog-post">
									<div class="p10">
										<span class="subtitle text-light mobile"><?= $report->type; ?></span>
										<h3 class="blog-title mobile"><?= $this->Html->link($report->title, $report->hh_url, $options = ['class' => 'text-link']) ?></h3>
										<p class="text-caption blog-byline mobile"><?= date_format($report->last_modified, 'F j, Y') ?></p>
										<p class="blog-image"><?php echo $this->Editorial->image($report); ?></p>
										<p class="blog-intro mobile" style="clear: both"><?= $report->short; ?></p>
									</div>
									<div class="p10 right-content">
										<span class="subtitle text-light"><?= $report->type; ?></span>
										<h3 class="blog-title"><?= $this->Html->link($report->title, $report->hh_url, $options = ['class' => 'text-link']) ?></h3>
										<p class="text-caption blog-byline"><?= date_format($report->last_modified, 'F j, Y') ?></p>
										<p class="blog-intro" style="clear: both"><?= $report->short; ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<footer class="panel-section expanded blog-pagination">
						<?php
						$paginationOptions = [
							'modulus' => 6,
							'url' => ['prefix'=>false, 'controller'=>'content', 'action'=>'report_index']
						];
						?>
						<?= $this->element('pagination', ['options'=>$paginationOptions]) ?>
					</footer>
				</div>
			</section>
		</div>
		<?= $this->element('side_panel') ?>
		</div>
	</div>
</div>