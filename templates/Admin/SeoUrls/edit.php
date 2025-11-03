<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUrl $seoUrl
 */
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">SEO URLs Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
            </div>
        </div>
    </div>
</header>

<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <!-- TO-DO check for redirect, seo title, etc -->
                    <div class="alert alert-info mb-3" role="alert">
                        <strong>For the URL below, turning on the <u>410 or redirect</u> features below will turn off features further down the list:</strong>
                        <ul>
                            <li>Selecting <em><strong>Active 410</strong></em> overrides any redirect settings and title/meta parameters</li>
                            <li>Not selecting <em><strong>Active 410</strong></em>, but selecting <em><strong>Active Redirect</strong></em> will override any title/meta parameters</li>
                        </ul>
                    </div>
                <div class="wikis form content">
                    <?= $this->Form->create($seoUrl) ?>
                    <fieldset>
                        <?php
                            echo '<div class="col-md-9 col-md-offset-3 pl0">';
                            echo $this->Form->control('is_410', [
                                'label' => 'Active 410',
                            ]);
                            echo '</div>';
                            echo $this->Form->control('url');
                            echo $this->Form->control('redirect_url');
                            echo '<div class="col-md-9 col-md-offset-3 pl0">';
                            echo $this->Form->control('redirect_is_active', [
                                'label' => 'Active Redirect',
                            ]);
                            echo '</div>';
                            echo $this->Form->control('seo_title');
                            echo $this->Form->control('seo_meta_description');
                        ?>
                    </fieldset>
                    <div class="form-actions tar">
                        <?= $this->Form->button(__('Save SEO URL'), ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>