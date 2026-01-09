<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUri $seoUri
 */

$this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Uris Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Redirects', ['controller' => 'seoRedirects', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Status Codes', ['controller' => 'seoStatusCodes', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Titles', ['controller' => 'seoTitles', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Add Seo Uri</h2>
                <hr>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="seoUris form content">
                            <?= $this->Form->create($seoUri) ?>
                            <fieldset>
                                <?= $this->Form->control('uri', ['required' => true]) ?>
                                <div class="col-md-9 col-md-offset-3 pl0">
                                    <?= $this->Form->control('is_approved') ?>
                                </div>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Save Uri', ['class' => 'btn btn-primary btn-lg']) ?>
                                <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-default btn-lg']) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>