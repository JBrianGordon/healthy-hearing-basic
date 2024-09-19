<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
Thank you,<br>
The <?php echo Configure::read('siteName'); ?> Team<br>
<?php echo $this->Html->link('www.' . Configure::read('siteUrl'), Router::url('/', true)); ?><br><br>

PS: If the email address we sent this to isn’t the best way for us to reach your practice about this <?php echo Configure::read('siteName'); ?> profile, please respond and let us know which email address you’d prefer that we use. Thank you.