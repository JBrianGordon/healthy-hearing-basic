<?php
use Cake\Core\Configure;

$this->Html->script('dist/common.min', ['block' => true]);
?>
<div class="container-fluid site-body home">
    <div class="row pt0">
        <div class="backdrop-container">
            <div class="backdrop backdrop-home-gradient backdrop-height"></div>
            <picture class="backdrop-home">
                <source media="(max-width: 991px)" sizes="1px" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w"/>
                <source media="(min-width:992px)" srcset="/img/home-hero.png">
                <img src="/img/home-hero.png" alt="smiling doctor giving a consultation" height="520">
            </picture>
            <div class="backdrop backdrop-home-gradient backdrop-opacity backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row">
                <?php //***TODO: uncomment when flash elements added*** echo $this->element('flashes'); ?>
                <div class="col-sm-7 col-lg-6 over-backdrop">
                    <section class="intro-text inverse">
                        <h1 class="hero-headline"><em>Be part of the </em><br>conversation</h1>
                        <p class="lead">
                            <p><?= $content ?></p>
                        </p>
                        <p class="btn-set">
                            <a href="<?= $this->Clinic->nearMeLink() ?>" class="near-me-link btn btn-default btn-lg">Show clinics near me</a>
                            <a href="/help/hearing-loss" class="btn btn-default btn-lg">Learn About Hearing Loss</a>
                            <a href="/help/hearing-aids" class="btn btn-default btn-lg">Learn About Hearing Aids</a>
                        </p>
                    </section>
                    <?php if (Configure::read('showHearingTest') && Configure::read('country') != 'US' && !$isMobileDevice): ?>
                        <div class="hearing-test">
                            <br>
                            <h3>Online hearing test</h3>
                            <p>Curious how you’re hearing? Take our simple test to help you assess if you would benefit from a checkup with a hearing healthcare professional! </p>
                            <br>
                            <p>
                                <a href="/help/online-hearing-test" class="btn btn-primary">Launch online hearing test</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            <div class="col-sm-5 col-lg-offset-1 over-backdrop right-desktop">
                <div class="panel panel-secondary">
                    <header class="panel-heading text-center">
                      Find a clinic
                    </header>
                    <div class="panel-body">
                        <div class="panel-section text-center">
                            <?php /*echo $this->element('locations/search', array(
                                'label' => 'City, '.$stateLabel.' or '.$zipShort,
                                'form_id' => 'homeform2',
                                'auto_id' => 'homeformsearchid2',
                                'search_id' => 'homeSearch2',
                                'btnId' => 'homeSearch2Btn'
                              ));*/ ?>
                            <br>
                            <p class="btn-set text-center">
                                <a href="/hearing-aids" class="btn btn-secondary">Browse by <?php echo $stateLabel; ?></a>
                            </p>
                        </div>
                        <div class="panel-section hidden-xs">
                            <?php if (Configure::read('country') == 'US'): ?>
                                <div data-hh-map></div>
                            <?php else: ?>
                                <object data="<?php Configure::read('map'); ?>" type="image/svg+xml" id="interactiveMap"></object>
                            <?php endif; ?>
                            <p class="text-center">
                                <button class="btn btn-secondary hidden-sm" data-toggle="modal" data-target="#enlargeMap"><span class="hh-icon-plus"></span> Enlarge Map</button>
                            </p>
                        </div>
                        <?php if (!empty($clinicsNearMe)): ?>
                            <div class="panel-section text-center">
                                <h4>Hearing clinics near me</h4>
                                <?php echo $this->element($this->Clinic->nearMe($clinicsNearMe)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ((Configure::read('showHearingTest') && Configure::read('country') == 'US') || $isMobileDevice): ?>
                    <div class="hearing-test">
                        <br>
                        <h3>Online hearing test</h3>
                        <p>Curious how you’re hearing? Take our simple test to help you assess if you would benefit from a checkup with a hearing healthcare professional! </p>
                        <br>
                        <p>
                            <a href="/help/online-hearing-test" class="btn btn-primary">Launch online hearing test</a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (Configure::read('showReports')): ?>
                <div class="col-sm-7 col-lg-6 mobile-clear">
                    <div class="panel panel-light">
                        <?php //echo $this->element('content/latest'); ?>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <?php $this->append('bs-modals'); ?>
        <div class="modal fade" id="enlargeMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4>Pick a <?php echo $stateLabel; ?></h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <?php if (Configure::read('country') == 'US'): ?>
                                <div data-hh-map></div>
                            <?php else: ?>
                                <object data="<?php echo Configure::read('map'); ?>" type="image/svg+xml" id="bigMap" style="width: 60%;"></object>
                            <?php endif; ?>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
