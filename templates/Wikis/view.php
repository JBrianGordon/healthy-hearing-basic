<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Wiki'), ['action' => 'edit', $wiki->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Wiki'), ['action' => 'delete', $wiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wiki->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Wiki'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="wikis view content">
            <h3><?= h($wiki->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($wiki->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($wiki->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title Head') ?></th>
                    <td><?= h($wiki->title_head) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title H1') ?></th>
                    <td><?= h($wiki->title_h1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Background File') ?></th>
                    <td><?= h($wiki->background_file) ?></td>
                </tr>
                <tr>
                    <th><?= __('Meta Description') ?></th>
                    <td><?= h($wiki->meta_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Title') ?></th>
                    <td><?= h($wiki->facebook_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image') ?></th>
                    <td><?= h($wiki->facebook_image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Alt') ?></th>
                    <td><?= h($wiki->facebook_image_alt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Description') ?></th>
                    <td><?= h($wiki->facebook_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Background Alt') ?></th>
                    <td><?= h($wiki->background_alt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($wiki->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($wiki->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Draft Parent') ?></th>
                    <td><?= $this->Number->format($wiki->id_draft_parent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $this->Number->format($wiki->order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Width') ?></th>
                    <td><?= $this->Number->format($wiki->facebook_image_width) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Height') ?></th>
                    <td><?= $this->Number->format($wiki->facebook_image_height) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Modified') ?></th>
                    <td><?= h($wiki->last_modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($wiki->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($wiki->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $wiki->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Facebook Image Bypass') ?></th>
                    <td><?= $wiki->facebook_image_bypass ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Responsive Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($wiki->responsive_body)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($wiki->body)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Short') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($wiki->short)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($wiki->users)) : ?>
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
                        <?php foreach ($wiki->users as $users) : ?>
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
                            <td><?= h($users->lastlogin) ?></td>
                            <td><?= h($users->is_active) ?></td>
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
                <h4><?= __('Related Tag Wikis') ?></h4>
                <?php if (!empty($wiki->tag_wikis)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Wiki Id') ?></th>
                            <th><?= __('Tag Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($wiki->tag_wikis as $tagWikis) : ?>
                        <tr>
                            <td><?= h($tagWikis->id) ?></td>
                            <td><?= h($tagWikis->wiki_id) ?></td>
                            <td><?= h($tagWikis->tag_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TagWikis', 'action' => 'view', $tagWikis->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TagWikis', 'action' => 'edit', $tagWikis->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TagWikis', 'action' => 'delete', $tagWikis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tagWikis->id)]) ?>
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
