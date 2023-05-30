<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
 
use App\Model\Entity\Location;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Model\Entity\CaCallGroup;
 
$this->Html->script('dist/clinic.min.js?v='.Configure::read("tagVersion"), ['block' => true]);
?>
<?php
$displayOpenClosed = $this->Clinic->getOpenClosedByLocationId($location->id);
$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($location->id);
$firstProvider = empty($location->location_providers[0]) ? null : $location->location_providers[0];
$hideProvider = empty($firstProvider->provider->title) && empty($firstProvider->provider->credentials) && empty($firstProvider->provider->thumb_url) && empty($firstProvider->provider->description);
$showSpecialAnnouncement = (
	($location->listing_type == Location::LISTING_TYPE_PREMIER) ||
	($location->feature_special_announcement)
);
$isCallTrackingBypassed = TableRegistry::get('Configurations')->isCallTrackingBypassed();
$this->Breadcrumbs->add([
    ['title' => 'Find a clinic', 'url' => '/hearing-aids'],
    ['title' => $location->state_full, 'url' => ['controller' => 'locations', 'action' => 'viewState', 'region' => $region]],
    ['title' => $location->city, 'url' => ['controller' => 'locations', 'action' => 'index', 'region' => $region, 'city' => $city]],
    ['title' => $location->title, 'url' => ''],
]);
?>
<div class="site-body container-fluid fap-results">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row" id="result_content">
				<header class="col-md-12 inverse breadcrumb-header">
					<?= $this->Breadcrumbs->render(); ?>
					<div id="ellipses">...</div>
				</header>
				<div class="col-md-12 page-content">
				
					<!-- Basic clinic info -->
					<div class="<?php if($isEnhancedOrPremier && Configure::read('country') != 'CA'){ echo "col-xs-12 col-md-7 p0"; }?>">
						<section class="panel<?php if($isEnhancedOrPremier){ echo " top-panel left-panel mb20"; }?>">
							<div class="panel-body">
								<div class="panel-section expanded basic-info">
									<div class="row">
										<div class="<?= Configure::read('country') != 'CA' ? 'col-xs-12' : 'col-md-6'; ?> clinic-info">
											<?php if ($isAdmin || $isClinic): ?>
												<div class="btn-group-vertical pull-right pt20">
													<?php echo $this->Clinic->adminLink($location->id, $isAdmin);?>
													<?php echo $this->Clinic->clinicLink($location->id, $isClinic, $isAdmin); ?>
												</div>
											<?php endif; ?>
											<h1 class="text-primary name"><?= $location->title ?></h1>
											<?php if(!empty($location->logo_url) && $location->listing_type == 'Premier'){
												echo '<img class="clinic-logo" src="/cloudfiles/clinics/'. $location->logo_url .'" alt="'. $location->title .' logo" width="400" height="80">';
											}; ?>
											<div class="geo" style="display:none;">
												<span class="latitude">
													<span class="value-title" title="<?= $location->lat ?>"></span>
												</span>
												<span class="longitude">
													<span class="value-title" title="<?= $location->lon ?>"></span>
												</span>
											</div>
											<?php if (!empty($displayOpenClosed)): ?>
												<div class="hours"><span class="glyphicon glyphicon-time small"></span> <?= $displayOpenClosed; ?></div>
											<?php endif; ?>
											<?php if(Configure::read('isCallAssistEnabled') || $isMobileDevice) : ?>
												<a href="#mapBuffer" style="text-decoration:underline;cursor:pointer">
											<?php endif; ?>
												<div class="address mb5">
													<span class="hh-icon-address"></span> <?= $this->Clinic->address($location); ?>
												</div>
											<?php if(Configure::read('isCallAssistEnabled')) : ?>
												</a>
											<?php endif; ?>
											<div class="reviews mb20 pull-left">
												<?php echo $this->Clinic->basicStarRating($location, ['showEmpty'=>true, 'showLink'=>true]); ?>
											</div>
											<div class="clearfix"></div>
											<?php if(!$displayOpenClosed && $isEnhancedOrPremier && Configure::read('isCallAssistEnabled')): ?>
												<p style="margin-left:-10px"><strong>It is outside of normal business hours for this location. Please fill out the <a <?php if($isMobileDevice){ echo 'href="#apptRequestModalAnchor" '; }?>id="requestFormHighlight">appointment request form</a> for a call back.</strong></p>
											<?php endif; ?>
											<div class="clinicPhone" data-id="<?= $location->id ?>">
												<div class="telephone h2 bi bi-telephone-fill">
													<?= $this->Clinic->phone($location, ['link' => $isMobileDevice]); ?>
												</div>
												<!-- Appointment request -->
												<?php if (Configure::read('isCallAssistEnabled') && !$isCallTrackingBypassed): ?>
													<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && !empty($location->direct_book_iframe)): ?>
														<div><a href="#" class='btn btn-secondary directBookBtn' style="min-width:250px;float:left;height:43px;padding:13px" data-button="<?= $location->id; ?>">Book now!</a></div>
													<?php endif; ?>
												<?php endif; ?>
											</div>
										</div>
										<?php if (Configure::read('country') == 'CA' && !$isMobileDevice): ?>
											<div class="col-md-6">
												<?= $this->element('locations/map', ['hideProvider' => $hideProvider]) ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
							</section>
							<?php if ($isEnhancedOrPremier): ?>
								<div id="quickLinkBar" class="col-xs-12 p0">
									<div class="container">
										<div id="linkBlock">
											<ul>
												<li class="quick-links">Quick links: </li>
												<li>
													<a href="#earqReviews" class="earq-link">Reviews</a>
												</li>
												<li>/</li>
												<li>
													<a href="#earqServices" class="earq-link">Services</a>
												</li>
												<li>/</li>
												<li>
													<a href="#earqProvider" class="earq-link">Staff</a>
												</li>
												<li>/</li>
												<li>
													<a href="#earqHours" class="earq-link">Hours</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<?php if (Configure::read('isCallAssistEnabled') && !$isCallTrackingBypassed): ?>
							<?php if ($location->is_call_assist && $isEnhancedOrPremier): ?>
								<section class="panel top-panel contracted" id="apptRequestPanel">
								<?php
								$topicOptions = [
									CaCallGroup::TOPIC_WANTS_APPT => 'Hearing test or hearing aid consultation</span><span class="topic-label vwo-test-new-label" style="display:none;">Difficulty hearing in certain situations',
									CaCallGroup::TOPIC_AID_LOST_OLD => 'Hearing aid lost or broken</span><span class="topic-label vwo-test-new-label" style="display:none;">My hearing aid is lost or broken',
									CaCallGroup::TOPIC_APPT_FOLLOWUP => 'Follow-up after recent hearing aid fitting</span><span class="topic-label vwo-test-new-label" style="display:none;">I need a follow-up appointment for adjustment to my hearing aids',
									CaCallGroup::TOPIC_TINNITUS => 'Ringing in the ear (tinnitus)</span><span class="topic-label vwo-test-new-label" style="display:none;">Ringing, buzzing or hissing sounds in my ear(s)',
								];
								?>
								<!-- Modal for online appointment request form -->
								<span id="apptRequestModalAnchor"></span>
								<div id="apptRequestModal">
									<div class="modal-content">
										<?= $this->Form->create(null, [
										    'url' => [
										        'controller' => 'CaCalls',
										        'action' => 'apptRequest'
										    ],
										    'class' => 'form-horizontal apptRequestForm',
										    'id' => 'CaCallApptRequestForm'
										]); ?>
											<button type="button" class="close pt10" data-dismiss="modal" aria-hidden="true">X</button>
											<div class="panel-heading text-center mb10">
												<h2 class="modal-title">Request an appointment</h2>
											</div>
											<?php
											echo $this->Form->hidden('CaCallGroup.location_id', ['value'=>$location->id]);
											echo $this->Form->hidden('CaCallGroup.is_patient', ['value'=>true]);
											echo $this->Form->hidden('CaCallGroup.is_appt_request_form', ['value'=>true]);
											echo $this->Form->hidden('CaCallGroup.traffic_source', ['value'=>'unknown']);
											echo $this->Form->hidden('CaCallGroup.traffic_medium', ['value'=>'unknown']);
											?>
											<div class='form-fields col-xs-12'>
												<div class="form-group required">
													<label for="CaCallGroupCallerFirstName" class="col col-md-5 control-label">Patient first name:</label>
													<div class="col col-md-7 required">
														<?= $this->Form->input('CaCallGroup.caller_first_name', [
																'placeholder' => 'First name',
																'required' => true,
																'autocomplete' => 'given-name',
																'maxlength' => 30,
																'class' => 'form-group'
															])
														?>
													</div>
												</div>
												<div class="form-group required">
													<label for="CaCallGroupCallerLastName" class="col col-md-5 control-label">Patient last name:</label>
													<div class="col col-md-7 required">
														<?= $this->Form->input('CaCallGroup.caller_last_name', [
															'placeholder' => 'Last name',
															'required' => true,
															'autocomplete' => 'family-name',
															'maxlength' => 30,
															'class' => 'form-group'
														]) ?>
													</div>
												</div>
												<div class="form-group required">
													<label for="CaCallGroupCallerPhone" class="col col-md-5 control-label">Phone number:</label>
													<div class="col col-md-7 required">
														<?= $this->Form->input('CaCallGroup.caller_phone', [
																'placeholder' => 'Phone number',
																'required' => true,
																'autocomplete' => 'tel',
																'class' => 'form-group'
															])
														?>
													</div>
												</div>
												<div class="form-group">
													<label for="CaCallGroupEmail" class="col col-md-5 control-label">Email:</label>
													<div class="col col-md-7">
														<?= $this->Form->input('CaCallGroup.email', [
																'type' => 'email',
																'placeholder' => 'Email address',
																'autocomplete' => 'email',
																'class' => 'form-group'
															])
														?>
													</div>
												</div>
												<div class="form-group">
													<label class="col col-md-5 control-label pull-left">Reason for appointment<br><small class="help-block">(Check all that apply)</small></label>
													<div class="col col-md-7">
														<div class="checkbox">
															<?php
																foreach ($topicOptions as $topicKey => $label) {
																    echo $this->Form->control('CaCallGroup.'.$topicKey, [
																        'type' => 'checkbox',
																        'label' => [
																            'class' => 'control-label pt0 pl5',
																            'style' => 'text-align:left;',
																            'text' => $label,
																            'escape' => false,
																        ],
																        'class' => 'form-check-input',
																        'id' => 'cacallgroup-' . $topicKey
																    ]);
																}
															?>
														</div>
													</div>
												</div>
											</div>
											<p class="col-xs-12 tac"><small class="tac help-block"><?= Configure::read('siteName'); ?> will contact you regarding your request as soon as possible.</small></p>
											<div class="row col-xs-12 ml0">
												<div class="col col-sm-12">
													<div id="apptRequestSubmitError" class="alert alert-danger tal" role="alert" style="display:none;">
														<button type="button" class="close" data-dismiss="alert">x</button>
														<span id="apptRequestSubmitErrorMessage">Error</span>
													</div>
												</div>
												<div class="col col-xs-12 col-sm-4 col-sm-offset-4 tac">
													<button id="apptRequestSubmitBtn" type="submit" class="btn btn-secondary btn-block btn-lg">Submit</button>
												</div>
												<div class="g-recaptcha"
													 data-sitekey="<?= Configure::read('recaptchaPublicKey'); ?>"
													 data-callback='submitApptRequest'
													 data-size="invisible">
												</div>
												<small class="help-block p20 tac clearfix">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" rel="noopener" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" rel="noopener" target="_blank">Terms of Service</a> apply.</small>
											</div>
										<?= $this->Form->end(); ?>
									</div>
								</div>
								<div id="apptRequestThankYouModal" style="display: none">
									<div>
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close pt10 pr10" data-dismiss="modal" aria-hidden="true">X</button>
												<h4>Thank you for requesting an appointment at <?= $location->title ?></h4>
											</div>
											<div class="modal-body">
												<p class="lead">
													<?= Configure::read('siteName') ?> will contact you as soon as possible to assist you.<br><br>
													Please note, submitting multiple forms on our site will result in you receiving multiple calls from our staff.
												</p>
											</div>
										</div>
									</div>
								</div>
						<?php endif; ?>
						</section>
					<?php endif; ?>
					<div class="row" style="clear: both">
						<?php $covid19Statement = trim($location->optional_message); ?>
						<?php if (!empty($covid19Statement)): ?>
							<div id="covidStatement" class="col-md-12">
								<h2>A message from <?= $location->title ?> about COVID-19:</h2>
								<p><?= $covid19Statement ?></p>
							</div>
						<?php endif; ?>
						<div class="col-md-8">
							<!-- About / Services -->
							<?php
							$hours = $this->Clinic->hours($location);
							if ($isMobileDevice) {
								echo "<span id='mapBuffer'></span>";
								echo '<section id="mobileMap" class="panel panel-primary">';
								echo '<header class="panel-heading text-center"><h2>Location</h2></header>';
								echo '<div class="panel-body"><div class="panel-section condensed">';
								echo $this->element('locations/map', ['hideProvider' => $hideProvider]);
								if (!$location->is_mobile && ($location->listing_type === 'Premier')) {
									echo '<a href="#" class="btn btn-lg btn-primary directions-link" rel="noopener" target="_blank">Driving Directions</a>';
								};
								echo '</div></div></section>';
								echo '<div id="hours" class="panel panel-light">
									<div id="earqHours"></div>
									<header class="panel-heading text-center">
										<h2>Hours of operation</h2>
									</header>
									<div class="panel-body">
										<div class="panel-section condensed">' .$hours.
										'</div>
									</div>
								</div>';
								echo $this->element('locations/profile/more_information');
								echo $this->element('locations/profile/video_gallery');
								echo $this->element('locations/profile/photo_gallery');
								if ($isEnhancedOrPremier) {
									echo $this->element('locations/profile/services');
								}
								echo $this->element('locations/profile/review_section');
								echo $this->element('locations/profile/provider', ['hideProvider' => $hideProvider]);
							} else {
								echo $this->element('locations/profile/provider', ['hideProvider' => $hideProvider]);
								if (Configure::read('country') != 'CA') {
									echo "<span id='mapBuffer'></span>";
									echo '<section id="mobileMap" class="panel panel-primary">';
									echo '<header class="panel-heading text-center"><h2>Location</h2></header>';
									echo '<div class="panel-body"><div class="panel-section condensed">';
									echo $this->element('locations/map', ['hideProvider' => $hideProvider]);
									if (!$location->is_mobile && ($location->listing_type === 'Premier')) {
										echo '<a href="#" class="btn btn-lg btn-primary directions-link" rel="noopener" target="_blank">Driving Directions</a>';
									};
									echo '</div></div></section>';
								}
								echo $this->element('locations/profile/review_section');
								echo $this->element('locations/profile/more_information');
								echo $this->element('locations/profile/video_gallery');
								echo $this->element('locations/profile/photo_gallery');
								if ($isEnhancedOrPremier) {
									echo $this->element('locations/profile/services');
								}
							}
							?>
							
							<!-- Clinic Badges -->
							<?php
								//Any changes made here should also be reflected in app/View/Helper/ClinicHelper.ctp
								if ($isEnhancedOrPremier) {
									$badgeArray = [
										['isOn' => $location->badge_coffee, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Free coffee" width="28" height="28" src="/img/coffee.png"><p class="icon-text">Free coffee</p>'],
										['isOn' => $location->badge_wifi, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Free wifi" width="28" height="28" src="/img/wifi.png"><p class="icon-text">Free WiFi</p>'],
										['isOn' => $location->badge_parking, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Convenient parking" width="28" height="28" src="/img/parking-square-sign.png"><p class="icon-text">Convenient parking</p>'],
										['isOn' => $location->badge_curbside, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Curbside service" width="28" height="28" src="/img/car.png"><p class="icon-text">Curbside service</p>'],
										['isOn' => $location->badge_wheelchair, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Wheelchair accessible" width="28" height="28" src="/img/disabled.png"><p class="icon-text">Wheelchair-accessible</p>'],
										['isOn' => $location->badge_service_pets, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Service pets welcome" width="28" height="28" src="/img/pet.png"><p class="icon-text">Service pets welcome</p>'],
										['isOn' => $location->badge_cochlear_implants, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Hearing implants" width="28" height="28" src="/img/hearing.png"><p class="icon-text">Hearing implants</p>'],
										['isOn' => $location->badge_ald, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Assistive listening devices" width="28" height="28" src="/img/deafness.png"><p class="icon-text">Assistive listening devices</p>'],
										['isOn' => $location->badge_pediatrics, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Pediatrics" width="28" height="28" src="/img/man-with-child.png"><p class="icon-text">Pediatrics</p>'],
										['isOn' => $location->badge_mobile_clinic, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Mobile clinic" width="32" height="28" src="/img/ear-van.png"><p class="icon-text">Mobile clinic</p>'],
										['isOn' => $location->badge_financing, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Financing available" width="28" height="28" src="/img/credit-card.png"><p class="icon-text">Financing available</p>'],
										['isOn' => $location->badge_telehearing, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Telehealth services" width="28" height="28" src="/img/monitor.png"><p class="icon-text">Telehealth services</p>'],
										['isOn' => $location->badge_asl, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="American sign language" width="28" height="28" src="/img/sign-language.png"><p class="icon-text">American Sign Language</p>'],
										['isOn' => $location->badge_tinnitus, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Tinnitus" width="28" height="28" src="/img/ear.png"><p class="icon-text">Tinnitus</p>'],
										['isOn' => $location->badge_balance, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Balance testing" width="28" height="28" src="/img/dizziness.png"><p class="icon-text">Balance testing</p>'],
										['isOn' => $location->badge_home, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Screen at home" width="28" height="28" src="/img/home.png"><p class="icon-text">Screen/test at home</p>'],
										['isOn' => $location->badge_remote, 'badgeElement' => '<img loading="lazy" class="badge-img" alt=" Remote hearing aid programming" width="28" height="28" src="/img/laptop.png"><p class="icon-text">Remote hearing aid programming</p>'],
										['isOn' => $location->badge_mask, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Masks worn here" width="28" height="28" src="/img/mask.png"><p class="icon-text">Masks worn here</p>'],
										['isOn' => $location->badge_ear_cleaning, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Ear cleaning" width="28" height="28" src="/img/ear-cleaning.png"><p class="icon-text">Ear cleaning</p>'],
										['isOn' => $location->badge_spanish, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Spanish" width="28" height="28" src="/img/mexico.png"><p class="icon-text">Habla Español</p>'],
										['isOn' => $location->badge_french, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="French" width="28" height="28" src="/img/france.png"><p class="icon-text">Parle Français</p>'],
										['isOn' => $location->badge_russian, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Russian" width="28" height="28" src="/img/russia.png"><p class="icon-text">мы говорим по-русски</p>'],
										['isOn' => $location->badge_chinese, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Chinese" width="28" height="28" src="/img/china.png"><p class="icon-text">我们说中文</p>'],
										['isOn' => $location->badge_punjabi, 'badgeElement' => '<img loading="lazy" class="badge-img" alt="Indian-Punjabi" width="28" height="28" src="/img/india.png"><p class="icon-text">ਅਸੀਂ ਪੰਜਾਬੀ ਬੋਲਦੇ ਹਾਂ</p>']
							
									];
									
									foreach ($badgeArray as $key => $badge) {
										
										if ($badge['isOn'] === false) {
											unset($badgeArray[$key]);
										}
										
									}
								}
							
							?>
							
							<?php if(!empty($badgeArray)): ?>
								<div class="panel panel-light mobile">
									<div class="panel-heading text-center">
										<h2>Amenities</h2>
									</div>
									<div class="panel-body">
										<div class="panel-section condensed">
											<div class="amenity-container">
												
												<?php foreach($badgeArray as $key): ?>
													<span class="amenity">
														<?= $key['badgeElement'] ?>
													</span>
												<?php endforeach; ?>
												
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
							
							<!-- Affiliations -->
							<?php if (($location->is_iris_plus || $location->is_cq_premier) && $location->listing_type == 'Premier'): ?>
								<div id="affiliates" class="panel panel-primary text-center">
									<header class="panel-heading text-center">
										<h2>Affiliations</h2>
									</header>
									<div class="panel-body">
										<div class="panel-section condensed">
											<div class="col-md-4">
												<img loading="lazy" class="earq-affiliate-img" src="/img/nflpa-cq.png" alt="Clinic affiliations" width="300" height="84">
											</div>
											<p class="earq-blurb col-md-8 tal">We are preferred providers of the NFL Players Association’s Professional Athletes Foundation. Our goal is to bring better hearing to former professional athletes and fit them with the hearing technology they need.</p>
											<div class="col-md-4">
												<img loading="lazy" class="earq-affiliate-img" src="/img/earq-hearstrong.jpg" alt="Clinic affiliations" width="300" height="42">
											</div>
											<p class="earq-blurb col-md-8 tal">We are a proud partner of HearStrong, an organization that spreads hearing loss awareness and provides hearing aids to those in need.</p>
										</div>
									</div>
								</div>
							<?php endif; ?>
							<?php if(!$isMobileDevice){
								echo $this->element('layouts/call_clinic', ['isEnhancedOrPremier'=>$isEnhancedOrPremier, 'displayOpenClosed',$displayOpenClosed, 'isCallTrackingBypassed'=>$isCallTrackingBypassed]);
							}
							?>
						</div>
				
						<div class="col-md-4">
							
							<!-- Clinic Links -->
							<?= $location->listing_type == 'Premier' ? $this->element('locations/profile/clinic_links') : null ?>
							
							<!-- Hours -->
							<?php if (!$isMobileDevice && $hours): ?>
								<div id="hours" class="panel panel-light">
									<div id="earqHours"></div>
									<header class="panel-heading text-center">
										<h2>Hours of operation</h2>
									</header>
									<div class="panel-body">
										<div class="panel-section condensed">
											<?php echo $hours; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
							
							<!-- Vidscrips -->
							<?php if ($location->is_cq_premier && isset($location->location_vidscrip->vidscrip)) : ?>
								<div class="vidscrip-container" style="margin: 0 auto 20px; max-width: 600px">
									<div id="vidscrip-embed-<?= $location->location_vidscrip->vidscrip ?>"></div>
									<script src="https://widget.vidscrip.com/vidscrip.js"></script>
									<script>
										var vidscripContainer = document.getElementsByClassName("vidscrip-container"),
											vidscripScript = vidscripContainer[0].getElementsByTagName("script"),
											isInViewport = function(element) {
											    const rect = element.getBoundingClientRect();
											    return (
											        rect.top >= 0 &&
											        rect.left >= 0 &&
											        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
											        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
											    );
											},
											vidscripCall = function(){
												var vidscripScroll = window.addEventListener("scroll",function() {
												    if (vidscripScript[0].getAttribute("src") == null && isInViewport(vidscripContainer[0])) {
												        vidscripScript[0].setAttribute("src",vidscripScript[0].getAttribute("src"));
												    } else if (vidscripScript[0].getAttribute("src") != null && isInViewport(vidscripContainer[0])) {
													    if(typeof(addVidscripWidget) !== 'undefined') {
															addVidscripWidget({ elementId: "vidscrip-embed-<?= $location->location_vidscrip->vidscrip ?>", vidscrips: ["<?= $location->location_vidscrip->vidscrip ?>"], theme: "v2", email: "<?= $location->location_vidscrip->email ?>" });
															isInViewport = function(){return false};
												        	var removeSignIn = setInterval(function(){
													        		$(".vidscrip-embed button:contains(Sign up)").prev().addClass("hidden");
																	$(".vidscrip-embed button:contains(Sign up)").addClass("hidden");
																	if($(".vidscrip-embed button:contains(Sign up)").hasClass("hidden")){
																		clearInterval(removeSignIn);
																	}
																}, 100)
														}
												    }
												});
											}();
											
									</script>
								</div>
							<?php endif; ?>
				
							<!-- Linked Locations -->
							<?php if ($isEnhancedOrPremier): ?>
								<?php $linkedLocations = $this->Clinic->linkedLocations($location->id); ?>
								<?php if (!empty($linkedLocations)): ?>
									<div id="linkedLocationAnchor" style="position:absolute;margin-top:-70px"></div>
									<div id="linkedLocations" class="panel panel-light text-center">
										<div></div>
										<header class="panel-heading text-center">
											<h2>Visit our other locations</h2>
										</header>
										<div class="panel-body">
											<div class="panel-section condensed">
												<?= $linkedLocations; ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							
							<!-- Special announcement -->
							<?php if ($showSpecialAnnouncement): ?>
								<?php if (!empty($location->id_coupon)): ?>
									<div class="panel panel-light" id="specialAnnouncement">
										<header class="panel-heading text-center"><h2>Special Offer</h2></header>
										<div class="panel-body">
											<div class="panel-section condensed">
												<?php
													$moneyOffArray = [1,4,7];
													$freeAccArray = [2,5,8];
													$freeScreenArray = [3,6,9];	
													if (in_array($location->id_coupon, $moneyOffArray)){
														$couponAlt = "$200 off premium technology coupon for ";
													} elseif (in_array($location->id_coupon, $freeAccArray)){
														$couponAlt = "Free accessory with purchase coupon for ";
													} elseif (in_array($location->id_coupon, $freeScreenArray)) {
														$couponAlt = "Free hearing screening coupon for ";
													}
													$couponAlt .= $location->title;
												?>
												<img loading="lazy" width="300" height="300" src="<?= '/img/coupons/coupon-'.$location->id_coupon.'.jpg'; ?>" alt="<?= $couponAlt ?>">
											</div>
										</div>
										<footer class="panel-footer">Please mention this Healthy Hearing coupon when you book your appointment.</footer>
									</div>
								<?php elseif (!empty($location->location_ad)): ?>
									<div class="panel panel-light" id="specialAnnouncement">
										<?php if (!empty($location->location_ad->title)): ?>
											<header class="panel-heading text-center">
												<h2><?= $location->location_ad->title; ?></h2>
											</header>
										<?php endif; ?>
										<?php if (!empty($location->location_ad->photo_url)): ?>
											<div class="panel-body">
												<div class="panel-section condensed">
													<img loading="lazy"<?php if(!empty($location->location_ad->border)){ echo ' class="' . $location->location_ad->border . '"';} ?> width="300" height="300" src="/cloudfiles/clinics/<?= $location->location_ad->photo_url; ?>" alt="Announcement for <?= $location->title ?>">
												</div>
											</div>
										<?php endif; ?>
										<?php if (!empty($location->location_ad->description)): ?>
											<footer class="panel-footer tac">
												<?= $location->location_ad->description; ?>
											</footer>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							
							<!-- Badges -->
							<?php if(!empty($badgeArray)): ?>
								<div class="panel panel-light desktop">
									<div class="panel-heading text-center">
										<h2>Amenities</h2>
									</div>
									<div class="panel-body">
										<div class="panel-section condensed">
											<div class="amenity-container">
												
												<?php foreach($badgeArray as $key): ?>
													<span class="amenity">
														<?= $key['badgeElement']?>
													</span>
												<?php endforeach; ?>
												
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
				
							<!-- Clinic Links -->
							<?= $location->listing_type != 'Premier' ? $this->element('locations/profile/clinic_links') : null ?>
							
							<!-- Payment -->
							<?php if ($payment = $this->Clinic->newMethodOfPayment($location)): ?>
								<div class="panel panel-light">
									<div class="panel-heading text-center">
										<h2>Accepted forms of payment</h2>
									</div>
									<div class="panel-body">
										<div class="panel-section condensed">
											<?= $payment; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
				
							<!-- Affiliations -->
							<?php if ($location->is_iris_plus && $location->listing_type == 'Premier' && $isMobileDevice): ?>
								<div id="affiliates" class="panel panel-light text-center">
									<header class="panel-heading text-center">
										<h2>Affiliations</h2>
									</header>
									<div class="panel-body">
										<div class="panel-section condensed">
											<div class="col-md-4">
												<img loading="lazy" class="earq-affiliate-img" src="/img/earq-warranty-logo.jpg" alt="Clinic affiliations" width="62" height="101">
											</div>
											<p class="earq-blurb col-md-8 tal">We are proud to be your exclusive EarQ provider. Only EarQ providers can offer leading hearing aid technology complete with the EarQ 4-Year Warranty that covers any EarQ device for four full years.</p>
											<div class="col-md-4">
												<img loading="lazy" class="earq-affiliate-img" src="/img/earq-hearstrong.jpg" alt="Clinic affiliations" width="300" height="42">
											</div>
											<p class="earq-blurb col-md-8 tal">We are a proud partner of HearStrong, an organization that spreads hearing loss awareness and provides hearing aids to those in need.</p>
											<div class="col-md-4">
												<img loading="lazy" class="earq-affiliate-img" src="/img/nflpa-cq.png" alt="Clinic affiliations" width="300" height="84">
											</div>
											<p class="earq-blurb col-md-8 tal">We are preferred providers of the NFL Players Association’s Professional Athletes Foundation. Our goal is to bring better hearing to former professional athletes and fit them with the hearing technology they need.</p>
										</div>
									</div>
								</div>
							<?php endif; ?>
							<?php if ($isMobileDevice) {
								echo $this->element('layouts/call_clinic', ['isEnhancedOrPremier'=>$isEnhancedOrPremier, 'displayOpenClosed',$displayOpenClosed, 'isCallTrackingBypassed'=>$isCallTrackingBypassed]);
							}
							?>
							
							<!-- Ida Explanation -->
							<?php
							$idaProvider = false;
							foreach ($location->location_providers as $locationProvider) {
								if ($locationProvider->provider->is_ida_verified) {
									$idaProvider = true;
									break;
								}
							}
							?>
							<?php if ($location->is_ida_verified || !empty($idaProvider)): ?>
								<div id="idaAnchor"></div>
								<div id="idaExplained" class="panel panel-light">
									<div class="panel-body">
										<div class="panel-section condensed">
											<img loading="lazy" class="ida-badge block" alt="Clinic badge from Ida Institute" src="/img/ida_badge.png" width="80" height="80">
											<small>Providers who have earned the Inspired by Ida label have taken courses online at the Ida Institute. To earn the label, a provider must take two specific courses that outline best practices for putting the patient first. Clinics may display the Inspired by Ida label if the majority of their providers have earned the provider label. The Ida Institute is a non-profit organization that develops resources to help hearing care professionals around the world strengthen their counseling process.
											</small>
										</div>
									</div>
								</div>
							<?php endif; ?>
				
							<!-- Disclaimer -->
							<div id="disclaimer" class="panel panel-light">
								<div class="panel-body">
									<div class="panel-section condensed">
										<small>
											<strong>Disclaimer:</strong>
											This clinic profile is for general information purposes only.
										</small>
									</div>
								</div>
							</div>
							<?php if (Configure::read('showAds') && !$isEnhancedOrPremier): ?>
								<!-- Ad space -->
								<?= $this->element('render_ad', ['ad' => $ad]) ?>
							<?php endif; ?>
							
						</div>
					</div>
					<?php $businessSchema = '<script type="application/ld+json">
						{
							"@context": "https://schema.org",
							"@type": "LocalBusiness",
							"name": "' . $location->title . '",
							"address": {
								"@type": "PostalAddress",';
								if (!$location->is_mobile) {
									$businessSchema .= '"streetAddress": "' . $location->address . '",';
								}
								$businessSchema .= '"addressLocality": "' . $location->city . '",
								"addressRegion": "' . $location->state . '",
								"postalCode": "' . $location->zip . '",
								"addressCountry": "' . Configure::read('country') . '"
							},
							"geo": {
								"@type": "GeoCoordinates",
								"latitude": "' . $location->lat . '",
								"longitude": "' . $location->lon . '"
							}';
							if (!empty($location->phone)) {
								$businessSchema .= ', "telephone": "' . $location->phone . '"';
							}
							if (!empty($firstProvider)) {
								$businessSchema .= ', "image": "' . $this->Clinic->providerImage($firstProvider, ['url_only' => true]) . '"';
							}
							if(!$hideProvider) {
								
								$businessSchema .= ', "employee": [';
								foreach ($location->location_providers as $key => $loocationProvider) {
									$provider = $loocationProvider->provider;
									$businessSchema .=  '{"@type": "Person",';
									
									if(!empty($provider->thumb_url)) {
										$businessSchema .= '"image": "' . $provider->thumb_url . '",';
									}
									if (!empty($provider->title)) {
										$businessSchema .= '"jobTitle": "' . $provider->title . '",';
									}
									if(!empty($provider->credentials)) {
										$businessSchema .= '"honorificSuffix": "' . $provider->credentials . '",';
									}
									if(!empty($provider['description'])) {
										$businessSchema .= '"description": "' . htmlentities(strip_tags($provider->description)) . '",';
									}
									
									$businessSchema .= '"name": "' . htmlentities(strip_tags($provider->first_name . ' ' . $provider->last_name)) . '"';
									
									if ($key + 1 >= count($location->location_providers)){
										$comma =  '';
									} else {
										$comma = ',';
									}
									$businessSchema .= '}' . $comma;
								}
								
								$businessSchema .= ']';
								
							}

							$businessSchema .= $this->Clinic->reviewSchema($location);
							
							$businessSchema .= ', "review": [';
								// Limit to 299 reviews in schema
								$reviews = array_slice($location->reviews, 0, 298);
								$truncate = isset($truncate) ? $truncate : false;
								$name = empty($name) ? null : $name;
								foreach ($reviews as $key => $review) {
									$businessSchema .= '{"@type": "Review",
										"reviewRating": {
											"@type": "Rating",
											"ratingValue": "'. $review->rating .'",
											"bestRating": "5",
											"worstRating": "1"
										},
										"datePublished": "' . date('Y-m-d', strtotime($review->created)) . '",
										"reviewBody": "' . htmlentities($this->Clinic->formatReview($review->body, $truncate)) . '"';
										if (empty($hideName)) {
											$businessSchema .= ',';
											$businessSchema .= '"author": {"@type": "Person", "name": "' . htmlentities(strip_tags($this->Clinic->formatReviewSignature($review, ['name' => $name, 'json' => true]))) . '"}';
										}
										if ($key + 1 >= count($reviews)){
											$comma =  '';
										} else {
											$comma = ',';
										}
										$businessSchema .= '}' . $comma;
								}
							$businessSchema .= ']';
							
							$dayCount = 0;
							$dayArray = ['sun'=>'Sunday','mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday'];
							
							foreach ($dayArray as $dayShort => $day) {
								$isClosed = $dayShort . '_is_closed';
								if ($location->location_hour->$isClosed != true){
									$dayCount++;
								}
							}
							
							if ($dayCount > 0) {
								$businessSchema .= ', "openingHoursSpecification": [';
								foreach ($dayArray as $dayShort => $day) {
									$isClosed = $dayShort . '_is_closed';
									$open = $dayShort . '_open';
									$close = $dayShort . '_close';
									if ($location->location_hour->$isClosed != true) {
										$businessSchema .= '{"@type": "OpeningHoursSpecification",
															"dayOfWeek": "' . $day . '",
															"opens": "' . $location->location_hour->$open . '",
															"closes": "' . $location->location_hour->$close .'"
															}';
										if ($dayCount > 1) {
											$businessSchema .= ',';
											$dayCount--;
										}
									}
									
								}
								$businessSchema .= ']';
							}
							$businessSchema .= '}</script>';
					echo $businessSchema;
					?>
				</div>
				<?= $this->element('locations/profile/map_modal') ?>
				<?php if (Configure::read('isCallAssistEnabled') && $location->is_call_assist && $isEnhancedOrPremier): ?>
					<?php $this->append('bs-modals'); ?>
					<?php $this->end(); ?>
				<?php endif; ?>
				<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && !empty($location->direct_book_iframe)): ?>
					<?= $this->element('locations/profile/direct_book_modal', ['iframe' => $location->direct_book_iframe, 'locationId' => $location->id, 'locationTitle' => $location->title]); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>