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
// TODO: Add JS for "Check for IP address warnings"
use Cake\Core\Configure;

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
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
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value,
    ];
}
?>
<div class="reviews index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("<i class='bi bi-search'></i> Browse", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-plus-lg'></i> Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-download'></i> Export", ['action' => 'export'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-check-lg'></i> To Publish", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-search'></i> Find Spam", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-x-lg'></i> Clear Spam", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
    </div>
    <h3><?= __('Reviews') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <div class="table-responsive">
        <?= $this->Form->create(null, ['url' => ['action' => 'approveAll']]); ?>
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
                                <?= ReviewResponseStatus::from($review->origin)->getResponseStatusLabel(); ?>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= $review->character_count; ?></span><br>
                                <?php echo $review->is_spam ? '<strong>Spam</strong>' : ''; ?><br>
                                <?php if (!empty($review->location->is_yhn)) : ?>
                                    <?php if (Configure::read('isYhnImportEnabled')) : ?>
                                        <span class='badge bg-yhn'>YHN</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($review->location->is_oticon) : ?>
                                    <span class='badge bg-oticon'>OTI</span>
                                <?php endif; ?>
                                <?php if (!empty($review->location->is_retail)) : ?>
                                    <span class='badge bg-primary'>Retail</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $this->element('locations/admin_review_body', ['review' => $review]); ?>
                                <?php if (ReviewOrigin::from($review->origin) === ReviewOrigin::ORIGIN_ONLINE) : ?>
                                    <button type="button" class='btn btn-xs btn-default ipCheckBtn' data-id="<?php echo $review->id; ?>">Check for IP address warnings</button>
                                    <span class="label label-success" style="display:none;" id="ipSuccess<?php echo $review->id; ?>"><strong><span class="glyphicon glyphicon-ok"></span> No IP warnings</strong></span>
                                    <span class="label label-danger" style="display:none;" id="ipWarning<?php echo $review->id; ?>"><strong><span class="glyphicon glyphicon-warning-sign"></span> IP warning</strong></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link(
                                    $review->location_id,
                                    ['controller' => 'locations', 'action' => 'edit', $review->location_id],
                                    ['class' => 'btn btn-xs btn-default']
                                ); ?><br>
                                <?php if (Configure::read('isTieringEnabled')) : ?>
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
                                    <?php echo $this->Html->link('View/Edit', ['admin' => true, 'action' => 'edit', $review->id], ['escape' => false, 'class' => 'btn btn-default']); ?>
                                    <?php echo $this->Form->postLink('Publish Positive', ['admin' => true, 'action' => 'approve', $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to publish ID #{$review->id} (positive)?"]); ?>
                                    <?php echo $this->Form->postLink('Publish Negative', ['admin' => true, 'action' => 'deny', $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to publish ID #{$review->id} (negative)?"]); ?>
                                    <?php echo $this->Form->postLink('Quick Spam', ['admin' => true, 'action' => 'spam', $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-default', 'confirm' => "Are you sure you want to mark ID #{$review->id} as spam?"]); ?>
                                    <!-- Phone reviews will be ignored instead of deleted -->
                                    <?php $ignoreOrDelete = ReviewOrigin::from($review->origin) === ReviewOrigin::ORIGIN_PHONE ? 'Ignore' : 'Delete'; ?>
                                    <?php echo $this->Form->postLink('<i class="bi bi-trash"></i> ' . $ignoreOrDelete, ['admin' => true, 'action' => $ignoreOrDelete, $review->id], ['block' => true, 'escape' => false, 'class' => 'btn btn-danger', 'confirm' => "Are you sure you want to {$ignoreOrDelete} #{$review->id}?"]); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $this->Form->submit('Approve selected'); ?>
        <?= $this->Form->end(); ?>
        <?= $this->fetch('postLink'); ?>
    </div>
    <?= $this->element('pagination') ?>
</div>
