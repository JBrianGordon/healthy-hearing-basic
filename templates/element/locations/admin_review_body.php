<?php
use App\Enums\Model\Review\ReviewOrigin;

$show_response = !empty($review->response);
$clinic_name = $clinic_name ?? $review->location->title;
$reviewClass = $show_response ? 'single_review responded' : 'single_review';
?>
<div class="<?= $reviewClass ?>" itemscope itemtype="https://schema.org/Review">
    <div class="quote" itemprop="reviewBody">
        <p><?php echo $review->body; ?></p>
    </div>
    <div itemprop="author" class="author">
        <?php echo $this->Clinic->formatReviewSignature($review); ?>
        <?php echo $this->Clinic->generateHalfStars($review->rating); ?>
        <?= '<br>' . ReviewOrigin::from($review->origin)->getOriginVerification(); ?>
    </div>
    <?php if ($show_response) : ?>
        <div class="response">
            <blockquote>
                <?php echo $review->response; ?>
            </blockquote>
            <div class="who">- <strong>Official Response<?php if ($clinic_name) {
                echo " from $clinic_name";
                                                        } ?></strong></div>
        </div>
    <?php endif; ?>
</div>
