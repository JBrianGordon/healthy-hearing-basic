<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review[]|\Cake\Collection\CollectionInterface $reviews
 */
// TODO: Add JS for "Check for IP address warnings"
use Cake\Core\Configure;
use App\Model\Entity\Review;
use App\Model\Entity\Location;

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
$filter ??= null;
// Add additional search fields
$fields['listing_type'] = 'string';
?>
<div class="reviews index content">
    <?= $this->Html->link(__('New Review'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reviews') ?></h3>
    <?= $this->element('pagination') ?>
    <div class="row justify-content-end">
        <?php if ($this->Search->isSearch()) : ?>
            <div class="col col-md-auto">
                <?= $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-info text-light', 'role' => 'button']) ?>
            </div>
        <?php endif; ?>
        <div class="col col-md-auto">
            <button class="btn btn-primary mb-3" type="button"
                data-bs-toggle="collapse" data-bs-target="#advancedSearch"
                aria-expanded="false" aria-controls="advancedSearch"
            >
                + Advanced
            </button>
        </div>
    </div>
    <div class="collapse" id="advancedSearch">
        <?php
        echo $this->Form->create(null, [
            'class' => 'bg-light mb-3 p-5',
            'valueSources' => 'query',
        ]);
        ?>
        <?php $column = 1; ?>
        <?php foreach ($fields as $field => $type): ?>
            <?php
            $label = '';
            $options = false;
            $empty = false;
            switch ($field) {
                case 'status':
                    $type = 'select';
                    $options = Review::$statuses;
                    $empty = '(All statuses)';
                    break;
                case 'response_status':
                    $type = 'select';
                    $options = Review::$responseStatuses;
                    $empty = '(All response statuses)';
                    break;
                case 'origin': 
                    $type = 'select';
                    $options = Review::$origins;
                    $empty = '(All origins)';
                    break;
                case 'rating': 
                    $type = 'select';
                    $options = Review::$ratings;
                    $empty = '(All ratings)';
                    break;
                case 'listing_type': 
                    $type = 'select';
                    $options = Location::$listingTypes;
                    $empty = '(All listing types)';
                    break;
            }
            ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?php echo $this->Admin->formInput($field, $type, $label, $options, $empty); ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?php echo $this->Admin->formInput($field, $type, $label, $options, $empty); ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
        <?php
        echo $this->Form->button('Filter', [
            'type' => 'submit',
            'class' => 'me-3 btn btn-default',
        ]);
        echo $this->Form->end();
        ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><input type="checkbox" class="checkall" /></th>
                    <th><?= $this->Paginator->sort('status') ?><br><?= $this->Paginator->sort('origin') ?></th>
                    <th><?= $this->Paginator->sort('character_count', 'Characters') ?><br><?= $this->Paginator->sort('is_spam', 'Spam') ?></th>
                    <th><?= $this->Paginator->sort('body', 'Review') ?></th>
                    <th nowrap><?= $this->Paginator->sort('location_id', 'Clinic') ?><br><?= $this->Paginator->sort('Location.listing_type', 'Listing Type') ?><br>Reviews</th>
                    <th><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('zip') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td class="center"><?php echo $this->Form->checkbox("Review.{$review->id}.id", array(
                            'value' => $review->id,
                            'hiddenField' => 0,
                            'class' => 'checkbox'
                        )); ?></td>
                        <td><?= $this->Clinic->reviewStatus($review->status); ?>
                            <?= $this->Clinic->reviewOrigin($review->origin); ?><br><br>
                            <?= $this->Clinic->reviewResponseStatus($review->response_status); ?></td>
                        <td>
                            <span class="badge bg-info"><?= $review->character_count; ?></span><br>
                            <?php echo ($review->is_spam) ? "<strong>Spam</strong>" : ""; ?><br>
                            <?php if (!empty($review->location->is_yhn)): ?>
                                <?php if (Configure::read('isYhnImportEnabled')): ?>
                                    <span class='badge bg-yhn'>YHN</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($review->location->is_oticon): ?>
                                <span class='badge bg-oticon'>OTI</span>
                            <?php endif; ?>
                            <?php if (!empty($review->location->is_retail)): ?>
                                <span class='badge bg-primary'>Retail</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $this->element('locations/admin_review_body', ['review' => $review]); ?>
                            <?php if ($review->origin == Review::ORIGIN_ONLINE): ?>
                                <button type="button" class='btn btn-xs btn-default ipCheckBtn' data-id="<?php echo $review->id; ?>">Check for IP address warnings</button>
                                <span class="label label-success" style="display:none;" id="ipSuccess<?php echo $review->id; ?>"><strong><span class="glyphicon glyphicon-ok"></span> No IP warnings</strong></span>
                                <span class="label label-danger" style="display:none;" id="ipWarning<?php echo $review->id; ?>"><strong><span class="glyphicon glyphicon-warning-sign"></span> IP warning</strong></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $this->Html->link($review->location_id,
                                ['controller' => 'locations', 'action' => 'edit', $review->location_id],
                                ['class' => 'btn btn-xs btn-default']); ?><br>
                            <?php if (Configure::read('isTieringEnabled')): ?>
                                <?php echo $this->Clinic->badgeListingType($review->location->listing_type); ?>
                            <?php endif; ?>
                            <?php echo $this->Clinic->badgeReview(null, $review->location->reviews_approved); ?>
                        </td>
                        <td style="min-width:110px">
                            <!-- Review created date is saved in server timezone (central). Display as Eastern time. -->
                            <?php echo dateTimeCentralToEastern($review->created); ?><br>
                            <span class="badge bg-info"><?php echo $review->zip; ?></span>
                        </td>
                        <td class="actions" nowrap>
                            <div class="btn-group-vertical btn-group-xs">
                                <?php echo $this->Html->link("View/Edit", array('admin' => true, 'action' => 'edit', $review->id), array('escape' => false, 'class' => 'btn btn-default')); ?>
                                <?php echo $this->Html->link("Publish Positive", array('admin' => true, 'action' => 'approve', $review->id, $filter), array('escape' => false, 'class' => 'btn btn-default'), "Are you sure you want to publish ID #{$review->id} (positive)?"); ?>
                                <?php echo $this->Html->link("Publish Negative", array('admin' => true, 'action' => 'deny', $review->id, $filter), array('escape' => false, 'class' => 'btn btn-default'), ['confirm' =>"Are you sure you want to publish ID #{$review->id} (negative)?"]);    ?>
                                <?php echo $this->Html->link("Quick Spam", array('admin' => true, 'action' => 'spam', $review->id, $filter), ['escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to mark ID #{$review->id} as Spam?"]);    ?>
                                <!-- Phone reviews will be ignored instead of deleted -->
                                <?php $ignoreOrDelete = ($review->origin == Review::ORIGIN_PHONE) ? "Ignore" : "Delete"; ?>
                                <?php echo $this->Form->postLink('<i class="bi bi-trash"></i> '.$ignoreOrDelete, ['admin' => true, 'action' => $ignoreOrDelete, $review->id, $filter], ['escape' => false, 'class' => 'btn btn-danger', 'confirm' => "Are you sure you want to {$ignoreOrDelete} #{$review->id}?"]); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
