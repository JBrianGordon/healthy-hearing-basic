<?php
use Cake\Core\Configure;

$this->Html->script('dist/common.min', ['block' => true]);
?>
<div class="container-fluid site-body">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row pt20">
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body clinicLayout anchor-underline">
							<div class="panel-section expanded">
								<h1 class="tac">Information for clinics</h1>
								<div class="col-md-12"><?= $clinicPage ?></div>
								<?php if(Configure::read('isCallAssistEnabled')) : ?>
									<div id="upgradeBlock">
										<div class="col-md-4 mt20 upgrade-panel show-plan" id="basicProfile">
											<div class="panel panel-light">
												<header class="panel-heading tac">
													<span class="close-plan hidden">Back to other plans</span>
													Basic Membership
												</header>
												<div class="panel-body">
													<div class="col-md-12">
														<div class="tac">
															<h2 class="annual-plan"><small style="color:#2b2c2d">Free to eligible clinics</small></h2>
														</div>
														<?= $basicFeatures ?>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 mt20 upgrade-panel show-plan" id="enhanceProfile">
											<div class="panel panel-light">
												<header class="panel-heading tac">
													<span class="close-plan hidden">Back to other plans</span>
													Enhanced Membership
												</header>
												<div class="panel-body">
													<div class="col-md-12">
														<div class="tac">
															<h2 class="annual-plan">$<?= $monthly_enhanced ?><small>/month</small></h2>
														</div>
														<?= $enhancedFeatures ?>
														<a href="https://app.smartsheet.com/b/form/133c44392f0849a68e16efc7bf8ce30f" class="btn btn-secondary btn-sm mt10 mb20 upgrade-button" rel="noopener noreferrer" target="_blank">Purchase Enhanced</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 mt20 upgrade-panel show-plan" id="premierProfile">
											<div class="panel panel-light">
												<header class="panel-heading tac">
													<span class="close-plan hidden">Back to other plans</span>
													Premier Membership
												</header>
												<div class="panel-body">
													<div class="col-md-12">
														<div class="tac">
															<h2 class="annual-plan">$<?= $monthly_premier ?><small>/month</small></h2>
														</div>
														<?= $premierFeatures ?>
														<a href="https://app.smartsheet.com/b/form/cfe81cc0d51e4cde89169341264ff241" class="btn btn-secondary btn-sm mt10 mb20 upgrade-button" rel="noopener noreferrer" target="_blank">Purchase Premier</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<p class="tac block" style="clear:both">Want more details? <a href="/files/pdf/Healthy-Hearing-Memberships.pdf" download="Healthy Hearing Upgrade">Download our membership brochure</a>.</p>
								<?php endif; ?>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>