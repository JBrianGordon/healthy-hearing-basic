<?php
use Cake\Core\Configure;
$this->Vite->script('common','common-vite');
$user = $location->users[0];
?>

<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container">
          <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-md-12">
            		<section class="panel">
                        <div class="panel-body">
                            <div class="panel-section expanded">
                                <h1 >My Account</h1>
                                <?= $this->Form->create($location) ?>
                                    <?php if ($isInactiveClinic): ?>
                                        <div class="alert alert-danger" role="alert">The clinic profile associated with this account number is not currently showing in the <?php echo Configure::read('siteUrl'); ?> clinic directory. For assistance, please call <?php echo $siteName; ?> at <?php echo Configure::read('phone'); ?>.</div>
                                    <?php endif; ?>
                                    <div class="form-group"><div class="col-md-offset-3 col-md-9 pl0">
                                        <h4 class="mb0"><span class="badge bg-secondary"><i class="bi bi-person-fill"></i> Account Number: <?php echo $user['username']; ?></span></h4>
                                    </div></div>
                                    <?php
                                    echo $this->Form->hidden('users.0.id');
                                    echo $this->Form->control('users.0.username', ['disabled' => true]);
                                    echo $this->Form->control('users.0.first_name');
                                    echo $this->Form->control('users.0.last_name');
                                    echo $this->Form->control('users.0.email', [
                                        'required' => true,
                                    ]);
                                    ?>
                                    <?php if (!empty($locationId)): ?>
                                        <br /><hr />
                                        <h3>Additional Notifications</h3>
                                        <?
                                        $emailCount = 0;
                                        foreach ($location->location_emails as $i => $locationEmail) {
                                            if (!empty ($locationEmail['id'])) {
                                                $emailCount++;
                                                echo $this->Html->link('Delete This Email', array('clinic' => true, 'controller' => 'LocationEmails', 'action' => 'delete', $locationEmail['id']), ['confirm' => __('Are you sure you want to delete {0}?', $locationEmail['email'])]);
                                                echo $this->Form->hidden("location_emails.$i.id", [
                                                    'value' => $locationEmail['id']
                                                ]);
                                                echo $this->Form->hidden("location_emails.$i.location_id", [
                                                    'value' => $locationEmail['location_id']
                                                ]);
                                                foreach (['email','first_name','last_name'] as $field) {
                                                    echo $this->Form->control("location_emails.$i.$field", [
                                                        'value' => isset($locationEmail[$field]) ? $locationEmail[$field] : ''
                                                    ]);
                                                }
                                                echo '<hr />';
                                            }
                                        }
                                        echo $this->Html->link('Add Another Email', '',
                                            ['onclick' => "document.getElementById('additional-notification').style.display = 'block'; return false;"]);
                                        $i=$emailCount;
                                        $style = !empty($location->location_emails[$i]) ? '' : 'display:none;';
                                        ?>
                                        <div id="additional-notification" style="<?= $style ?>">
                                            <?php
                                            echo $this->Form->hidden("location_emails.$i.location_id", [
                                                'value' => $locationId
                                            ]);
                                            foreach (['email','first_name','last_name'] as $field) {
                                                echo $this->Form->control("location_emails.$i.$field", [
                                                    'required' => false,
                                                    'autocomplete' => 'autocomplete-off',
                                                ]);
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <hr />
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="submit" value="Update Account" class="btn btn-primary btn-lg">
                                            <?php if($profileComplete): ?>
                                                <?php echo $this->Html->link('Go To Profile', ['clinic' => true, 'controller' => 'locations', 'action' => 'edit', $locationId], ['class' => 'btn btn-default']); ?>
                                            <?php endif; ?>
                                            <?php echo $this->Html->link('Change password', 
                                            '/clinic/password', ['class' => 'btn btn-default']); ?>
                                        </div>
                                    </div>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
