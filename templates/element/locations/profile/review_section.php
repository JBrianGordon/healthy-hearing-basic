<?php
/**
 * @var \App\View\AppView $this
 */
?>

<!-- Reviews -->
<section id="reviews" class="panel panel-primary">
	<h3>Reviews</h3>
	<?= $this->element('locations/profile/review_modal', ['location' => $location]) ?>
</section>