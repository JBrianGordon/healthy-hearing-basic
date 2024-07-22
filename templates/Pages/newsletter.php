<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 * @var \App\Form\NewsletterForm $newsletterForm
 */

$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => $siteName . " " . $page->title, 'url' => ''],
]);

$articles = null;

$this->Html->script('dist/content.min.js', ['block' => true]);
?>
<div class="container-fluid site-body blog p-sm-0 overflow-hidden">
  <div class="row">
    <div class="backdrop backdrop-gradient backdrop-height"></div>
    <div class="container">
      <div class="row noprint">
    <div class="col-sm-9 inverse">
        <ul class="breadcrumb">
            <?= $this->Breadcrumbs->render() ?>
            <?= $this->element('breadcrumb_schema') ?>
        </ul>
        <div id="ellipses">...</div>
    </div>
    </div>
      <div class="row page-content">
        <div class="col-sm-9">
            <article class="panel">
                <div class="panel-body">
                    <div class="panel-section expanded">
                        <h1>Healthy Hearing newsletter</h1>
                        <?php
                            echo $this->Form->create($newsletterForm);
                            $this->Form->setTemplates([
                                'inputContainer' => '<div class="mb-3 form-group text flex-column">{{content}}</div>',
                            ]);
                            echo $this->Form->control('first_name', ['label' => ['class' => 'tal pl0'], 'placeholder' => 'First name', 'class' => 'w-100']);
                            echo $this->Form->control('last_name', ['label' => ['class' => 'tal pl0'], 'placeholder' => 'Last name', 'class' => 'w-100']);
                            echo $this->Form->control('email', ['label' => ['text' => 'Email', 'class' => 'tal pl0'],'placeholder' => 'Email','class' => 'w-100' ]);
                            echo $this->Recaptcha->display();
                        ?>
                        <div class="form-actions tar">
                            <?= $this->Form->button('Sign Up', ['class' => 'btn btn-primary btn-lg']) ?>
                        </div>
                        <?php
                            echo $this->Form->end();
                            echo $page->content;
                        ?>
                    </div>
                </div>
            </article>
        </div>
        <?= $this->element('side_panel', ['articles' => $articles]) ?>
    </div>
</div>