<?php
use Cake\Core\Configure;
use App\Model\Entity\Location;

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
/*
TODO: add search functionality for has_url, using_logo, using_photos, etc...
add search functionality for date ranges
*/

$queryParams = $this->request->getQueryParams();
// Add additional search fields
$fields['is_oticon'] = 'boolean';
$fields['has_url'] = 'boolean';
$fields['notes'] = 'string';
$fields['full_name'] = 'string';
$fields['npi_number'] = 'string';
$fields['using_logo'] = 'boolean';
$fields['using_photos'] = 'boolean';
$fields['using_videos'] = 'boolean';
$fields['using_flex_space'] = 'boolean';
$fields['using_badges'] = 'boolean';
$fields['using_linked_locations'] = 'boolean';
// Fields to ignore
$ignore_fields = ['last_xml','lat','lon','facebook','twitter','youtube','slogan','about_us','payment','services','is_geocoded','filter_evening_weekend','filter_adult_hearing_test','filter_hearing_aid_fitting','redirect','landmarks','url','country','direct_book_url','direct_book_iframe','content_library_expiration','special_announcement_expiration','logo_url','id_coupon','mobile_text','radius','created'];
if (!Configure::read('isCallAssistEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_call_assist', 'direct_book_type', 'is_bypassed']);
}
if (!Configure::read('isYhnImportEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_yhn', 'yhn_tier', 'is_cq_premier', 'is_iris_plus']);
}
if (!Configure::read('isOticonImportEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_oticon', 'oticon_tier', 'location_segment', 'entity_segment', 'is_title_ignore', 'is_address_ignore', 'is_phone_ignore', 'is_email_ignore']);
}
if (!Configure::read('isTieringEnabled')) {
    $ignore_fields = array_merge($ignore_fields, ['is_listing_type_frozen', 'is_grace_period', 'grace_period_end', 'listing_type', 'badge_coffee', 'badge_wifi', 'badge_parking', 'badge_curbside', 'badge_wheelchair', 'badge_service_pets', 'badge_cochlear_implants', 'badge_ald', 'badge_pediatrics', 'badge_mobile_clinic', 'badge_financing', 'badge_telehearing', 'badge_asl', 'badge_tinnitus', 'badge_balance', 'badge_home', 'badge_remote', 'badge_mask', 'badge_spanish', 'badge_french', 'badge_russian', 'badge_chinese', 'is_service_agreement_signed', 'using_logo', 'using_photos', 'using_videos', 'using_flex_space', 'using_badges', 'using_linked_locations']);
}
foreach ($fields as $field => $type) {
    if (in_array($field, $ignore_fields)) {
        unset($fields[$field]);
    }
}
$generalFields = ['id', 'id_oticon', 'id_parent', 'id_sf', 'id_yhn_location', 'cqp_practice_id', 'cqp_office_id', 'title', 'subtitle', 'address', 'address_2', 'city', 'state', 'zip', 'is_mobile', 'phone', 'email', 'priority', 'is_active', 'is_show', 'is_listing_type_frozen', 'oticon_tier', 'yhn_tier', 'cqp_tier', 'listing_type', 'is_oticon', 'is_retail', 'is_yhn', 'is_cqp', 'is_hh', 'is_cq_premier', 'is_iris_plus', 'notes', 'full_name', 'is_bypassed', 'filter_has_photo', 'filter_insurance', 'is_call_assist', 'timezone', 'has_url', 'npi_number', 'location_segment', 'entity_segment', 'direct_book_type', 'frozen_expiration', 'is_ida_verified', 'is_service_agreement_signed', 'covid19_statement', 'is_junk', 'is_email_allowed'];
$reviewFields = ['reviews_approved', 'review_status', 'average_rating', 'last_review_date'];
$changeMgmtFields = ['modified', 'last_contact_date', 'is_last_edit_by_owner', 'last_edit_by_owner_date', 'completeness', 'last_note_status', 'last_import_status', 'is_grace_period', 'grace_period_end', 'review_needed', 'email_status', 'phone_status', 'address_status', 'title_status', 'is_title_ignore', 'is_address_ignore', 'is_phone_ignore', 'is_email_ignore'];
$upgradeFields = ['feature_content_library', 'feature_special_announcement', 'logo_url', 'badge_coffee', 'badge_wifi', 'badge_parking', 'badge_curbside', 'badge_wheelchair', 'badge_service_pets', 'badge_cochlear_implants', 'badge_ald', 'badge_pediatrics', 'badge_mobile_clinic', 'badge_financing', 'badge_telehearing', 'badge_asl', 'badge_tinnitus', 'badge_balance', 'badge_home', 'badge_remote', 'badge_mask', 'badge_spanish', 'badge_french', 'badge_russian', 'badge_chinese', 'using_logo', 'using_photos', 'using_videos', 'using_badges', 'using_flex_space', 'using_linked_locations'];
$generalFieldInputs = [];
$reviewFieldInputs = [];
$changeMgmtFieldInputs = [];
$upgradeFieldInputs = [];
$otherInputs = [];
?>

