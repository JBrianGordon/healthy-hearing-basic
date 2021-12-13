<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Review'), ['action' => 'edit', $review->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Review'), ['action' => 'delete', $review->id], ['confirm' => __('Are you sure you want to delete # {0}?', $review->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Review'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reviews view content">
            <h3><?= h($review->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $review->has('location') ? $this->Html->link($review->location->title, ['controller' => 'Locations', 'action' => 'view', $review->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($review->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($review->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($review->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($review->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($review->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rating') ?></th>
                    <td><?= $this->Number->format($review->rating) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($review->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Origin') ?></th>
                    <td><?= $this->Number->format($review->origin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Response Status') ?></th>
                    <td><?= $this->Number->format($review->response_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Character Count') ?></th>
                    <td><?= $this->Number->format($review->character_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($review->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($review->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Denied Date') ?></th>
                    <td><?= h($review->denied_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Spam') ?></th>
                    <td><?= $review->is_spam ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($review->body)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Response') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($review->response)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
