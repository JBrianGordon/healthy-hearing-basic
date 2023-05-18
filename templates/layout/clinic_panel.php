<?php
/**
 * @var \App\View\AppView $this
 */

$this->extend('/layout/base');
?>

<?php // Default header for application
    $this->start('header');
        echo $this->element('header/clinic_panel');
    $this->end();
?>

<?= $this->fetch('content') ?>