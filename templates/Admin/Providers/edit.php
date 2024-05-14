<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Provider $provider
 */

$this->Html->script('dist/admin_providers.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Provider Pages Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Form->postLink(' Delete', ['action' => 'delete', $provider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $provider->id), 'class' => 'btn btn-danger bi bi-trash-fill']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="providers form content">
                    <?= $this->Form->create($provider) ?>
                    <fieldset>
                        <?php
                            echo $this->Form->control('first_name');
                            echo $this->Form->control('middle_name');
                            echo $this->Form->control('last_name');
                            echo $this->Form->control('credentials');
                            echo $this->Form->control('title');
                            echo $this->Form->control('email');
                            //*** TODO: Replace description with CKEditor instance ***
                            echo $this->Form->control('description', ['class' => 'editor']);
                            echo $this->Form->control('micro_url');
                            echo $this->Form->control('square_url');
                            echo $this->Form->control('thumb_url');
                            echo $this->Form->control('image_url');
                            echo '<div class="col-md-3 col-md-offset-3 pl0 mb-3">';
                            echo $this->Form->control('is_active');
                            echo '</div>';
                            echo $this->Form->control('phone');
                            echo $this->Form->control('priority');
                            echo $this->Form->control('aud_or_his');
                            echo '<div class="col-md-3 col-md-offset-3 pl0 mb-3">';
                            echo $this->Form->control('is_ida_verified');
                            echo '</div>';
                            echo $this->Form->control('id_yhn_provider');
                            echo '<div class="mb-3 form-group text"><label class="form-label col-sm-3" for="location-association-list">Associated Locations</label><div id="location-association-list" class="col-xs-12 p0">';
                            foreach ($provider->locations as $key => $location) {
                                echo '<div class="associated-location col-sm-9 p0" data-location-key=' .$key .'">';
                                echo $this->Form->control("locations.{$key}.id");
                                echo $this->Form->text($location->title, ['value' => $location->title, 'readonly' => true, 'class' => 'd-inline-block mb10']);
                                //echo $this->Form->label("locations.{$key}.id", $location->title);
                                echo $this->Form->button('Delete',['data-location-key' => $key, 'class' => 'delete-location-association btn btn-danger ml20 mb10', 'type' => 'button']);
                                echo '</div>';
                            }
                            echo '</div></div>';
                            echo $this->Form->control('locations-query', ['id' => 'locations-query', 'label' => 'Add an associated clinic']);
                        ?>
                        <div id="query-results" class="col-sm-offset-3"></div>
                    </fieldset><br>
                    <?= '<div class="form-actions tar clearfix">'
                        . $this->Form->button('Save Provider', ['class' => 'btn btn-primary btn-lg'])
                        . '</div>' ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>