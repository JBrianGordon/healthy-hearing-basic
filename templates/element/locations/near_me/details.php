<ul class="no-bullets text-small">
    <?php foreach($clinicsNearMe as $distance => $location): ?>
        <li>
            <?php echo $this->Html->link($location->title, $location->hh_url, ['class' => 'text-link']); ?> - <?php echo $location->city.', '.$location->state; ?>
        </li>
    <?php endforeach; ?>
</ul>
<div>
    <?php $nearMeLink = $this->Clinic->nearMeLink(); ?>
    <a href="<?php echo $nearMeLink; ?>" class="btn btn-primary btn-xs m10 pl10 pr10">See more clinics</a>
</div>
