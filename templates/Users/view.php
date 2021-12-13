<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($user->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($user->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Middle Name') ?></th>
                    <td><?= h($user->middle_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Degrees') ?></th>
                    <td><?= h($user->degrees) ?></td>
                </tr>
                <tr>
                    <th><?= __('Credentials') ?></th>
                    <td><?= h($user->credentials) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= h($user->company) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($user->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($user->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address 2') ?></th>
                    <td><?= h($user->address_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($user->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($user->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($user->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($user->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($user->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Url') ?></th>
                    <td><?= h($user->image_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Thumb Url') ?></th>
                    <td><?= h($user->thumb_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Square Url') ?></th>
                    <td><?= h($user->square_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Micro Url') ?></th>
                    <td><?= h($user->micro_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recovery Email') ?></th>
                    <td><?= h($user->recovery_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinic Password') ?></th>
                    <td><?= h($user->clinic_password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timezone') ?></th>
                    <td><?= h($user->timezone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($user->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= $this->Number->format($user->modified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Corp Id') ?></th>
                    <td><?= $this->Number->format($user->corp_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timezone Offset') ?></th>
                    <td><?= $this->Number->format($user->timezone_offset) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lastlogin') ?></th>
                    <td><?= h($user->lastlogin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $user->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Hardened Password') ?></th>
                    <td><?= $user->is_hardened_password ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Admin') ?></th>
                    <td><?= $user->is_admin ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is It Admin') ?></th>
                    <td><?= $user->is_it_admin ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Agent') ?></th>
                    <td><?= $user->is_agent ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Call Supervisor') ?></th>
                    <td><?= $user->is_call_supervisor ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Author') ?></th>
                    <td><?= $user->is_author ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Deleted') ?></th>
                    <td><?= $user->is_deleted ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Csa') ?></th>
                    <td><?= $user->is_csa ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Writer') ?></th>
                    <td><?= $user->is_writer ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Title Dept Company') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->title_dept_company)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Bio') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->bio)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Corps') ?></h4>
                <?php if (!empty($user->corps)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Last Modified') ?></th>
                            <th><?= __('Modified By') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Title Long') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Abbr') ?></th>
                            <th><?= __('Short') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Notify Email') ?></th>
                            <th><?= __('Approval Email') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Website Url') ?></th>
                            <th><?= __('Website Url Description') ?></th>
                            <th><?= __('Pdf All Url') ?></th>
                            <th><?= __('Favicon') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Thumb Url') ?></th>
                            <th><?= __('Facebook Title') ?></th>
                            <th><?= __('Facebook Description') ?></th>
                            <th><?= __('Facebook Image') ?></th>
                            <th><?= __('Date Approved') ?></th>
                            <th><?= __('Id Old') ?></th>
                            <th><?= __('Is Approvalrequired') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Featured') ?></th>
                            <th><?= __('Id Draft Parent') ?></th>
                            <th><?= __('Wbc Config') ?></th>
                            <th><?= __('Order') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->corps as $corps) : ?>
                        <tr>
                            <td><?= h($corps->id) ?></td>
                            <td><?= h($corps->user_id) ?></td>
                            <td><?= h($corps->type) ?></td>
                            <td><?= h($corps->created) ?></td>
                            <td><?= h($corps->modified) ?></td>
                            <td><?= h($corps->last_modified) ?></td>
                            <td><?= h($corps->modified_by) ?></td>
                            <td><?= h($corps->title) ?></td>
                            <td><?= h($corps->title_long) ?></td>
                            <td><?= h($corps->slug) ?></td>
                            <td><?= h($corps->abbr) ?></td>
                            <td><?= h($corps->short) ?></td>
                            <td><?= h($corps->description) ?></td>
                            <td><?= h($corps->notify_email) ?></td>
                            <td><?= h($corps->approval_email) ?></td>
                            <td><?= h($corps->phone) ?></td>
                            <td><?= h($corps->website_url) ?></td>
                            <td><?= h($corps->website_url_description) ?></td>
                            <td><?= h($corps->pdf_all_url) ?></td>
                            <td><?= h($corps->favicon) ?></td>
                            <td><?= h($corps->address) ?></td>
                            <td><?= h($corps->thumb_url) ?></td>
                            <td><?= h($corps->facebook_title) ?></td>
                            <td><?= h($corps->facebook_description) ?></td>
                            <td><?= h($corps->facebook_image) ?></td>
                            <td><?= h($corps->date_approved) ?></td>
                            <td><?= h($corps->id_old) ?></td>
                            <td><?= h($corps->is_approvalrequired) ?></td>
                            <td><?= h($corps->is_active) ?></td>
                            <td><?= h($corps->is_featured) ?></td>
                            <td><?= h($corps->id_draft_parent) ?></td>
                            <td><?= h($corps->wbc_config) ?></td>
                            <td><?= h($corps->order) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Corps', 'action' => 'view', $corps->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Corps', 'action' => 'edit', $corps->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Corps', 'action' => 'delete', $corps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corps->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Content') ?></h4>
                <?php if (!empty($user->content)) : ?>
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
                        <?php foreach ($user->content as $content) : ?>
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
                <h4><?= __('Related Wikis') ?></h4>
                <?php if (!empty($user->wikis)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Consumer Guide Id') ?></th>
                            <th><?= __('Responsive Body') ?></th>
                            <th><?= __('Body') ?></th>
                            <th><?= __('Short') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Id Draft Parent') ?></th>
                            <th><?= __('Order') ?></th>
                            <th><?= __('Title Head') ?></th>
                            <th><?= __('Title H1') ?></th>
                            <th><?= __('Background File') ?></th>
                            <th><?= __('Meta Description') ?></th>
                            <th><?= __('Facebook Title') ?></th>
                            <th><?= __('Facebook Image') ?></th>
                            <th><?= __('Facebook Image Bypass') ?></th>
                            <th><?= __('Facebook Image Width') ?></th>
                            <th><?= __('Facebook Image Height') ?></th>
                            <th><?= __('Facebook Image Alt') ?></th>
                            <th><?= __('Facebook Description') ?></th>
                            <th><?= __('Last Modified') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Background Alt') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->wikis as $wikis) : ?>
                        <tr>
                            <td><?= h($wikis->id) ?></td>
                            <td><?= h($wikis->name) ?></td>
                            <td><?= h($wikis->slug) ?></td>
                            <td><?= h($wikis->user_id) ?></td>
                            <td><?= h($wikis->consumer_guide_id) ?></td>
                            <td><?= h($wikis->responsive_body) ?></td>
                            <td><?= h($wikis->body) ?></td>
                            <td><?= h($wikis->short) ?></td>
                            <td><?= h($wikis->is_active) ?></td>
                            <td><?= h($wikis->id_draft_parent) ?></td>
                            <td><?= h($wikis->order) ?></td>
                            <td><?= h($wikis->title_head) ?></td>
                            <td><?= h($wikis->title_h1) ?></td>
                            <td><?= h($wikis->background_file) ?></td>
                            <td><?= h($wikis->meta_description) ?></td>
                            <td><?= h($wikis->facebook_title) ?></td>
                            <td><?= h($wikis->facebook_image) ?></td>
                            <td><?= h($wikis->facebook_image_bypass) ?></td>
                            <td><?= h($wikis->facebook_image_width) ?></td>
                            <td><?= h($wikis->facebook_image_height) ?></td>
                            <td><?= h($wikis->facebook_image_alt) ?></td>
                            <td><?= h($wikis->facebook_description) ?></td>
                            <td><?= h($wikis->last_modified) ?></td>
                            <td><?= h($wikis->modified) ?></td>
                            <td><?= h($wikis->created) ?></td>
                            <td><?= h($wikis->background_alt) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Wikis', 'action' => 'view', $wikis->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Wikis', 'action' => 'edit', $wikis->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Wikis', 'action' => 'delete', $wikis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wikis->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Ca Call Group Notes') ?></h4>
                <?php if (!empty($user->ca_call_group_notes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Ca Call Group Id') ?></th>
                            <th><?= __('Body') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->ca_call_group_notes as $caCallGroupNotes) : ?>
                        <tr>
                            <td><?= h($caCallGroupNotes->id) ?></td>
                            <td><?= h($caCallGroupNotes->ca_call_group_id) ?></td>
                            <td><?= h($caCallGroupNotes->body) ?></td>
                            <td><?= h($caCallGroupNotes->status) ?></td>
                            <td><?= h($caCallGroupNotes->user_id) ?></td>
                            <td><?= h($caCallGroupNotes->created) ?></td>
                            <td><?= h($caCallGroupNotes->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CaCallGroupNotes', 'action' => 'view', $caCallGroupNotes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CaCallGroupNotes', 'action' => 'edit', $caCallGroupNotes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CaCallGroupNotes', 'action' => 'delete', $caCallGroupNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroupNotes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Ca Calls') ?></h4>
                <?php if (!empty($user->ca_calls)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Ca Call Group Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('Duration') ?></th>
                            <th><?= __('Call Type') ?></th>
                            <th><?= __('Recording Url') ?></th>
                            <th><?= __('Recording Duration') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->ca_calls as $caCalls) : ?>
                        <tr>
                            <td><?= h($caCalls->id) ?></td>
                            <td><?= h($caCalls->ca_call_group_id) ?></td>
                            <td><?= h($caCalls->user_id) ?></td>
                            <td><?= h($caCalls->start_time) ?></td>
                            <td><?= h($caCalls->duration) ?></td>
                            <td><?= h($caCalls->call_type) ?></td>
                            <td><?= h($caCalls->recording_url) ?></td>
                            <td><?= h($caCalls->recording_duration) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CaCalls', 'action' => 'view', $caCalls->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CaCalls', 'action' => 'edit', $caCalls->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CaCalls', 'action' => 'delete', $caCalls->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCalls->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Crm Searches') ?></h4>
                <?php if (!empty($user->crm_searches)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Search') ?></th>
                            <th><?= __('Is Public') ?></th>
                            <th><?= __('Order') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->crm_searches as $crmSearches) : ?>
                        <tr>
                            <td><?= h($crmSearches->id) ?></td>
                            <td><?= h($crmSearches->user_id) ?></td>
                            <td><?= h($crmSearches->model) ?></td>
                            <td><?= h($crmSearches->title) ?></td>
                            <td><?= h($crmSearches->search) ?></td>
                            <td><?= h($crmSearches->is_public) ?></td>
                            <td><?= h($crmSearches->order) ?></td>
                            <td><?= h($crmSearches->created) ?></td>
                            <td><?= h($crmSearches->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CrmSearches', 'action' => 'view', $crmSearches->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CrmSearches', 'action' => 'edit', $crmSearches->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CrmSearches', 'action' => 'delete', $crmSearches->id], ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearches->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Drafts') ?></h4>
                <?php if (!empty($user->drafts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Model Id') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Json') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->drafts as $drafts) : ?>
                        <tr>
                            <td><?= h($drafts->id) ?></td>
                            <td><?= h($drafts->model_id) ?></td>
                            <td><?= h($drafts->model) ?></td>
                            <td><?= h($drafts->user_id) ?></td>
                            <td><?= h($drafts->created) ?></td>
                            <td><?= h($drafts->modified) ?></td>
                            <td><?= h($drafts->json) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Drafts', 'action' => 'view', $drafts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Drafts', 'action' => 'edit', $drafts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Drafts', 'action' => 'delete', $drafts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $drafts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Icing Versions') ?></h4>
                <?php if (!empty($user->icing_versions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Model Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('Json') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->icing_versions as $icingVersions) : ?>
                        <tr>
                            <td><?= h($icingVersions->id) ?></td>
                            <td><?= h($icingVersions->model_id) ?></td>
                            <td><?= h($icingVersions->user_id) ?></td>
                            <td><?= h($icingVersions->model) ?></td>
                            <td><?= h($icingVersions->json) ?></td>
                            <td><?= h($icingVersions->created) ?></td>
                            <td><?= h($icingVersions->url) ?></td>
                            <td><?= h($icingVersions->ip) ?></td>
                            <td><?= h($icingVersions->is_delete) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'IcingVersions', 'action' => 'view', $icingVersions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'IcingVersions', 'action' => 'edit', $icingVersions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'IcingVersions', 'action' => 'delete', $icingVersions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $icingVersions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Notes') ?></h4>
                <?php if (!empty($user->location_notes)) : ?>
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
                        <?php foreach ($user->location_notes as $locationNotes) : ?>
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
                <h4><?= __('Related Pages') ?></h4>
                <?php if (!empty($user->pages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->pages as $pages) : ?>
                        <tr>
                            <td><?= h($pages->id) ?></td>
                            <td><?= h($pages->title) ?></td>
                            <td><?= h($pages->content) ?></td>
                            <td><?= h($pages->created) ?></td>
                            <td><?= h($pages->modified) ?></td>
                            <td><?= h($pages->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Pages', 'action' => 'view', $pages->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Pages', 'action' => 'edit', $pages->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pages', 'action' => 'delete', $pages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pages->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Queue Task Logs') ?></h4>
                <?php if (!empty($user->queue_task_logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Executed') ?></th>
                            <th><?= __('Scheduled') ?></th>
                            <th><?= __('Scheduled End') ?></th>
                            <th><?= __('Reschedule') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('End Time') ?></th>
                            <th><?= __('Cpu Limit') ?></th>
                            <th><?= __('Is Restricted') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Command') ?></th>
                            <th><?= __('Result') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->queue_task_logs as $queueTaskLogs) : ?>
                        <tr>
                            <td><?= h($queueTaskLogs->id) ?></td>
                            <td><?= h($queueTaskLogs->user_id) ?></td>
                            <td><?= h($queueTaskLogs->created) ?></td>
                            <td><?= h($queueTaskLogs->modified) ?></td>
                            <td><?= h($queueTaskLogs->executed) ?></td>
                            <td><?= h($queueTaskLogs->scheduled) ?></td>
                            <td><?= h($queueTaskLogs->scheduled_end) ?></td>
                            <td><?= h($queueTaskLogs->reschedule) ?></td>
                            <td><?= h($queueTaskLogs->start_time) ?></td>
                            <td><?= h($queueTaskLogs->end_time) ?></td>
                            <td><?= h($queueTaskLogs->cpu_limit) ?></td>
                            <td><?= h($queueTaskLogs->is_restricted) ?></td>
                            <td><?= h($queueTaskLogs->priority) ?></td>
                            <td><?= h($queueTaskLogs->status) ?></td>
                            <td><?= h($queueTaskLogs->type) ?></td>
                            <td><?= h($queueTaskLogs->command) ?></td>
                            <td><?= h($queueTaskLogs->result) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'QueueTaskLogs', 'action' => 'view', $queueTaskLogs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'QueueTaskLogs', 'action' => 'edit', $queueTaskLogs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'QueueTaskLogs', 'action' => 'delete', $queueTaskLogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queueTaskLogs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Queue Tasks') ?></h4>
                <?php if (!empty($user->queue_tasks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Executed') ?></th>
                            <th><?= __('Scheduled') ?></th>
                            <th><?= __('Scheduled End') ?></th>
                            <th><?= __('Reschedule') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('End Time') ?></th>
                            <th><?= __('Cpu Limit') ?></th>
                            <th><?= __('Is Restricted') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Command') ?></th>
                            <th><?= __('Result') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->queue_tasks as $queueTasks) : ?>
                        <tr>
                            <td><?= h($queueTasks->id) ?></td>
                            <td><?= h($queueTasks->user_id) ?></td>
                            <td><?= h($queueTasks->created) ?></td>
                            <td><?= h($queueTasks->modified) ?></td>
                            <td><?= h($queueTasks->executed) ?></td>
                            <td><?= h($queueTasks->scheduled) ?></td>
                            <td><?= h($queueTasks->scheduled_end) ?></td>
                            <td><?= h($queueTasks->reschedule) ?></td>
                            <td><?= h($queueTasks->start_time) ?></td>
                            <td><?= h($queueTasks->end_time) ?></td>
                            <td><?= h($queueTasks->cpu_limit) ?></td>
                            <td><?= h($queueTasks->is_restricted) ?></td>
                            <td><?= h($queueTasks->priority) ?></td>
                            <td><?= h($queueTasks->status) ?></td>
                            <td><?= h($queueTasks->type) ?></td>
                            <td><?= h($queueTasks->command) ?></td>
                            <td><?= h($queueTasks->result) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'QueueTasks', 'action' => 'view', $queueTasks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'QueueTasks', 'action' => 'edit', $queueTasks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'QueueTasks', 'action' => 'delete', $queueTasks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queueTasks->id)]) ?>
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
