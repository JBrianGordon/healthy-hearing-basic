<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
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
	<link rel="preload" href="/font/glyphicons-halflings-regular.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/font/glyphicons-halflings-regular.woff" as="font" type="font/woff" crossorigin>
	<link rel="preload" href="/font/hh-icons.woff?j17ed6" as="font" type="font/woff" crossorigin>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css('responsive'); ?>
    <?= $this->Html->css(['BootstrapUI./font/bootstrap-icons', 'BootstrapUI./font/bootstrap-icon-sizes']); ?>
    <?= $this->Html->script(['BootstrapUI.popper.min', 'BootstrapUI.bootstrap.min']); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <nav class="navbar navbar-default sticky-top navbar-expand-lg navbar-light bg-light">
    	<div class="container p0">
		    <div class="col-xs-12" id="navParent">
		        <a class="navbar-brand d-inline-block navbar-logo" href="/">
		          <img src="/img/hh-logo.svg" alt="" width="198" height="40">
		        </a>
		        <button class="navbar-toggler navbar-side-nav-trigger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuToggler" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation" data-hh-side-nav-trigger>
		        	<a href="" id="desktopSideNavTrigger">
						<span class="hh-icon-menu"></span>
		        	</a>
		        </button>
		        <div class="collapse navbar-collapse" id="navbarMenuToggler">
		          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
		            <li class="nav-item">
		              <a class="nav-link text-uppercase" href="#">Find a clinic</a>
		            </li>
		            <li class="nav-item">
		              <?php echo $this->AuthLink->link('Hearing loss help', '/help', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
		            </li>
		            <li class="nav-item">
		              <?php echo $this->AuthLink->link('Hearing aids help', '/help', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
		            </li>
		            <li class="nav-item">
		              <?php echo $this->AuthLink->link('News', '/report', ['escape' => false, 'class'=>'nav-link text-uppercase']); ?>
		            </li>
		            <li>
		              <?php echo $this->AuthLink->link('<i class="bi bi-gear-fill"></i>', '/admin', ['escape' => false, 'class'=>'nav-link']); ?>
		            </li>
		          </ul>
		        </div>
		    </div>
    	</div>
    </nav>
    <?= $this->element('side_nav') ?>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <?= $this->fetch('bs-modals') ?>
    <?= $this->element('footer') ?>
</body>
<?= $this->fetch('script') ?>
</html>
