<?php
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Location;

$Configurations = TableRegistry::get('Configurations');
?>
<!-- Phone number -->
<section id="callClinic" class="panel">
	<div class="panel-body">
		<div class="panel-section expanded">
			<div class="clinicPhone text-center" data-id="<?= $location->id ?>">
				<!-- Show number for CA clinics, basic clinics and open Premier clinics -->
				<?php if (!Configure::read('isCallAssistEnabled') || !$isEnhancedOrPremier || ($displayOpenClosed && $isEnhancedOrPremier)): ?>
					<div class="telephone h2 text-secondary mt0 bi bi-telephone-fill"> <?= $this->Clinic->phone($location, ['link' => $isMobileDevice]); ?></div>
				<?php endif; ?>
				<!-- Appointment request -->
				<?php if (Configure::read('isCallAssistEnabled') && !$Configurations->isCallTrackingBypassed()): ?>
					<?php if ($location->is_call_assist && $isEnhancedOrPremier): ?>
						<div class="tac"><a href="#" class="btn btn-lg btn-secondary apptRequestBtn mb5" style="min-width:250px;" title="An agent will call you to schedule your appointment">Request my appointment</a></div>
					<?php endif; ?>
					<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && !empty($location->direct_book_iframe)): ?>
						<div class="tac"><a href="#" class="btn btn-lg btn-secondary directBookBtn" style="min-width:250px;" data-button="<?= $location->id ?>">Book now!</a></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>