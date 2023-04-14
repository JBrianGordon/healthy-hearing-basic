<?php if($this->Clinic->website() || $this->Clinic->social()): ?>
	<section class="panel panel-light">
		<div class="panel-heading text-center">
			<h3>Clinic links</h3>
		</div>
		<div class="panel-body">
			<div class="panel-section condensed">
				<?php if ($website = $this->Clinic->website()): ?>
					<span class="website"><span style="color: #cacacb; display: inline-block; margin: 5px 2px 5px 5px;" class="glyphicon glyphicon-globe"></span> <?php echo $website; ?></span><br>
				<?php endif; ?>
				<?php echo $this->Clinic->social(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>