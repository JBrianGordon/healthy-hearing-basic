<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$hideLearnMore = true;

$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => ($siteName . ' sitemap page'), 'url' => '/sitemap']]);

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
                                <h1 class="text-primary blog-title"><?= Configure::read('siteName') . ' sitemap' ?></h1>
                                <p class="lead">Our sitemap page provides top level links to major sections of our website.</p>
                                <h4>
                                    <a href="/help" class="text-link">Hearing aids and hearing loss information - Find what you need to make good choices about hearing aids.</a>
                                </h4>
								<ul class="no-bullets mb60 ml20">
									<?php foreach($wikis as $wiki): ?>
										<li><a href="/help/<?= $wiki['slug'] ?>" class="text-link"><?= $wiki['title_h1'] ?></a></li>
									<?php endforeach; ?>
								</ul>

                                <?php if (Configure::read('showReports')): ?>
                                    <h4><a href="/report" class="text-link">Healthy Hearing Report</a></h4>
                                    <ul class="no-bullets mb60 ml20">
                                        <li><a href="/feeds" class="text-link">Subscribe to RSS feed</a></li>
                                        <li><a href="/newsletter" class="text-link">Subscribe to email newsletters</a></li>
                                    </ul>
                                <?php endif; ?>

                                <h4><a href="/hearing-aids" class="text-link">Find a clinic - Get the help you need from our directory of <?= Configure::read('roughProviderCount') ?> hearing aid professionals in <?= Configure::read('fullCountryName') ?>.</a></h4>
                                <ul class="no-bullets mb60 ml20">
                                    <li><a href="/hearing-aids" class="text-link">Browse by <?= $stateLabel ?></a></li>
                                </ul>

                                <?php if (Configure::read('showManufacturers')): ?>
                                    <h4><a href="/hearing-aid-manufacturers" class="text-link">Hearing aid companies - Research information on the various hearing aid manufacturers and their products</a></h4>
                                    <ul class="no-bullets ml20">
                                        <?php foreach($corps as $corp): ?>
                                            <li><a href="/<?= $corp['slug'] ?>" class="text-link"><?= $corp['title']?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                </div>
                <?= $this->element('side_panel', ['hideLearnMore' => $hideLearnMore]) ?>
            </div>
        </div>
    </div>
</div>