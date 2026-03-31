<?php
use Cake\Core\Configure;

$this->Vite->script('admin_location_link','admin');
?>
<meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Imports Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Dashboard', ['prefix' => 'Admin', 'controller' => 'import-locations', 'action' => 'index'], ['class' => 'btn btn-default bi bi-speedometer']) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="import index p20">
                    <h2>Location Link</h2>
                    <table class="table table-striped table-bordered table-condensed mt20">
                        <tr>
                            <th>Oticon ID</th>
                            <td><?= $importLocation->id_oticon ?></td>
                        </tr>
                        <tr>
                            <th><?= $externalIdLabel ?></th>
                            <td><?= $importLocation->id_external ?></td>
                        </tr>
                        <?php if ($importLocation->import->type == 'cqp'): ?>
                            <tr>
                                <th>CQP Practice ID</th>
                                <td><?= $importLocation->id_cqp_practice ?></td>
                            </tr>
                            <tr>
                                <th>CQP Office ID</th>
                                <td><?= $importLocation->id_cqp_office ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Office Name</th>
                            <td><?= $importLocation->title ?></td>
                        </tr>
                        <tr>
                            <th>Practice Name</th>
                            <td><?= $importLocation->subtitle ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>
                                <?= $importLocation->address ?><br>
                                <?php if (!empty($importLocation->address_2)): ?>
                                    <?= $importLocation->address_2 ?><br>
                                <?php endif; ?>
                                <?= $importLocation->city .', ' . $importLocation->state . ' ' . $importLocation->zip ?>
                            </td>
                        </tr>
                    </table>

                    <?= $this->Form->create($importLocation) ?>
                        <?php $helpText = "Search by Title, Subtitle, Address, City, ".ucwords($zipShort)." or ID."; ?>
                        <?php $defaultSearch = (Configure::read('country') == 'US') ? substr($importLocation->zip, 0, 5) : $importLocation->city; ?>
                        <?= $this->Form->control('search', [
                            'label' => 'Search',
                            'templates' => [
                                'inputContainer' => '{{content}}{{help}}',
                                'help' => '<small class="form-text text-muted col-md-offset-3 mb-3">{{content}}</small><br>'
                            ],
                            'help' => $helpText,
                            'default' => $defaultSearch,
                        ]) ?>
                        <div class="form-actions tar">
                            <a href="<?= $importIndexReferer ?>">
                                <input type="button" tabindex="1" value="Cancel" class="btn btn-danger btn-lg">
                            </a>
                            <input type="button" tabindex="1" value="Search" class="btn btn-primary btn-lg" id="searchBtn" data-import-type="<?= $importLocation->import->type ?>">
                        </div>
                    <?= $this->Form->end() ?>
                    <div id="searchResults" class="table-responsive"></div>
                    <br>
                    <div class="form-actions tar">
                        Didn't find a match?  <a href="/admin/imports/location_add/<?= $importLocation->id ?>" class="btn btn-default btn-xs bi bi-plus-circle-fill"> Add Location</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
