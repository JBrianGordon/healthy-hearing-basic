<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Corp'), ['action' => 'edit', $corp->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Corp'), ['action' => 'delete', $corp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corp->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Corps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Corp'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="corps view content">
            <h3><?= h($corp->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($corp->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($corp->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title Long') ?></th>
                    <td><?= h($corp->title_long) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($corp->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Abbr') ?></th>
                    <td><?= h($corp->abbr) ?></td>
                </tr>
                <tr>
                    <th><?= __('Notify Email') ?></th>
                    <td><?= h($corp->notify_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approval Email') ?></th>
                    <td><?= h($corp->approval_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($corp->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Website Url') ?></th>
                    <td><?= h($corp->website_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Website Url Description') ?></th>
                    <td><?= h($corp->website_url_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pdf All Url') ?></th>
                    <td><?= h($corp->pdf_all_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Favicon') ?></th>
                    <td><?= h($corp->favicon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($corp->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Thumb Url') ?></th>
                    <td><?= h($corp->thumb_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Title') ?></th>
                    <td><?= h($corp->facebook_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Description') ?></th>
                    <td><?= h($corp->facebook_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image') ?></th>
                    <td><?= h($corp->facebook_image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($corp->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($corp->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= $this->Number->format($corp->modified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Old') ?></th>
                    <td><?= $this->Number->format($corp->id_old) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Approvalrequired') ?></th>
                    <td><?= $this->Number->format($corp->is_approvalrequired) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Draft Parent') ?></th>
                    <td><?= $this->Number->format($corp->id_draft_parent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= $this->Number->format($corp->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($corp->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($corp->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Modified') ?></th>
                    <td><?= h($corp->last_modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Approved') ?></th>
                    <td><?= h($corp->date_approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $corp->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Featured') ?></th>
                    <td><?= $corp->is_featured ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Short') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($corp->short)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($corp->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Wbc Config') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($corp->wbc_config)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($corp->users)) : ?>
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
                        <?php foreach ($corp->users as $users) : ?>
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
                <h4><?= __('Related Advertisements') ?></h4>
                <?php if (!empty($corp->advertisements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Modified By') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Corp Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Src') ?></th>
                            <th><?= __('Dest') ?></th>
                            <th><?= __('Slot') ?></th>
                            <th><?= __('Height') ?></th>
                            <th><?= __('Width') ?></th>
                            <th><?= __('Alt') ?></th>
                            <th><?= __('Class') ?></th>
                            <th><?= __('Style') ?></th>
                            <th><?= __('Onclick') ?></th>
                            <th><?= __('Onmouseover') ?></th>
                            <th><?= __('Weight') ?></th>
                            <th><?= __('Active Expires') ?></th>
                            <th><?= __('Restrict Path') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Is Ao') ?></th>
                            <th><?= __('Is Hh') ?></th>
                            <th><?= __('Is Sp') ?></th>
                            <th><?= __('Is Ei') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Tag Corps') ?></th>
                            <th><?= __('Tag Basic') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($corp->advertisements as $advertisements) : ?>
                        <tr>
                            <td><?= h($advertisements->id) ?></td>
                            <td><?= h($advertisements->created) ?></td>
                            <td><?= h($advertisements->modified) ?></td>
                            <td><?= h($advertisements->modified_by) ?></td>
                            <td><?= h($advertisements->title) ?></td>
                            <td><?= h($advertisements->slug) ?></td>
                            <td><?= h($advertisements->corp_id) ?></td>
                            <td><?= h($advertisements->type) ?></td>
                            <td><?= h($advertisements->src) ?></td>
                            <td><?= h($advertisements->dest) ?></td>
                            <td><?= h($advertisements->slot) ?></td>
                            <td><?= h($advertisements->height) ?></td>
                            <td><?= h($advertisements->width) ?></td>
                            <td><?= h($advertisements->alt) ?></td>
                            <td><?= h($advertisements->class) ?></td>
                            <td><?= h($advertisements->style) ?></td>
                            <td><?= h($advertisements->onclick) ?></td>
                            <td><?= h($advertisements->onmouseover) ?></td>
                            <td><?= h($advertisements->weight) ?></td>
                            <td><?= h($advertisements->active_expires) ?></td>
                            <td><?= h($advertisements->restrict_path) ?></td>
                            <td><?= h($advertisements->notes) ?></td>
                            <td><?= h($advertisements->is_ao) ?></td>
                            <td><?= h($advertisements->is_hh) ?></td>
                            <td><?= h($advertisements->is_sp) ?></td>
                            <td><?= h($advertisements->is_ei) ?></td>
                            <td><?= h($advertisements->is_active) ?></td>
                            <td><?= h($advertisements->tag_corps) ?></td>
                            <td><?= h($advertisements->tag_basic) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Advertisements', 'action' => 'view', $advertisements->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Advertisements', 'action' => 'edit', $advertisements->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Advertisements', 'action' => 'delete', $advertisements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $advertisements->id)]) ?>
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
