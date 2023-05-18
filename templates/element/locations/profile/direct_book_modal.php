<?php 
	$iframe = isset($iframe) ? $iframe : null;
	$locationId = $locationId ? $locationId : null;
	$locationTitle = isset($locationTitle) ? $locationTitle : null;
?>

<?php $this->append('bs-modals'); ?>
<div class="modal fade" id="directBookModal-<?php echo $locationId; ?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Book your appointment at <?php echo $locationTitle; ?>:</h4>
			</div>
			<!-- For speed optimization, the iframe code will be un-commented by js when the 'Book now' button is clicked -->
			<div class="modal-body direct-book-body">
				<!--<?php echo $iframe; ?>-->
			</div>
		</div>
	</div>
</div>
<?php $this->end();