<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Locations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locations view content">
            <h3><?= h($location->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id Oticon') ?></th>
                    <td><?= h($location->id_oticon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Parent') ?></th>
                    <td><?= h($location->id_parent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Sf') ?></th>
                    <td><?= h($location->id_sf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($location->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtitle') ?></th>
                    <td><?= h($location->subtitle) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($location->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address 2') ?></th>
                    <td><?= h($location->address_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($location->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($location->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($location->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($location->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mobile Text') ?></th>
                    <td><?= h($location->mobile_text) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($location->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($location->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Logo Url') ?></th>
                    <td><?= h($location->logo_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($location->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook') ?></th>
                    <td><?= h($location->facebook) ?></td>
                </tr>
                <tr>
                    <th><?= __('Twitter') ?></th>
                    <td><?= h($location->twitter) ?></td>
                </tr>
                <tr>
                    <th><?= __('Youtube') ?></th>
                    <td><?= h($location->youtube) ?></td>
                </tr>
                <tr>
                    <th><?= __('Listing Type') ?></th>
                    <td><?= h($location->listing_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location Segment') ?></th>
                    <td><?= h($location->location_segment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Segment') ?></th>
                    <td><?= h($location->entity_segment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Review Status') ?></th>
                    <td><?= h($location->review_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= h($location->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Completeness') ?></th>
                    <td><?= h($location->completeness) ?></td>
                </tr>
                <tr>
                    <th><?= __('Redirect') ?></th>
                    <td><?= h($location->redirect) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Yhn Location') ?></th>
                    <td><?= h($location->id_yhn_location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Direct Book Type') ?></th>
                    <td><?= h($location->direct_book_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Direct Book Url') ?></th>
                    <td><?= h($location->direct_book_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Direct Book Iframe') ?></th>
                    <td><?= h($location->direct_book_iframe) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timezone') ?></th>
                    <td><?= h($location->timezone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Covid19 Statement') ?></th>
                    <td><?= h($location->covid19_statement) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($location->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Radius') ?></th>
                    <td><?= $this->Number->format($location->radius) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lat') ?></th>
                    <td><?= $this->Number->format($location->lat) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lon') ?></th>
                    <td><?= $this->Number->format($location->lon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Oticon Tier') ?></th>
                    <td><?= $this->Number->format($location->oticon_tier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Yhn Tier') ?></th>
                    <td><?= $this->Number->format($location->yhn_tier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title Status') ?></th>
                    <td><?= $this->Number->format($location->title_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address Status') ?></th>
                    <td><?= $this->Number->format($location->address_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Status') ?></th>
                    <td><?= $this->Number->format($location->phone_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Average Rating') ?></th>
                    <td><?= $this->Number->format($location->average_rating) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reviews Approved') ?></th>
                    <td><?= $this->Number->format($location->reviews_approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Note Status') ?></th>
                    <td><?= $this->Number->format($location->last_note_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Import Status') ?></th>
                    <td><?= $this->Number->format($location->last_import_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email Status') ?></th>
                    <td><?= $this->Number->format($location->email_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Review Needed') ?></th>
                    <td><?= $this->Number->format($location->review_needed) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Coupon') ?></th>
                    <td><?= $this->Number->format($location->id_coupon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($location->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($location->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Frozen Expiration') ?></th>
                    <td><?= h($location->frozen_expiration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grace Period End') ?></th>
                    <td><?= h($location->grace_period_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Content Library Expiration') ?></th>
                    <td><?= h($location->content_library_expiration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Special Announcement Expiration') ?></th>
                    <td><?= h($location->special_announcement_expiration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Contact Date') ?></th>
                    <td><?= h($location->last_contact_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Edit By Owner Date') ?></th>
                    <td><?= h($location->last_edit_by_owner_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Mobile') ?></th>
                    <td><?= $location->is_mobile ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Listing Type Frozen') ?></th>
                    <td><?= $location->is_listing_type_frozen ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Ida Verified') ?></th>
                    <td><?= $location->is_ida_verified ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Title Ignore') ?></th>
                    <td><?= $location->is_title_ignore ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Address Ignore') ?></th>
                    <td><?= $location->is_address_ignore ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Phone Ignore') ?></th>
                    <td><?= $location->is_phone_ignore ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $location->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Show') ?></th>
                    <td><?= $location->is_show ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Grace Period') ?></th>
                    <td><?= $location->is_grace_period ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Geocoded') ?></th>
                    <td><?= $location->is_geocoded ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Filter Has Photo') ?></th>
                    <td><?= $location->filter_has_photo ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Filter Insurance') ?></th>
                    <td><?= $location->filter_insurance ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Filter Evening Weekend') ?></th>
                    <td><?= $location->filter_evening_weekend ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Filter Adult Hearing Test') ?></th>
                    <td><?= $location->filter_adult_hearing_test ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Filter Hearing Aid Fitting') ?></th>
                    <td><?= $location->filter_hearing_aid_fitting ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Coffee') ?></th>
                    <td><?= $location->badge_coffee ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Wifi') ?></th>
                    <td><?= $location->badge_wifi ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Parking') ?></th>
                    <td><?= $location->badge_parking ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Curbside') ?></th>
                    <td><?= $location->badge_curbside ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Wheelchair') ?></th>
                    <td><?= $location->badge_wheelchair ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Service Pets') ?></th>
                    <td><?= $location->badge_service_pets ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Cochlear Implants') ?></th>
                    <td><?= $location->badge_cochlear_implants ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Ald') ?></th>
                    <td><?= $location->badge_ald ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Pediatrics') ?></th>
                    <td><?= $location->badge_pediatrics ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Mobile Clinic') ?></th>
                    <td><?= $location->badge_mobile_clinic ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Financing') ?></th>
                    <td><?= $location->badge_financing ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Telehearing') ?></th>
                    <td><?= $location->badge_telehearing ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Asl') ?></th>
                    <td><?= $location->badge_asl ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Tinnitus') ?></th>
                    <td><?= $location->badge_tinnitus ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Balance') ?></th>
                    <td><?= $location->badge_balance ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Home') ?></th>
                    <td><?= $location->badge_home ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Remote') ?></th>
                    <td><?= $location->badge_remote ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Spanish') ?></th>
                    <td><?= $location->badge_spanish ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge French') ?></th>
                    <td><?= $location->badge_french ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Russian') ?></th>
                    <td><?= $location->badge_russian ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Badge Chinese') ?></th>
                    <td><?= $location->badge_chinese ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Feature Content Library') ?></th>
                    <td><?= $location->feature_content_library ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Feature Special Announcement') ?></th>
                    <td><?= $location->feature_special_announcement ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Last Edit By Owner') ?></th>
                    <td><?= $location->is_last_edit_by_owner ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Email Ignore') ?></th>
                    <td><?= $location->is_email_ignore ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Retail') ?></th>
                    <td><?= $location->is_retail ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Yhn') ?></th>
                    <td><?= $location->is_yhn ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Hh') ?></th>
                    <td><?= $location->is_hh ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Cyhn') ?></th>
                    <td><?= $location->is_cyhn ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Earq') ?></th>
                    <td><?= $location->is_earq ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Bypassed') ?></th>
                    <td><?= $location->is_bypassed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Call Assist') ?></th>
                    <td><?= $location->is_call_assist ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Service Agreement Signed') ?></th>
                    <td><?= $location->is_service_agreement_signed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Junk') ?></th>
                    <td><?= $location->is_junk ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Email Allowed') ?></th>
                    <td><?= $location->is_email_allowed ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Payment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($location->payment)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Services') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($location->services)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Slogan') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($location->slogan)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('About Us') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($location->about_us)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Last Xml') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($location->last_xml)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Landmarks') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($location->landmarks)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Content') ?></h4>
                <?php if (!empty($location->content)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Id Brafton') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Last Modified') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Alt Title') ?></th>
                            <th><?= __('Title Head') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Short') ?></th>
                            <th><?= __('Body') ?></th>
                            <th><?= __('Meta Description') ?></th>
                            <th><?= __('Bodyclass') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Library Item') ?></th>
                            <th><?= __('Library Share Text') ?></th>
                            <th><?= __('Is Gone') ?></th>
                            <th><?= __('Facebook Title') ?></th>
                            <th><?= __('Facebook Description') ?></th>
                            <th><?= __('Facebook Image') ?></th>
                            <th><?= __('Facebook Image Width') ?></th>
                            <th><?= __('Facebook Image Width Override') ?></th>
                            <th><?= __('Facebook Image Height') ?></th>
                            <th><?= __('Facebook Image Alt') ?></th>
                            <th><?= __('Comment Count') ?></th>
                            <th><?= __('Like Count') ?></th>
                            <th><?= __('Old Url') ?></th>
                            <th><?= __('Id Draft Parent') ?></th>
                            <th><?= __('Is Frozen') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->content as $content) : ?>
                        <tr>
                            <td><?= h($content->id) ?></td>
                            <td><?= h($content->id_brafton) ?></td>
                            <td><?= h($content->user_id) ?></td>
                            <td><?= h($content->type) ?></td>
                            <td><?= h($content->date) ?></td>
                            <td><?= h($content->created) ?></td>
                            <td><?= h($content->modified) ?></td>
                            <td><?= h($content->last_modified) ?></td>
                            <td><?= h($content->title) ?></td>
                            <td><?= h($content->alt_title) ?></td>
                            <td><?= h($content->title_head) ?></td>
                            <td><?= h($content->slug) ?></td>
                            <td><?= h($content->short) ?></td>
                            <td><?= h($content->body) ?></td>
                            <td><?= h($content->meta_description) ?></td>
                            <td><?= h($content->bodyclass) ?></td>
                            <td><?= h($content->is_active) ?></td>
                            <td><?= h($content->is_library_item) ?></td>
                            <td><?= h($content->library_share_text) ?></td>
                            <td><?= h($content->is_gone) ?></td>
                            <td><?= h($content->facebook_title) ?></td>
                            <td><?= h($content->facebook_description) ?></td>
                            <td><?= h($content->facebook_image) ?></td>
                            <td><?= h($content->facebook_image_width) ?></td>
                            <td><?= h($content->facebook_image_width_override) ?></td>
                            <td><?= h($content->facebook_image_height) ?></td>
                            <td><?= h($content->facebook_image_alt) ?></td>
                            <td><?= h($content->comment_count) ?></td>
                            <td><?= h($content->like_count) ?></td>
                            <td><?= h($content->old_url) ?></td>
                            <td><?= h($content->id_draft_parent) ?></td>
                            <td><?= h($content->is_frozen) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Content', 'action' => 'view', $content->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Content', 'action' => 'edit', $content->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Content', 'action' => 'delete', $content->id], ['confirm' => __('Are you sure you want to delete # {0}?', $content->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Ca Call Groups') ?></h4>
                <?php if (!empty($location->ca_call_groups)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Caller Phone') ?></th>
                            <th><?= __('Caller First Name') ?></th>
                            <th><?= __('Caller Last Name') ?></th>
                            <th><?= __('Is Patient') ?></th>
                            <th><?= __('Patient First Name') ?></th>
                            <th><?= __('Patient Last Name') ?></th>
                            <th><?= __('Refused Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Topic Wants Appt') ?></th>
                            <th><?= __('Topic Clinic Hours') ?></th>
                            <th><?= __('Topic Insurance') ?></th>
                            <th><?= __('Topic Clinic Inquiry') ?></th>
                            <th><?= __('Topic Aid Lost Old') ?></th>
                            <th><?= __('Topic Aid Lost New') ?></th>
                            <th><?= __('Topic Warranty Old') ?></th>
                            <th><?= __('Topic Warranty New') ?></th>
                            <th><?= __('Topic Batteries') ?></th>
                            <th><?= __('Topic Parts') ?></th>
                            <th><?= __('Topic Cancel Appt') ?></th>
                            <th><?= __('Topic Reschedule Appt') ?></th>
                            <th><?= __('Topic Appt Followup') ?></th>
                            <th><?= __('Topic Medical Records') ?></th>
                            <th><?= __('Topic Tinnitus') ?></th>
                            <th><?= __('Topic Hearing Previously Tested') ?></th>
                            <th><?= __('Topic Aids Previously Worn') ?></th>
                            <th><?= __('Topic Medical Inquiry') ?></th>
                            <th><?= __('Topic Solicitor') ?></th>
                            <th><?= __('Topic Personal Call') ?></th>
                            <th><?= __('Topic Request Fax') ?></th>
                            <th><?= __('Topic Request Name') ?></th>
                            <th><?= __('Topic Remove From List') ?></th>
                            <th><?= __('Topic Foreign Language') ?></th>
                            <th><?= __('Topic Other') ?></th>
                            <th><?= __('Topic Declined') ?></th>
                            <th><?= __('Wants Hearing Test') ?></th>
                            <th><?= __('Prospect') ?></th>
                            <th><?= __('Is Prospect Override') ?></th>
                            <th><?= __('Front Desk Name') ?></th>
                            <th><?= __('Score') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Appt Date') ?></th>
                            <th><?= __('Scheduled Call Date') ?></th>
                            <th><?= __('Final Score Date') ?></th>
                            <th><?= __('Is Bringing Third Party') ?></th>
                            <th><?= __('Is Review Needed') ?></th>
                            <th><?= __('Ca Call Count') ?></th>
                            <th><?= __('Clinic Followup Count') ?></th>
                            <th><?= __('Patient Followup Count') ?></th>
                            <th><?= __('Clinic Outbound Count') ?></th>
                            <th><?= __('Patient Outbound Count') ?></th>
                            <th><?= __('Vm Outbound Count') ?></th>
                            <th><?= __('Is Locked') ?></th>
                            <th><?= __('Lock Time') ?></th>
                            <th><?= __('Id Locked By User') ?></th>
                            <th><?= __('Outbound Priority') ?></th>
                            <th><?= __('Question Visit Clinic') ?></th>
                            <th><?= __('Question What For') ?></th>
                            <th><?= __('Question Purchase') ?></th>
                            <th><?= __('Question Brand') ?></th>
                            <th><?= __('Question Brand Other') ?></th>
                            <th><?= __('Did They Want Help') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Traffic Source') ?></th>
                            <th><?= __('Traffic Medium') ?></th>
                            <th><?= __('Is Appt Request Form') ?></th>
                            <th><?= __('Is Spam') ?></th>
                            <th><?= __('Id Xml File') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->ca_call_groups as $caCallGroups) : ?>
                        <tr>
                            <td><?= h($caCallGroups->id) ?></td>
                            <td><?= h($caCallGroups->location_id) ?></td>
                            <td><?= h($caCallGroups->caller_phone) ?></td>
                            <td><?= h($caCallGroups->caller_first_name) ?></td>
                            <td><?= h($caCallGroups->caller_last_name) ?></td>
                            <td><?= h($caCallGroups->is_patient) ?></td>
                            <td><?= h($caCallGroups->patient_first_name) ?></td>
                            <td><?= h($caCallGroups->patient_last_name) ?></td>
                            <td><?= h($caCallGroups->refused_name) ?></td>
                            <td><?= h($caCallGroups->email) ?></td>
                            <td><?= h($caCallGroups->topic_wants_appt) ?></td>
                            <td><?= h($caCallGroups->topic_clinic_hours) ?></td>
                            <td><?= h($caCallGroups->topic_insurance) ?></td>
                            <td><?= h($caCallGroups->topic_clinic_inquiry) ?></td>
                            <td><?= h($caCallGroups->topic_aid_lost_old) ?></td>
                            <td><?= h($caCallGroups->topic_aid_lost_new) ?></td>
                            <td><?= h($caCallGroups->topic_warranty_old) ?></td>
                            <td><?= h($caCallGroups->topic_warranty_new) ?></td>
                            <td><?= h($caCallGroups->topic_batteries) ?></td>
                            <td><?= h($caCallGroups->topic_parts) ?></td>
                            <td><?= h($caCallGroups->topic_cancel_appt) ?></td>
                            <td><?= h($caCallGroups->topic_reschedule_appt) ?></td>
                            <td><?= h($caCallGroups->topic_appt_followup) ?></td>
                            <td><?= h($caCallGroups->topic_medical_records) ?></td>
                            <td><?= h($caCallGroups->topic_tinnitus) ?></td>
                            <td><?= h($caCallGroups->topic_hearing_previously_tested) ?></td>
                            <td><?= h($caCallGroups->topic_aids_previously_worn) ?></td>
                            <td><?= h($caCallGroups->topic_medical_inquiry) ?></td>
                            <td><?= h($caCallGroups->topic_solicitor) ?></td>
                            <td><?= h($caCallGroups->topic_personal_call) ?></td>
                            <td><?= h($caCallGroups->topic_request_fax) ?></td>
                            <td><?= h($caCallGroups->topic_request_name) ?></td>
                            <td><?= h($caCallGroups->topic_remove_from_list) ?></td>
                            <td><?= h($caCallGroups->topic_foreign_language) ?></td>
                            <td><?= h($caCallGroups->topic_other) ?></td>
                            <td><?= h($caCallGroups->topic_declined) ?></td>
                            <td><?= h($caCallGroups->wants_hearing_test) ?></td>
                            <td><?= h($caCallGroups->prospect) ?></td>
                            <td><?= h($caCallGroups->is_prospect_override) ?></td>
                            <td><?= h($caCallGroups->front_desk_name) ?></td>
                            <td><?= h($caCallGroups->score) ?></td>
                            <td><?= h($caCallGroups->status) ?></td>
                            <td><?= h($caCallGroups->appt_date) ?></td>
                            <td><?= h($caCallGroups->scheduled_call_date) ?></td>
                            <td><?= h($caCallGroups->final_score_date) ?></td>
                            <td><?= h($caCallGroups->is_bringing_third_party) ?></td>
                            <td><?= h($caCallGroups->is_review_needed) ?></td>
                            <td><?= h($caCallGroups->ca_call_count) ?></td>
                            <td><?= h($caCallGroups->clinic_followup_count) ?></td>
                            <td><?= h($caCallGroups->patient_followup_count) ?></td>
                            <td><?= h($caCallGroups->clinic_outbound_count) ?></td>
                            <td><?= h($caCallGroups->patient_outbound_count) ?></td>
                            <td><?= h($caCallGroups->vm_outbound_count) ?></td>
                            <td><?= h($caCallGroups->is_locked) ?></td>
                            <td><?= h($caCallGroups->lock_time) ?></td>
                            <td><?= h($caCallGroups->id_locked_by_user) ?></td>
                            <td><?= h($caCallGroups->outbound_priority) ?></td>
                            <td><?= h($caCallGroups->question_visit_clinic) ?></td>
                            <td><?= h($caCallGroups->question_what_for) ?></td>
                            <td><?= h($caCallGroups->question_purchase) ?></td>
                            <td><?= h($caCallGroups->question_brand) ?></td>
                            <td><?= h($caCallGroups->question_brand_other) ?></td>
                            <td><?= h($caCallGroups->did_they_want_help) ?></td>
                            <td><?= h($caCallGroups->created) ?></td>
                            <td><?= h($caCallGroups->modified) ?></td>
                            <td><?= h($caCallGroups->traffic_source) ?></td>
                            <td><?= h($caCallGroups->traffic_medium) ?></td>
                            <td><?= h($caCallGroups->is_appt_request_form) ?></td>
                            <td><?= h($caCallGroups->is_spam) ?></td>
                            <td><?= h($caCallGroups->id_xml_file) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CaCallGroups', 'action' => 'view', $caCallGroups->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CaCallGroups', 'action' => 'edit', $caCallGroups->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CaCallGroups', 'action' => 'delete', $caCallGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroups->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Call Sources') ?></h4>
                <?php if (!empty($location->call_sources)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Customer Name') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Phone Number') ?></th>
                            <th><?= __('Target Number') ?></th>
                            <th><?= __('Clinic Number') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Ivr Enabled') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->call_sources as $callSources) : ?>
                        <tr>
                            <td><?= h($callSources->id) ?></td>
                            <td><?= h($callSources->customer_name) ?></td>
                            <td><?= h($callSources->location_id) ?></td>
                            <td><?= h($callSources->is_active) ?></td>
                            <td><?= h($callSources->notes) ?></td>
                            <td><?= h($callSources->phone_number) ?></td>
                            <td><?= h($callSources->target_number) ?></td>
                            <td><?= h($callSources->clinic_number) ?></td>
                            <td><?= h($callSources->start_date) ?></td>
                            <td><?= h($callSources->end_date) ?></td>
                            <td><?= h($callSources->created) ?></td>
                            <td><?= h($callSources->is_ivr_enabled) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CallSources', 'action' => 'view', $callSources->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CallSources', 'action' => 'edit', $callSources->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CallSources', 'action' => 'delete', $callSources->id], ['confirm' => __('Are you sure you want to delete # {0}?', $callSources->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Cs Calls') ?></h4>
                <?php if (!empty($location->cs_calls)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Call Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Ad Source') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('Result') ?></th>
                            <th><?= __('Duration') ?></th>
                            <th><?= __('Call Type') ?></th>
                            <th><?= __('Call Status') ?></th>
                            <th><?= __('Leadscore') ?></th>
                            <th><?= __('Recording Url') ?></th>
                            <th><?= __('Tracking Number') ?></th>
                            <th><?= __('Caller Phone') ?></th>
                            <th><?= __('Clinic Phone') ?></th>
                            <th><?= __('Caller Firstname') ?></th>
                            <th><?= __('Caller Lastname') ?></th>
                            <th><?= __('Prospect') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->cs_calls as $csCalls) : ?>
                        <tr>
                            <td><?= h($csCalls->id) ?></td>
                            <td><?= h($csCalls->call_id) ?></td>
                            <td><?= h($csCalls->location_id) ?></td>
                            <td><?= h($csCalls->ad_source) ?></td>
                            <td><?= h($csCalls->start_time) ?></td>
                            <td><?= h($csCalls->result) ?></td>
                            <td><?= h($csCalls->duration) ?></td>
                            <td><?= h($csCalls->call_type) ?></td>
                            <td><?= h($csCalls->call_status) ?></td>
                            <td><?= h($csCalls->leadscore) ?></td>
                            <td><?= h($csCalls->recording_url) ?></td>
                            <td><?= h($csCalls->tracking_number) ?></td>
                            <td><?= h($csCalls->caller_phone) ?></td>
                            <td><?= h($csCalls->clinic_phone) ?></td>
                            <td><?= h($csCalls->caller_firstname) ?></td>
                            <td><?= h($csCalls->caller_lastname) ?></td>
                            <td><?= h($csCalls->prospect) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CsCalls', 'action' => 'view', $csCalls->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CsCalls', 'action' => 'edit', $csCalls->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CsCalls', 'action' => 'delete', $csCalls->id], ['confirm' => __('Are you sure you want to delete # {0}?', $csCalls->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Import Locations') ?></h4>
                <?php if (!empty($location->import_locations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Id External') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Id Oticon') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Subtitle') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Address 2') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Match Type') ?></th>
                            <th><?= __('Is Retail') ?></th>
                            <th><?= __('Is New') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->import_locations as $importLocations) : ?>
                        <tr>
                            <td><?= h($importLocations->id) ?></td>
                            <td><?= h($importLocations->import_id) ?></td>
                            <td><?= h($importLocations->id_external) ?></td>
                            <td><?= h($importLocations->location_id) ?></td>
                            <td><?= h($importLocations->id_oticon) ?></td>
                            <td><?= h($importLocations->title) ?></td>
                            <td><?= h($importLocations->subtitle) ?></td>
                            <td><?= h($importLocations->email) ?></td>
                            <td><?= h($importLocations->address) ?></td>
                            <td><?= h($importLocations->address_2) ?></td>
                            <td><?= h($importLocations->city) ?></td>
                            <td><?= h($importLocations->state) ?></td>
                            <td><?= h($importLocations->zip) ?></td>
                            <td><?= h($importLocations->phone) ?></td>
                            <td><?= h($importLocations->match_type) ?></td>
                            <td><?= h($importLocations->is_retail) ?></td>
                            <td><?= h($importLocations->is_new) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportLocations', 'action' => 'view', $importLocations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportLocations', 'action' => 'edit', $importLocations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportLocations', 'action' => 'delete', $importLocations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Import Status') ?></h4>
                <?php if (!empty($location->import_status)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Oticon Tier') ?></th>
                            <th><?= __('Listing Type') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Show') ?></th>
                            <th><?= __('Is Grace Period') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->import_status as $importStatus) : ?>
                        <tr>
                            <td><?= h($importStatus->id) ?></td>
                            <td><?= h($importStatus->location_id) ?></td>
                            <td><?= h($importStatus->status) ?></td>
                            <td><?= h($importStatus->oticon_tier) ?></td>
                            <td><?= h($importStatus->listing_type) ?></td>
                            <td><?= h($importStatus->is_active) ?></td>
                            <td><?= h($importStatus->is_show) ?></td>
                            <td><?= h($importStatus->is_grace_period) ?></td>
                            <td><?= h($importStatus->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportStatus', 'action' => 'view', $importStatus->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportStatus', 'action' => 'edit', $importStatus->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportStatus', 'action' => 'delete', $importStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importStatus->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Ads') ?></h4>
                <?php if (!empty($location->location_ads)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Photo Url') ?></th>
                            <th><?= __('Alt') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Border') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_ads as $locationAds) : ?>
                        <tr>
                            <td><?= h($locationAds->id) ?></td>
                            <td><?= h($locationAds->location_id) ?></td>
                            <td><?= h($locationAds->photo_url) ?></td>
                            <td><?= h($locationAds->alt) ?></td>
                            <td><?= h($locationAds->title) ?></td>
                            <td><?= h($locationAds->description) ?></td>
                            <td><?= h($locationAds->border) ?></td>
                            <td><?= h($locationAds->created) ?></td>
                            <td><?= h($locationAds->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationAds', 'action' => 'view', $locationAds->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationAds', 'action' => 'edit', $locationAds->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationAds', 'action' => 'delete', $locationAds->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationAds->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Emails') ?></h4>
                <?php if (!empty($location->location_emails)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_emails as $locationEmails) : ?>
                        <tr>
                            <td><?= h($locationEmails->id) ?></td>
                            <td><?= h($locationEmails->location_id) ?></td>
                            <td><?= h($locationEmails->email) ?></td>
                            <td><?= h($locationEmails->first_name) ?></td>
                            <td><?= h($locationEmails->last_name) ?></td>
                            <td><?= h($locationEmails->created) ?></td>
                            <td><?= h($locationEmails->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationEmails', 'action' => 'view', $locationEmails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationEmails', 'action' => 'edit', $locationEmails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationEmails', 'action' => 'delete', $locationEmails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationEmails->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Hours') ?></h4>
                <?php if (!empty($location->location_hours)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Sun Open') ?></th>
                            <th><?= __('Sun Close') ?></th>
                            <th><?= __('Sun Is Closed') ?></th>
                            <th><?= __('Sun Is Byappt') ?></th>
                            <th><?= __('Mon Open') ?></th>
                            <th><?= __('Mon Close') ?></th>
                            <th><?= __('Mon Is Closed') ?></th>
                            <th><?= __('Mon Is Byappt') ?></th>
                            <th><?= __('Tue Open') ?></th>
                            <th><?= __('Tue Close') ?></th>
                            <th><?= __('Tue Is Closed') ?></th>
                            <th><?= __('Tue Is Byappt') ?></th>
                            <th><?= __('Wed Open') ?></th>
                            <th><?= __('Wed Close') ?></th>
                            <th><?= __('Wed Is Closed') ?></th>
                            <th><?= __('Wed Is Byappt') ?></th>
                            <th><?= __('Thu Open') ?></th>
                            <th><?= __('Thu Close') ?></th>
                            <th><?= __('Thu Is Closed') ?></th>
                            <th><?= __('Thu Is Byappt') ?></th>
                            <th><?= __('Fri Open') ?></th>
                            <th><?= __('Fri Close') ?></th>
                            <th><?= __('Fri Is Closed') ?></th>
                            <th><?= __('Fri Is Byappt') ?></th>
                            <th><?= __('Sat Open') ?></th>
                            <th><?= __('Sat Close') ?></th>
                            <th><?= __('Sat Is Closed') ?></th>
                            <th><?= __('Sat Is Byappt') ?></th>
                            <th><?= __('Is Evening Weekend Hours') ?></th>
                            <th><?= __('Is Closed Lunch') ?></th>
                            <th><?= __('Lunch Start') ?></th>
                            <th><?= __('Lunch End') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_hours as $locationHours) : ?>
                        <tr>
                            <td><?= h($locationHours->id) ?></td>
                            <td><?= h($locationHours->location_id) ?></td>
                            <td><?= h($locationHours->sun_open) ?></td>
                            <td><?= h($locationHours->sun_close) ?></td>
                            <td><?= h($locationHours->sun_is_closed) ?></td>
                            <td><?= h($locationHours->sun_is_byappt) ?></td>
                            <td><?= h($locationHours->mon_open) ?></td>
                            <td><?= h($locationHours->mon_close) ?></td>
                            <td><?= h($locationHours->mon_is_closed) ?></td>
                            <td><?= h($locationHours->mon_is_byappt) ?></td>
                            <td><?= h($locationHours->tue_open) ?></td>
                            <td><?= h($locationHours->tue_close) ?></td>
                            <td><?= h($locationHours->tue_is_closed) ?></td>
                            <td><?= h($locationHours->tue_is_byappt) ?></td>
                            <td><?= h($locationHours->wed_open) ?></td>
                            <td><?= h($locationHours->wed_close) ?></td>
                            <td><?= h($locationHours->wed_is_closed) ?></td>
                            <td><?= h($locationHours->wed_is_byappt) ?></td>
                            <td><?= h($locationHours->thu_open) ?></td>
                            <td><?= h($locationHours->thu_close) ?></td>
                            <td><?= h($locationHours->thu_is_closed) ?></td>
                            <td><?= h($locationHours->thu_is_byappt) ?></td>
                            <td><?= h($locationHours->fri_open) ?></td>
                            <td><?= h($locationHours->fri_close) ?></td>
                            <td><?= h($locationHours->fri_is_closed) ?></td>
                            <td><?= h($locationHours->fri_is_byappt) ?></td>
                            <td><?= h($locationHours->sat_open) ?></td>
                            <td><?= h($locationHours->sat_close) ?></td>
                            <td><?= h($locationHours->sat_is_closed) ?></td>
                            <td><?= h($locationHours->sat_is_byappt) ?></td>
                            <td><?= h($locationHours->is_evening_weekend_hours) ?></td>
                            <td><?= h($locationHours->is_closed_lunch) ?></td>
                            <td><?= h($locationHours->lunch_start) ?></td>
                            <td><?= h($locationHours->lunch_end) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationHours', 'action' => 'view', $locationHours->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationHours', 'action' => 'edit', $locationHours->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationHours', 'action' => 'delete', $locationHours->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationHours->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Links') ?></h4>
                <?php if (!empty($location->location_links)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Id Linked Location') ?></th>
                            <th><?= __('Distance') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_links as $locationLinks) : ?>
                        <tr>
                            <td><?= h($locationLinks->id) ?></td>
                            <td><?= h($locationLinks->location_id) ?></td>
                            <td><?= h($locationLinks->id_linked_location) ?></td>
                            <td><?= h($locationLinks->distance) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationLinks', 'action' => 'view', $locationLinks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationLinks', 'action' => 'edit', $locationLinks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationLinks', 'action' => 'delete', $locationLinks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationLinks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Notes') ?></h4>
                <?php if (!empty($location->location_notes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Body') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_notes as $locationNotes) : ?>
                        <tr>
                            <td><?= h($locationNotes->id) ?></td>
                            <td><?= h($locationNotes->location_id) ?></td>
                            <td><?= h($locationNotes->body) ?></td>
                            <td><?= h($locationNotes->status) ?></td>
                            <td><?= h($locationNotes->user_id) ?></td>
                            <td><?= h($locationNotes->created) ?></td>
                            <td><?= h($locationNotes->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationNotes', 'action' => 'view', $locationNotes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationNotes', 'action' => 'edit', $locationNotes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationNotes', 'action' => 'delete', $locationNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationNotes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Photos') ?></h4>
                <?php if (!empty($location->location_photos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Photo Url') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Alt') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_photos as $locationPhotos) : ?>
                        <tr>
                            <td><?= h($locationPhotos->id) ?></td>
                            <td><?= h($locationPhotos->location_id) ?></td>
                            <td><?= h($locationPhotos->photo_url) ?></td>
                            <td><?= h($locationPhotos->created) ?></td>
                            <td><?= h($locationPhotos->modified) ?></td>
                            <td><?= h($locationPhotos->alt) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationPhotos', 'action' => 'view', $locationPhotos->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationPhotos', 'action' => 'edit', $locationPhotos->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationPhotos', 'action' => 'delete', $locationPhotos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationPhotos->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Providers') ?></h4>
                <?php if (!empty($location->location_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Provider Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_providers as $locationProviders) : ?>
                        <tr>
                            <td><?= h($locationProviders->id) ?></td>
                            <td><?= h($locationProviders->location_id) ?></td>
                            <td><?= h($locationProviders->provider_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationProviders', 'action' => 'view', $locationProviders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationProviders', 'action' => 'edit', $locationProviders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationProviders', 'action' => 'delete', $locationProviders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationProviders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Users') ?></h4>
                <?php if (!empty($location->location_users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Lastlogin') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Reset Url') ?></th>
                            <th><?= __('Reset Expiration Date') ?></th>
                            <th><?= __('Clinic Password') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_users as $locationUsers) : ?>
                        <tr>
                            <td><?= h($locationUsers->id) ?></td>
                            <td><?= h($locationUsers->username) ?></td>
                            <td><?= h($locationUsers->password) ?></td>
                            <td><?= h($locationUsers->first_name) ?></td>
                            <td><?= h($locationUsers->last_name) ?></td>
                            <td><?= h($locationUsers->email) ?></td>
                            <td><?= h($locationUsers->created) ?></td>
                            <td><?= h($locationUsers->modified) ?></td>
                            <td><?= h($locationUsers->lastlogin) ?></td>
                            <td><?= h($locationUsers->is_active) ?></td>
                            <td><?= h($locationUsers->reset_url) ?></td>
                            <td><?= h($locationUsers->reset_expiration_date) ?></td>
                            <td><?= h($locationUsers->clinic_password) ?></td>
                            <td><?= h($locationUsers->location_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationUsers', 'action' => 'view', $locationUsers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationUsers', 'action' => 'edit', $locationUsers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationUsers', 'action' => 'delete', $locationUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationUsers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Videos') ?></h4>
                <?php if (!empty($location->location_videos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Video Url') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_videos as $locationVideos) : ?>
                        <tr>
                            <td><?= h($locationVideos->id) ?></td>
                            <td><?= h($locationVideos->location_id) ?></td>
                            <td><?= h($locationVideos->video_url) ?></td>
                            <td><?= h($locationVideos->created) ?></td>
                            <td><?= h($locationVideos->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationVideos', 'action' => 'view', $locationVideos->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationVideos', 'action' => 'edit', $locationVideos->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationVideos', 'action' => 'delete', $locationVideos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationVideos->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Vidscrips') ?></h4>
                <?php if (!empty($location->location_vidscrips)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Vidscrip') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->location_vidscrips as $locationVidscrips) : ?>
                        <tr>
                            <td><?= h($locationVidscrips->id) ?></td>
                            <td><?= h($locationVidscrips->location_id) ?></td>
                            <td><?= h($locationVidscrips->vidscrip) ?></td>
                            <td><?= h($locationVidscrips->email) ?></td>
                            <td><?= h($locationVidscrips->created) ?></td>
                            <td><?= h($locationVidscrips->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationVidscrips', 'action' => 'view', $locationVidscrips->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationVidscrips', 'action' => 'edit', $locationVidscrips->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationVidscrips', 'action' => 'delete', $locationVidscrips->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationVidscrips->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Reviews') ?></h4>
                <?php if (!empty($location->reviews)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Body') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Rating') ?></th>
                            <th><?= __('Is Spam') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Origin') ?></th>
                            <th><?= __('Response') ?></th>
                            <th><?= __('Response Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Denied Date') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th><?= __('Character Count') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($location->reviews as $reviews) : ?>
                        <tr>
                            <td><?= h($reviews->id) ?></td>
                            <td><?= h($reviews->location_id) ?></td>
                            <td><?= h($reviews->body) ?></td>
                            <td><?= h($reviews->first_name) ?></td>
                            <td><?= h($reviews->last_name) ?></td>
                            <td><?= h($reviews->zip) ?></td>
                            <td><?= h($reviews->rating) ?></td>
                            <td><?= h($reviews->is_spam) ?></td>
                            <td><?= h($reviews->status) ?></td>
                            <td><?= h($reviews->origin) ?></td>
                            <td><?= h($reviews->response) ?></td>
                            <td><?= h($reviews->response_status) ?></td>
                            <td><?= h($reviews->created) ?></td>
                            <td><?= h($reviews->modified) ?></td>
                            <td><?= h($reviews->denied_date) ?></td>
                            <td><?= h($reviews->ip) ?></td>
                            <td><?= h($reviews->character_count) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Reviews', 'action' => 'view', $reviews->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Reviews', 'action' => 'edit', $reviews->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reviews', 'action' => 'delete', $reviews->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reviews->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
