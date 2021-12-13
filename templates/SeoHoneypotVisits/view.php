<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoHoneypotVisit $seoHoneypotVisit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Honeypot Visit'), ['action' => 'edit', $seoHoneypotVisit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Honeypot Visit'), ['action' => 'delete', $seoHoneypotVisit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoHoneypotVisit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Honeypot Visits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Honeypot Visit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoHoneypotVisits view content">
            <h3><?= h($seoHoneypotVisit->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoHoneypotVisit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= $this->Number->format($seoHoneypotVisit->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoHoneypotVisit->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
