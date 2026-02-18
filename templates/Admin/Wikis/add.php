<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */

use Cake\I18n\FrozenTime;

$this->Vite->script('wiki_edit','admin-vite');

$author_default = false;

if (empty($content->id)) {
    if (in_array($user->id, $authors)) {
        $author_default = $user->id;
    }
}
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Help Pages Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">                                    
                <div class="wikis form content">
                    <?= $this->Form->create($wiki, ['id' => 'wikisForm', 'type' => 'file']) ?>
                    <fieldset>
                        <?php
                            echo $this->Form->control('name');
                            echo $this->Form->control('slug');
                            echo $this->Form->control('user_id', [
                                'label' => 'Primary Author',
                                'options' => $authors,
                                'default' => $author_default,
                                'empty' => 'Select an author'
                            ]);
                            echo $this->Form->control('last_modified', [
                                'default' => FrozenTime::now()
                            ]);
                            echo '<div class="col-md-9 col-md-offset-3 pl0">';
                            echo $this->Form->control('is_active', ['label' => ' Active']);
                            echo '</div>';
                        ?>
                        <ul class="nav nav-tabs clearfix" role="tablist">
                            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-target="#details" data-bs-toggle="tab" type="button">Help</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#admin" data-bs-toggle="tab" type="button">Admin</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#tags" data-bs-toggle="tab" type="button">Tags</button></li>
                        </ul>
                        <div class="tab-content mt20">
                            <div class="tab-pane active" id="details">
                                <?= $this->Form->control('body', ['required' => false, 'class' => 'editor', 'label' => false]) ?>
                                <div class="ck-word-count tar w-100 mb-3"></div>
                                <?= $this->Form->control('short') ?>
                            </div>
                            <div class="tab-pane" id="admin">
                                <?php
                                    echo $this->Form->control('priority', [
                                        'required' => true,
                                        'label' => 'Order',
                                        'min' => -20,
                                        'max' => 1000,
                                    ]);
                                    echo $this->Form->control('title_head');
                                    echo $this->Form->control('title_h1');
                                    echo $this->Form->control('meta_description');
                                    echo $this->Form->control('facebook_title');
                                    echo $this->Form->control('facebook_description');
                                ?>
								<img id="facebook-imagePreview0" src="<?= $wiki->facebook_image_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3<?= $wiki->facebook_image_url ? '' : " d-none" ?>" alt="Facebook Image Preview" style="max-width: 100px; max-height: 100px;" />
								<input type="hidden" id="facebookImageUrl" name="facebook_image_url" class="d-none">
								<?php
									$inputValue = $this->Form->getValue('facebook_image_name');
									$class = isset($inputValue) ? 'mt-3 btn w-25' : 'mt-3 btn';
								?>

								<?=
									$this->Form->control('facebook_image_name', [
										'id' => 'facebook-imageUpload0',
										'class' => $class,
										'style' => 'background-color:#78afc9;color:#fff',
										'required' => false,
										'label' => ['text' => 'Update Facebook Image'],
										'placeholder' => 'Choose an image',
										'readonly' => true
									]);
								?>
                                <?php
									echo $this->Form->control('facebook_image_width', [
										'label' => 'Image Width (min 800px)',
										'readonly' => true,
									]);
									echo $this->Form->control('facebook_image_height', [
										'label' => 'Image Height',
										'readonly' => true,
									]);
				                    echo $this->Form->control('facebook_image_alt', ['label' => 'Image Alt Text', 'required' => false]);
				                ?>
                                <hr>
                                <h3>Additional Authors</h3>
                                <strong>
                                    <em class="text-secondary">Select multiple with the control key (PC) or command key (Mac)</em>
                                </strong>
                                <?=
                                    $this->Form->select('contributors._ids',
                                        $authors,
                                        [
                                            'empty' => "NO additional contributors",
                                            'multiple' => true,
                                            'size' => 14
                                        ]
                                    )
                                ?>
                                <h3 class="mt-5">Reviewers</h3>
                                <?= $this->Form->control('reviewers._ids', ['label' => false,'options' => $reviewers,'multiple' => 'checkbox']) ?>
                            </div>
                            <div class="tab-pane" id="tags">
                                <strong>A help/wiki page should only be associated with one tag. For now, repeated use of a tag is possible, so be aware of any conflicts. Before a tag can appear in the list below, it must be created in the <?= $this->Html->link('Tag admin panel', ['controller' => 'tags', 'action' => 'index'], ['target' => '_blank']) ?>.</strong>
                                <br>
                                <em>Select one tag</em>
                                <?= $this->Form->select('tags._ids', $tags) ?>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions tar">
                        <?= $this->Form->button(__('Save Help Page'), ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>