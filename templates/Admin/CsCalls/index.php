<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */

$this->Html->script('dist/ca_call_index.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Ca Calls Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <!--*** TODO: export function will need to be built out in controller ***-->
                <?= $this->Form->button(' Export', ['type' => 'button', 'id' => 'exportBtn', 'class' => 'btn btn-default bi bi-download', 'escapeTitle' => false]) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Call Tracking Calls</h2>
                <!--*** TODO: add Cs Call search, advanced search and save search ***-->
                <div class="csCalls index content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('id') ?><br><?= $this->Paginator->sort('call_id', ['label' => 'CS Call ID']) ?></th>
                                    <!--*** TODO: pull in clinic names instead of clinic id's ***-->
                                    <th><?= $this->Paginator->sort('location_id', ['text' => 'Clinic']) ?></th>
                                    <th><?= $this->Paginator->sort('caller_lastname', ['text' => 'Caller Name']) ?></th>
                                    <th><?= $this->Paginator->sort('start_time') ?>/<br><?= $this->Paginator->sort('duration') ?></th>
                                    <th><?= $this->Paginator->sort('prospect') ?></th>
                                    <th><?= $this->Paginator->sort('leadscore') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($csCalls as $csCall): ?>
                                <tr>
                                    <td><?= $csCall->id ?><br><?= $csCall->call_id ?></td>
                                    <td><?= $csCall->has('location') ? $this->Html->link($csCall->location->title, ['controller' => 'Locations', 'action' => 'view', $csCall->location->id]) : '' ?></td>
                                    <td><?= h($csCall->caller_firstname) ?> <?= h($csCall->caller_lastname) ?></td>
                                    <td><?= h($csCall->start_time) ?><br><?= gmdate("H:i:s", $csCall->duration) ?></td>
                                    <td><?= h($csCall->prospect) ?></td>
                                    <td><?= h($csCall->leadscore) ?></td>
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
            </div>
        </div>
    </section>
</div>