<?php
use Cake\Core\Configure;
?>
<?php if (Configure::read('isCallAssistEnabled')): ?>
	<?php $quickPickNumber = Configure::read('quickPickNumber'); ?>
	<?php if ($locationsPage): // Locations page ?>
		<p class="text-large mb10">Need a hearing test but not sure which clinic to choose?</p>
		<p class="message-800-number mb10" class="text-large mt60 mb20">
			<span class="telephone">Call <a href=<?= "tel:+".$quickPickNumber ?>><?= $quickPickNumber ?></a></span> to book a hearing test with a clinic near you.
		</p>
	<?php else: ?>
		<?php if (isFeatureOn('quick_pick')): // Wiki/Content page ?>
			<p class="question-800-number mb10">Need a hearing test but not sure which clinic to choose?</p>
			<p class="message-800-number mb10">
				<span class="telephone">Call <a href=<?= "tel:+".$quickPickNumber ?>><?= $quickPickNumber ?></a></span> for help setting up a hearing test appointment.
			</p>
		<?php else: ?>
			<?php if (Configure::read('showReviewsByCity')): ?>
				<p class="mb10">We have more hearing clinic reviews than any other site!</p>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
