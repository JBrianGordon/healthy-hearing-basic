<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
use App\Enums\Model\Review\ReviewOrigin;
use App\Enums\Model\Review\ReviewRating;
use App\Enums\Model\Review\ReviewResponseStatus;
use App\Enums\Model\Review\ReviewStatus;
use Cake\Core\Configure;
?>
<header class="col-sm-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Review Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link( ' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi-search'])?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi-plus-lg']) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-sm-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="reviews form content">
                            <?= $this->Form->create($review) ?>
                            <fieldset>
                                <?php
                                    //*** TODO: add location search functionality: ***/
                                    echo $this->Form->control('location_search');
                                    echo $this->Form->control('location_id', ['label' => 'Location Id', 'required' => true, 'type' => 'text']);
                                    echo $this->Form->control('body');
                                    echo $this->Form->control('character_count', ['required' => false, 'disabled' => true]);
                                    echo $this->Form->control('first_name');
                                    echo $this->Form->control('last_name', ['required' => true]);
                                    echo $this->Form->control('zip', ['label' => Configure::read('zipLabel')]);
                                ?>
                                <?php
                                    echo $this->Form->control('origin', ['options' => ReviewOrigin::getOriginLabelArray()]);
                                    echo $this->Form->control('status', ['options' => ReviewStatus::getEditStatusLabelArray()]);
                                ?>
                                <em class="col-sm-9 col-sm-offset-3">Please note that statuses that are saved as "Published Negative" will be automatically changed to "Published" after the negative review email has been sent to the clinic.<br><br></em>
                                <?php
                                    echo $this->Form->control(
                                        'rating', [
                                            'type' => 'select',
                                            'options' => array_combine(
                                                ReviewRating::getRatingValueArray(),
                                                ReviewRating::getRatingLabelArray(),
                                            ),
                                        ]
                                    );
                                    echo $this->Form->control('response');
                                    echo $this->Form->control('response_status', ['required' => false, 'options' => ReviewResponseStatus::getResponseStatusLabelArray()]);
                                ?>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Save Review', ['class' => 'btn btn-primary btn-lg']) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>