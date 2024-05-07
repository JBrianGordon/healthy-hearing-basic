<?php
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use App\Model\Entity\Location;

$isCallAssistEnabled = Configure::read('isCallAssistEnabled');
$isCallTrackingBypassed = isset($isCallTrackingBypassed) ? $isCallTrackingBypassed : TableRegistry::get('Configurations')->isCallTrackingBypassed();

$this->Html->script('dist/location_results.min', ['block' => true]);
?>
<?php if (count($locations) != 0): ?>
	<section class="panel panel-primary">
		<div class="panel-heading text-center">
			<h2>Local audiologists and hearing aid specialists</h2>
		</div>
		<div class="panel-body">
			<div class="panel-section expanded">
				<div class="row">
					<?php foreach($locations as $location): ?>
						<?php
							$locationId = $location->id;
							$distance = $location->distance;
							$displayOpenClosed = $this->Clinic->getOpenClosedByLocationId($locationId);
							$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($locationId);
							$locationUrl = Router::url($location->hh_url);
						?>
						<?php if ($isEnhancedOrPremier): ?>
							<div class="col-md-12 gutter-below">
									<?php
										$ninetyDaysAgo = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 90, date("Y")));
										if ($location->last_review_date > $ninetyDaysAgo){
											echo '<fieldset class="well clinic-info t1 high-reviews reviewed"><legend class="patient-praise recent-review"><a href="' . $locationUrl . '#reviews">Recent review</a></legend>';
										} else if($location->reviews_approved > 10){
											echo '<fieldset class="well clinic-info t1 high-reviews reviewed"><legend class="patient-praise"><a href="' . $locationUrl . '#reviews">More than 10 reviews</a></legend>';
										} else if($location->reviews_approved > 0 && $location->reviews_approved <= 10){
											echo '<fieldset class="well clinic-info t1 reviewed">';
											
										} else {
											echo '<fieldset class="well clinic-info t1">';
										}	
									?>
									<div class="row">
										<?php if(!empty($location->logo_url) && $isMobileDevice && $location->listing_type == 'Premier'): ?>
											<h2 class="name mt0 mr10 pull-left">
												<?= $this->Html->link($location->title, $location->hh_url, ['class' => 'text-primary', 'onclick' => $this->Clinic->zipResultsClickEvent($location), 'escape' => false]) ?> <small><?= '(' . $this->Clinic->distance($distance) .')' ?></small>
											</h2>
											<div class="logo-container mr10">
												<img loading="lazy" class="clinic-logo" src="/cloudfiles/clinics/<?= $location->logo_url ?>" alt="<?= $location->title ?> logo" width="180" height="60">
											</div>
											<div class="clearfix"></div>
											<div class="col-md-6">
										<?php else: ?>
											<div class="col-md-6">
												<h2 class="name mt0 mr10">
													<?= $this->Html->link($location->title, $location->hh_url, ['class' => 'text-primary', 'onclick' => $this->Clinic->zipResultsClickEvent($location), 'escape' => false]) ?> <small><?= '(' . $this->Clinic->distance($distance) .')' ?></small>
												</h2>
										<?php endif; ?>
											<div class="clearfix"></div>
											<?php if (!empty($displayOpenClosed)): ?>
												<div class="hours mb5"><span class="bi bi-clock"></span> <?= $displayOpenClosed ?></div>
											<?php endif; ?>
											<?= $this->Clinic->addressSchemaHidden($location) ?>
											<div class="address mb5"><span class="hh-icon-address"></span> <?= $this->Clinic->address($location) ?></div>
											<?= $this->Clinic->reviewSchemaHidden($location) ?>
											<?php if ($location->reviews_approved > 0 && $isEnhancedOrPremier): ?>
												<div class="reviews">
													<a href="<?= $locationUrl . '#reviews' ?>" onclick="<?= $this->Clinic->zipResultsClickEvent($location) ?>">
														<?= $this->Clinic->basicStarRating($location) ?>
													</a>
												</div>
											<?php endif; ?>
											<?php $linkedLocations = $this->Clinic->linkedLocations($location->id); ?>
											<?php if (!empty($linkedLocations) && $location->is_iris_plus): ?>
												<a href="<?= $locationUrl . '#linkedLocationAnchor' ?>" onclick="<?= $this->Clinic->zipResultsClickEvent($location) ?>" class="text-link">More locations available</a>
											<?php endif; ?>
											<div class="clinicPhone mb5<?= !empty($linkedLocations) ? ' mt10' : ''?>" data-id="<?= $locationId ?>">
												<div class="telephone h2 bi bi-telephone-fill"> <?= $this->Clinic->phone($location, ['link' => $isMobileDevice]) ?></div>
												<!-- Appointment request -->
												<?php if ($isCallAssistEnabled && !$isCallTrackingBypassed): ?>
													<?php if ($location->is_call_assist && empty($location->direct_book_iframe)): ?>
														<!-- *** TODO: appointment request modal not functioning properly, I think some backend work may be needed: ***-->
														<a href="#" class="btn btn-lg btn-secondary apptRequestBtn mb5" data-id="<?= $locationId ?>" data-bs-toggle="modal">
															Request my appointment
														</a>
													<?php endif; ?>
												<?php endif; ?>
												<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && (!empty($location->direct_book_iframe))): ?>
													<div>
														<a href="#" class="btn btn-lg btn-secondary directBookBtn mb5" style="min-width:250px;" data-bs-toggle="modal" data-bs-target="#directBookModal-<?= $location->id ?>">Book now!</a>
													</div>
													<?= $this->element('locations/profile/direct_book_modal', ['iframe' => $location->direct_book_iframe, 'locationId' => $location->id, 'locationTitle' => $location->title]) ?>
												<?php endif; ?>
											</div>
											<?php if (empty($linkedLocations) || !$location->is_iris_plus): ?>
												<div class="details mb5"><a href="<?= $locationUrl ?>" onclick="<?= $this->Clinic->zipResultsClickEvent($location); ?>" class="text-link">View clinic details</a></div>
											<?php endif; ?>
											<?= $location->listing_type == Location::LISTING_TYPE_PREMIER ? $this->Clinic->getBadges($location) : null ?>
										</div>
										<div class="col-md-6">
											<?php
											// Display provider photo if we have one
											if ($location->filter_has_photo) {
												if (!empty($location->providers)) {
													// Grab first provider with picture
													echo $this->element('locations/provider_right', [
														'location'=>$location,
														'provider'=>$location->providers[0]
													]);
												}
											}
											?>
										</div>
									</div>
								</fieldset>
							</div>
						<?php elseif ($location->listing_type == Location::LISTING_TYPE_BASIC): ?>
							<div class="col-md-12 gutter-below">
								<?= ($location->reviews_approved > 0 && $location->reviews_approved <= 10) ? '<div class="well clinic-info t2 reviewed">' : '<div class="well clinic-info t2">'
								?>
									<div class="row">
										<div class="col-md-6">
											<h3 class="name"><?= $this->Html->link($location->title, $location->hh_url, ['class' => 'text-primary', 'onclick' => $this->Clinic->zipResultsClickEvent($location), 'escape'=>false]) ?> <small><?= '(' . $this->Clinic->distance($distance) .')' ?></small></h3>
											<?= $this->Clinic->addressSchemaHidden($location) ?>
											<div class="address d-block d-sm-none"><span class="hh-icon-address"></span> <?= $this->Text->truncate($this->Clinic->address($location), 59) ?></div>
											<?= $this->Clinic->reviewSchemaHidden($location) ?>
											<?php if ($location->reviews_approved > 0 && $isEnhancedOrPremier): ?>
												<div class="reviews">
													<a href="<?= $locationUrl . '#reviews' ?>" onclick="<?= $this->Clinic->zipResultsClickEvent($location) ?>">
														<?= $this->Clinic->basicStarRating($location) ?>
													</a>
												</div>
											<?php endif; ?>
											<div class="clinicPhone" data-id="<?= $locationId ?>">
												<div class="telephone h4"><span><span class="glyphicon glyphicon-earphone"></span> <?= $this->Clinic->phone($location, ['link' => $isMobileDevice], $isCallTrackingBypassed) ?></span></div>
												<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && (!empty($location->direct_book_iframe))): ?>
													<div>
														<a href="#" class="btn btn-lg btn-secondary directBookBtn mb5" data-bs-toggle="modal" data-button="<?= $location->id ?>" data-bs-target="#directBookModal-<?= $location->id ?>">Book now!</a>
													</div>
													<?= $this->element('locations/profile/direct_book_modal', ['iframe' => $location->direct_book_iframe, 'locationId' => $location->id, 'locationTitle' => $location->title]) ?>
												<?php endif; ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="address mt5 d-none d-sm-block"><span class="hh-icon-address"></span> <?= $this->Text->truncate($this->Clinic->address($location), 59) ?></div>
											<div class="details mb5"><a href="<?= $locationUrl ?>" class="text-link" onclick="<?= $this->Clinic->zipResultsClickEvent($location) ?>">View clinic details</a></div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<?php
				if (empty($zip)) {
					// City page
					$searchTitle = "Want more specific results? Try searching your ".Configure::read('zipLabel').".";
					$searchPlaceholder = "Search by ".$zipShort;
				} else {
					// Zip page
					$searchTitle = "Need to find a hearing aid clinic in a different area?";
					$searchPlaceholder = "Search by city or ".$zipShort;
				}
				?>
				<h3 class="text-center text-primary"><em><?= $searchTitle ?></em></h3>
				<div class="col-md-offset-3 col-md-6">
					<?= $this->element('locations/search', ['label' => $searchPlaceholder]) ?>
				</div>
				<div class="clearfix"></div>

				<h2 class="text-primary">Learn more about hearing health</h2>
				<p>If you're not ready to make that call, visit our <a href="/help">Hearing Help</a> pages for extensive information about <a href="/help/hearing-loss">hearing loss</a>, <a href="/help/hearing-aids">hearing aids</a>, 
				<?php if (Configure::read('country') == 'CA'): ?>
					<a href="/help/hearing-loss/tinnitus-treatment">tinnitus</a> and <a href="/help/hearing-aids/assistive-listening-devices">assistive listening devices</a>.
				<?php else: ?>
					<a href="/help/tinnitus">tinnitus</a> and <a href="/help/assistive-listening-devices">assistive listening devices</a>.
				<?php endif; ?>
				</p>
			</div>
		</div>
	</section>
	<div id="ajaxModals">
	</div>
<?php endif; ?>
