<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoRedirect $seoRedirect
 * @var \Cake\Collection\CollectionInterface|string[] $seoUris
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Redirects Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Status codes', ['controller' => 'seoStatusCodes', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
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
                <h2>Add Seo Redirect</h2>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="seoRedirects form content">
                            <?= $this->Form->create($seoRedirect) ?>
                            <fieldset>
                                <?php
                                    /*** TODO: change seo_uri_id to a uri value ***/
                                    echo $this->Form->control('seo_uri_id', ['required' => true]);
                                    echo $this->Form->control('redirect', ['required' => true]);
                                ?>
                                <span class="help-block col-md-9 col-md-offset-3 pl0">Redirect via SeoAppError-&gt;catch404() will always be 301.</span>
                                <?= $this->Form->control('priority', ['required' => true]) ?>
                                <div class="col-md-9 col-md-offset-3 pl0">
                                    <?php
                                        echo $this->Form->control('is_nocache', ['label' => ' Instruct the browser to not cache the 301 redirect via cache headers.']);
                                        echo $this->Form->control('is_active', ['label' => ' Active']);
                                    ?>
                                </div>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Save Redirect', ['class' => 'btn btn-primary btn-lg']) ?>
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
