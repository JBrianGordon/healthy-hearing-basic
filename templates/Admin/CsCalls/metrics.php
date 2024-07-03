<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Cs Calls Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Call Tracking Metrics <small>(from CallSource LeadScoring)</small></h2>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="csCalls form content col col-md-6">
                            <!--*** TODO: functionality needs to be built out in controller ***-->
                            <?= $this->Form->create() ?>
                            <fieldset>
                                <?php
                                    echo $this->Form->control('start_date', ['type' => 'date']);
                                    echo $this->Form->control('end_date', ['type' => 'date']);
                                ?>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Find Report', ['class' => 'btn btn-primary btn-lg']) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>