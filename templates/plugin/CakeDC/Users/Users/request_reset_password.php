<?php
/**
 * @var \CakeDC\Users\Model\Entity\User $user
 */

use Cake\Core\Configure;

$this->Vite->script('common','common');
?>
<div class="container-fluid site-body fap-cities">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-sm-12 panel-parent">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="panel-section expanded">
                                <div class="users form">
                                    <h1>Forgot Password</h1>
                                    <?= $this->Flash->render('auth') ?>
                                    <?= $this->Form->create($user) ?>
                                    <fieldset>
                                        <?= $this->Form->control('reference', ['label' => 'Account number', 'required' => true]) ?>
                                        <small>Having trouble logging in?  Please contact our Customer Support at <?= Configure::read('phone') ?> or <a href="mailto:<?= Configure::read('customer-support-email') ?>"><?= Configure::read('customer-support-email') ?></a>.</small>
                                    </fieldset>
                                    <div class="form-group pt20">
                                        <?= $this->Form->button(__d('cake_d_c/users', 'Reset password'), ['class' => 'btn btn-primary btn-lg']); ?>
                                    </div>
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
