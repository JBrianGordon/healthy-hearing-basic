<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

// Update for sitemaps

// $this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => ('Contact '.Configure::read('siteName')), 'url' => '/sitemap']]);

$this->Html->script('dist/common.min', ['block' => true]);
?>
<div class="container-fluid site-body blog">
    <div class="row">
        <div class="backdrop backdrop-gradient backdrop-height"></div>
        <div class="container">
            <div class="row noprint">
                <div class="col-sm-9 inverse">
                    <?= $this->Breadcrumbs->render(); ?>
                    <?= $this->element('breadcrumb_schema') ?>
                    <div id="ellipses">...</div>
                </div>
            </div>
            <div class="row page-content">
                <div class="col-lg-9 float-start">
                    <article class="panel">
                        <div class="panel-body anchor-underline">
                            <div class="panel-section expanded">
                                <h1 class="text-primary blog-title">Sitemap</h1>
								<ul class="no-bullets mb60 ml20">
									<?php foreach($wikis as $wiki): ?>
										<li><?php echo $wiki['title_h1']; ?></li>
									<?php endforeach; ?>
								</ul>
                            </div>
                        </div>
                    </article>
                </div>
                <?= $this->element('side_panel') ?>
            </div>
        </div>
    </div>
</div>