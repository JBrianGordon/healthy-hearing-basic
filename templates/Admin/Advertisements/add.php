<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Advertisement $advertisement
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <header class="col-md-12 mt10">
                    <div class="panel panel-light">
                        <div class="panel-heading">Pages Actions</div>
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
                                <div class="advertisements form content">
                                    <?= $this->Form->create($advertisement, ['type' => 'file']) ?>
                                    <fieldset>
                                        <?= $this->Form->control('title') ?>
                                        <div class="col-md-offset-3 col-md-9 mb10">
                                            <?= $this->Form->checkbox('is_active', ['hiddenField' => false]) ?> Active
                                        </div>
                                        <?= $this->Form->control('type'); ?>
                                        <?= $this->Form->control('slot'); ?>
                                        <?= $this->Form->control('src', ['id' => 'imageUpload', 'type' => 'file', 'required' => false]); ?>
                                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;" />
                                        <?= $this->Form->control('dest', ['required' => false]); ?>
                                        <?= $this->Form->control('alt', ['required' => false]); ?>
                                    </fieldset>
                                    <div class="form-actions tar">
                                        <?= $this->Form->button(__('Save ad'), ['class' => 'btn btn-primary btn-lg']) ?>
                                        <?= $this->Form->end() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('imageUpload').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
