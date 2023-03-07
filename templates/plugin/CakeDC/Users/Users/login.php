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

<?php $this->Html->script('dist/login.min', ['block' => true]); ?>
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 panel-parent">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h1 style="display:inline-block">Admin Login</h1>
								<!-- *** TODO: rewrite the link once the LocationUsers controller is built *** -->
								<p style="display:inline-block" class="pull-right">Looking for clinic login? <a href="/clinic/users/login">Click here</a>.</p>
								<div class="users form">
								    <?= $this->Flash->render('auth') ?>
								    <?= $this->Form->create() ?>
								    <fieldset>
								        <?= $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'required' => true]) ?>
								        <?= $this->Form->control('password', ['label' => __d('cake_d_c/users', 'Password'), 'required' => true]) ?>
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
