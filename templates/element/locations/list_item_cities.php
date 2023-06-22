<?php
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Location;

$isCallAssistEnabled = Configure::read('isCallAssistEnabled');
$isCallTrackingBypassed = isset($isCallTrackingBypassed) ? $isCallTrackingBypassed : TableRegistry::get('Configurations')->isCallTrackingBypassed();

$locationId = $location->id;
$displayOpenClosed = $this->Clinic->getOpenClosedByLocationId($locationId);
$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($locationId);
?>
<div class="col-md-12 gutter-below">
	<div class="well clinic-info">
		<div class="row">
			<h2 class="name mt0 pull-left">
				<?php echo $this->Html->link($location->title, $location->hh_url, ['class' => 'text-primary ' . 'ClinicClick-' . $location->listing_type, 'escape' => false]); ?>
			</h2>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php if (!empty($displayOpenClosed)): ?>
					<div class="hours mb5">
						<span class="glyphicon glyphicon-time small"></span>
						<?php echo $displayOpenClosed; ?>
					</div>
				<?php endif; ?>
				<?php echo $this->Clinic->addressSchemaHidden($location); ?>
				<div class="address mb5">
					<span class="hh-icon-address"></span>
					<?php echo $this->Clinic->address($location); ?>
				</div>
				<?php echo $this->Clinic->reviewSchemaHidden($location); ?>
				<div class="reviews">
					<?php echo $this->Clinic->basicStarRating($location); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="clinicPhone mb5" data-id="<?php echo $locationId; ?>">
					<div class="telephone h2"><span class="glyphicon glyphicon-earphone"></span> <?php echo $this->Clinic->phone($location, ['link' => $isMobileDevice]); ?></div>
					<!-- Appointment request -->
					<?php if ($isCallAssistEnabled && !$isCallTrackingBypassed): ?>
						<?php if ($location->is_call_assist && empty($location->direct_book_iframe)): ?>
							<a href="#" class="btn btn-lg btn-secondary apptRequestBtn" data-id="<?php echo $locationId; ?>">
								Request my appointment
							</a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && (!empty($location->direct_book_iframe))): ?>
						<div>
							<a href="#" class='btn btn-lg btn-secondary directBookBtn mb5 mt10' data-button="<?php echo $location->id; ?>">Book now!</a>
						</div>
						<?php echo $this->element('locations/profile/direct_book_modal', ['iframe' => $location->direct_book_iframe, 'locationId' => $location->id, 'locationTitle' => $location->title]); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<<<<<<< HEAD
</div>
=======
</div>
>>>>>>> main
