<?php
/**
 * @var \App\View\AppView $this
 */

$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => $siteName . " newsletter", 'url' => ''],
]);

$this->Html->script('dist/content.min.js', ['block' => true]);
?>
<div class="container-fluid site-body blog p0">
  <div class="row">
    <div class="backdrop backdrop-gradient backdrop-height"></div>
    <div class="container">
      <div class="row noprint">
    <div class="col-sm-9 inverse">
        <ul class="breadcrumb">
            <?= $this->Breadcrumbs->render() ?>
            <?= $this->element('breadcrumb_schema') ?>
        </ul>
        <div id="ellipses">...</div>
    </div>
    </div>
      <div class="row page-content">
        <div class="col-sm-9">
            <article class="panel">
                <div class="panel-body">
                    <div class="panel-section expanded">
						<h1>Healthy Hearing newsletter</h1>

						<h2>Check your inbox!</h2>

						<p>Please check your inbox for a confirmation message from Healthy Hearing with the subject line: <strong>Healthy Hearing Newsletter: Please Confirm Subscription</strong>.</p>

						<p>You will need to click a link listed in this message to activate your subscription. If you don't see a confirmation e-mail within the next few minutes, please check your spam/junk folder.</p>

						<p>Need a hearing care provider? Here are clinics near you:</p>

						<div id="near-me-results">
							<?= $this->element($this->Clinic->nearMe($clinicsNearMe)) ?>
						</div>
					</div>
				</div>
			</article>
		</div>
		<?= $this->element('side_panel') ?>
	</div>
</div>
