<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use Cake\Core\Configure;

$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'login', 'url' => ''],
]);
$this->set('title', 'Login');

$this->Html->script('dist/common.min.js', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row">
                <header class="col-lg-12 inverse breadcrumb-header">
                    <?= $this->Breadcrumbs->render(); ?>
                    <?= $this->element('breadcrumb_schema') ?>
                    <div id="ellipses">...</div>
                </header>
                <div class="col-sm-12 panel-parent">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="panel-section expanded">
                                <h1 style="display:inline-block">Login</h1>
                                <div class="users form">
                                    <?= $this->Flash->render('auth') ?>
                                    <?= $this->Form->create() ?>
                                    <fieldset>
                                        <?= $this->Form->control('username', ['label' => 'Email or Username', 'required' => true]) ?>
                                        <small class="mb10 col-md-offset-3 col-md-9">Your username was provided in an email from <?= $siteName ?></small>
                                        <?= $this->Form->control('password') ?>
                                        <?php
                                        if (Configure::read('Users.reCaptcha.login')) {
                                            echo $this->User->addReCaptcha();
                                        }
                                        if (Configure::read('Users.RememberMe.active')) {
                                            echo $this->Form->control(Configure::read('Users.Key.Data.rememberMe'), [
                                                'type' => 'checkbox',
                                                'label' => __d('cake_d_c/users', 'Remember me'),
                                                'checked' => Configure::read('Users.RememberMe.checked'),
                                            ]);
                                        }
                                        ?>
                                        <?php
                                        $registrationActive = Configure::read('Users.Registration.active');
                                        if ($registrationActive) {
                                            echo $this->Html->link(__d('cake_d_c/users', 'Register'), ['action' => 'register']);
                                        }
                                        if (Configure::read('Users.Email.required')) {
                                            if ($registrationActive) {
                                                echo ' | ';
                                            }
                                            echo $this->Html->link(__d('cake_d_c/users', 'Reset Password'), ['action' => 'requestResetPassword'], ['class' => 'd-block clearfix mb-3']);
                                        }
                                        ?>
                                    </fieldset>
                                    <?= implode(' ', $this->User->socialLoginList()); ?>
                                    <?= $this->Form->button(__d('cake_d_c/users', 'Login'), ['class' => 'btn btn-primary btn-lg']); ?>
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
