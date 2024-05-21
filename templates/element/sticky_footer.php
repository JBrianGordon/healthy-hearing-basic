<?php
	use Cake\Core\Configure;
	use Cake\ORM\TableRegistry;
	use App\Model\Entity\Location;
?>
<footer id="stickyFooter" class="d<?= isset($location->id) || $this->getRequest()->getParam('controller') == 'Locations' || $this->getRequest()->getParam('controller') == 'Content' || $this->getRequest()->getParam('controller') == 'Wikis' || $this->getRequest()->getParam('controller') == 'Corps' ? "-lg" : ""?>-none col-xs-12 w-100 sticky-footer noprint">
	<div class="col-xs-12 w-100 mt10 mb10">
		<?php if (isset($location->id)): ?>
			<?php 
				$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($location->id);
				$displayOpenClosed = $this->Clinic->getOpenClosedByLocationId($location->id);
			?>
			<!-- Clinic profile pages -->
			<?php if (Configure::read('isCallAssistEnabled') && $location->is_call_assist && $isEnhancedOrPremier && !TableRegistry::get('Configurations')->isCallTrackingBypassed()): ?>
				<div>
					<?php if (in_array($location->direct_book_type, [Location::DIRECT_BOOK_BLUEPRINT, Location::DIRECT_BOOK_EARQ]) && !empty($location->direct_book_iframe)): ?>
						<a href="#" class="btn btn-secondary directBookBtn" data-button="<?= $location->id; ?>" style="min-width:180px;">Book now!</a>
					<?php else: ?>
						<a href="#" class="btn btn-secondary apptRequestBtn">Request my appointment</a>
					<?php endif; ?>
				</div>
				<?php if(!empty($displayOpenClosed) || !Configure::read('isCallAssistEnabled')): ?>
					<div class="telephone mt5">
						Or call: <strong><?= $this->Clinic->phone($location); ?></strong>
					</div>
				<?php endif; ?>
			<?php else: ?>
				<div class="telephone">
					<span class="glyphicon glyphicon-earphone"></span> <strong><?= $this->Clinic->phone($location); ?></strong>
				</div>
			<?php endif; ?>
		<?php elseif ($this->getRequest()->getParam('controller') == 'Locations'): ?>
		<!--*** TODO: set up quick pick ***-->
			<?php if (isFeatureOn('quick_pick')): ?>
				<p class="message-800-number mb0" class="text-large">
					<span class="telephone">Call <a href=<?= "tel:+".Configure::read('quickPickNumber'); ?>><?= Configure::read('quickPickNumber'); ?></a></span> to book a test<br>with a clinic near you.
				</p>
			<?php else: ?>
				<!-- Nothing to display. Hide the sticky footer. -->
				<script>document.getElementById("stickyFooter").style.display = "none";</script>
			<?php endif; ?>
		<?php elseif($this->getRequest()->getParam('controller') == 'Content' || $this->getRequest()->getParam('controller') == 'Wikis' || $this->getRequest()->getParam('controller') == 'Corps'): ?>
			<!-- Report/Help/Manufacturer pages -->
			<div>
				<a href="<?= $this->Clinic->nearMeLink();?>" class="btn btn-secondary">Connect with clinics near me</a>
			</div>
			<?php if (Configure::read('showHearingTest')): ?>
				<div class="mt5">
					Not sure? Take our <a href="/help/online-hearing-test" class="text-link">online hearing test.</a>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</footer>