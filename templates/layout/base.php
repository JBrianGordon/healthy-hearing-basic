<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use App\Model\Entity\Location;

// Prepend country abbreviations to titles in non-prod environments
$env = Configure::read('env');
$country = Configure::read('country');
$title_for_layout = empty($title) ? Configure::read('siteName') : $title;

if ($env != 'prod') {
    $title_for_layout = strtoupper($env) . ": " . $title_for_layout;
    if ($country != 'US') {
        $title_for_layout = $country . "-" . $title_for_layout;
    }
}
?>
<!DOCTYPE html>
<html lang="<?= Configure::read('htmlLanguage') ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title_for_layout ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->element('google_tag_manager') ?>

    <!--Preload fonts-->
    <link rel="preload" href="/font/hh-icons.woff?j17ed6" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="/font/roboto-v20-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/font/lato-v17-latin-regular.woff2" as="font" type="font/woff2" crossorigin>

    <!-- AutocompleteJS styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/css/autoComplete.min.css">

    <!-- Prefetches -->
    <?php
    function renderPrefetches($Seo) {
        $prefetchOutput = $Seo->prefetches();
        if (!empty($prefetchOutput)) {
            echo $prefetchOutput;
        }
    }
    ?>

    <!-- Meta tags -->
    <?php
    function renderMetaTags($Seo, $view) {
        ob_start();
        $Seo->metaTags();
        $metaOutput = ob_get_clean();
        $metaBlock = $view->fetch('meta');
        if (empty($metaOutput) && empty($metaBlock)) {
            // Output default meta tags
            echo '<meta name="description" content="Read hearing aid clinic reviews for thousands of independent hearing centers in the US, plus updated news and information on hearing aids and hearing loss.">';
        } else {
            echo $metaOutput;
            echo $metaBlock;
        }
    }
    renderMetaTags($this->Seo, $this);
    ?>

    <!-- Social Options -->
    <?php
    function renderSocialOptions($Seo, $view) {
        $socialOutput = $Seo->socialOptions();
        $socialBlock = $view->fetch('socialOptions');
        if (empty($socialOutput) && empty($socialBlock)) {
            // Output default social tags
            echo '<meta property="og:type" content="website">';
            echo '<meta property="og:url" content="https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '">';
            echo '<meta property="og:title" content="Hearing aid and hearing clinic directory">';
            echo '<meta property="og:description" content="Read hearing aid clinic reviews for thousands of independent hearing centers in the US, plus updated news and information on hearing aids and hearing loss.">';
            echo '<meta property="og:image" content="/img/hh-symbol.png">';
        } else {
            echo $socialOutput;
            echo $socialBlock;
        }
    }
    renderSocialOptions($this->Seo, $this);
    ?>

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
        } elseif ($_SERVER['REQUEST_URI'] == '/hearing-aid-manufacturers') {
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
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=<?=Configure::read('gtmId') ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
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
    <?= $this->element('google_analytics') ?>
</body>
<?= $this->fetch('script') ?>
</html>
