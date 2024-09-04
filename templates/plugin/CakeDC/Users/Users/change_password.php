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

$this->Html->script('dist/common.min.js', ['block' => true]);
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
                                    <?= $this->Flash->render('auth') ?>
                                    <?= $this->Form->create($user) ?>
                                    <fieldset>
                                        <h2 class="mb30">Please enter a new password</h2>
                                        <?php if ($validatePassword) : ?>
                                            <?= $this->Form->control('current_password', [
                                                'type' => 'password',
                                                'required' => true,
                                                'label' => __d('cake_d_c/users', 'Current password')]);
                                            ?>
                                        <?php endif; ?>
                                        <?= $this->Form->control('password', [
                                            'type' => 'password',
                                            'required' => true,
                                            'label' => __d('cake_d_c/users', 'New password')]);
                                        ?>
                                        <?= $this->Form->control('password_confirm', [
                                            'type' => 'password',
                                            'required' => true,
                                            'label' => __d('cake_d_c/users', 'Confirm password')]);
                                        ?>
                                    </fieldset>
                                    <div class="form-actions tar">
                                        <?= $this->Form->button(__d('cake_d_c/users', 'Change Password'), ['class' => 'btn btn-primary btn-lg']); ?>
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
