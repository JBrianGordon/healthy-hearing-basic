<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */

$this->Vite->script('common','common-vite');
use BootstrapUI\View\Helper\FormHelper;
?>

<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container noprint">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body clinicLayout">
                            <div class="panel-section expanded">
                                <?= $this->element('locations/review_body', ['review' => $review, 'clinicName' => $location->title]) ?>

                                <?php
                                    echo $this->Form->create($review, [
                                        'align' => [
                                            FormHelper::GRID_COLUMN_ONE => 3,
                                            FormHelper::GRID_COLUMN_TWO => 9,
                                        ],
                                    ]);
                                ?>
                                <fieldset>
                                    <?= $this->Form->control('response', [
                                            'required' => true,
                                            'label' => [
                                                'class' => 'text-end'
                                            ],
                                        ])
                                    ?>
                                </fieldset>

                                <p class="text-end">You are responsible for ensuring that your clinic's review response does not violate any applicable privacy laws or our <a href="/terms-of-use" target="_blank">Terms of Use</a>.</p>

                                <?=
                                    $this->Form->button('Save Response', [
                                        'class' => 'btn btn-primary'
                                    ])
                                ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>