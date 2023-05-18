<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Content'), ['action' => 'edit', $content->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Content'), ['action' => 'delete', $content->id], ['confirm' => __('Are you sure you want to delete # {0}?', $content->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Content'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Content'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="content view content">
            <h3><?= h($content->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($content->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($content->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Alt Title') ?></th>
                    <td><?= h($content->alt_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtitle') ?></th>
                    <td><?= h($content->subtitle) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title Head') ?></th>
                    <td><?= h($content->title_head) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($content->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Meta Description') ?></th>
                    <td><?= h($content->meta_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bodyclass') ?></th>
                    <td><?= h($content->bodyclass) ?></td>
                </tr>
                <tr>
                    <th><?= __('Library Share Text') ?></th>
                    <td><?= h($content->library_share_text) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Title') ?></th>
                    <td><?= h($content->facebook_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Description') ?></th>
                    <td><?= h($content->facebook_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image') ?></th>
                    <td><?= h($content->facebook_image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Alt') ?></th>
                    <td><?= h($content->facebook_image_alt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($content->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Brafton') ?></th>
                    <td><?= $this->Number->format($content->id_brafton) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($content->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Width') ?></th>
                    <td><?= $this->Number->format($content->facebook_image_width) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Height') ?></th>
                    <td><?= $this->Number->format($content->facebook_image_height) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Draft Parent') ?></th>
                    <td><?= $this->Number->format($content->id_draft_parent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($content->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($content->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($content->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Modified') ?></th>
                    <td><?= h($content->last_modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $content->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Library Item') ?></th>
                    <td><?= $content->is_library_item ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Gone') ?></th>
                    <td><?= $content->is_gone ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Width Override') ?></th>
                    <td><?= $content->facebook_image_width_override ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Old Url') ?></th>
                    <td><?= $content->old_url ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Frozen') ?></th>
                    <td><?= $content->is_frozen ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Short') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($content->short)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($content->body)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($content->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Middle Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Degrees') ?></th>
                            <th><?= __('Credentials') ?></th>
                            <th><?= __('Title Dept Company') ?></th>
                            <th><?= __('Company') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Address 2') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Bio') ?></th>
                            <th><?= __('Image Url') ?></th>
                            <th><?= __('Thumb Url') ?></th>
                            <th><?= __('Square Url') ?></th>
                            <th><?= __('Micro Url') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Modified By') ?></th>
                            <th><?= __('Lastlogin') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Hardened Password') ?></th>
                            <th><?= __('Is Admin') ?></th>
                            <th><?= __('Is It Admin') ?></th>
                            <th><?= __('Is Agent') ?></th>
                            <th><?= __('Is Call Supervisor') ?></th>
                            <th><?= __('Is Author') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Corp Id') ?></th>
                            <th><?= __('Is Deleted') ?></th>
                            <th><?= __('Is Csa') ?></th>
                            <th><?= __('Is Writer') ?></th>
                            <th><?= __('Recovery Email') ?></th>
                            <th><?= __('Clinic Password') ?></th>
                            <th><?= __('Timezone Offset') ?></th>
                            <th><?= __('Timezone') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($content->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->username) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->level) ?></td>
                            <td><?= h($users->first_name) ?></td>
                            <td><?= h($users->middle_name) ?></td>
                            <td><?= h($users->last_name) ?></td>
                            <td><?= h($users->degrees) ?></td>
                            <td><?= h($users->credentials) ?></td>
                            <td><?= h($users->title_dept_company) ?></td>
                            <td><?= h($users->company) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->phone) ?></td>
                            <td><?= h($users->address) ?></td>
                            <td><?= h($users->address_2) ?></td>
                            <td><?= h($users->city) ?></td>
                            <td><?= h($users->state) ?></td>
                            <td><?= h($users->zip) ?></td>
                            <td><?= h($users->country) ?></td>
                            <td><?= h($users->url) ?></td>
                            <td><?= h($users->bio) ?></td>
                            <td><?= h($users->image_url) ?></td>
                            <td><?= h($users->thumb_url) ?></td>
                            <td><?= h($users->square_url) ?></td>
                            <td><?= h($users->micro_url) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td><?= h($users->modified_by) ?></td>
                            <td><?= h($users->last_login) ?></td>
                            <td><?= h($users->active) ?></td>
                            <td><?= h($users->is_hardened_password) ?></td>
                            <td><?= h($users->is_admin) ?></td>
                            <td><?= h($users->is_it_admin) ?></td>
                            <td><?= h($users->is_agent) ?></td>
                            <td><?= h($users->is_call_supervisor) ?></td>
                            <td><?= h($users->is_author) ?></td>
                            <td><?= h($users->notes) ?></td>
                            <td><?= h($users->corp_id) ?></td>
                            <td><?= h($users->is_deleted) ?></td>
                            <td><?= h($users->is_csa) ?></td>
                            <td><?= h($users->is_writer) ?></td>
                            <td><?= h($users->recovery_email) ?></td>
                            <td><?= h($users->clinic_password) ?></td>
                            <td><?= h($users->timezone_offset) ?></td>
                            <td><?= h($users->timezone) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Locations') ?></h4>
                <?php if (!empty($content->locations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Id Oticon') ?></th>
                            <th><?= __('Id Parent') ?></th>
                            <th><?= __('Id Sf') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Subtitle') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Address 2') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Is Mobile') ?></th>
                            <th><?= __('Mobile Text') ?></th>
                            <th><?= __('Radius') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Lat') ?></th>
                            <th><?= __('Lon') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Logo Url') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Facebook') ?></th>
                            <th><?= __('Twitter') ?></th>
                            <th><?= __('Youtube') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Listing Type Frozen') ?></th>
                            <th><?= __('Frozen Expiration') ?></th>
                            <th><?= __('Oticon Tier') ?></th>
                            <th><?= __('Yhn Tier') ?></th>
                            <th><?= __('Listing Type') ?></th>
                            <th><?= __('Is Ida Verified') ?></th>
                            <th><?= __('Location Segment') ?></th>
                            <th><?= __('Entity Segment') ?></th>
                            <th><?= __('Title Status') ?></th>
                            <th><?= __('Address Status') ?></th>
                            <th><?= __('Phone Status') ?></th>
                            <th><?= __('Is Title Ignore') ?></th>
                            <th><?= __('Is Address Ignore') ?></th>
                            <th><?= __('Is Phone Ignore') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Show') ?></th>
                            <th><?= __('Is Grace Period') ?></th>
                            <th><?= __('Grace Period End') ?></th>
                            <th><?= __('Is Geocoded') ?></th>
                            <th><?= __('Filter Has Photo') ?></th>
                            <th><?= __('Filter Insurance') ?></th>
                            <th><?= __('Filter Evening Weekend') ?></th>
                            <th><?= __('Filter Adult Hearing Test') ?></th>
                            <th><?= __('Filter Hearing Aid Fitting') ?></th>
                            <th><?= __('Badge Coffee') ?></th>
                            <th><?= __('Badge Wifi') ?></th>
                            <th><?= __('Badge Parking') ?></th>
                            <th><?= __('Badge Curbside') ?></th>
                            <th><?= __('Badge Wheelchair') ?></th>
                            <th><?= __('Badge Service Pets') ?></th>
                            <th><?= __('Badge Cochlear Implants') ?></th>
                            <th><?= __('Badge Ald') ?></th>
                            <th><?= __('Badge Pediatrics') ?></th>
                            <th><?= __('Badge Mobile Clinic') ?></th>
                            <th><?= __('Badge Financing') ?></th>
                            <th><?= __('Badge Telehearing') ?></th>
                            <th><?= __('Badge Asl') ?></th>
                            <th><?= __('Badge Tinnitus') ?></th>
                            <th><?= __('Badge Balance') ?></th>
                            <th><?= __('Badge Home') ?></th>
                            <th><?= __('Badge Remote') ?></th>
                            <th><?= __('Badge Spanish') ?></th>
                            <th><?= __('Badge French') ?></th>
                            <th><?= __('Badge Russian') ?></th>
                            <th><?= __('Badge Chinese') ?></th>
                            <th><?= __('Feature Content Library') ?></th>
                            <th><?= __('Content Library Expiration') ?></th>
                            <th><?= __('Feature Special Announcement') ?></th>
                            <th><?= __('Special Announcement Expiration') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Services') ?></th>
                            <th><?= __('Slogan') ?></th>
                            <th><?= __('About Us') ?></th>
                            <th><?= __('Average Rating') ?></th>
                            <th><?= __('Reviews Approved') ?></th>
                            <th><?= __('Review Status') ?></th>
                            <th><?= __('Last Xml') ?></th>
                            <th><?= __('Last Note Status') ?></th>
                            <th><?= __('Last Import Status') ?></th>
                            <th><?= __('Last Contact Date') ?></th>
                            <th><?= __('Is Last Edit By Owner') ?></th>
                            <th><?= __('Last Edit By Owner Date') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Completeness') ?></th>
                            <th><?= __('Redirect') ?></th>
                            <th><?= __('Landmarks') ?></th>
                            <th><?= __('Email Status') ?></th>
                            <th><?= __('Is Email Ignore') ?></th>
                            <th><?= __('Id Yhn Location') ?></th>
                            <th><?= __('Review Needed') ?></th>
                            <th><?= __('Is Retail') ?></th>
                            <th><?= __('Direct Book Type') ?></th>
                            <th><?= __('Direct Book Url') ?></th>
                            <th><?= __('Direct Book Iframe') ?></th>
                            <th><?= __('Is Yhn') ?></th>
                            <th><?= __('Is Hh') ?></th>
                            <th><?= __('Is Cyhn') ?></th>
                            <th><?= __('Is Earq') ?></th>
                            <th><?= __('Is Bypassed') ?></th>
                            <th><?= __('Is Call Assist') ?></th>
                            <th><?= __('Timezone') ?></th>
                            <th><?= __('Covid19 Statement') ?></th>
                            <th><?= __('Is Service Agreement Signed') ?></th>
                            <th><?= __('Is Junk') ?></th>
                            <th><?= __('Id Coupon') ?></th>
                            <th><?= __('Is Email Allowed') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($content->locations as $locations) : ?>
                        <tr>
                            <td><?= h($locations->id) ?></td>
                            <td><?= h($locations->id_oticon) ?></td>
                            <td><?= h($locations->id_parent) ?></td>
                            <td><?= h($locations->id_sf) ?></td>
                            <td><?= h($locations->title) ?></td>
                            <td><?= h($locations->subtitle) ?></td>
                            <td><?= h($locations->address) ?></td>
                            <td><?= h($locations->address_2) ?></td>
                            <td><?= h($locations->city) ?></td>
                            <td><?= h($locations->state) ?></td>
                            <td><?= h($locations->zip) ?></td>
                            <td><?= h($locations->country) ?></td>
                            <td><?= h($locations->is_mobile) ?></td>
                            <td><?= h($locations->mobile_text) ?></td>
                            <td><?= h($locations->radius) ?></td>
                            <td><?= h($locations->phone) ?></td>
                            <td><?= h($locations->lat) ?></td>
                            <td><?= h($locations->lon) ?></td>
                            <td><?= h($locations->email) ?></td>
                            <td><?= h($locations->logo_url) ?></td>
                            <td><?= h($locations->url) ?></td>
                            <td><?= h($locations->facebook) ?></td>
                            <td><?= h($locations->twitter) ?></td>
                            <td><?= h($locations->youtube) ?></td>
                            <td><?= h($locations->created) ?></td>
                            <td><?= h($locations->modified) ?></td>
                            <td><?= h($locations->is_listing_type_frozen) ?></td>
                            <td><?= h($locations->frozen_expiration) ?></td>
                            <td><?= h($locations->oticon_tier) ?></td>
                            <td><?= h($locations->yhn_tier) ?></td>
                            <td><?= h($locations->listing_type) ?></td>
                            <td><?= h($locations->is_ida_verified) ?></td>
                            <td><?= h($locations->location_segment) ?></td>
                            <td><?= h($locations->entity_segment) ?></td>
                            <td><?= h($locations->title_status) ?></td>
                            <td><?= h($locations->address_status) ?></td>
                            <td><?= h($locations->phone_status) ?></td>
                            <td><?= h($locations->is_title_ignore) ?></td>
                            <td><?= h($locations->is_address_ignore) ?></td>
                            <td><?= h($locations->is_phone_ignore) ?></td>
                            <td><?= h($locations->is_active) ?></td>
                            <td><?= h($locations->is_show) ?></td>
                            <td><?= h($locations->is_grace_period) ?></td>
                            <td><?= h($locations->grace_period_end) ?></td>
                            <td><?= h($locations->is_geocoded) ?></td>
                            <td><?= h($locations->filter_has_photo) ?></td>
                            <td><?= h($locations->filter_insurance) ?></td>
                            <td><?= h($locations->filter_evening_weekend) ?></td>
                            <td><?= h($locations->filter_adult_hearing_test) ?></td>
                            <td><?= h($locations->filter_hearing_aid_fitting) ?></td>
                            <td><?= h($locations->badge_coffee) ?></td>
                            <td><?= h($locations->badge_wifi) ?></td>
                            <td><?= h($locations->badge_parking) ?></td>
                            <td><?= h($locations->badge_curbside) ?></td>
                            <td><?= h($locations->badge_wheelchair) ?></td>
                            <td><?= h($locations->badge_service_pets) ?></td>
                            <td><?= h($locations->badge_cochlear_implants) ?></td>
                            <td><?= h($locations->badge_ald) ?></td>
                            <td><?= h($locations->badge_pediatrics) ?></td>
                            <td><?= h($locations->badge_mobile_clinic) ?></td>
                            <td><?= h($locations->badge_financing) ?></td>
                            <td><?= h($locations->badge_telehearing) ?></td>
                            <td><?= h($locations->badge_asl) ?></td>
                            <td><?= h($locations->badge_tinnitus) ?></td>
                            <td><?= h($locations->badge_balance) ?></td>
                            <td><?= h($locations->badge_home) ?></td>
                            <td><?= h($locations->badge_remote) ?></td>
                            <td><?= h($locations->badge_spanish) ?></td>
                            <td><?= h($locations->badge_french) ?></td>
                            <td><?= h($locations->badge_russian) ?></td>
                            <td><?= h($locations->badge_chinese) ?></td>
                            <td><?= h($locations->feature_content_library) ?></td>
                            <td><?= h($locations->content_library_expiration) ?></td>
                            <td><?= h($locations->feature_special_announcement) ?></td>
                            <td><?= h($locations->special_announcement_expiration) ?></td>
                            <td><?= h($locations->payment) ?></td>
                            <td><?= h($locations->services) ?></td>
                            <td><?= h($locations->slogan) ?></td>
                            <td><?= h($locations->about_us) ?></td>
                            <td><?= h($locations->average_rating) ?></td>
                            <td><?= h($locations->reviews_approved) ?></td>
                            <td><?= h($locations->review_status) ?></td>
                            <td><?= h($locations->last_xml) ?></td>
                            <td><?= h($locations->last_note_status) ?></td>
                            <td><?= h($locations->last_import_status) ?></td>
                            <td><?= h($locations->last_contact_date) ?></td>
                            <td><?= h($locations->is_last_edit_by_owner) ?></td>
                            <td><?= h($locations->last_edit_by_owner_date) ?></td>
                            <td><?= h($locations->priority) ?></td>
                            <td><?= h($locations->completeness) ?></td>
                            <td><?= h($locations->redirect) ?></td>
                            <td><?= h($locations->landmarks) ?></td>
                            <td><?= h($locations->email_status) ?></td>
                            <td><?= h($locations->is_email_ignore) ?></td>
                            <td><?= h($locations->id_yhn_location) ?></td>
                            <td><?= h($locations->review_needed) ?></td>
                            <td><?= h($locations->is_retail) ?></td>
                            <td><?= h($locations->direct_book_type) ?></td>
                            <td><?= h($locations->direct_book_url) ?></td>
                            <td><?= h($locations->direct_book_iframe) ?></td>
                            <td><?= h($locations->is_yhn) ?></td>
                            <td><?= h($locations->is_hh) ?></td>
                            <td><?= h($locations->is_cyhn) ?></td>
                            <td><?= h($locations->is_earq) ?></td>
                            <td><?= h($locations->is_bypassed) ?></td>
                            <td><?= h($locations->is_call_assist) ?></td>
                            <td><?= h($locations->timezone) ?></td>
                            <td><?= h($locations->covid19_statement) ?></td>
                            <td><?= h($locations->is_service_agreement_signed) ?></td>
                            <td><?= h($locations->is_junk) ?></td>
                            <td><?= h($locations->id_coupon) ?></td>
                            <td><?= h($locations->is_email_allowed) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Locations', 'action' => 'view', $locations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Locations', 'action' => 'edit', $locations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Locations', 'action' => 'delete', $locations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tags') ?></h4>
                <?php if (!empty($content->tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Is Category') ?></th>
                            <th><?= __('Is Sub Category') ?></th>
                            <th><?= __('Header') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Display Header') ?></th>
                            <th><?= __('Ribbon Header') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($content->tags as $tags) : ?>
                        <tr>
                            <td><?= h($tags->id) ?></td>
                            <td><?= h($tags->name) ?></td>
                            <td><?= h($tags->is_category) ?></td>
                            <td><?= h($tags->is_sub_category) ?></td>
                            <td><?= h($tags->header) ?></td>
                            <td><?= h($tags->created) ?></td>
                            <td><?= h($tags->modified) ?></td>
                            <td><?= h($tags->display_header) ?></td>
                            <td><?= h($tags->ribbon_header) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tags->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tags', 'action' => 'delete', $tags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->id)]) ?>
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
