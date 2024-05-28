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
                                    <?= $this->Form->create($advertisement) ?>
                                    <fieldset>
                                        <?php
                                            echo $this->Form->control('title');
                                            echo $this->Form->control('is_active');
                                            echo $this->Form->control('type');
                                            echo $this->Form->control('slot', ['required' => false]);
                                            echo $this->Form->control('dest', ['required' => false]);
                                            echo $this->Form->control('alt', ['required' => false]);
                                            echo $this->Form->control('src', ['required' => false]);
                                            echo $this->Form->control('tag_corps', ['required' => false]);
                                            echo $this->Form->control('tag_basic', ['required' => false]);
                                        ?>
                                    </fieldset>
                                    <?= $this->Form->button(__('Submit')) ?>
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>