<?php 
	$iframe = isset($iframe) ? $iframe : null;
	$locationId = $locationId ? $locationId : null;
	$locationTitle = isset($locationTitle) ? $locationTitle : null;
?>


<div class="modal fade" id="directBookModal-<?= $locationId ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Book your appointment at <?= $locationTitle ?>:</h4>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- For speed optimization, the iframe code will be un-commented by js when the 'Book now' button is clicked -->
			<div class="modal-body direct-book-body">
				<!--<?= $iframe ?>-->
			</div>
		</div>
	</div>
</div>
<?php $this->end();