<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location[]|\Cake\Collection\CollectionInterface $locations
 */

use Cake\Core\Configure;
use App\Model\Entity\Location;
use App\Model\Entity\ImportStatus;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Routing\Router;

$this->Vite->script('admin_index_locations','admin');

$siteNameAbbr = Configure::read('siteNameAbbr');
$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);

// Add additional search fields
$fields['is_oticon'] = 'boolean';
$fields['has_url'] = 'boolean';
$fields['notes'] = 'string';
$fields['full_name'] = 'string';
$fields['using_logo'] = 'boolean';
$fields['using_photos'] = 'boolean';
$fields['using_flex_space'] = 'boolean';
$fields['using_badges'] = 'boolean';
$fields['using_linked_locations'] = 'boolean';
$fields['q'] = 'string';
// Fields to ignore
$ignore_fields = ['last_xml','lat','lon','facebook','twitter','youtube','slogan','about_us','payment','services','is_geocoded','filter_evening_weekend','filter_adult_hearing_test','filter_hearing_aid_fitting','redirect','landmarks','url','country','direct_book_url','direct_book_iframe','content_library_expiration','special_announcement_expiration','logo_url', 'logo_name', 'id_coupon','mobile_text','radius','created'];
if (!Configure::read('isCallAssistEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_call_assist', 'direct_book_type']);
}
if (!Configure::read('isYhnImportEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_yhn', 'is_cq_premier', 'is_iris_plus']);
}
if (!Configure::read('isCqpImportEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_cqp', 'cqp_tier', 'id_cqp_practice', 'id_cqp_office']);
}
if (!Configure::read('isOticonImportEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_oticon', 'oticon_tier', 'location_segment', 'entity_segment', 'is_title_ignore', 'is_address_ignore', 'is_phone_ignore', 'is_email_ignore']);
}
if (!Configure::read('isTieringEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_listing_type_frozen', 'frozen_expiration', 'is_grace_period', 'grace_period_end', 'is_service_agreement_signed', 'using_logo', 'using_photos', 'using_flex_space', 'using_linked_locations']);
}
foreach ($fields as $field => $type) {
    if (in_array($field, $ignore_fields)) {
        unset($fields[$field]);
    }
}
// Group fields into sections
$generalFieldList = ['q', 'id', 'id_oticon', 'id_parent', 'id_sf', 'id_yhn_location', 'id_cqp_practice', 'id_cqp_office', 'title', 'subtitle', 'address', 'address_2', 'city', 'state', 'zip', 'is_mobile', 'phone', 'email', 'priority', 'is_active', 'is_show', 'is_listing_type_frozen', 'oticon_tier', 'yhn_tier', 'cqp_tier', 'listing_type', 'is_oticon', 'is_retail', 'is_yhn', 'is_cqp', 'is_hh', 'is_cq_premier', 'is_iris_plus', 'notes', 'full_name', 'filter_has_photo', 'filter_insurance', 'is_call_assist', 'timezone', 'has_url', 'location_segment', 'entity_segment', 'direct_book_type', 'frozen_expiration', 'is_service_agreement_signed', 'optional_message', 'is_junk', 'is_email_allowed'];
$reviewFieldList = ['reviews_approved', 'review_status', 'average_rating', 'last_review_date'];
$changeMgmtFieldList = ['modified', 'last_contact_date', 'is_last_edit_by_owner', 'last_edit_by_owner_date', 'completeness', 'last_note_status', 'last_import_status', 'is_grace_period', 'grace_period_end', 'review_needed', 'email_status', 'phone_status', 'address_status', 'title_status', 'is_title_ignore', 'is_address_ignore', 'is_phone_ignore', 'is_email_ignore'];
$upgradeFieldList = ['feature_content_library', 'feature_special_announcement', 'logo_url', 'badge_coffee', 'badge_wifi', 'badge_parking', 'badge_curbside', 'badge_wheelchair', 'badge_service_pets', 'badge_cochlear_implants', 'badge_ald', 'badge_pediatrics', 'badge_mobile_clinic', 'badge_financing', 'badge_telehearing', 'badge_asl', 'badge_tinnitus', 'badge_balance', 'badge_home', 'badge_remote', 'badge_mask', 'badge_ear_cleaning', 'badge_oticon_foundation', 'badge_hearing_simulator', 'badge_spanish', 'badge_french', 'badge_russian', 'badge_chinese', 'badge_punjabi', 'using_logo', 'using_photos', 'using_badges', 'using_flex_space', 'using_linked_locations'];
$generalFields = $reviewFields = $changeMgmtFields = $upgradeFields = $otherFields = [];
// Advanced search details
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    $placeholder = null;
    if (in_array($type, ['date', 'datetime'])) {
        if (empty($value)) {
            $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
            $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
        }
    }
    switch ($field) {
        case 'id_parent':
            $label = 'Oticon parent id';
            break;
        case 'id_oticon':
            $label = 'Oticon id';
            break;
        case 'id_sf':
            $label = 'SF id';
            break;
        case 'id_cqp_practice':
            $label = 'CQP practice id';
            break;
        case 'id_cqp_office':
            $label = 'CQP office id';
            break;
        case 'id_external':
        case 'id_yhn_location':
            $label = Configure::read('isYhnImportEnabled') ? 'YHN location id' : 'Retail id';
            break;
        case 'state':
            $label = ucfirst(Configure::read('stateLabel'));
            break;
        case 'zip':
            $label = ucfirst(Configure::read('zipShort'));
            break;
        case 'listing_type':
            $type = 'select';
            $options = Location::$listingTypes;
            $empty = '(All listing types)';
            break;
        case 'direct_book_type':
            $type = 'select';
            $options = Location::$directBookTypes;
            $empty = '(All direct book types)';
            break;
        case 'review_status':
            $type = 'select';
            $options = Location::$reviewStatuses;
            $empty = 'Select One';
            break;
        case 'completeness':
            $type = 'select';
            $options = Location::$completenessFields;
            $empty = 'Select One';
            break;
        case 'last_import_status':
            $type = 'select';
            $options = ImportStatus::$statuses;
            $empty = 'Select One';
            break;
        case 'email_status':
        case 'phone_status':
        case 'address_status':
        case 'title_status':
            $type = 'select';
            $options = Location::$changeStatuses;
            $empty = 'Select One';
            break;
        case 'oticon_tier':
            $placeholder = '0 [or] 1 [or] 2 [or] 3';
            break;
        case 'yhn_tier':
            $label = Configure::read('isYhnImportEnabled') ? 'YHN tier' : 'Import tier';
            $placeholder = '0 [or] 2';
            break;
        case 'cqp_tier':
            $placeholder = '0 [or] 2';
            break;
        case 'is_hh':
            $label = 'Is '.Configure::read('siteNameAbbr');
            break;
        case 'is_email_allowed':
            $label = 'Is profile update email allowed';
            break;
        case 'has_url':
            $label = 'Has URL';
            break;
        case 'q':
            $label = 'Location search';
            break;
    }
    $advancedSearchField = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value,
        'placeholder' => $placeholder
    ];
    if (in_array($field, $generalFieldList)) {
        $key = array_search($field, $generalFieldList);
        $generalFields[$key] = $advancedSearchField;
    } elseif (in_array($field, $reviewFieldList)) {
        $key = array_search($field, $reviewFieldList);
        $reviewFields[$key] = $advancedSearchField;
    } elseif (in_array($field, $changeMgmtFieldList)) {
        $key = array_search($field, $changeMgmtFieldList);
        $changeMgmtFields[$key] = $advancedSearchField;
    } elseif (in_array($field, $upgradeFieldList)) {
        $key = array_search($field, $upgradeFieldList);
        $upgradeFields[$key] = $advancedSearchField;
    } else {
        $otherFields[] = $advancedSearchField;
    }
}
ksort($generalFields);
ksort($reviewFields);
ksort($changeMgmtFields);
ksort($upgradeFields);
$groupedFields = [
    'generalDemographics' => $generalFields,
    'reviews' => $reviewFields,
    'changeManagement' => $changeMgmtFields,
    'upgradeFeatures' => $upgradeFields
]
?>
<span id="count" class="d-none"><?= $count ?></span>
<span id="exportUrl" class="d-none"><?= $exportUrl ?></span>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Locations Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link("<i class='bi bi-plus-lg'></i> Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
                <!-- TODO : Export functionality -->
                <?= $this->Html->link("<i class='bi bi-download'></i> Export", ['action' => 'index'], ['id' => 'exportBtn', 'class' => 'btn btn-default', 'escapeTitle' => false]) ?>
                <!-- TODO : Email functionality -->
                <?php if (Configure::read('isYhnImportEnabled')): ?>
                    <?= $this->Html->link("<i class='bi bi-download'></i> Emails", ['action' => 'emailsCsv', '?' => $queryParams], ['class' => 'btn btn-default', 'escape' => false]) ?>
                    <?= $this->Html->link("YHN", '/admin/locations/index?is_show=1&is_active=1&is_yhn=1&yhn_tier=2', ['class' => 'btn btn-default', 'escape' => false]) ?>
                    <?= $this->Html->link("Oticon", '/admin/locations/index?is_show=1&is_active=1&is_oticon=1&oticon_tier=1[or]2[or]3', ['class' => 'btn btn-default', 'escape' => false]) ?>
                    <?= $this->Html->link("YHN & Oticon", '/admin/locations/index?is_show=1&is_active=1&is_oticon=1&is_yhn=1&listing_type=Basic[or]Enhanced[or]Premier', ['class' => 'btn btn-default', 'escape' => false]) ?>
                    <?= $this->Html->link("One Retail", '/admin/locations/index?is_show=1&is_active=1&is_retail=1', ['class' => 'btn btn-default', 'escape' => false]) ?>
                    <?= $this->Html->link("CQP", '/admin/locations/index?is_show=1&is_active=1&is_cqp=1&cqp_tier=2', ['class' => 'btn btn-default', 'escape' => false]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2><?= __('Locations CRM') ?></h2>
                <div class="locations index content">
                    <?= $this->element('pagination') ?>
                    <?= $this->element('admin_filter', ['modelName' => 'location']) ?>
                    <?= $this->element('advanced_search', ['groupedFields' => $groupedFields, 'fields' => $otherFields]) ?>
                    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
                    <div class="table-responsive mt20">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>
                                        <?= $this->Paginator->sort('id') ?><br>
                                        <?= $this->Paginator->sort('listing_type') ?>
                                        <?php if (Configure::read('isYhnImportEnabled')): ?>
                                            <br><?= $this->Paginator->sort('is_cq_premier', 'CQ Premier') ?>
                                            <br><?= $this->Paginator->sort('is_iris_plus', 'CQ Iris+') ?>
                                        <?php endif; ?>
                                    </th>
                                    <th>
                                        <?php if (Configure::read('isTieringEnabled')): ?>
                                            <?= $this->Paginator->sort('oticon_tier', 'OTI'); ?>
                                            <?= $this->Paginator->sort('yhn_tier', 'YHN'); ?><br>
                                        <?php endif; ?>
                                        <?php if (Configure::read('isCqpImportEnabled')): ?>
                                            <?= $this->Paginator->sort('cqp_tier', 'CQP'); ?>
                                        <?php endif; ?>
                                        <?= $this->Paginator->sort('is_hh', $siteNameAbbr); ?>
                                        <?= $this->Paginator->sort('is_retail', 'Retail'); ?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('is_active', 'Active');?><br />
                                        <?= $this->Paginator->sort('is_show', 'Show');?><br />
                                        <?php if (Configure::read('isTieringEnabled')): ?>
                                            <?= $this->Paginator->sort('is_grace_period', 'Grace');?>
                                        <?php endif; ?>
                                    </th>
                                    <th><?= $this->Paginator->sort('priority') ?></th>
                                    <th>
                                        <?= $this->Paginator->sort('title');?><br>
                                        <?= $this->Paginator->sort('address');?> 
                                        <?= $this->Paginator->sort('city');?> 
                                        <?= $this->Paginator->sort('state', ucfirst(Configure::read('stateLabel')));?> 
                                        <?= $this->Paginator->sort('zip', ucfirst(Configure::read('zipLabel')));?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('phone'); ?><br>
                                        <?= $this->Paginator->sort('is_call_assist', 'Call Concierge');?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('last_contact_date', 'Last Contact'); ?><br>
                                        <?= $this->Paginator->sort('completeness', 'Complete');?><br>
                                        <?= $this->Paginator->sort('reviews_approved', 'Reviews'); ?>
                                    </th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($locations as $location): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary"><?= $location->id; ?></span><br>
                                        <?= $this->Clinic->badgeListingType($location->listing_type) ?><br>
                                        <?php if (Configure::read('isYhnImportEnabled')): ?>
                                            <?php if (!empty($location->is_cq_premier)): ?>
                                                <span class='badge bg-cqp'>CQ Premier</span><br>
                                            <?php endif; ?>
                                            <?php if (!empty($location->is_iris_plus)): ?>
                                                <span class='badge bg-earq'>CQ Iris+</span><br>
                                            <?php endif; ?>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($location->is_yhn)): ?>
                                            <?php if (Configure::read('isYhnImportEnabled')): ?>
                                                <span class='badge bg-yhn'>YHN <?php echo $location->yhn_tier; ?></span><br>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ($location->is_oticon): ?>
                                            <span class='badge bg-oticon'>OTI
                                            <?php if (Configure::read('isTieringEnabled')): ?>
                                                <?php echo $location->oticon_tier; ?>
                                            <?php endif; ?>
                                            </span><br>
                                        <?php endif; ?>
                                        <?php if (Configure::read('isCqpImportEnabled')): ?>
                                            <?php if (!empty($location->is_cqp)): ?>
                                                <span class='badge bg-cqp'>CQP <?php echo $location->cqp_tier; ?></span><br>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($location->is_hh)): ?>
                                            <span class='badge bg-hh'><?php echo $siteNameAbbr; ?></span><br>
                                        <?php endif; ?>
                                        <?php if (!empty($location->is_retail)): ?>
                                            <span class='badge bg-primary'>Retail</span><br>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $location->is_active ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Active</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> Inactive</span>"; ?><br />
                                        <?php echo $location->is_show ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Show</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> No Show</span>"; ?>
                                        <?php if (Configure::read('isTieringEnabled')): ?>
                                            <?php if ($location->oticon_tier == 3): ?>
                                                <br />
                                                <?php echo $location->is_grace_period ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Grace</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> No Grace</span>"; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Admin->inlineAjax("Locations.priority", $location); ?>
                                    </td>
                                    <td>
                                        <?= $location->title ?><br />
                                        <?= $location->address.', '.$location->city.' '.$location->state.', '.$location->zip; ?>
                                    </td>
                                    <td nowrap>
                                        <?= formatPhoneNumber($location->phone) ?><br>
                                        <?php echo $location->is_call_assist ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Call Concierge</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> Not Call Concierge</span>"; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($location->last_contact_date) {
                                            echo date('m/d/Y', strtotime($location->last_contact_date)).'<br>';
                                        }
                                        ?>
                                        <?= $location->completeness ?><br>
                                        <?= $this->Clinic->badgeReview($location->reviews_approved) ?>
                                    </td>
                                    <td class="actions" nowrap>
                                        <div class="btn-group-vertical btn-group-sm">
                                            <?= $this->Html->link("<i class='bi bi-wrench'></i> Manage",
                                                ['action' => 'edit', $location->id],
                                                ['class' => 'btn btn-default btn-xs', 'escape' => false]) ?>
                                            <?= $this->Html->link("<i class='bi bi-eye-fill'></i> View",
                                                $location->hh_url,
                                                ['class' => 'btn btn-default btn-xs', 'escape' => false]) ?>
                                            <?= $this->Html->link("<i class='bi bi-pencil-fill'></i> Clinic Edit",
                                                ['action' => 'edit', 'prefix' => 'Clinic', $location->id],
                                                ['class' => 'btn btn-default btn-xs', 'escape' => false]) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $this->element('pagination') ?>
                </div>
                <?= $this->element('locations/admin_export_modal') ?>
            </div>
        </div>
    </section>
</div>