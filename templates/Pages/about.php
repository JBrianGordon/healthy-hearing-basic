<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */

	use Cake\Core\Configure;

	$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => ('About '.Configure::read('siteName')), 'url' => '/contact-us']]);
	
	$this->Html->script('dist/common.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
      <div class="row">
        <div class="backdrop-container">
          <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row noprint">
                <div class="col-sm-9 inverse">
                    <?= $this->Breadcrumbs->render(); ?>
                    <?= $this->element('breadcrumb_schema') ?>
                    <div id="ellipses">...</div>
                </div>
            </div>
	        <div class="row">
	          	<div class="col-md-12">
	          		<section class="panel">
	          			<div class="panel-body">
		          			<div class="panel-section expanded">
		            			<div class="about">
									<?= $page->content ?>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>