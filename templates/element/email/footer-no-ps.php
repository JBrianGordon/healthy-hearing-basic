<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
Thank you,<br>
The <?= Configure::read('siteName') ?> Team<br>
<?= $this->Html->link('www.' . Configure::read('siteUrl'), Router::url('/', true)) ?><br><br>