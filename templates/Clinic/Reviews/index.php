<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Review> $reviews
 */

use Cake\View\Helper\Form;
?>
<div class="reviews index content">
    <h3><?= __('Reviews') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('body') ?></th>
                    <th><?= $this->Paginator->sort('rating') ?></th>
                    <th><?= $this->Paginator->sort('origin') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th>Respond</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= h($review->created) ?></td>
                    <td><?= h($review->first_name) ?></td>
                    <td><?= h($review->last_name) ?></td>
                    <td><?= h($review->body) ?></td>
                    <td><?= $this->Number->format($review->rating) ?></td>
                    <td><?= $this->Number->format($review->origin) ?></td>
                    <td><?= $this->Number->format($review->status) ?></td>
                    <td>
                        <?=
                            $this->Html->link(
                                'Response optional',
                                [
                                    'prefix' => 'Clinic',
                                    'controller' => 'Reviews',
                                    'action' => 'respond',
                                    $review->id
                                ],
                                [
                                    'class' => 'btn btn-primary'
                                ]
                            )
                        ?>
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
