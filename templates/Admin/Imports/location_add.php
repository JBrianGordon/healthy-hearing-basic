<?php
use Cake\Core\Configure;

$searchButton = '
<a target="_blank" rel="noopener" href="https://www.google.com/search?q=' . urlencode($importLocation->title . ' ' . $importLocation->city) . ' "
    <button class="btn btn-lg btn-success">
        Search
    </button>
</a>
';

$this->Html->script('dist/admin_location_add.min.js?v='.Configure::read("tagVersion"));
?>
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
                <h2>Add Location from <?= strtoupper($importLocation->import->type) ?> Import</h2>
                <?= $this->Form->create($importLocation)?>
                    <?= $this->Form->control('title', ['label' => 'Title', 'default' => $importLocation->title]); ?>
                    <?= $this->Form->control('subtitle', ['label' => 'Subtitle', 'default' => $importLocation->subtitle]); ?>
                    <?= $this->Form->control('phone', ['label' => 'Phone', 'default' => $importLocation->phone]); ?>
                    <?= $this->Form->control('address', ['label' => 'Address 1', 'default' => $importLocation->address]); ?>
                    <?= $this->Form->control('address_2', ['label' => 'Address 2', 'default' => $importLocation->address_2]); ?>
                    <?= $this->Form->control('city', ['label' => 'City', 'default' => $importLocation->city]); ?>
                    <?= $this->Form->control('zip', ['label' => ucwords($zipShort), 'default' => $importLocation->zip]); ?>
                    <?= $this->Form->control('state', ['label' => ucwords($stateLabel), 'default' => $importLocation->state]); ?>
                    <?= $this->Form->control('email', ['label' => 'Email', 'default' => $importLocation->email]); ?>
                    <?= $this->Form->control('is_retail', ['label' => 'Is Retail', 'default' => $importLocation->is_retail, 'type' => 'boolean']); ?>
                    <?= $this->Form->control('id_oticon', ['label' => 'Oticon ID', 'default' => $importLocation->id_oticon, 'type' => 'text']); ?>
                    <?= $this->Form->control('url', ['label' => 'Website', 'default' => '', 'type' => 'text', 'wrapInput' => 'col col-md-7', 'after' => $searchButton]); ?>
                    <?php if ($importLocation->import->type == 'cqp'): ?>
                        <?= $this->Form->control('id_cqp_practice', ['label' => 'CQP practice ID', 'default' => $importLocation->id_cqp_practice, 'disabled' => true, 'type' => 'text']); ?>
                        <?= $this->Form->control('id_cqp_office', ['label' => 'CQP office ID', 'default' => $importLocation->id_cqp_office, 'disabled' => true, 'type' => 'text']); ?>
                        <?= $this->Form->hidden('id_cqp_practice', ['default' => $importLocation->id_cqp_practice]); ?>
                        <?= $this->Form->hidden('id_cqp_office', ['default' => $importLocation->id_cqp_office]); ?>
                        <?= $this->Form->hidden('id_external', ['default' => '']); ?>
                    <?php else: ?>
                        <?= $this->Form->control('id_external', ['label' => $externalIdLabel, 'default' => $importLocation->id_external, 'disabled' => true, 'type' => 'text']); ?>
                        <?= $this->Form->hidden('id_external', ['default' => $importLocation->id_external]); ?>
                    <?php endif; ?>

                    <div class="form-actions tar">
                        <a href="<?= $importIndexReferer; ?>">
                            <input type="button" tabindex="1" value="Cancel" class="btn btn-danger btn-lg">
                        </a>
                        <input type="submit" tabindex="1" value="Add Location" class="btn btn-primary btn-lg" id="submitBtn">
                    </div>
                </form>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </section>
</div>
