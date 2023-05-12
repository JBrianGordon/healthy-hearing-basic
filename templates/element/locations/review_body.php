<?php
if (!isset($review['Review']) && isset($review->body)) {
	$review['Review'] = $review;
}
// Only show the response after the response has been approved
$show_response = !empty($review->response) && ($review->response_status == Review::RESPONSE_STATUS_PUBLISHED);
$clinic_name = isset($clinic_name) ? $clinic_name : $this->Clinic->nameById($review->location_id);
$truncate = isset($truncate) ? $truncate : false;
$onclick = isset($onclick) ? $onclick : false;
$min_height = isset($min_height) ? $min_height : false;
$response_trunc = isset($response_trunc) ? $response_trunc : false;
$name = empty($name) ? null : $name;
?>
<div class="single_review <?php if($show_response){ echo "responded"; }?>" <?php if($onclick){ echo 'onclick="' . $onclick . '"'; } ?>>
	<div <?php if($onclick): ?>style="cursor: pointer"<?php endif; ?>>
		<div class="quote" <?php if($min_height){ echo "style=\"min-height: $min_height\""; } ?>>
			<p class="lead"><?php echo $this->Clinic->formatReview($review->body, $truncate); ?></p>
		</div>
		<div class="author">
			<?php
			if(empty($hideName)) {
				echo $this->Clinic->formatReviewSignature($review, ['name' => $name]);
			}
			$stars = $this->Clinic->generateHalfStars($review->rating);
			echo '&nbsp;&nbsp;&nbsp;' . $stars;

			echo '<br />';
			echo date('m/d/Y', strtotime($review->created)) . '&nbsp;&nbsp;&nbsp;';
			echo $this->Clinic->reviewVerification($review);

			?>
		</div>
		<?php if ($show_response) : ?>
		<div class="response">
			<br />
			<blockquote>
				<div class="who">
					<strong>Official Response<?php if($clinic_name && !$response_trunc) { echo " from $clinic_name";} ?>:</strong>
				</div>
				<div class="quote"><?php echo $this->Clinic->formatReview($review->response, $response_trunc); ?></div>
			</blockquote>
			Received <?php echo date('m/d/Y', strtotime($review->modified));	?>
		</div>
		<?php endif; ?>
	</div>
</div>
