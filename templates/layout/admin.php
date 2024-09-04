<?php
/**
 * @var \App\View\AppView $this
 */

$this->extend('/layout/base');
?>

<?php // Default header for application
    $this->start('header');
        echo $this->element('header/default');
    $this->end();
?>
<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="clear"></div>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
</div>