
<?php
use Cake\Core\Configure;
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Locations Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(" Browse", ['action' => 'index'], ['class' => 'btn btn-success bi bi-search', 'escape' => false]) ?>
                <?= $this->Html->link(" Edit", ['action' => 'edit', $locationId, '#' => 'CallSource'], ['class' => 'btn btn-default bi bi-pencil-fill', 'escapeTitle' => false]) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Raw CallSource Data <small class="text-muted">Location <?= $locationId ?></small></h2>
                <?php if (Configure::read('env') != 'prod'): ?>
                    <div class="alert alert-danger">Warning: This is the test CallSource environment. View on prod for accurate data.</div>
                <?php endif; ?>
                <?php pr($call_source); ?>
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-left"></span> Back to location edit',
                    ['admin' => true, 'controller' => 'locations', 'action' => 'edit', $locationId, '#' => 'CallSource'],
                    ['class' => 'btn btn-default', 'escape' => false]);
                ?>
            </div>
        </div>
    </section>
</div>
