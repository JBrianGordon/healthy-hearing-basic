<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Healthy Hearing</title>
    <?= $this->Html->meta('icon') ?>

    <!--Preload fonts-->
    <link rel="preload" href="/font/hh-icons.woff?j17ed6" as="font" type="font/woff" crossorigin>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <?= $this->fetch('header') ?>
    <?= $this->element('side_nav') ?>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <?= $this->fetch('bs-modals') ?>
    <?= $this->element('footer') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap" rel="stylesheet">
    <?= $this->Html->css('responsive', ['rel' => 'preload', 'as' => 'style', 'onload' => 'this.onload=null;this.rel="stylesheet"']); ?>
    <noscript><link rel="stylesheet" href="styles.css"></noscript>
    <?= $this->Html->css(['BootstrapUI./font/bootstrap-icons', 'BootstrapUI./font/bootstrap-icon-sizes']); ?>
    <?= $this->Html->script(['BootstrapUI.popper.min', 'BootstrapUI.bootstrap.min']); ?>
    <!--/*** TODO: uncomment this once GTM is pulled in: ?= $this->element('cookie_footer')*/ ?-->
</body>
<?= $this->fetch('script') ?>
</html>
