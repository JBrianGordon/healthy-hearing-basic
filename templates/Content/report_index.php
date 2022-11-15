<?php
$this->Html->script('dist/content.min', ['block' => true]); 
if (isset($search)) {
	$pageUrl = ['controller' => 'content', 'action' => 'search', $search];
} elseif (isset($tag) && strpos($this->request->here, 'tag') !== false) {
	$pageUrl = ['controller' => 'content', 'action' => 'tag', $tag];
} else {
	$pageUrl = ['controller' => 'content', 'action' => 'report_index'];
}
//Pagination in head
/***TODO: uncomment when paginator and router built out***
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
}*/
?>
<div class="container-fluid site-body fap-cities">
	<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
	</div>
	<div class="container">
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
										<!--- *** TODO: uncomment when contenthelper built out ***
										<span class="subtitle text-light mobile"><?php //echo $this->Content->getType(); ?></span>
										--->
										<h3 class="blog-title mobile"><?= $this->Html->link($report->title, $report->hh_url) ?></h3>
										<p class="text-caption blog-byline mobile"><?= $report->modified ?></p>
										<!--- *** TODO: uncomment when contenthelper built out ***
										<p class="blog-image"><?php //echo $this->Content->image($report); ?></p>
										<p class="blog-intro mobile" style="clear: both"><?php //echo $this->Content->get('short'); ?></p>
										--->
									</div>
									<div class="p10 right-content">
										<!--- *** TODO: uncomment when contenthelper built out ***
										<span class="subtitle text-light"><?php //echo $this->Content->getType(); ?></span>
										--->
										<h3 class="blog-title"><?= $this->Html->link($report->title, $report->hh_url) ?></h3>
										<p class="text-caption blog-byline"><?= $report->modified ?></p>
										<!--- *** TODO: uncomment when contenthelper built out ***
										<p class="blog-intro" style="clear: both"><?php //echo $this->Content->get('short'); ?></p>
										--->
									</div>
								</div>
							<?php endforeach; ?>
							<?php foreach ($reports as $report): ?>
							<div>
							    <div>
							        <?= $this->Html->link($report->title, $report->hh_url) ?>
							    </div>
							    <div>
							        <?= $report->modified ?>
							    </div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<footer class="panel-section expanded blog-pagination">
						<?php
						echo $this->element('pagination',[
							'options' => [
								'url' => $pageUrl,
								'escape' => false
							]
						]); ?>
					</footer>
				</div>
			</section>
		</div>
        <div class="col-md-3 noprint float-end">
	      <!--- *** TODO: uncomment when Configure works *** -->
	      <?php //if (Configure::read('showAds') && $this->Content->isMobileDevice()): ?>
	      <!--- *** TODO: uncomment when render_ad works *** -->
	        <?php //echo $this->element('render_ad', array('ad' => $ad)); ?>
	      <?php //endif; ?>
	      <?php if ($this->request->controller != 'quiz_results'): ?>
	      	<!--- *** TODO: uncomment when locations/preferred built *** -->
	      	<?php //echo $this->element('locations/preferred'); ?>
	      <?php endif; ?>
	      <!--- *** TODO: uncomment when Configure works *** -->
          <?php //if (Configure::read('showHearingTest') && ($this->request->controller != 'quiz_results')): ?>
          <section class="panel" style="clear:both">
            <a href="/help/online-hearing-test">
	            <!--- *** TODO: uncomment when Content Helper built *** -->
	          <?php //if($this->Content->isMobileDevice()): ?>
              	<img src="/img/hh-hearing-check.svg" width="262" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive">
              <?php //else: ?>
              	<img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" class="img-responsive">
              <?php //endif; ?>
            </a>
          </section>
          <?php //endif; ?>
          <!--- *** TODO: uncomment when Configure works *** -->
          <?php //if (Configure::read('showAds') && !$this->Content->isMobileDevice()): ?>
          	<!--- *** TODO: uncomment when render_ad works *** -->
          	<?php //echo $this->element('render_ad', array('ad' => $ad)); ?>
          <?php //endif; ?>
          <section class="panel panel-secondary">
            <header class="panel-heading text-center">
              <h4>Find a clinic</h4>
            </header>
            <div class="panel-body pt20 pl20 pr20 pb20">
	          <!--- *** TODO: uncomment when lcoations/search is built *** -->
              <?php //echo $this->element('locations/search', array('label' => 'Enter city')); ?>
              <?php //echo $this->element('fac_config_text', ["locationsPage" => false]); ?>
            </div>
          </section>
	      <?php if ($this->request->controller == 'quiz_results'): ?>
	      	<?php echo $this->element('locations/preferred'); ?>
	      <?php endif; ?>
	      <!--- *** TODO: uncomment when Configure works *** -->
          <?php //if (Configure::read('showReports') && ($this->request->controller != 'quiz_results') && ($_SERVER['REQUEST_URI'] != '/report')): ?>
          <section class="panel panel-light blog-previews">
            <header class="panel-heading text-center">
              <h4>The Healthy Hearing Report</h4>
            </header>
            <div class="panel-body">
	          <!--- *** TODO: uncomment ClassRegistry works *** -->
              <?php //$articles = ClassRegistry::init('Content')->findLatest(4); ?>
              <?php //foreach ($articles as $content): ?>
                <div class="panel-section condensed blog-preview">
                  <div class="row">
                    <div class="col-md-3">
                      <?php //echo $this->Content->dateHome($content, array('large' => false)); ?>
                    </div>
                    <div class="col-md-9">
                      <div class="subtitle"><!--- *** TODO: uncomment when contenthelper built out ***<?php //echo $this->Content->getType(); ?>--></div>
                      <?php //echo $this->Content->titleLink($content, array('class' => 'text-link text-small')); ?>
                    </div>
                  </div>
                </div>
              <?php //endforeach; ?>
            </div>
            <!-- <footer>
              <p class="lead tac"><?php echo $this->Html->link('See all reports', array('controller' => 'content', 'action' => 'report_index'), array('class' => 'text-link')); ?></p>
            </footer> -->
          </section>
          <?php //endif; ?>
        </div>
		<ul class="pagination">
		    <?=
		        $this->Paginator->options([
		            'url' => [
		                'controller' => 'content',
		                'action' => 'report_index'
		            ]
		        ]);
		    ?>
		    <?= $this->Paginator->first("FIRST"); ?>
		    <?= $this->Paginator->prev(); ?>
		    <?= $this->Paginator->numbers(['modulus' => 2]); ?>
		    <?= $this->Paginator->next(">>"); ?>
		    <?= $this->Paginator->last("LAST"); ?>
		</ul>
	</div>
</div>