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
                                        <?= $this->Form->control('title') ?>
                                        <div class="col-md-offset-3 col-md-9 mb10">
                                            <?= $this->Form->checkbox('is_active', ['hiddenField' => false]) ?> Active
                                        </div>
                                        <?php
                                            echo $this->Form->control('type');
                                            echo $this->Form->control('slot', ['required' => false]);
                                            echo $this->Form->control('dest', ['required' => false]);
                                            echo $this->Form->control('alt', ['required' => false]);
                                            echo $this->Form->control('src', ['required' => false]);
                                        ?>
                                    </fieldset>
                                    <hr>
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs clearfix" role="tablist">
                                            <li class="nav-item">
                                                <button class="nav-link active" data-bs-target="#Preview" data-bs-toggle="tab" aria-controls="Location" aria-expanded="true" type="button" role="tab">Preview</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-target="#Tags" data-bs-toggle="tab" aria-controls="Details" aria-expanded="false" type="button" role="tab">Tags</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content mt10">
                                        <div class="tab-pane active" id="Preview">
                                        <h4>Preview</h4>
                                            <div id="discover">
							                    <section id="adPanel" class="panel mb0">
                                                    <a href="<?= $advertisement->dest ?>" rel="sponsored nofollow noopener" class="img-responsive" title="<?= $advertisement->title ?>" id="adBlock" target="_blank">
                                                        <img id="adImage" class="ml0" src="<?= $advertisement->src ?>" data-value="ViewBanner_<?= $advertisement->id ?>" alt="<?= $advertisement->alt ?>" border="0" width="<?= $advertisement->width ?>px" height="<?= $advertisement->height ?>px">
                                                    </a>
                                                    <label for="adBlock" class="pull-right mb20"><i>Advertisement</i></label>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="Tags">
                                            <div class="control-group mb0">
                                                <div class="controls">
                                                    <h3 class="mb5">Exclusivity Tags</h3>
                                                    <p class="mb20">
                                                        Select tags to display this ad only on certain report pages that are related to this tag.<br>
                                                        If no tags are selected, it will be considered a "generic ad" and will display on all pages that don't have an exclusive ad.
                                                    </p>
                                                    <?= $this->Form->control('Wikis.Tags', ['label' => false,'options' => $tags,'multiple' => 'checkbox','escape' => false]) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions tar">
                                    <?= $this->Form->button(__('Save ad'), ['class' => 'btn btn-primary btn-lg']) ?>
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