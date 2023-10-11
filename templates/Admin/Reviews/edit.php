<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
use App\Enums\Model\Review\ReviewStatus;
use App\Enums\Model\Review\ReviewRating;
use App\Enums\Model\Review\ReviewResponseStatus;

$this->Html->script('dist/review_index.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="clear"></div>
                <header class="col-sm-12 mt10">
                    <div class="panel panel-light">
                        <div class="panel-heading">Review Actions</div>
                        <div class="panel-body p10">
                            <div class="btn-group">
                                <?= $this->Html->link( ' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi-search'])?>
                                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi-plus-lg']) ?>
                                <?= $this->Form->postLink(' Delete', ['action' => 'delete', $review->id], ['confirm' => __('Are you sure you want to delete # {0}?', $review->id), 'class' => 'btn btn-danger bi-trash-fill', 'id' => 'deleteBtn']
                                ) ?>
                                <?= $this->Html->link( ' Edit Location', ['controller' => 'locations', 'action' => 'edit', $review->location_id], ['class' => 'btn btn-default bi-geo-alt-fill'])?>
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
                                            <h2 class="mt0">Edit Review</h2>
                                            <table class="table table-striped table-bordered table-condensed">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-sm-3 tar">Review ID</th>
                                                        <td class="col-sm-9"><?= $review->id ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-sm-3 tar">Created</th>
                                                        <td class="col-sm-9">
                                                            <?php
                                                                $formattedDate = strtotime($review->created);
                                                                date_default_timezone_set('America/New_York');
                                                                echo date('M. d Y, H:i T', $formattedDate);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                                    echo $this->Form->control('zip', ['label' => 'ZIP code']);
                                                    echo $this->Form->control('ip', ['disabled' => true]);
                                                ?>
                                                <div class="col-sm-9 col-sm-offset-3 p0">
                                                    <?= $this->Form->control('is_spam') ?>
                                                </div>
                                                <?php
                                                    echo $this->Form->control('origin');
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
                                                    echo $this->Form->control('denied_date', ['empty' => true]);
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
            </div>
        </div>
    </div>
</div>
