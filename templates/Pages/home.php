<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Html->script('dist/common.min', ['block' => true]);
?>

<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/autoComplete.min.js"></script>

<div class="container-fluid site-body home">
    <div class="row pt0">
        <div class="backdrop-container">
            <div class="backdrop backdrop-home-gradient backdrop-height"></div>
            <picture class="backdrop-home">
                <source media="(max-width: 991px)" sizes="1px" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w"/>
                <source media="(min-width:992px)" srcset="/img/home-hero.webp 1x, /img/home-hero-2x.webp 2x">
                <img class="h-100" src="/img/home-hero.webp" alt="smiling doctor giving a consultation">
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
                            <h2>Online hearing test</h2>
                            <p>Curious how you’re hearing? Take our simple test to help you assess if you would benefit from a checkup with a hearing healthcare professional! </p>
                            <br>
                            <p>
                                <a href="/help/online-hearing-test" class="btn btn-primary">Launch online hearing test</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-5 col-lg-offset-1 over-backdrop pull-right" style="min-height:1350px;float:right">
                <div class="panel panel-secondary">
                    <header class="panel-heading text-center">
                      Find a clinic
                    </header>
                    <div class="panel-body">
                        <div class="panel-section text-center">
                            <input id="autoCompleteJs">
                            <p class="btn-set text-center">
                                <a href="/hearing-aids" class="btn btn-secondary">Browse by <?= $stateLabel ?></a>
                            </p>
                        </div>
                        <div class="panel-section d-none d-sm-block">
                            <div data-hh-map></div>
                            <p class="text-center">
                                <button class="btn btn-secondary d-none d-md-block m-auto" data-bs-toggle="modal" data-bs-target="#enlargeMap"><span class="hh-icon-plus"></span> Enlarge Map</button>
                            </p>
                        </div>
                        <?php if (!empty($clinicsNearMe)): ?>
                            <div class="panel-section text-center">
                                <h2 class="h3">Hearing clinics near me</h2>
                                <?= $this->element($this->Clinic->nearMe($clinicsNearMe)); ?>
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
                                <section class="panel-section blog-previews hidden-xs hidden-sm">
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

<script type="text/javascript">
    const autoCompleteJS = new autoComplete({
        selector: "#autoCompleteJs",
        placeHolder: "Search for a city, state, or ZIP...",
        debounce: 300,
        data: {
            src: async (query) => {
                try {
                    const response = await fetch(`/locations/autocomplete?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    return await response.json();
                } catch (error) {
                    console.error('Autocomplete fetch error:', error);
                    return [];
                }
            },
            keys: ['name'],
            cache: false
        },
        resultItem: {
            highlight: true
        },
        events: {
            input: {
                selection: (event) => {
                    const selection = event.detail.selection.value;
                    document.querySelector("#autoCompleteJs").value = selection.name;

                    window.location.href = selection.url;
                }
            }
        }
    });
</script>

<?php $this->end(); ?>
