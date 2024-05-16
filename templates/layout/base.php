<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html lang="<?= Configure::read('htmlLanguage') ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Healthy Hearing</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->element('google_tag_manager_head') ?>

    <!--Preload fonts-->
    <link rel="preload" href="/font/hh-icons.woff?j17ed6" as="font" type="font/woff" crossorigin>

    <?= $this->fetch('meta') ?>
    <!-- Above the fold CSS -->
    <?php
        if ($_SERVER['REQUEST_URI'] == '/help/online-hearing-test') {
            echo $this->Html->css('/css/atf/online-hearing-test.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/help') {
            echo $this->Html->css('/css/atf/help.css');
        } elseif (preg_match('/\/help\//', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/help-page.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/report') {
            echo $this->Html->css('/css/atf/report.css');
        } elseif (preg_match('/\/report\//', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/report-page.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/hearing-aids') {
            echo $this->Html->css('/css/atf/hearing-aids.css');
        } else if(isset($location['Location']['listing_type']) && $location['Location']['listing_type'] == Location::LISTING_TYPE_ENHANCED){
            echo $this->Html->css('/css/atf/enhanced-page.css');
        } elseif (preg_match('/\/hearing-aids\/[0-9]{5}/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/clinic-page.css');
        } elseif (preg_match('/\/hearing-aids\/[A-Z]{2}\-[A-Za-z]*[\-]?[A-Za-z]*\/[A-Z0-9]/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/city-page.css');
        } elseif (preg_match('/\/hearing-aids\/[A-Z]{2}\-[A-Za-z]*[\-]?[A-Za-z]*/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/state-page.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/about') {
            echo $this->Html->css('/css/atf/about.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/hearing-aid-manufacturers' || preg_match('/\/clinic\/locations\/edit\//', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/manufacturers.css');
        } elseif (preg_match('/[A-Za-z]*-hearing-aids/', $_SERVER['REQUEST_URI']) || preg_match('/[A-Za-z]*-implants/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/manufacturer.css');
        }
        //using the home page atf css as a fallback
        else{
            echo $this->Html->css('/css/atf/home.css');
        }
    ?>
</head>
<body>
    <?= $this->element('google_tag_manager') ?>
    <?= $this->fetch('header') ?>
    <?= $this->element('side_nav') ?>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <?= $this->fetch('bs-modals') ?>
    <?= $this->element('footer') ?>
    <?= $this->Html->css('responsive', ['rel' => 'preload', 'as' => 'style', 'onload' => 'this.onload=null;this.rel="stylesheet"']); ?>
    <noscript><link rel="stylesheet" href="/css/responsive.css"></noscript>
    <?= $this->Html->css(['/bootstrap-icons-1.8.2/bootstrap-icons', 'BootstrapUI./font/bootstrap-icon-sizes']); ?>
    <?= $this->Html->script(['BootstrapUI.popper.min', 'BootstrapUI.bootstrap.min']); ?>
    <div id="footerContainer">
        <?= $this->element('cookie_footer') ?>
        <?= (preg_match('/\/hearing-aids\/[0-9]{5}/', $_SERVER['REQUEST_URI']) || preg_match('/\/hearing-aids\/[A-Z]{2}\-[A-Za-z]*[\-]?[A-Za-z]*\/[A-Z0-9]/', $_SERVER['REQUEST_URI'])) ? $this->element('sticky_footer') : '' ?>
    </div>
</body>
<?= $this->fetch('script') ?>
</html>
