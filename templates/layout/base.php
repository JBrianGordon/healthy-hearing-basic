<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use App\Model\Entity\Location;
?>
<!DOCTYPE html>
<html lang="<?= Configure::read('htmlLanguage') ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= empty($title) ? Configure::read('siteName') : $title ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->element('google_tag_manager') ?>

    <!--Preload fonts-->
    <link rel="preload" href="/font/hh-icons.woff?j17ed6" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="/font/roboto-v20-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/font/lato-v17-latin-regular.woff2" as="font" type="font/woff2" crossorigin>

    <!-- AutocompleteJS styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/css/autoComplete.min.css">

    <!-- Meta tags -->
    <!-- TO-DO: ADD META TAGS -->

    <?php /* Display social options
    TODO: These are currently assigned in the view file, but should be done similar to metaTags */ ?>
    <?= $this->fetch('meta') ?>

    <!-- Start VWO Async SmartCode -->
    <link rel="preconnect" href="https://dev.visualwebsiteoptimizer.com" />
    <script type='text/javascript' id='vwoCode'>
    window._vwo_code=window._vwo_code || (function() {
    var account_id=351850,
    version = 1.5,
    settings_tolerance=2000,
    library_tolerance=2500,
    use_existing_jquery=false,
    is_spa=1,
    hide_element='body',
    hide_element_style = 'opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important',
    /* DO NOT EDIT BELOW THIS LINE */
    f=false,w=window,d=document,vwoCodeEl=d.querySelector('#vwoCode'),code={use_existing_jquery:function(){return use_existing_jquery},library_tolerance:function(){return library_tolerance},hide_element_style:function(){return'{'+hide_element_style+'}'},finish:function(){if(!f){f=true;var e=d.getElementById('_vis_opt_path_hides');if(e)e.parentNode.removeChild(e)}},finished:function(){return f},load:function(e){var t=d.createElement('script');t.fetchPriority='high';t.src=e;t.type='text/javascript';t.onerror=function(){_vwo_code.finish()};d.getElementsByTagName('head')[0].appendChild(t)},getVersion:function(){return version},getMatchedCookies:function(e){var t=[];if(document.cookie){t=document.cookie.match(e)||[]}return t},getCombinationCookie:function(){var e=code.getMatchedCookies(/(?:^|;)\s?(_vis_opt_exp_\d+_combi=[^;$]*)/gi);e=e.map(function(e){try{var t=decodeURIComponent(e);if(!/_vis_opt_exp_\d+_combi=(?:\d+,?)+\s*$/.test(t)){return''}return t}catch(e){return''}});var i=[];e.forEach(function(e){var t=e.match(/([\d,]+)/g);t&&i.push(t.join('-'))});return i.join('|')},init:function(){if(d.URL.indexOf('__vwo_disable__')>-1)return;w.settings_timer=setTimeout(function(){_vwo_code.finish()},settings_tolerance);var e=d.currentScript,t=d.createElement('style'),i=e&&!e.async?hide_element?hide_element+'{'+hide_element_style+'}':'':code.lA=1,n=d.getElementsByTagName('head')[0];t.setAttribute('id','_vis_opt_path_hides');vwoCodeEl&&t.setAttribute('nonce',vwoCodeEl.nonce);t.setAttribute('type','text/css');if(t.styleSheet)t.styleSheet.cssText=i;else t.appendChild(d.createTextNode(i));n.appendChild(t);var o=this.getCombinationCookie();this.load('https://dev.visualwebsiteoptimizer.com/j.php?a='+account_id+'&u='+encodeURIComponent(d.URL)+'&f='+ +is_spa+'&vn='+version+(o?'&c='+o:''));return settings_timer}};w._vwo_settings_timer = code.init();return code;}());
    </script>
    <!-- End VWO Async SmartCode -->
    
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
        } else if(isset($location->listing_type) && $location->listing_type == Location::LISTING_TYPE_ENHANCED){
            echo $this->Html->css('/css/atf/enhanced-page.css');
        } elseif (preg_match('/\/hearing-aids\/[0-9]{5}/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/clinic-page.css');
        } elseif (preg_match('/\/hearing-aids\/[A-Z]{2}\-[A-Za-z]*[\-]?[A-Za-z]*\/[A-Z0-9]/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/city-page.css');
        } elseif (preg_match('/\/hearing-aids\/[A-Z]{2}\-[A-Za-z]*[\-]?[A-Za-z]*/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/state-page.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/about') {
            echo $this->Html->css('/css/atf/about.css');
        } elseif ($_SERVER['REQUEST_URI'] == '/hearing-aid-manufacturers' || preg_match('/\/locations\/edit\//', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/manufacturers.css');
        } elseif (preg_match('/[A-Za-z]*-hearing-aids/', $_SERVER['REQUEST_URI']) || preg_match('/[A-Za-z]*-implants/', $_SERVER['REQUEST_URI'])) {
            echo $this->Html->css('/css/atf/manufacturer.css');
        }
        //using the home page atf css as a fallback
        else{
            echo $this->Html->css('/css/atf/home.css');
        }
    ?>

    <!-- AutocompleteJS -->
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/autoComplete.min.js"></script>
</head>
<body>
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
        <!-- Regex check to show sticky footer on city or clinic pages only-->
        <?= preg_match('/\/hearing-aids\/([0-9]{5}\-[A-Za-z\-]+|[A-Z]{2}\-[A-Za-z\-]+\/[A-Za-z\-]+)/', $_SERVER['REQUEST_URI']) ? $this->element('sticky_footer') : '' ?>
    </div>
</body>
<?= $this->fetch('script') ?>
</html>
