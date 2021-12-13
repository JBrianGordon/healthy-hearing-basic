<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Advertisement $advertisement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Advertisement'), ['action' => 'edit', $advertisement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Advertisement'), ['action' => 'delete', $advertisement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $advertisement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Advertisements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Advertisement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="advertisements view content">
            <h3><?= h($advertisement->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($advertisement->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($advertisement->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Corp') ?></th>
                    <td><?= $advertisement->has('corp') ? $this->Html->link($advertisement->corp->title, ['controller' => 'Corps', 'action' => 'view', $advertisement->corp->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($advertisement->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Src') ?></th>
                    <td><?= h($advertisement->src) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dest') ?></th>
                    <td><?= h($advertisement->dest) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slot') ?></th>
                    <td><?= h($advertisement->slot) ?></td>
                </tr>
                <tr>
                    <th><?= __('Height') ?></th>
                    <td><?= h($advertisement->height) ?></td>
                </tr>
                <tr>
                    <th><?= __('Width') ?></th>
                    <td><?= h($advertisement->width) ?></td>
                </tr>
                <tr>
                    <th><?= __('Alt') ?></th>
                    <td><?= h($advertisement->alt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Class') ?></th>
                    <td><?= h($advertisement->class) ?></td>
                </tr>
                <tr>
                    <th><?= __('Style') ?></th>
                    <td><?= h($advertisement->style) ?></td>
                </tr>
                <tr>
                    <th><?= __('Onclick') ?></th>
                    <td><?= h($advertisement->onclick) ?></td>
                </tr>
                <tr>
                    <th><?= __('Onmouseover') ?></th>
                    <td><?= h($advertisement->onmouseover) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($advertisement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= $this->Number->format($advertisement->modified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Weight') ?></th>
                    <td><?= $this->Number->format($advertisement->weight) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($advertisement->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($advertisement->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active Expires') ?></th>
                    <td><?= h($advertisement->active_expires) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Ao') ?></th>
                    <td><?= $advertisement->is_ao ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Hh') ?></th>
                    <td><?= $advertisement->is_hh ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Sp') ?></th>
                    <td><?= $advertisement->is_sp ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Ei') ?></th>
                    <td><?= $advertisement->is_ei ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $advertisement->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag Corps') ?></th>
                    <td><?= $advertisement->tag_corps ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag Basic') ?></th>
                    <td><?= $advertisement->tag_basic ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Restrict Path') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($advertisement->restrict_path)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($advertisement->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
