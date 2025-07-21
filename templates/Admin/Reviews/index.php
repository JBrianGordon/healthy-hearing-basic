<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review[]|\Cake\Collection\CollectionInterface $reviews
 */
use App\Enums\Model\Review\ReviewOrigin;
use App\Enums\Model\Review\ReviewResponseStatus;
use App\Enums\Model\Review\ReviewStatus;
use App\Model\Entity\Location;
use App\Model\Entity\Review;
use Cake\Core\Configure;

$queryParams = $this->request->getQueryParams();
$filter ??= null;
// Add additional search fields
$fields['listing_type'] = 'string';
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = $queryParams[$field] ?? null;
    $placeholder = null;
    if (in_array($type, ['date', 'datetime'])) {
        $value['start'] = $queryParams[$field . '_start'] ?? null;
        $value['end'] = $queryParams[$field . '_end'] ?? null;
    }
    switch ($field) {
        case 'status':
            $type = 'select';
            $options = ReviewStatus::getStatusLabelArray();
            $empty = '(All statuses)';
            break;
        case 'response_status':
            $type = 'select';
            $options = ReviewResponseStatus::getResponseStatusLabelArray();
            $empty = '(All response statuses)';
            break;
        case 'origin':
            $type = 'select';
            $options = ReviewOrigin::getOriginLabelArray();
            $empty = '(All origins)';
            break;
        case 'rating':
            $type = 'selectMultiple';
            $options = Review::$ratings;
            $empty = '(All ratings)';
            break;
        case 'listing_type':
            $type = 'select';
            $options = Location::$listingTypes;
            $empty = '(All listing types)';
            break;
    }
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value,
        'placeholder' => $placeholder
    ];
}

