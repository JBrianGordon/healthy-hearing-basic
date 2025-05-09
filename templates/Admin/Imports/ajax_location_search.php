<?php
use Cake\Core\Configure;
?>
<table class="table table-striped table-bordered table-condensed mt20 locationresults"> 
<?php if (empty($locations)): ?>
    <tr>
        <td class="text-center">No results found.</td>
    </tr>
<?php else: ?>
    <tr>
        <th>
            <?php if (Configure::read('isCqpImportEnabled')): ?>
                Oticon/YHN/<br>CQP IDs
            <?php else: ?>
                Oticon ID<br>
                <?= $externalIdLabel ?>
            <?php endif; ?>
        </th>
        <th>Title</th>
        <th>
            <?php if (Configure::read('isTieringEnabled')): ?>
                Listing Type<br>
            <?php endif; ?>
            Status
        </th>
        <th>Address</th>
        <th>City/<?= ucfirst($stateLabel) ?></th>
        <th></th>
    </tr>
<?php endif; ?>
<?php foreach ($locations AS $location): ?>
    <tr>
        <td>
            <?php if (!empty($location->id_oticon)): ?>
                <span class="badge bg-oticon"><?= $location->id_oticon ?></span><br>
            <?php endif; ?>
            <?php if (!empty($location->id_yhn_location)): ?>
                <span class="badge bg-yhn"><?= $location->id_yhn_location ?></span><br>
            <?php endif; ?>
            <?php if (!empty($location->id_cqp_practice)): ?>
                <span class="badge bg-cqp"><?= $location->id_cqp_practice ?></span><br>
            <?php endif; ?>
            <?php if (!empty($location->id_cqp_office)): ?>
                <span class="badge bg-cqp"><?= $location->id_cqp_office ?></span><br>
            <?php endif; ?>
        </td>
        <td>
            <a href="/admin/locations/edit/<?= $location->id ?>" target="_blank">
                <?= $location->title ?>
            </a>
        </td>
        <td nowrap>
            <?php if (Configure::read('isTieringEnabled')): ?>
                <?= $location->listing_type ?><br>
            <?php endif; ?>
            <?php if ($location->is_show): ?>
                <span class="badge bg-success">Show</span>
            <?php else: ?>
                <span class="badge bg-danger">No Show</span>
            <?php endif; ?>
            <?php if ($location->is_active): ?>
                <span class="badge bg-success">Active</span>
            <?php else: ?>
                <span class="badge bg-danger">Inactive</span>
            <?php endif; ?>
        </td>
        <td><?= $location->address ?></td>
        <td><?= $location->city ?>, <?= $location->state ?> <?= $location->zip ?></td>
        <td>
            <?php if ($importType == 'cqp'): ?>
                <?php if (!empty($location->id_yhn_location)): ?>
                    <span class="badge bg-yhn">YHN Linked</span><br>
                <?php endif; ?>
                <?php if (!empty($location->id_cqp_office)): ?>
                    <span class="badge bg-cqp">CQP Linked</span><br>
                    <div class="btn-group btn-group-vertical">
                        <?php echo $this->Html->link(' Link', "?location_id=".$location->id, ['escape' => false, 'class' => 'btn btn-default btn-xs bi bi-link-45deg'], 'This location is already linked. The existing CQP practice and office IDs will be overwritten with the new id. Are you sure?'); ?>
                    </div>
                <?php else: ?>
                    <div class="btn-group btn-group-vertical">
                        <a href="?location_id=<?= $location->id ?>" class="btn btn-default btn-xs bi bi-link-45deg"> Link</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (!empty($location->id_cqp_office)): ?>
                    <span class="badge bg-cqp">CQP Linked</span><br>
                <?php endif; ?>
                <?php if (!empty($location->id_yhn_location)): ?>
                    <span class="badge bg-success"><?= Configure::read('importTag') ?> Linked</span><br>
                    <div class="btn-group btn-group-vertical">
                        <?php echo $this->Html->link(' Link', "?location_id=".$location->id, ['escape' => false, 'class' => 'btn btn-default btn-xs bi bi-link-45deg'], 'This location is already linked. The existing YHN ID will be overwritten with the new id. Are you sure?'); ?>
                    </div>
                <?php else: ?>
                    <div class="btn-group btn-group-vertical">
                        <a href="?location_id=<?= $location->id ?>" class="btn btn-default btn-xs bi bi-link-45deg"> Link</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
