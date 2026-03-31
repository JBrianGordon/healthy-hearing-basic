<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
use App\Enums\Model\Review\ReviewOrigin;
use App\Enums\Model\Review\ReviewStatus;

$siteUrl = Configure::read('siteUrl');
$shortReviewUrl = 'www.' . $siteUrl . '/review/'. $location->id;
?>
<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container noprint">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body clinicLayout">
                            <div class="panel-section expanded">
                                <div class="row card-row" style="display:none">
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?= $shortReviewUrl ?></p>
                                            <p>Then click the orange "write a review" button. It only takes a minute. Thank you!</p>
                                            <img class="hh-symbol" src="/img/hh-symbol.svg">
                                        </div>
                                    </div>
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?= $shortReviewUrl ?></p>
                                            <p>Then click the orange "write a review" button. It only takes a minute. Thank you!</p>
                                            <img class="hh-symbol" src="/img/hh-symbol.svg">
                                        </div>
                                    </div>
                                </div>
                                <div class="row card-row" style="display:none">
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?= $shortReviewUrl ?></p>
                                            <p>Then click the orange "write a review" button. It only takes a minute. Thank you!</p>
                                            <img class="hh-symbol" src="/img/hh-symbol.svg">
                                        </div>
                                    </div>
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?= $shortReviewUrl ?></p>
                                            <p>Then click the orange "write a review" button. It only takes a minute. Thank you!</p>
                                            <img class="hh-symbol" src="/img/hh-symbol.svg">
                                        </div>
                                    </div>
                                </div>
                                <div class="noprint">
                                    <h1 class="noprint">Reviews</h1>
                                    <?php if ($isAdmin && !isset($location->id)): ?>
                                        <?= $this->Form->create($reviews) ?>
                                            <div class="row noprint">
                                                <div class="col col-lg-6">
                                                    <?= $this->Form->control('username', ['label' => ['text' => 'Username', 'class' => 'col-sm-3 pt10'],'type' => 'text', 'class' => 'col-sm-9 mb20', 'required' => true]) ?>
                                                    <div class="form-actions mt10">
                                                        <input type="submit" value="Find reviews" class="btn btn-primary btn-lg">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                    <?php if (isset($location->id)): ?>
                                        <?php
                                            $options = [
                                                'url' => [$location->id],
                                            ];
                                            $this->Paginator->options($options);
                                        ?>
                                        <a class="btn btn-print btn-light noprint" onclick="window.print()">Download review cards</a><span class="noprint"> Download and print customized review encouragement cards to hand out to your patients.</span>
                                        <table class="table table-striped table-bordered white-background table-condensed noprint">
                                        <?php if(Configure::read('country') == 'US') : ?>
                                            <p class="mb0">Link to your Healthy Hearing profile on your clinic website to get more reviews!</p>
                                            <button id="copyLink" class="btn btn-light mb20" value="<?= Router::url($location->hh_url, true) ?>">Copy link</button>
                                        <?php endif; ?>
                                            <tr>
                                                <th style="min-width:115px"><?= $this->Paginator->sort('created', 'Date') ?></th>
                                                <th><?= $this->Paginator->sort('first_name', 'Name') ?></th>
                                                <th><?= $this->Paginator->sort('body', 'Review') ?></th>
                                                <th><?= $this->Paginator->sort('origin', 'Origin') ?></th>
                                                <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                                                <th style="min-width:175px"><a href="#">Respond</a></th>
                                            </tr>
                                            <?php   foreach($reviews as $review):   ?>
                                                <tr>
                                                    <td class="center"><?= dateTimeCentralToEastern($review->created) ?></td>
                                                    <td>
                                                        <?= $this->Clinic->formatReviewSignature($review, ['name' => 'full']); ?><br />
                                                        <?= $review->zip;?>
                                                    </td>
                                                    <td class="center">
                                                        <?= $this->element('locations/review_body', ['review' => $review, 'hideName' => true, 'clinicName' => $location->title]) ?>
                                                    </td>
                                                    <td class="center"><?= ReviewOrigin::from($review->origin)->getOriginLabel() ?></td>
                                                    <td class="center">
                                                        <?php
                                                        $status = ReviewStatus::from($review->status)->getStatusLabel();
                                                        if ($status == 'Denied') {
                                                            $status = "Will be published ".date("m/d/y", strtotime($review->denied_date.'+ 30 days'));
                                                        }
                                                        echo $status;
                                                        ?>
                                                    </td>
                                                    <td class="center">
                                                        <?php
                                                        if (!empty($review->response)) {
                                                            echo $this->Html->link('Edit response',
                                                                ['action' => 'respond', $review->id], ['class' => 'btn btn-primary']);
                                                        } else if ($review->status == ReviewStatus::DENIED) {
                                                            echo $this->Html->link('Response needed',
                                                                ['action' => 'respond', $review->id], ['class' => 'btn btn-secondary']);
                                                        } else {
                                                            echo $this->Html->link('Write a response',
                                                                ['action' => 'respond', $review->id], ['class' => 'btn btn-primary']);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if(empty($reviews)): ?>
                                                <tr><td colspan="6" class="center">No reviews found.</td></tr>
                                            <?php endif; ?>
                                        </table>
                                        <p>Please contact <?= $this->Html->link(Configure::read('siteName'), Router::url('/contact-us', true), ['target' => '_blank']) ?> at 
                                        <?php
                                            $email = Configure::read('customer-support-email');
                                            $emailLink = str_replace('/clinic/reviews/', '', 'mailto:' . $email);
                                            echo $this->Html->link($email, $emailLink);
                                            ?> if you'd like some tips on how to respond to reviews.</p>
                                        <?= $this->element('pagination', ['options' => $options]) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Vite->script('review_clinic_index','common'); ?>
