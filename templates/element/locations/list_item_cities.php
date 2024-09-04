<?php
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Location;

$isCallAssistEnabled = Configure::read('isCallAssistEnabled');
$isCallTrackingBypassed = TableRegistry::get('Configurations')->isCallTrackingBypassed();

$locationId = $location->id;
$displayOpenClosed = $this->Clinic->getOpenClosedByLocationId($locationId);
$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($locationId);
?>
<div class="col-md-12 gutter-below">
	<div class="well clinic-info">
		<div class="row">
			<h2 class="name mt0 pull-left">
				<!-- *** TODO: check this when setLocation is working on the link function ***-->
				<?= $this->Clinic->link($location, false, ['class' => 'text-primary ' . 'ClinicClick-' . $location->listing_type, 'escape' => false]) ?>
			</h2>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<?php if (!empty($displayOpenClosed)): ?>
					<div class="hours mb5">
						<span class="glyphicon glyphicon-time small"></span>
						<?= $displayOpenClosed ?>
					</div>
				<?php endif; ?>
				<?= $this->Clinic->addressSchemaHidden($location) ?>
				<div class="address mb5">
					<span class="hh-icon-address"></span>
					<?= $this->Clinic->address($location) ?>
				</div>
				<?= $this->Clinic->reviewSchemaHidden($location) ?>
				<div class="reviews">
					<?= $this->Clinic->basicStarRating($location) ?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinicPhone mb5" data-id="<?= $locationId ?>">
					<div class="telephone h2"><span class="bi bi-telephone-fill"></span> <?= $this->Clinic->phone($location, ['link' => $isMobileDevice]) ?></div>
					<!-- Appointment request -->
					<?php if ($isCallAssistEnabled && !$isCallTrackingBypassed): ?>
						<?php if ($location->is_call_assist && empty($location->direct_book_iframe)): ?>
							<a href="#" class="btn btn-lg btn-secondary apptRequestBtn" data-id="<?= $locationId ?>">
								Request my appointment
							</a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && (!empty($location->direct_book_iframe))): ?>
						<div>
							<a href="#" class='btn btn-lg btn-secondary directBookBtn mb5 mt10' data-button="<?=$location->id ?>">Book now!</a>
						</div>
						<?= $this->element('locations/profile/direct_book_modal', ['iframe' => $location->direct_book_iframe, 'locationId' => $location->id, 'locationTitle' => $location->title]) ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
