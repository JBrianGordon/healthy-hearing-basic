<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 * @var \App\Form\ContactUsForm $contactUsForm
 */

use Cake\Core\Configure;

$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => ('Contact '.Configure::read('siteName')), 'url' => '/contact-us']]);

$this->Html->script('dist/contact.min', ['block' => true]);
?>
<div class="container-fluid site-body blog">
    <div class="row">
        <div class="backdrop backdrop-gradient backdrop-height"></div>
        <div class="container">
            <div class="row noprint">
                <div class="col-sm-9 inverse">
                    <?= $this->Breadcrumbs->render(); ?>
                    <?= $this->element('breadcrumb_schema') ?>
                    <div id="ellipses">...</div>
                </div>
            </div>
            <div class="row page-content">
                <div class="col-lg-9 float-start">
                    <article class="panel">
                        <div class="panel-body anchor-underline">
                            <div class="panel-section expanded">
                                <h1 class="text-primary blog-title">Contact <?= $siteName ?></h1>

                                    <?= $this->Form->create($contactUsForm, ['class' => 'form-horizontal', 'role' => false, 'id' => 'PageContactUsForm']) ?>
                                        <p><strong>If you are trying to reach a specific clinic, please click on the "Find a clinic" menu above and enter your <?= strtolower(Configure::read('zipLabel')) ?>.</strong></p>
                                        <?php 
                                            echo $this->Form->control('first_name', ['placeholder' => 'First name', 'class' => 'col-sm-9 mb15', 'label' => ['class' => 'col-sm-3 control-label pl0 tal']]);
                                            echo $this->Form->control('last_name', ['placeholder' => 'Last name', 'class' => 'col-sm-9 mb15', 'label' => ['class' => 'col-sm-3 control-label pl0 tal']]);
                                            echo $this->Form->control('phone', ['placeholder' => 'Phone', 'class' => 'col-sm-9 mb15', 'label' => ['class' => 'col-sm-3 control-label pl0 tal']]);
                                            echo $this->Form->control('email', ['placeholder' => 'Email', 'class' => 'col-sm-9 mb15', 'label' => ['class' => 'col-sm-3 control-label pl0 tal'], 'required' => false]);
                                            echo $this->Form->control('zip', ['class' => 'col-sm-9 mb15', 'label' => ['text' => Configure::read('zipLabel'), 'class' => 'col-sm-3 control-label pl0 tal'], 'placeholder' => Configure::read('zipLabel')]);
                                            if (Configure::read('showNewsletter')) {
                                                echo $this->Form->control('subscribe', ['checked' => true,'type' => 'checkbox', 'class' => 'col-sm-offset-2', 'label' => ['class' => 'control-label pt5 pl45','text' => 'Subscribe to our newsletter']
                                                ]); 
                                            }
                                            echo $this->Form->control('hearing_care_professional', ['type' => 'checkbox', 'id' => 'ContactHearingCareProfessional', 'class' => 'col-sm-offset-2', 'label' => ['class' => 'control-label pt5 pl45','text' => 'I am a hearing care professional']]); ?>
                                        <div id="ContactCompany" style="display:none;">
                                            <?= $this->Form->control('company', ['class' => 'col-sm-9', 'label' => 'Practice Name', 'placeholder' => 'Practice Name', 'class' => 'col-sm-3']); ?>
                                        </div>
                                        <?php
                                            echo $this->Form->control('Robot.check', ['label' => ['text' => 'Leave blank', 'class' => 'hidden'], 'class' => 'hidden']);
                                            echo $this->Form->control('message', ['type' => 'textarea', 'class' => 'col-sm-9', 'label' => ['text' => 'Message', 'class' => 'col-sm-3 tar pl0'], 'maxlength' => '1000', 'style' => 'min-height:172px']);
                                            echo $this->Form->hidden('g-recaptcha-response', ['id' => 'g-recaptcha-response']); ?>
                                        <div class="w-100 d-flex flex-row-reverse">
                                            <?= $this->Recaptcha->display() ?>
                                        </div>
                                        <div class="form-actions tar">
                                            <input class="btn btn-primary btn-lg g-recaptcha mt20" data-sitekey="<?= Configure::read('recaptchaPublicKey') ?>" data-callback="onSubmit" type="submit" value="Send Message">
                                        </div>
                                        <small class="help-block p20 tar">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" rel="noopener" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" rel="noopener" target="_blank">Terms of Service</a> apply.</small>
                                    </form>
                                    <hr>
                                    <?= $page->content ?>
                            </div>
                        </div>
                    </article>
                </div>
                <?= $this->element('side_panel') ?>
            </div>
        </div>
    </div>
</div>
