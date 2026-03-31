<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */

	use Cake\Core\Configure;

	$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => (Configure::read('siteName') . ' Terms of use'), 'url' => '/terms-of-use']]);
	
	$this->Vite->script('common','common');
?>
<div class="container-fluid site-body fap-cities">
  <div class="row">
    <div class="backdrop-container">
      <div class="backdrop backdrop-gradient backdrop-height"></div>
    </div>
    <div class="container">
      <div class="row">
        	<header class="col-md-12 inverse">
            <div class="row noprint">
                <div class="col-sm-9 inverse">
                    <?= $this->Breadcrumbs->render(); ?>
                    <?= $this->element('breadcrumb_schema') ?>
                    <div id="ellipses">...</div>
                </div>
            </div>
					</header>
        	<div class="col-md-12">
        		<section class="panel">
        			<div class="panel-body">
          			<div class="panel-section expanded">
            			<div class="p20">
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