<div class="row justify-content-end">
    <?php if ($this->Search->isSearch()) : ?>
        <div class="col col-md-auto">
            <?= $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-info text-light', 'role' => 'button']) ?>
        </div>
    <?php endif; ?>
    <div class="col col-md-auto">
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#advancedSearch" aria-expanded="false" aria-controls="advancedSearch">
            + Advanced
        </button>
    </div>
</div>
<div class="collapse" id="advancedSearch">
    <?php
    echo $this->Form->create(null, [
        'class' => 'bg-light mb-2 p-4',
        'valueSources' => 'query',
    ]);
    ?>
    <?php
    foreach ($fields as $field => $type) {
        $label = '';
        $options = false;
        $empty = false;
        switch ($field) {
            case 'id_parent':
                $label = 'Oticon parent id';
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
            case 'email_status': 
            case 'phone_status': 
            case 'address_status': 
            case 'title_status': 
                $type = 'select';
                $options = Location::$changeStatuses;
                $empty = 'Select One';
                break;
            case 'is_hh':
                $label = 'Is '.Configure::read('siteNameAbbr');
                break;
            case 'is_email_allowed':
                $label = 'Is profile update email allowed';
                break;
            // TODO: options for last_note_status (after baking LocationNotes)
            // TODO: options for last_import_status (after baking Import)
        }
        $formInput = $this->Admin->formInput($field, $type, $label, $options, $empty);
        if (in_array($field, $generalFields)) {
            $key = array_search($field, $generalFields);
            $generalFieldInputs[$key] = $formInput;
        } elseif (in_array($field, $reviewFields)) {
            $key = array_search($field, $reviewFields);
            $reviewFieldInputs[$key] = $formInput;
        } elseif (in_array($field, $changeMgmtFields)) {
            $key = array_search($field, $changeMgmtFields);
            $changeMgmtFieldInputs[$key] = $formInput;
        } elseif (in_array($field, $upgradeFields)) {
            $key = array_search($field, $upgradeFields);
            $upgradeFieldInputs[$key] = $formInput;
        } else {
            $otherInputs[] = $formInput;
        }
    }
    ksort($generalFieldInputs);
    ksort($reviewFieldInputs);
    ksort($changeMgmtFieldInputs);
    ksort($upgradeFieldInputs);
    ?>
    <!-- GENERAL DEMOGRAPHICS -->
    <div class="row justify-content-end">
        <div class="col col-md-auto">
            <button class="btn btn-sm btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#generalDemographics" aria-expanded="false" aria-controls="advancedSearch" style="min-width:178px;">
                + General demographics
            </button>
        </div>
    </div>
    <div class="collapse mb-3" id="generalDemographics" style="border:2px solid #a3a3a3;padding:20px;">
        <?php $column = 1; ?>
        <?php foreach ($generalFieldInputs as $formInput): ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
    </div>
    <!-- REVIEWS -->
    <div class="row justify-content-end">
        <div class="col col-md-auto">
            <button class="btn btn-sm btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#reviews" aria-expanded="false" aria-controls="advancedSearch" style="min-width:178px;">
                + Reviews
            </button>
        </div>
    </div>
    <div class="collapse mb-3" id="reviews" style="border:2px solid #a3a3a3;padding:20px;">
        <?php $column = 1; ?>
        <?php foreach ($reviewFieldInputs as $formInput): ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
    </div>
    <!-- CHANGE MANAGEMENT -->
    <div class="row justify-content-end">
        <div class="col col-md-auto">
            <button class="btn btn-sm btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#changeManagement" aria-expanded="false" aria-controls="advancedSearch" style="min-width:178px;">
                + Change management
            </button>
        </div>
    </div>
    <div class="collapse mb-3" id="changeManagement" style="border:2px solid #a3a3a3;padding:20px;">
        <?php $column = 1; ?>
        <?php foreach ($changeMgmtFieldInputs as $formInput): ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
    </div>
    <!-- UPGRADE FEATURES -->
    <div class="row justify-content-end">
        <div class="col col-md-auto">
            <button class="btn btn-sm btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#upgradeFeatures" aria-expanded="false" aria-controls="advancedSearch" style="min-width:178px;">
                + Upgrade features
            </button>
        </div>
    </div>
    <div class="collapse mb-3" id="upgradeFeatures" style="border:2px solid #a3a3a3;padding:20px;">
        <?php $column = 1; ?>
        <?php foreach ($upgradeFieldInputs as $formInput): ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?= $formInput ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
    </div>
    <!-- OTHER -->
    <?php $column = 1; ?>
    <?php foreach ($otherInputs as $formInput): ?>
        <?php if ($column == 1): ?>
            <div class="row" style="min-height: 74px;">
                <div class="col-md-6">
                    <?= $formInput ?>
                    <?php $column = 2; ?>
                </div> <!-- end col -->
        <?php else: // column 2 ?>
                <div class="col-md-6">
                    <?= $formInput ?>
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
        'class' => 'me-3',
    ]);
    echo $this->Form->end();
    ?>
</div>

