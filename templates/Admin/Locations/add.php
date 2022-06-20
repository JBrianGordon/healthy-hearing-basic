<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 * @var \Cake\Collection\CollectionInterface|string[] $content
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Locations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locations form content">
            <?= $this->Form->create($location) ?>
            <fieldset>
                <legend><?= __('Add Location') ?></legend>
                <?php
                    echo $this->Form->control('id_oticon');
                    echo $this->Form->control('id_parent');
                    echo $this->Form->control('id_sf');
                    echo $this->Form->control('title');
                    echo $this->Form->control('subtitle');
                    echo $this->Form->control('address');
                    echo $this->Form->control('address_2');
                    echo $this->Form->control('city');
                    echo $this->Form->control('state');
                    echo $this->Form->control('zip');
                    echo $this->Form->control('country');
                    echo $this->Form->control('is_mobile');
                    echo $this->Form->control('mobile_text');
                    echo $this->Form->control('radius');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('lat');
                    echo $this->Form->control('lon');
                    echo $this->Form->control('email');
                    echo $this->Form->control('logo_url');
                    echo $this->Form->control('url');
                    echo $this->Form->control('facebook');
                    echo $this->Form->control('twitter');
                    echo $this->Form->control('youtube');
                    echo $this->Form->control('is_listing_type_frozen');
                    echo $this->Form->control('frozen_expiration', ['empty' => true]);
                    echo $this->Form->control('oticon_tier');
                    echo $this->Form->control('yhn_tier');
                    echo $this->Form->control('cqp_tier');
                    echo $this->Form->control('listing_type');
                    echo $this->Form->control('is_ida_verified');
                    echo $this->Form->control('location_segment');
                    echo $this->Form->control('entity_segment');
                    echo $this->Form->control('title_status');
                    echo $this->Form->control('address_status');
                    echo $this->Form->control('phone_status');
                    echo $this->Form->control('is_title_ignore');
                    echo $this->Form->control('is_address_ignore');
                    echo $this->Form->control('is_phone_ignore');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_show');
                    echo $this->Form->control('is_grace_period');
                    echo $this->Form->control('grace_period_end', ['empty' => true]);
                    echo $this->Form->control('is_geocoded');
                    echo $this->Form->control('filter_has_photo');
                    echo $this->Form->control('filter_insurance');
                    echo $this->Form->control('filter_evening_weekend');
                    echo $this->Form->control('filter_adult_hearing_test');
                    echo $this->Form->control('filter_hearing_aid_fitting');
                    echo $this->Form->control('badge_coffee');
                    echo $this->Form->control('badge_wifi');
                    echo $this->Form->control('badge_parking');
                    echo $this->Form->control('badge_curbside');
                    echo $this->Form->control('badge_wheelchair');
                    echo $this->Form->control('badge_service_pets');
                    echo $this->Form->control('badge_cochlear_implants');
                    echo $this->Form->control('badge_ald');
                    echo $this->Form->control('badge_pediatrics');
                    echo $this->Form->control('badge_mobile_clinic');
                    echo $this->Form->control('badge_financing');
                    echo $this->Form->control('badge_telehearing');
                    echo $this->Form->control('badge_asl');
                    echo $this->Form->control('badge_tinnitus');
                    echo $this->Form->control('badge_balance');
                    echo $this->Form->control('badge_home');
                    echo $this->Form->control('badge_remote');
                    echo $this->Form->control('badge_mask');
                    echo $this->Form->control('badge_spanish');
                    echo $this->Form->control('badge_french');
                    echo $this->Form->control('badge_russian');
                    echo $this->Form->control('badge_chinese');
                    echo $this->Form->control('feature_content_library');
                    echo $this->Form->control('content_library_expiration', ['empty' => true]);
                    echo $this->Form->control('feature_special_announcement');
                    echo $this->Form->control('special_announcement_expiration', ['empty' => true]);
                    echo $this->Form->control('payment');
                    echo $this->Form->control('services');
                    echo $this->Form->control('slogan');
                    echo $this->Form->control('about_us');
                    echo $this->Form->control('average_rating');
                    echo $this->Form->control('reviews_approved');
                    echo $this->Form->control('review_status');
                    echo $this->Form->control('last_review_date', ['empty' => true]);
                    echo $this->Form->control('last_xml');
                    echo $this->Form->control('last_note_status');
                    echo $this->Form->control('last_import_status');
                    echo $this->Form->control('last_contact_date', ['empty' => true]);
                    echo $this->Form->control('is_last_edit_by_owner');
                    echo $this->Form->control('last_edit_by_owner_date', ['empty' => true]);
                    echo $this->Form->control('priority');
                    echo $this->Form->control('completeness');
                    echo $this->Form->control('redirect');
                    echo $this->Form->control('landmarks');
                    echo $this->Form->control('email_status');
                    echo $this->Form->control('is_email_ignore');
                    echo $this->Form->control('id_yhn_location');
                    echo $this->Form->control('cqp_practice_id');
                    echo $this->Form->control('cqp_office_id');
                    echo $this->Form->control('review_needed');
                    echo $this->Form->control('is_retail');
                    echo $this->Form->control('direct_book_type');
                    echo $this->Form->control('direct_book_url');
                    echo $this->Form->control('direct_book_iframe');
                    echo $this->Form->control('is_yhn');
                    echo $this->Form->control('is_hh');
                    echo $this->Form->control('is_cqp');
                    echo $this->Form->control('is_cq_premier');
                    echo $this->Form->control('is_iris_plus');
                    echo $this->Form->control('is_bypassed');
                    echo $this->Form->control('is_call_assist');
                    echo $this->Form->control('timezone');
                    echo $this->Form->control('covid19_statement');
                    echo $this->Form->control('is_service_agreement_signed');
                    echo $this->Form->control('is_junk');
                    echo $this->Form->control('id_coupon');
                    echo $this->Form->control('is_email_allowed');
                    echo $this->Form->control('content._ids', ['options' => $content]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
