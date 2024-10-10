<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;

?>
Hello Awesome Editor,<br><br> 

You are being notified that you have something waiting to be approved.<br><br>

Content ID: <?= $content->id ?><br>
Content Title: <?= $content->title ?><br><br>

View the content online at <?=$this->Html->link(Router::url($url, true)) ?><br><br>

<br>
Your friendly, and grossly underpaid, <br> 
WebBot