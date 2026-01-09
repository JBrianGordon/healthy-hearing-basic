<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoStatusCode $seoStatusCode
 * @var string[]|\Cake\Collection\CollectionInterface $seoUris
 */

$this->Vite->script('admin_common','admin-vite');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Blacklists Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Redirects', ['controller' => 'seoRedirects', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Titles', ['controller' => 'seoTitles', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Uris', ['controller' => 'seoUris', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Add Seo Status Code</h2>
                <hr>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="seoStatusCodes form content">
                            <?= $this->Form->create($seoStatusCode) ?>
                            <fieldset>
                                <?php
                                    echo $this->Form->control('seo_uri.uri');
                                    echo $this->Form->control('status_code');
                                    echo $this->Form->control('priority');
                                ?>
                                <div class="col-md-9 col-md-offset-3 pl0">
                                    <?= $this->Form->control('is_active', ['label' => ' Active']) ?>
                                </div>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Save Status Code', ['class' => 'btn btn-primary btn-lg']) ?>
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
