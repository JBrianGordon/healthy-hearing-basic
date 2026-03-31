<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */

	use Cake\Core\Configure;

	$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => 'RSS Feed', 'url' => '/feeds']]);
	
	$this->Vite->script('content','common');
?>
<div class="container-fluid site-body blog">
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
	          	<div class="col-lg-9">
	          		<section class="panel">
	          			<div class="panel-body anchor-underline">
		          			<div class="panel-section expanded">
		            			<div class="about">
									<?= $page->content ?>
								</div>
							</div>
						</div>
					</section>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
		</div>
	</div>
</div>