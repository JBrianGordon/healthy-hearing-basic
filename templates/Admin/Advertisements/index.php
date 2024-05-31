<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Advertisement> $advertisements
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
                <header class="col-md-12 mt10">
                    <div class="panel panel-light">
                        <div class="panel-heading">Ads Actions</div>
                        <div class="panel-body p10">
                            <div class="btn-group">
                                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                            </div>
                        </div>
                    </div>
                </header>						
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="panel-section expanded">
                                <div class="wikis index">
                                    <h2>Advertisements</h2>
                                    <?= $this->element('pagination') ?>
                                    <!-- ***TODO*** : Populate fields for advanced search --> 
                                    <?= $this->element('advanced_search') ?>
                                    <div class="advertisements index content">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-condensed mt20">
                                                <thead>
                                                    <tr>
                                                        <th><?= $this->Paginator->sort('id') ?></th>
                                                        <th><?= $this->Paginator->sort('is_active') ?></th>
                                                        <th style="width:450px"><?= $this->Paginator->sort('title') ?><br><?= $this->Paginator->sort('src') ?></th>
                                                        <th><?= $this->Paginator->sort('slot') ?><br><?= $this->Paginator->sort('type') ?></th>
                                                        <th><?= $this->Paginator->sort('tag_corps') ?></th>
                                                        <th><?= $this->Paginator->sort('tag_basic') ?></th>
                                                        <th><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('modified') ?></th>
                                                        <th class="actions">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($advertisements as $advertisement): ?>
                                                    <tr>
                                                        <td><?= $this->Number->format($advertisement->id) ?></td>
                                                        <td><?= h($advertisement->is_active) ? "<span class='badge bg-success bi bi-check-lg'> Active</span>" : "<span class='badge bg-danger bi bi-x-lg'> Inactive</span>"; ?></td>
                                                        <td><?= h($advertisement->title) ?><br><?= h($advertisement->src) ?></td>
                                                        <td><?= h($advertisement->slot) ?><br><span class="label label-default"><?= h($advertisement->type) ?></span></td>
                                                        <td><?= h($advertisement->tag_corps) ?></td>
                                                        <td><?= h($advertisement->tag_basic) ?></td>
                                                        <td><?= date('m/d/Y', strtotime($advertisement->created)) ?><br><?= date('m/d/Y', strtotime($advertisement->modified)) ?></td>
                                                        <td class="actions">
                                                            <?= $this->Html->link('Edit', ['action' => 'edit', $advertisement->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?= $this->element('pagination') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>