$this->Html->script('dist/admin_index_review.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Reviews Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link("<i class='bi bi-search'></i> Browse", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
                <?= $this->Html->link("<i class='bi bi-download'></i> Export", ['action' => 'export', '?' => $_searchParams], ['class' => 'btn btn-default', 'escape' => false]) ?>
                <?=
                    $this->Html->link(
                        "<i class='bi bi-check-lg'></i> To Publish", [
                            'action' => 'index',
                            '?' => ['status' => ReviewStatus::PENDING->value],
                        ], [
                            'class' => 'btn btn-default',
                            'escape' => false
                        ])
                ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Reviews</h2>
                <div class="reviews index content">
                    <?= $this->element('pagination') ?>
                    <?= $this->element('admin_filter', ['modelName' => 'review']) ?>
                    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
                    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
                    <div class="table-responsive">
                        <?= $this->Form->create(null, ['url' => ['action' => 'massAction'], 'class' => 'mb10']); ?>
                            <table class="table table-striped table-bordered table-sm mb20">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkall" /></th>
                                        <th><?= $this->Paginator->sort('status') ?><br><?= $this->Paginator->sort('origin') ?></th>
                                        <th><?= $this->Paginator->sort('character_count', 'Characters') ?><br><?= $this->Paginator->sort('is_spam', 'Spam') ?></th>
                                        <th><?= $this->Paginator->sort('body', 'Review') ?></th>
                                        <th nowrap><?= $this->Paginator->sort('location_id', 'Clinic') ?><br><?= $this->Paginator->sort('Location.listing_type', 'Listing Type') ?><br>Reviews</th>
                                        <th><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('zip', ['label' => Configure::read('zipLabel')]) ?></th>
                                        <th class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reviews as $review) : ?>
                                        <tr>
                                            <td class="center">
                                                <?= $this->Form->checkbox(
                                                    'ids[]',
                                                    [
                                                        'value' => $review->id,
                                                        'hiddenField' => false,
                                                        'class' => 'checkbox',
                                                    ]
                                                );
                                                ?>
                                            </td>
                                            <td>
                                                <?= ReviewStatus::from($review->status)->getStatusLabel(); ?>
                                                <?= ReviewOrigin::from($review->origin)->getOriginLabel(); ?>
                                                <br>
                                                <br>
                                                <?= ReviewResponseStatus::from($review->response_status)->getResponseStatusLabel(); ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= $review->character_count; ?></span><br>
                                                <?= $review->is_spam ? '<strong>Spam</strong>' : '' ?><br>
                                                <?php if (!empty($review->location->is_yhn)) : ?>
                                                    <?php if (Configure::read('isYhnImportEnabled')) : ?>
                                                        <span class='badge bg-yhn bi bi-globe2'> YHN</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if ($review->location->is_oticon) : ?>
                                                    <span class='badge bg-oticon bi bi-briefcase-fill'> OTI</span>
                                                <?php endif; ?>
                                                <?php if (!empty($review->location->is_retail)) : ?>
                                                    <span class='badge bg-primary'>Retail</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $this->element('locations/admin_review_body', ['review' => $review]) ?>
                                                <?php if (ReviewOrigin::from($review->origin) === ReviewOrigin::ORIGIN_ONLINE) : ?>
                                                    <button type="button" class='btn btn-xs btn-default ipCheckBtn' data-id="<?= $review->id; ?>">Check for IP address warnings</button>
                                                    <span class="badge bg-success" style="display:none;" id="ipSuccess<?= $review->id; ?>"><strong><span class="bi bi-check-lg" style="font-size: 1.3rem;"></span> No IP warnings</strong></span>
                                                    <span class="badge bg-danger" style="display:none;" id="ipWarning<?= $review->id; ?>"><strong><span class="bi bi-exclamation-triangle" style="font-size: 1.3rem;"></span> IP warnings</strong></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $this->Html->link(
                                                    $review->location_id,
                                                    ['controller' => 'locations', 'action' => 'edit', $review->location_id],
                                                    ['class' => 'btn btn-xs btn-default']
                                                ) ?><br>
                                                <?php if (Configure::read('isTieringEnabled')) : ?>
                                                    <?= $this->Clinic->badgeListingType($review->location->listing_type) ?>
                                                <?php endif; ?>
                                                <?= $this->Clinic->badgeReview($review->location->reviews_approved) ?>
                                            </td>
                                            <td style="min-width:110px">
                                                <!-- Review created date is saved in server timezone (central). Display as Eastern time. -->
                                                <?= dateTimeCentralToEastern($review->created) ?><br>
                                                <span class="badge bg-info"><?= $review->zip ?></span>
                                            </td>
                                            <td class="actions p5" nowrap>
                                                <div class="btn-group-vertical btn-group-xs">
                                                    <?= $this->Html->link('View/Edit', ['action' => 'edit', $review->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
                                                    <?= $this->Form->postLink('Publish Positive', ['action' => 'approve', $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to publish ID #{$review->id} (positive)?"]) ?>
                                                    <?= $this->Form->postLink('Publish Negative', ['action' => 'deny', $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to publish ID #{$review->id} (negative)?"]) ?>
                                                    <?= $this->Form->postLink('Quick Spam', ['action' => 'spam', $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to mark ID #{$review->id} as spam?"]) ?>
                                                    <!-- Phone reviews will be ignored instead of deleted -->
                                                    <?php $ignoreOrDelete = ReviewOrigin::from($review->origin) === ReviewOrigin::ORIGIN_PHONE ? 'Ignore' : 'Delete'; ?>
                                                    <?= $this->Form->postLink('<i class="bi bi-trash"></i> ' . $ignoreOrDelete, ['action' => $ignoreOrDelete, $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-danger', 'confirm' => "Are you sure you want to {$ignoreOrDelete} #{$review->id}?"]) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= $this->Form->button('Delete Selected', ['id' => 'mass_delete', 'class' => 'btn btn-danger', 'type' => 'submit', 'name' => 'massAction', 'value' => 'deleteAllSelected', 'confirm' => 'Are you sure you want to delete the selected reviews?']) ?>
                            <?= $this->Form->button('Publish Positive Selected', ['id' => 'mass_approve', 'class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'massAction', 'value' => 'approveAllSelected', 'confirm' => 'Are you sure you want to approve the selected positive reviews?']) ?>
                        <?= $this->Form->end() ?>
                        <?= $this->fetch('postLink') ?>
                    </div>
                    <?= $this->element('pagination') ?>
                </div>
            </div>
        </div>
    </section>
</div>