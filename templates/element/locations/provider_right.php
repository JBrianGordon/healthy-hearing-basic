<?php
use Cake\Routing\Router;

$alt = 'Photo of '.$provider->first_name.' '.$provider->last_name;
if (!empty($provider->credentials)) {
    $alt .= ', '.$provider->credentials;
}
$alt .= ' from '.$location->title;
$locationUrl = Router::url($location->hh_url);
?>
<div class='well provider-well mb0'>
    <div class='row'>
        <div class='col-sm-8'>
            <?php
            $providerName = $provider->first_name . ' ' . $provider->last_name;
            if (!empty($provider->credentials)) {
                $providerName .= ', <span class="provider-credentials">' . $provider->credentials . '</span>';
            }
            ?>
            <h3 class="clinic-provider-name"><?= $providerName ?></h3>
            <?php
            $providerTitle = $provider->title;
            if (empty($providerTitle)) {
                $providerTitle = $this->Clinic->getProviderTitle($provider->credentials);
            }
            ?>
            <?php if (!empty($providerTitle)): ?>
                <h4 class="provider-title text-primary"><?= $providerTitle ?></h4>
            <?php endif; ?>
            <p class="clinic-provider-bio mb0"><?= $this->Clinic->truncate(strip_tags($provider->description), 100, "..."); ?></p>
        </div>
        <div class='col-sm-4'>
            <a href="<?= $locationUrl ?>">
                <?php if(!empty($location->logo_url) && !$isMobileDevice && $location->listing_type == 'Premier'): ?>
                    <div class="logo-container mr10 col-xs-12"><img loading="lazy" class="clinic-logo" src="<?=$location->logo_url?>" alt="<?=$location->title?> logo" width="120" height="40"></div>
                <?php endif; ?>
                <?= $this->Clinic->providerImage($provider, [
                    'class' => 'img-responsive align-center',
                    'alt' => $alt,
                    'width' => 200,
                    'height' => 150,
                ]); ?>
                <span class="visually-hidden">
                    <?= $location->title ?>
                </span>
             </a>
        </div>
    </div>
</div>
