<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location[]|\Cake\Collection\CollectionInterface $locations
 */
?>
<div class="locations index content">
    <?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Locations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_oticon') ?></th>
                    <th><?= $this->Paginator->sort('id_parent') ?></th>
                    <th><?= $this->Paginator->sort('id_sf') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('subtitle') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('address_2') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('is_mobile') ?></th>
                    <th><?= $this->Paginator->sort('mobile_text') ?></th>
                    <th><?= $this->Paginator->sort('radius') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('lon') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('logo_url') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('facebook') ?></th>
                    <th><?= $this->Paginator->sort('twitter') ?></th>
                    <th><?= $this->Paginator->sort('youtube') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_listing_type_frozen') ?></th>
                    <th><?= $this->Paginator->sort('frozen_expiration') ?></th>
                    <th><?= $this->Paginator->sort('oticon_tier') ?></th>
                    <th><?= $this->Paginator->sort('yhn_tier') ?></th>
                    <th><?= $this->Paginator->sort('listing_type') ?></th>
                    <th><?= $this->Paginator->sort('is_ida_verified') ?></th>
                    <th><?= $this->Paginator->sort('location_segment') ?></th>
                    <th><?= $this->Paginator->sort('entity_segment') ?></th>
                    <th><?= $this->Paginator->sort('title_status') ?></th>
                    <th><?= $this->Paginator->sort('address_status') ?></th>
                    <th><?= $this->Paginator->sort('phone_status') ?></th>
                    <th><?= $this->Paginator->sort('is_title_ignore') ?></th>
                    <th><?= $this->Paginator->sort('is_address_ignore') ?></th>
                    <th><?= $this->Paginator->sort('is_phone_ignore') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_show') ?></th>
                    <th><?= $this->Paginator->sort('is_grace_period') ?></th>
                    <th><?= $this->Paginator->sort('grace_period_end') ?></th>
                    <th><?= $this->Paginator->sort('is_geocoded') ?></th>
                    <th><?= $this->Paginator->sort('filter_has_photo') ?></th>
                    <th><?= $this->Paginator->sort('filter_insurance') ?></th>
                    <th><?= $this->Paginator->sort('filter_evening_weekend') ?></th>
                    <th><?= $this->Paginator->sort('filter_adult_hearing_test') ?></th>
                    <th><?= $this->Paginator->sort('filter_hearing_aid_fitting') ?></th>
                    <th><?= $this->Paginator->sort('badge_coffee') ?></th>
                    <th><?= $this->Paginator->sort('badge_wifi') ?></th>
                    <th><?= $this->Paginator->sort('badge_parking') ?></th>
                    <th><?= $this->Paginator->sort('badge_curbside') ?></th>
                    <th><?= $this->Paginator->sort('badge_wheelchair') ?></th>
                    <th><?= $this->Paginator->sort('badge_service_pets') ?></th>
                    <th><?= $this->Paginator->sort('badge_cochlear_implants') ?></th>
                    <th><?= $this->Paginator->sort('badge_ald') ?></th>
                    <th><?= $this->Paginator->sort('badge_pediatrics') ?></th>
                    <th><?= $this->Paginator->sort('badge_mobile_clinic') ?></th>
                    <th><?= $this->Paginator->sort('badge_financing') ?></th>
                    <th><?= $this->Paginator->sort('badge_telehearing') ?></th>
                    <th><?= $this->Paginator->sort('badge_asl') ?></th>
                    <th><?= $this->Paginator->sort('badge_tinnitus') ?></th>
                    <th><?= $this->Paginator->sort('badge_balance') ?></th>
                    <th><?= $this->Paginator->sort('badge_home') ?></th>
                    <th><?= $this->Paginator->sort('badge_remote') ?></th>
                    <th><?= $this->Paginator->sort('badge_spanish') ?></th>
                    <th><?= $this->Paginator->sort('badge_french') ?></th>
                    <th><?= $this->Paginator->sort('badge_russian') ?></th>
                    <th><?= $this->Paginator->sort('badge_chinese') ?></th>
                    <th><?= $this->Paginator->sort('feature_content_library') ?></th>
                    <th><?= $this->Paginator->sort('content_library_expiration') ?></th>
                    <th><?= $this->Paginator->sort('feature_special_announcement') ?></th>
                    <th><?= $this->Paginator->sort('special_announcement_expiration') ?></th>
                    <th><?= $this->Paginator->sort('average_rating') ?></th>
                    <th><?= $this->Paginator->sort('reviews_approved') ?></th>
                    <th><?= $this->Paginator->sort('review_status') ?></th>
                    <th><?= $this->Paginator->sort('last_note_status') ?></th>
                    <th><?= $this->Paginator->sort('last_import_status') ?></th>
                    <th><?= $this->Paginator->sort('last_contact_date') ?></th>
                    <th><?= $this->Paginator->sort('is_last_edit_by_owner') ?></th>
                    <th><?= $this->Paginator->sort('last_edit_by_owner_date') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('completeness') ?></th>
                    <th><?= $this->Paginator->sort('redirect') ?></th>
                    <th><?= $this->Paginator->sort('email_status') ?></th>
                    <th><?= $this->Paginator->sort('is_email_ignore') ?></th>
                    <th><?= $this->Paginator->sort('id_yhn_location') ?></th>
                    <th><?= $this->Paginator->sort('review_needed') ?></th>
                    <th><?= $this->Paginator->sort('is_retail') ?></th>
                    <th><?= $this->Paginator->sort('direct_book_type') ?></th>
                    <th><?= $this->Paginator->sort('direct_book_url') ?></th>
                    <th><?= $this->Paginator->sort('direct_book_iframe') ?></th>
                    <th><?= $this->Paginator->sort('is_yhn') ?></th>
                    <th><?= $this->Paginator->sort('is_hh') ?></th>
                    <th><?= $this->Paginator->sort('is_cyhn') ?></th>
                    <th><?= $this->Paginator->sort('is_earq') ?></th>
                    <th><?= $this->Paginator->sort('is_bypassed') ?></th>
                    <th><?= $this->Paginator->sort('is_call_assist') ?></th>
                    <th><?= $this->Paginator->sort('timezone') ?></th>
                    <th><?= $this->Paginator->sort('optional_message') ?></th>
                    <th><?= $this->Paginator->sort('is_service_agreement_signed') ?></th>
                    <th><?= $this->Paginator->sort('is_junk') ?></th>
                    <th><?= $this->Paginator->sort('id_coupon') ?></th>
                    <th><?= $this->Paginator->sort('is_email_allowed') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locations as $location): ?>
                <tr>
                    <td><?= $this->Number->format($location->id) ?></td>
                    <td><?= h($location->id_oticon) ?></td>
                    <td><?= h($location->id_parent) ?></td>
                    <td><?= h($location->id_sf) ?></td>
                    <td><?= h($location->title) ?></td>
                    <td><?= h($location->subtitle) ?></td>
                    <td><?= h($location->address) ?></td>
                    <td><?= h($location->address_2) ?></td>
                    <td><?= h($location->city) ?></td>
                    <td><?= h($location->state) ?></td>
                    <td><?= h($location->zip) ?></td>
                    <td><?= h($location->country) ?></td>
                    <td><?= h($location->is_mobile) ?></td>
                    <td><?= h($location->mobile_text) ?></td>
                    <td><?= $this->Number->format($location->radius) ?></td>
                    <td><?= h($location->phone) ?></td>
                    <td><?= $this->Number->format($location->lat) ?></td>
                    <td><?= $this->Number->format($location->lon) ?></td>
                    <td><?= h($location->email) ?></td>
                    <td><?= h($location->logo_url) ?></td>
                    <td><?= h($location->url) ?></td>
                    <td><?= h($location->facebook) ?></td>
                    <td><?= h($location->twitter) ?></td>
                    <td><?= h($location->youtube) ?></td>
                    <td><?= h($location->created) ?></td>
                    <td><?= h($location->modified) ?></td>
                    <td><?= h($location->is_listing_type_frozen) ?></td>
                    <td><?= h($location->frozen_expiration) ?></td>
                    <td><?= $this->Number->format($location->oticon_tier) ?></td>
                    <td><?= $this->Number->format($location->yhn_tier) ?></td>
                    <td><?= h($location->listing_type) ?></td>
                    <td><?= h($location->is_ida_verified) ?></td>
                    <td><?= h($location->location_segment) ?></td>
                    <td><?= h($location->entity_segment) ?></td>
                    <td><?= $this->Number->format($location->title_status) ?></td>
                    <td><?= $this->Number->format($location->address_status) ?></td>
                    <td><?= $this->Number->format($location->phone_status) ?></td>
                    <td><?= h($location->is_title_ignore) ?></td>
                    <td><?= h($location->is_address_ignore) ?></td>
                    <td><?= h($location->is_phone_ignore) ?></td>
                    <td><?= h($location->is_active) ?></td>
                    <td><?= h($location->is_show) ?></td>
                    <td><?= h($location->is_grace_period) ?></td>
                    <td><?= h($location->grace_period_end) ?></td>
                    <td><?= h($location->is_geocoded) ?></td>
                    <td><?= h($location->filter_has_photo) ?></td>
                    <td><?= h($location->filter_insurance) ?></td>
                    <td><?= h($location->filter_evening_weekend) ?></td>
                    <td><?= h($location->filter_adult_hearing_test) ?></td>
                    <td><?= h($location->filter_hearing_aid_fitting) ?></td>
                    <td><?= h($location->badge_coffee) ?></td>
                    <td><?= h($location->badge_wifi) ?></td>
                    <td><?= h($location->badge_parking) ?></td>
                    <td><?= h($location->badge_curbside) ?></td>
                    <td><?= h($location->badge_wheelchair) ?></td>
                    <td><?= h($location->badge_service_pets) ?></td>
                    <td><?= h($location->badge_cochlear_implants) ?></td>
                    <td><?= h($location->badge_ald) ?></td>
                    <td><?= h($location->badge_pediatrics) ?></td>
                    <td><?= h($location->badge_mobile_clinic) ?></td>
                    <td><?= h($location->badge_financing) ?></td>
                    <td><?= h($location->badge_telehearing) ?></td>
                    <td><?= h($location->badge_asl) ?></td>
                    <td><?= h($location->badge_tinnitus) ?></td>
                    <td><?= h($location->badge_balance) ?></td>
                    <td><?= h($location->badge_home) ?></td>
                    <td><?= h($location->badge_remote) ?></td>
                    <td><?= h($location->badge_spanish) ?></td>
                    <td><?= h($location->badge_french) ?></td>
                    <td><?= h($location->badge_russian) ?></td>
                    <td><?= h($location->badge_chinese) ?></td>
                    <td><?= h($location->feature_content_library) ?></td>
                    <td><?= h($location->content_library_expiration) ?></td>
                    <td><?= h($location->feature_special_announcement) ?></td>
                    <td><?= h($location->special_announcement_expiration) ?></td>
                    <td><?= $this->Number->format($location->average_rating) ?></td>
                    <td><?= $this->Number->format($location->reviews_approved) ?></td>
                    <td><?= h($location->review_status) ?></td>
                    <td><?= $this->Number->format($location->last_note_status) ?></td>
                    <td><?= $this->Number->format($location->last_import_status) ?></td>
                    <td><?= h($location->last_contact_date) ?></td>
                    <td><?= h($location->is_last_edit_by_owner) ?></td>
                    <td><?= h($location->last_edit_by_owner_date) ?></td>
                    <td><?= h($location->priority) ?></td>
                    <td><?= h($location->completeness) ?></td>
                    <td><?= h($location->redirect) ?></td>
                    <td><?= $this->Number->format($location->email_status) ?></td>
                    <td><?= h($location->is_email_ignore) ?></td>
                    <td><?= h($location->id_yhn_location) ?></td>
                    <td><?= $this->Number->format($location->review_needed) ?></td>
                    <td><?= h($location->is_retail) ?></td>
                    <td><?= h($location->direct_book_type) ?></td>
                    <td><?= h($location->direct_book_url) ?></td>
                    <td><?= h($location->direct_book_iframe) ?></td>
                    <td><?= h($location->is_yhn) ?></td>
                    <td><?= h($location->is_hh) ?></td>
                    <td><?= h($location->is_cyhn) ?></td>
                    <td><?= h($location->is_earq) ?></td>
                    <td><?= h($location->is_bypassed) ?></td>
                    <td><?= h($location->is_call_assist) ?></td>
                    <td><?= h($location->timezone) ?></td>
                    <td><?= h($location->optional_message) ?></td>
                    <td><?= h($location->is_service_agreement_signed) ?></td>
                    <td><?= h($location->is_junk) ?></td>
                    <td><?= $this->Number->format($location->id_coupon) ?></td>
                    <td><?= h($location->is_email_allowed) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $location->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $location->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
