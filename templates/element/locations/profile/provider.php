<?php 
use Cake\Core\Configure;

$this->set('hideProvider', $hideProvider);
?>
<!-- Provider -->
<?php if(!$hideProvider): ?>
	<section id="provider" class="panel panel-primary">
		<div id="earqProvider"></div>
		<div class="panel-heading text-center">
			<h2>Staff</h2>
		</div>
		<div class="panel-body">
			<div class="panel-section expanded">
				<?php foreach($location->location_providers as $providerKey => $location_provider): ?>
					<?php $provider = $location_provider->provider; ?>
						<?php if(!empty($provider->title) || !empty($provider->credentials) || !empty($provider->thumb_url) || !empty($provider->description)) : ?>
							<div class="row provider-bio">
								<?php if(!empty($provider->thumb_url) || (isset($provider->file->tmp_name) && !empty($provider->file->tmp_name))): ?>
									<div class="col-md-4">
										<?php
										$alt = 'Photo of '.htmlentities(strip_tags($provider->first_name.' '.$provider->last_name));
										if (!empty($provider->credentials)) {
											$alt .= ', '.$provider->credentials;
										}
										$alt .= ' from '.$location->title;
										echo $this->Clinic->providerImage($provider, [
											'class' => 'img-responsive',
											'alt' => $alt,
											'width' => 150,
											'height' => 200
										]);
										?>
										<?php if($provider->is_ida_verified): ?>
											<a href="#idaAnchor" class="ida-link">
												<img loading="lazy" class="ida-badge" alt="Provider badge from Ida Institute" src="/img/ida_pro.png" width="80" height="80">
											</a>
										<?php endif; ?> 
									</div>
								<?php else: ?>
									<div class="col-md-4 gutter-below hidden-sm hidden-xs">
									<?php if($provider->is_ida_verified): ?>
										<a href="#idaAnchor" class="ida-link">
											<img loading="lazy" class="ida-badge" alt="Provider badge from Ida Institute" src="/img/ida_pro.png" width="80" height="80">
										</a>
									<?php endif; ?> 
									</div>
								<?php endif; ?>
								<div class="col-md-8 gutter-below">
									<h2 class="provider-name">
										<?php
										$providerName = $provider->first_name.' '.$provider->last_name;
										if (!empty($provider->credentials)) {
											$providerName .= ", ";
										}
										?>
										<span><?=$providerName; ?></span>
										<?php if (!empty($provider->credentials)): ?>
											<br class="br-mobile">
											<span class="provider-qualifications"><?= $provider->credentials ?></span>
											<?php if (Configure::read('showProviderCredentialButtons')): ?>
												<a data-toggle='popover' data-trigger='hover click' data-content='' data-html='true' data-placement='bottom' class='cred-popover-<?= $providerKey; ?>'>
													<span class='glyphicon glyphicon-question-sign'></span>
												</a>
											<?php endif; ?>
										<?php endif; ?>
									</h2>
									<?php
									$providerTitle = $provider->title;
									if (empty($providerTitle)) {
										/*** TODO: getProviderTitle needs to be created: ***/
										//$providerTitle = $this->Clinic->getProviderTitle($provider->credentials);
									}
									?>
									<?php if (!empty($providerTitle)): ?>
										<h3 class="provider-title text-primary"><?= $providerTitle ?></h3>
									<?php endif; ?>
									<div class="provider-bio">
										<?= $provider->description?>
									</div>
								</div>
							</div>
						<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>