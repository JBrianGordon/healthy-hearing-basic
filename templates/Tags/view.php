<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tags view content">
            <h3><?= h($tag->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($tag->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Display Header') ?></th>
                    <td><?= h($tag->display_header) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ribbon Header') ?></th>
                    <td><?= h($tag->ribbon_header) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tag->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($tag->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($tag->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Category') ?></th>
                    <td><?= $tag->is_category ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Sub Category') ?></th>
                    <td><?= $tag->is_sub_category ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Header') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tag->header)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Content') ?></h4>
                <?php if (!empty($tag->content)) : ?>
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
                        <?php foreach ($tag->content as $content) : ?>
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
                <h4><?= __('Related Tag Ads') ?></h4>
                <?php if (!empty($tag->tag_ads)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Ad Id') ?></th>
                            <th><?= __('Tag Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tag->tag_ads as $tagAds) : ?>
                        <tr>
                            <td><?= h($tagAds->id) ?></td>
                            <td><?= h($tagAds->ad_id) ?></td>
                            <td><?= h($tagAds->tag_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TagAds', 'action' => 'view', $tagAds->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TagAds', 'action' => 'edit', $tagAds->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TagAds', 'action' => 'delete', $tagAds->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tagAds->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tag Wikis') ?></h4>
                <?php if (!empty($tag->tag_wikis)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Wiki Id') ?></th>
                            <th><?= __('Tag Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tag->tag_wikis as $tagWikis) : ?>
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
