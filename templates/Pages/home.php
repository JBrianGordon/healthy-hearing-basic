<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Vite->script('common','common');
?>

<div class="container-fluid site-body home">
    <div class="row pt0">
        <div class="backdrop-container">
            <div class="backdrop backdrop-home-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-6 over-backdrop">
                    <section class="intro-text">
                        <h1 class="hero-headline"><?= Configure::read('heroHeadline') ?></h1>
                        <p class="lead">
                            <p><?= $content ?></p>
                        </p>
                        <p class="btn-set">
                            <a href="<?= $this->Clinic->nearMeLink() ?>" class="near-me-link btn btn-default btn-lg">Show hearing clinics near me</a>
                            <a href="/help/hearing-loss" class="btn btn-default btn-lg ml0 mb0">Got hearing loss? Learn more</a>
                            <a href="/help/<?= Configure::read('isCallAssistEnabled') ? '' : 'hearing-loss/'; ?>tinnitus" class="btn btn-default btn-lg ml0">Got tinnitus? Learn more</a>
                        </p>
                    </section>
                    <?php if (Configure::read('showHearingTest') && Configure::read('country') != 'US' && !$isMobileDevice): ?>
                        <div class="panel panel-primary hearing-test p0 mb30">
                            <header class="panel-heading text-center">Online hearing test</header>
                            <div class="panel-body">
                                <br>
                                <p class="pr25 pl25">Curious how you’re hearing? Take our simple test to help you assess if you would benefit from a checkup with a hearing healthcare professional! </p>
                                <p class="pb25 pr25 pl25 pt10">
                                <a href="/help/online-hearing-test" class="btn btn-primary">Launch online hearing test</a>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 col-xl-5 over-backdrop pull-right mb30">
                    <div class="panel panel-secondary">
                        <header class="panel-heading text-center">
                        Find a clinic
                        </header>
                        <div class="panel-body">
                            <div class="panel-section text-center">
                                <input id="FACHomepagePanel" class="autoCompleteJs w-100">
                                <p class="btn-set text-center">
                                    <a href="/hearing-aids" class="btn btn-secondary">Browse by <?= $stateLabel ?></a>
                                </p>
                            </div>
                            <?php if (!empty($clinicsNearMe)): ?>
                                <div class="panel-section text-center">
                                    <h2 class="h3">Hearing clinics near me</h2>
                                    <?= $this->element($this->Clinic->nearMe($clinicsNearMe)); ?>
                                </div>
                            <?php endif; ?>
                            <div class="panel-section d-none d-sm-block">
                                <div data-hh-map></div>
                                <p class="text-center">
                                    <button class="btn btn-secondary d-none d-md-block m-auto" data-bs-toggle="modal" data-bs-target="#enlargeMap"><span class="hh-icon-plus"></span> Enlarge Map</button>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if ((Configure::read('showHearingTest') && Configure::read('country') == 'US') || $isMobileDevice): ?>
                        <div class="panel panel-primary hearing-test p0">
                            <header class="panel-heading text-center">Online hearing test</header>
                            <div class="panel-body">
                                <br>
                                <p class="pl25 pr25">Curious how you’re hearing? Take our simple test to help you assess if you would benefit from a checkup with a hearing healthcare professional! </p>
                                <p class="pb25 pr25 pl25 pt10">
                                <a href="/help/online-hearing-test" class="btn btn-primary">Launch online hearing test</a>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (Configure::read('showReports')): ?>
                <div class="col-lg-7 col-xl-6 mobile-clear p0">
                    <div class="report-panel panel panel-light">
                        <?php if (!empty($articles)): ?>
                            <header class="panel-heading text-center">
                            <h2>The Healthy Hearing Report</h2>
                            </header>
                            <div class="panel-body">
                                <section class="panel-section hidden-xs hidden-sm">
                                    <p class="lead">Our daily dose of original articles, news and interviews to keep you current about hearing health and hearing aids.</p>
                                </section>
                                <section class="panel-section">
                                    <div class="row d-flex">
                                        <div class="col-md-2 col-xs-3">
                                        <?php //convert articles object to array for easier iteration
                                            $articlesArray = $articles->toArray();
                                        ?>
                                        <?= $this->Editorial->dateHome($articlesArray[0]) ?>
                                        </div>
                                        <div class="col-md-10 col-xs-9">
                                        <div class="subtitle">Article</div>
                                        <h3 class="mt0"><?= $this->Editorial->titleLink($articlesArray[0], false, ['class' => 'text-link']) ?></h3>
                                        <p>
                                            <a href="<?= Router::url($articles->first()->get('hh_url')) ?>" class="btn btn-light">Read Post</a>
                                        </p>
                                        <p class="blog-byline text-caption">
                                            <em>Contributed by <?= $this->Editorial->getAuthorsByline($articles->first()->primary_author) ?></em>
                                        </p>
                                        <p>
                                            <?= $articlesArray[0]->get('short') ?>
                                        </p>
                                        </div>
                                    </div>
                                </section>
                                <section class="panel-section blog-previews d-none d-lg-block">
                                    <?php for($i = 1; $i <= 3; $i+=2): ?>
                                        <div class="row preview-row d-flex">
                                        <div class="col-md-6 blog-preview">
                                            <div class="row">
                                            <div class="col-md-3">
                                                <?= $this->Editorial->dateHome($articlesArray[$i], ['large' => false]) ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="subtitle">Article</div>
                                                <?= $this->Editorial->titleLink($articlesArray[$i], false, ['class' => 'text-link text-small']) ?>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 blog-preview">
                                            <div class="row">
                                            <div class="col-md-3">
                                                <?= $this->Editorial->dateHome($articlesArray[$i + 1], ['large' => false]) ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="subtitle">Article</div>
                                                <?= $this->Editorial->titleLink($articlesArray[$i + 1], false, ['class' => 'text-link text-small']) ?>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    <?php endfor; ?>
                                </section>
                                <section class="panel-section">
                                    <p class="lead tac">
                                        <?= $this->Html->link(
                                            'See all reports', 
                                            ['controller' => 'Content', 'action' => 'reportIndex'], 
                                            ['class' => 'text-link']
                                        ) ?>
                                    </p>
                                </section>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php $this->append('bs-modals'); ?>
        <div class="modal fade" id="enlargeMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header p15">
                        <h4>Pick a <?= $stateLabel ?></h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div data-hh-map></div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end(); ?>
