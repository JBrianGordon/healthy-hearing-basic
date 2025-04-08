<?php
use Cake\Core\Configure;
//TODO: CSS
echo $this->Html->css('admin/imports.css?v='.Configure::read("tagVersion"));
echo $this->Html->script('dist/admin_location_link.min.js?v='.Configure::read("tagVersion"));
?>
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
        <strong>Search by Title, Subtitle, Address, City, <?php echo ucwords($zipShort); ?> or ID.</strong><br><br>
        <?= $this->Form->control('search', ['label' => 'Search', 'default' => $importLocation->title]) ?>
        <div class="form-actions tar">
            <a href="<?= $importIndexReferer ?>">
                <input type="button" tabindex="1" value="Cancel" class="btn btn-danger btn-lg">
            </a>
            <input type="button" tabindex="1" value="Search" class="btn btn-primary btn-lg" id="searchBtn" data-import-type="<?= $importLocation->import->type ?>">
        </div>
    <?= $this->Form->end() ?>
    <div id="searchResults" class="table-responsive"></div>
</div>
