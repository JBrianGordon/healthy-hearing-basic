<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */

$this->Html->script('dist/common.min.js', ['block' => true]);
?>
<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-sm-12 panel-parent">
                    <section class="panel">
                        <div class="panel-body clinicLayout">
                            <div class="panel-section expanded">
                                <div class="single_review ">
                                    <div class="quote">
                                        <p class="lead">"<?= $review->body ?>"</p>
                                    </div>
                                    <div class="author">
                                        <?= $review->first_name . " " . $review->last_name . "&nbsp;&nbsp;" ?>
                                        <?= $this->Clinic->generateHalfStars($review->rating) ?><br>
                                        <?= date('m/j/Y', strtotime($review->created)) ?>
                                        <?= $this->Clinic->reviewVerification($review) ?>
                                    </div>
                                </div>
                                <div class="reviews form content">
                                    <?= $this->Form->create($review) ?>
                                    <fieldset>
                                        <?= $this->Form->control('response', ['label' => ['class' => 'col-sm-3 tar'], 'class' => 'col-sm-9', 'required' => true]) ?>
                                    </fieldset>
                                    <p class="pull-right pt20">You are responsible for ensuring that your clinic's review response does not violate any applicable privacy laws or our <a href="/terms-of-use" target="_blank">Terms of Use</a>.</p>
                                    <div class="form-actions">
                                        <?= $this->Form->button('Save response', ['class' => 'btn btn-primary btn-lg']) ?>
                                    </div>
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
