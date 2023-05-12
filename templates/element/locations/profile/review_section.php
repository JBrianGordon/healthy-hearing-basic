<?php
/**
 * @var \App\View\AppView $this
 */
?>

<!-- Reviews -->
<section id="reviews" class="panel panel-primary">
	<?= $this->element('locations/profile/review_modal', ['location' => $location]) ?>
	<?php if(!empty($location->reviews) || $location->state != 'ON') : ?>
	  <!-- Reviews -->
	  <section id="reviews" class="panel panel-primary">
	    <a name="Reviews"></a>
	    <div id="earqReviews"></div>
	    <header class="panel-heading text-center">
	      <h3>Reviews</h3>
	      <small><?php echo $siteName; ?> posts all positive and negative reviews that meet publishing <a href="/terms-of-use#reviews" class="text-link">criteria</a>.</small>
	    </header>
	    <div class="panel-body clinic-info">
	      <div class="panel-section reviews">
	        <p>
	          <?php /*** TODO: uncomment when reviewText built in clinic helper*** :echo $this->Clinic->reviewText($location);*/ ?>
	        </p>
	        <p<?php if($location->state == 'ON'){ echo ' style="height:20px"'; } ?>>
	          <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#reviewSubmitModal">Write a review</button>
	          <?php if (isset($location->reviews) && count($location->reviews)): ?>
	          <span id="sortSpan">Sort by: <select id="sortSelect">
	                  <option value="newestArr">Newest</option><option value="highestRating">Highest Rating</option><option value="lowestRating">Lowest Rating</option>
	                </select>
	              </span>
	          <?php endif; ?>
	        </p>
	        <?php if (isset($location->reviews) && count($location->reviews)): ?>
	          <?php $reviews = $this->Clinic->sliceReviews($location->reviews); ?>
	          <?php foreach ($reviews[0] as $review): ?>
	            <div class="well">
	              <?php //echo $this->element('locations/review_body', ['review' => $review]); ?>
	            </div>
	          <?php endforeach; ?>
	          <?php if (!empty($reviews[1])): ?>
	            <div id="more-reviews" style="display:none;">
	              <?php foreach($reviews[1] as $review): ?>
	                <div class="well">
	                  <?php echo $this->element('locations/review_body', array('review' => $review)); ?>
	                </div>
	              <?php endforeach; ?>
	            </div>
	            <p class="text-center">
	              <a href="" id="fewer-reviews-button" class="btn btn-light">Fewer Reviews</a>
	              <a href="" id="more-reviews-button" class="btn btn-light">More Reviews</a>
	            </p>
	          <?php endif; ?>
	        <?php elseif($location['Location']['state'] != 'ON'): ?>
	          <p>Click on the orange button above and tell others about your experience at <?php echo $location['Location']['title']; ?> to help them find the hearing care they need.</p>
	        <?php endif; ?>
	      </div>
	    </div>
	  </section>
	<?php endif; ?>
</section>