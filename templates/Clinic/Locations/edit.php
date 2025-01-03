<?= $this->element('ckbox_script') ?>
<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
use App\Model\Entity\Location;

$siteUrl = Configure::read('siteUrl');
$locationId = $location->id;
$showSpecialAnnouncement = ($location->listing_type == Location::LISTING_TYPE_PREMIER);
$isBasicClinic = $location->listing_type == Location::LISTING_TYPE_BASIC;
$hhUrl = $location->hh_url;
preg_match('/\d+/', $hhUrl, $shortId);
$shortReviewUrl = 'www.' . $siteUrl . '/review/'. $shortId[0];
$locationAd = $location->location_ad;
$adId = $location->location_ad->id ?? null;

$this->Html->script('dist/clinic_edit.min.js?v='.Configure::read("tagVersion"), ['block' => true]);
?>
<meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">
<!-- Additional ATF CSS, since the css generator can't access our pages behind the login -->
<style type="text/css">
    .pt20 {
        padding-top: 20px;
    }
    .clear, .clearfix {
        display: block;
        clear: both;
    }
    .clinicLayout .basic-info {
        width: 70%;
        display: inline-block;
        float: left;
    }
    table.basic-info th, table.basic-info td {
        padding: 12px 24px;
    }
    .clinicLayout #quickButtons {
        width: 29%;
        display: inline-block;
        float: left;
    }
    .clinicLayout #quickButtons a {
        display: block;
        margin: 0 auto 20px;
        width: 250px;
    }
    .hidden {
        display: none;
    }
</style>
<div class="container-fluid site-body">
    <div class="row">
        <div class="backdrop-container">
            <div class="backdrop backdrop-gradient backdrop-height"></div>
        </div>
        <div class="container">
            <div class="row pt20">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body clinicLayout">
                            <div class="panel-section expanded">
                                <div class="row card-row hidden">
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?= $shortReviewUrl ?></p>
                                            <p>Then click the orange "write a review" button. It only takes a minute. Thank you!</p>
                                            <img class="hh-symbol" src="/img/hh-symbol.svg" style="max-width:50px;">
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
                                            <img class="hh-symbol" src="/img/hh-symbol.svg" style="max-width:50px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row card-row hidden">
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?=$shortReviewUrl ?></p>
                                            <p>Then click the orange "write a review" button. It only takes a minute. Thank you!</p>
                                            <img class="hh-symbol" src="/img/hh-symbol.svg" style="max-width:50px;">
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
                                            <img class="hh-symbol" src="/img/hh-symbol.svg" style="max-width:50px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="noprint">
                                    <?php
                                    $userIP = getenv('REMOTE_ADDR');
                                    $locationUserLogins = isset($this->request->data['LocationUser']['LocationUserLogin']) ? $this->request->data['LocationUser']['LocationUserLogin'] : [];
                                    $loginCount = 0;
                                    $showModal = true;
                                    $session = $this->request->getSession();
                                    $messageFlash = $session->read('Message.flash');
                                    if (!empty($messageFlash) || $isAdmin) {
                                        $showModal = false;
                                    }
                                    foreach($locationUserLogins as $locationUserLogin) {
                                        if($locationUserLogin['ip'] == $userIP){
                                            $loginCount++;
                                            if ($loginCount >= 2) {
                                                $showModal = false;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <h1>Welcome to your <?= Configure::read('siteName') ?> profile!</h1>
                                    <h2><strong><?= $location->title ?></strong></h2>
                                    <?= $this->Form->create($location, ['class' => 'form-horizontal', 'id' => 'LocationClinicEditForm']); ?>
                                    <?php if ($isAdmin && !isset($locationId)): ?>
                                        <div class="row">
                                            <div class="col col-lg-6 noprint">
                                                <?= $this->Form->control('LocationUser.username', [
                                                    'label' => 'Username',
                                                    'type' => 'text',
                                                    'required' => true,
                                                    'div' => 'form-group required',
                                                ])
                                                ?>
                                                <div class="form-actions mt10">
                                                    <input type="submit" value="Find Profile" class="btn btn-primary btn-lg">
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <h2>Basic information</h2>
                                        <div>
                                            <table class="table table-bordered mb0 basic-info">
                                                <tr>
                                                    <th><?= $siteName ?> ID</th>
                                                    <td><?= $location->id ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Oticon ID</th>
                                                    <td><?= $location->id_oticon ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Clinic email</th>
                                                    <td><?= $location->email ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>
                                                        <?= $location->address.' '.$location->address_2.'<br>'.$location->city.', '.$location->state.' '.$location->zip
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Clinic phone number</th>
                                                    <td><?= formatPhoneNumber($location->phone) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tracking phone number on profile</th>
                                                    <td>
                                                        <?php
                                                        foreach ($location->call_sources as $cs) {
                                                            if ($cs->is_active) {
                                                                echo formatPhoneNumber($cs->phone_number).' ';
                                                                echo $this->Html->link('Why is this different?', ['clinic' => true, 'controller' => 'pages', 'action' => 'faq', '#' => 'phone'], ['target' => '_blank']);
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Profile URL</th>
                                                    <td><?= $this->Html->link(router::url($location->hh_url, true), $location->hh_url, ['target' => '_blank']) ?></td>
                                                </tr>
                                                <?php if(Configure::read('country') == 'US') : ?>
                                                    <tr>
                                                        <th>Membership level</th>
                                                        <td><?php echo $location->listing_type; 
                                                            if($location->listing_type === 'Basic') { echo '&nbsp;&nbsp;&nbsp;<a href="/clinic/pages/faq#upgrades" target="_blank" class="btn btn-light is-basic">Learn how to upgrade</a>'; } ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th>Purchase Healthy Hearing TV for my waiting room</th>
                                                    <td><?php
                                                        if($location->listing_type == 'Basic' || Configure::read('country') == 'CA') {
                                                            $btnClass = '';
                                                            if(Configure::read('country') == 'US') {
                                                                $btnClass = ' class="btn btn-light"';
                                                            }
                                                            echo '<a href="https://cleardigitalmedia.net/healthyhearing/" target="_blank"' . $btnClass . '>Learn more</a>';
                                                        } else {
                                                            echo '<button id="hhtvButton" class="btn btn-light" type="button">Learn more</button>';
                                                        }
                                                    ?></td>
                                                </tr>
                                            </table>
                                            <div id="quickButtons">
                                                <a href="#providers" class="btn btn-light">Edit staff</a>
                                                <a href="#hoursOfOperation" class="btn btn-light">Edit hours</a>
                                                <?php
                                                    echo $this->Html->link(
                                                        'Reviews',
                                                        [
                                                            'prefix' => 'Clinic',
                                                            'controller' => 'Reviews',
                                                            'action' => 'index',
                                                            $location['id']
                                                        ],
                                                        ['class' => 'btn btn-light']
                                                    );
                                                ?>

                                                <a href="/clinic/ca_call_groups/report" class="btn btn-light">Call reports</a>
                                                <a href="/clinic/pages/faq" class="btn btn-light">FAQ</a>
                                                <?= $this->Html->link('View my profile', $location->hh_url, ['target' => '_blank', 'class' => 'btn btn-light']) ?>
                                                <?php if (($location->listing_type == Location::LISTING_TYPE_PREMIER && $location->is_cq_premier == true) || $location->feature_content_library): ?>
                                                    <a href="/clinic/library" class="btn btn-light">Social Media Sharing Library</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <p class="clear block">The basic information above cannot be changed here. For any questions you may have about your profile, please refer to our <a href="/clinic/pages/faq">FAQ section</a>. To edit your clinic's basic information, contact <?= $siteName ?> via email: <?= $this->Html->link(Configure::read('customer-support-email'), 'mailto:' . Configure::read('customer-support-email')) ?>.</p>
                                        <a class="btn btn-print btn-secondary" onclick="window.print()">Download review cards</a><span> Download and print customized review encouragement cards to hand out to your patients.</span>
                                        <hr>
                                        
                                        <h2 class="mt20">Profile information</h2>
                                        <?php
                                        echo $this->Form->control('title', ['class' => 'col-sm-9 mb10', 'label' => ['class' => 'col-sm-3 control-label']]);
                                        echo $this->Form->control('slogan', ['class' => 'col-sm-9 mb10', 'type' => 'text', 'label' => ['class' => 'col-sm-3 control-label']]);
                                        ?>
                                        <div class="form-group">
                                            <label class="col col-sm-3 control-label"> Mobile-only clinic?</label>
                                            <div class="col-sm-9" style="margin-left: -24px;">
                                                <?= $this->Form->control('is_mobile', [
                                                    'label' => ['text' => '<span class="ml5 mt0 help-block">Check this to hide your street address from your profile</span>', 'class' => 'mt5', 'escape' => false],
                                                    'class' => 'ml0 mt10'
                                                ]) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <?= $this->Form->control('radius', [
                                                'label' => Configure::read('isMetric') ? 'Radius (km)' : 'Radius (miles)',
                                                'min' => 0,
                                                'templates' => [
                                                    'inputContainer' => '<div class="form-group input {{type}}{{required}}" style="display:none">{{content}}</div>'
                                                ]
                                            ]) ?>
                                            <span id="radiusHelp" class="help-block col-md-offset-3 mt0 hidden">How far are you willing to travel from <?= $location->city ?>?</span>
                                            <?= $this->Form->control('mobile_text', [
                                                'label' => 'Mobile clinic description',
                                                'placeholder' => Location::$mobileTextDefault,
                                                'required' => false,
                                                'templates' => [
                                                    'inputContainer' => '<div class="form-group input {{type}}{{required}}" style="display:none">{{content}}</div>'
                                                ]
                                            ]) ?>
                                            <span id="addressHelp" class="help-block col-md-offset-3 mt0 mb10 hidden">This will be displayed instead of street address</span>
                                        </div>
                                        <?php
                                        echo $this->Form->control('landmarks', [
                                            'label' => ['text' => 'Landmarks <a data-toggle="popover" data-bs-trigger="hover" data-container="body" data-bs-placement="right" data-bs-content="Use this field for landmarks, cross streets, neighborhood or other information that helps patients find your clinic."><span class="bi bi-question-circle-fill"></span></a>',
                                                'escape' => false, 'class' => 'col-sm-3 control-label'
                                            ],
                                            'rows' => 2,
                                            'class' => 'col-sm-9 mb10'
                                            ]);
                                        echo '<span id="urlAnchor" class="clinic-anchor"></span>';
                                        echo $this->Form->control('url', [
                                            'label' => ['text' => 'Website URL', 'class' => 'col-sm-3 control-label'],
                                            'help_block' => 'Must start with http:// or https://',
                                            'div' => 'form-group mb5',
                                            'class' => 'col-sm-9 mb10'
                                        ]);
                                        echo $this->Form->control('facebook', [
                                            'label' => ['text' => 'Facebook', 'class' => 'col-sm-3 control-label'],
                                            'placeholder' => 'Copy and paste the entire URL into this field',
                                            'beforeInput' => '<div class="input-group col-12">',
                                            'afterInput' => '</div>',
                                            'class' => 'col-sm-9 mb10'
                                            ]);
                                        echo $this->Form->control('youtube', [
                                            'label' => ['text' => 'YouTube', 'class' => 'col-sm-3 control-label'],
                                            'placeholder' => 'Copy and paste the entire URL into this field',
                                            'beforeInput' => '<div class="input-group col-12">',
                                            'afterInput' => '</div>',
                                            'class' => 'col-sm-9 mb10'
                                            ]);
                                        ?>
                                        <hr>
                                        <span id="providers" class="clinic-anchor"></span>
                                        <h2>Clinic staff</h2>
                                        <?php $count = count($location->providers); ?>
                                        <?php foreach ($location->providers as $key => $provider): ?>
                                            <?= $this->element('locations/provider', ['key' => $key, 'provider' => $provider, 'clinic' => true, 'isBasicClinic' => $isBasicClinic]) ?>
                                        <?php endforeach; ?>
                                        <?= $this->element('locations/provider', ['new' => true, 'key' => $count, 'provider' => [], 'clinic' => true, 'isBasicClinic' => $isBasicClinic]) ?>
                                        <hr>
                                        <span id="aboutUs" class="clinic-anchor"></span>
                                        <h2 class="mt20 mb0" id="aboutLabel">About us</h2>
                                        <small>Please limit your description to an <a data-toggle="popover" data-bs-trigger="hover" data-container="body" data-bs-placement="right" title="Original content" data-bs-content="Please do not paste copied text from your clinic website into this form. Having the exact same text in two different places has the potential to reduce your search engine rankings.">original</a>, concise paragraph.</small>
                                        <?php echo $this->Form->control('about_us', ['label' => false, 'class' => 'editor']); 
                                        echo '<span id="upsellMessageAbout" class="text-danger pb20 col-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';?>
                                        <span id="services" class="clinic-anchor"></span>
                                        <h2 class="mt20 mb0" id="servicesLabel">Services</h2>
                                        <small>This should be an <a data-toggle="popover" data-bs-trigger="hover" data-container="body" data-bs-placement="right" title="Original content" data-bs-content="Please do not paste copied text from your clinic website into this form. Having the exact same text in two different places has the potential to reduce your search engine rankings.">original</a> list of services your clinic provides.</small>
                                        <?php
                                        echo $this->Form->control('services', [
                                            'label' => false,
                                            'class' => 'editor'
                                        ]); 
                                        echo '<span id="upsellMessageServices" class="text-danger pb20 col-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';
                                        ?>

                                        <span id="hoursOfOperation" class="clinic-anchor"></span>   
                                        <h2 class="mt20 mb10" id="hoursLabel">Hours of operation</h2>
                                        <table class="table table-bordered table-striped white-background">
                                            <tr>
                                                <th>Day of week</th>
                                                <th>Open hours</th>
                                                <th>Close hours</th>
                                                <th>Closed</th>
                                                <th>By appointment</th>
                                            </tr>
                                            <?= $this->Form->hidden("LocationHour.id") ?>
                                            <?php foreach ($days as $day): ?>
                                                <tr>
                                                    <td><?= date("l", strtotime($day)) ?></td>
                                                    <td>
                                                        <?= $this->Form->control("LocationHour.".$day."_open", [
                                                            'label' => false,
                                                            'type' => 'time',
                                                            'empty' => true,
                                                            'value' => $this->Clinic->convert24hours($location->location_hour->{$day.'_open'})
                                                        ]) ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->control("LocationHour.".$day."_close", [
                                                            'label' => false,
                                                            'type' => 'time',
                                                            'empty' => true,
                                                            'value' => $this->Clinic->convert24hours($location->location_hour->{$day.'_close'})
                                                        ]) ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->control("LocationHour.".$day."_is_closed", [
                                                            'label' => false,
                                                            'type' => 'checkbox',
                                                            'class' => 'is-closed-checkbox',
                                                            'data-day' => $day,
                                                            'checked' => $location->location_hour->{$day.'_is_closed'}
                                                        ]) ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->control("LocationHour.".$day."_is_byappt", [
                                                            'label' => false,
                                                            'type' => 'checkbox',
                                                            'checked' => $location->location_hour->{$day.'_is_byappt'}
                                                        ]) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="5">
                                                    <?= $this->Form->control('LocationHour.is_evening_weekend_hours', [
                                                        'type' => 'checkbox',
                                                        'label' => [
                                                            'text' => '<strong class="ml5">Evening and/or weekend hours available by appointment. Please call to schedule.</strong>',
                                                            'escape' => false,
                                                            'class' => 'col col-md-12 control-label tal',
                                                        ],
                                                        'checked' => $location->location_hour->is_evening_weekend_hours
                                                    ]) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <?= $this->Form->control('LocationHour.is_closed_lunch', [
                                                        'type' => 'checkbox',
                                                        'label' => [
                                                            'text' => '<strong class="ml5">Closed for lunch</strong>',
                                                            'escape' => false,
                                                            'class' => 'col col-md-12 control-label tal',
                                                        ],
                                                        'checked' => $location->location_hour->is_closed_lunch
                                                    ]) ?>
                                                    <!--*** TODO: add lunch break logic: -->
                                                    <div id="closedLunch" class="col col-md-12 hidden">
                                                        <div class="form-group required">
                                                            <label class="col col-md-2 tal">Lunch break</label>
                                                            <div class="col col-md-10">
                                                                <?= $this->Form->control('LocationHour.lunch_start', [
                                                                    'type' => 'time',
                                                                    'label' => false,
                                                                    'empty' => true,
                                                                    'autocomplete' => 'off',
                                                                    'interval' => 15,
                                                                    'value' => $this->Clinic->convert24hours($location->location_hour->lunch_start),
                                                                ]) ?>
                                                                <span class="mr5 ml5">-</span>
                                                                <?= $this->Form->control('LocationHour.lunch_end', [
                                                                    'type' => 'time',
                                                                    'label' => false,
                                                                    'empty' => true,
                                                                    'autocomplete' => 'off',
                                                                    'interval' => 15,
                                                                    'value' => $this->Clinic->convert24hours($location->location_hour->lunch_end),
                                                                ]) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <span id="payment" class="clinic-anchor"></span>
                                        <h2 class="mt20 mb20" id="paymentLabel">Accepted methods of payment</h2>
                                        <div class="ml20 row">
                                            <?= $this->Clinic->paymentForm($location->payment) ?>
                                        </div>
                                        
                                        <?php if($location->listing_type != Location::LISTING_TYPE_BASIC): ?>
                                            <div class="row">
                                                <h2 class="mt20 mb20 ml10">Optional message</h2>
                                                <div class="col-md-12">
                                                    <?= $this->Form->control('optional_message', [
                                                        'label' => false,
                                                        'rows' => 3,
                                                        'maxlength' => 400,
                                                        'required' => false,
                                                        'class' => 'col-sm-9',
                                                    ]) ?>
                                                    <span class="help-block col-sm-9">Use this field to highlight a temporary announcement for patients, such as a note about any precautions your clinic is implementing regarding public health concerns. This is also a good place to highlight time-sensitive information such as closures due to illness, power outage, or renovation. The optional message field will only display on your profile if there is text in it.</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Linked Locations -->
                                        <!--- *** TODO: add and delete location functionality needed: ***-->
                                        <div class="clearfix"></div>
                                        <?php if(Configure::read('isTieringEnabled')): ?>
                                            <div class="panel panel-default mt20">
                                                <div class="panel-heading">
                                                    <div class="panel-title">Enhanced membership features</div>
                                                </div>
                                        <?php endif; ?>
                                            <?php if (!in_array($location->listing_type, Location::$preferredListingTypes)): ?>
                                                <p class="m10">Would you like to learn more about Healthy Hearing's <strong><em>Enhanced</em></strong> profile features? <a href="/clinic">Check them out here</a> or <a href="mailto:<?= Configure::read('customer-support-email') ?>">contact us</a> for more details today!</p>
                                            <?php endif; ?>
                                            <div class="panel-body<?= Configure::read('isTieringEnabled') ? ' m10' : '' ?><?= !in_array($location->listing_type, Location::$preferredListingTypes) ? " panel-disabled" : '' ?>">
                                                <h2 class="mt20 mb20">Linked locations</h2>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><?= Configure::read('isTieringEnabled') ? "For enhanced or premier members only, " : '' ?><?= $siteName ?> will display up to five clinic locations associated with this one. In the case of larger chains, we suggest linking the five closest locations.</p>
                                                        <table class="table-striped table-bordered col-sm-offset-3 col-sm-9 mb40 p0">
                                                            <tbody class="col-12 p0">
                                                                <?php foreach ($uniqueLocationLinks as $key => $linkedLocationId): ?>
                                                                    <tr id="tr-link-<?= $key ?>" class="col-12 p0 flex">
                                                                        <td class="col-8">
                                                                            <div id="div-link-<?= $key ?>">
                                                                                <?= $this->Clinic->linkedLocationInfo($linkedLocationId) ?>
                                                                                <span class="help-block text-danger hidden" id="link-error-<?= $key ?>"></span>
                                                                            </div>
                                                                        </td>
                                                                        <td class="col-4 mt5 center-both" align="center">
                                                                            <button type="button" class="btn btn-md btn-danger js-link-delete alignment-content-stretch" data-key="<?= $key ?>" data-id="<?= $locationId ?>" data-link="<?= $linkedLocationId ?>">Delete</button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                <?php $key = count($uniqueLocationLinks); ?>
                                                                <tr id="tr-link-<?= $key ?>" class="col-12 p0">
                                                                    <td class="col-sm-8 p0">
                                                                        <div id="div-link-<?= $key ?>">
                                                                            <?= $this->Form->hidden('id_linked_location') ?>
                                                                            <input class="form-control linked-location" data-key="<?= $key ?>" data-id="<?= $locationId ?>" />
                                                                            <span class="help-block text-danger hidden" id="link-error-<?= $key ?>"></span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="col-sm-4" align="center">
                                                                        <div id="div-add-delete-<?= $key ?>">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="help-block col-md-offset-2 col-md-10">
                                                            Search by typing in clinic name, <?= $zipShort ?>, or <?= $siteName ?> ID. Select the correct clinic from the drop-down list.
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Badges -->
                                                <h2 class="mt20 mb20">Badges</h2>
                                                <div class="row clinic-badges">
                                                    <div class="col col-md-4 col-md-offset-2">
                                                        <?= $this->element('locations/badges') ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php if(Configure::read('isTieringEnabled')): ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="clearfix"></div>

                                        <?php if (Configure::read('isTieringEnabled')): ?>
                                            <div class="panel panel-default mt10">
                                                <div class="panel-heading">
                                                    <div class="panel-title">Premier membership features</div>
                                                </div>
                                                <?php if ($showSpecialAnnouncement && ($location->listing_type !== Location::LISTING_TYPE_PREMIER)): ?>
                                                    <p class="m10">Would you like to learn more about all of Healthy Hearing's <strong><em>Premier</em></strong> profile features? <a href="/clinic">Check them out here</a> or <a href="mailto:<?= Configure::read('customer-support-email') ?>">contact us</a> for more details today!</p>
                                                <?php elseif ($location->listing_type !== Location::LISTING_TYPE_PREMIER):  ?>
                                                    <p class="m10"><a href="/clinic">Click here</a> to learn more about Healthy Hearing's <strong><em>Premier</em></strong> profile features or <a href="mailto:<?= Configure::read('customer-support-email') ?>">Contact us</a> for more details today!</p>
                                                <?php endif; ?>
                                                <div class="panel-body m10<?= ($location->listing_type !== Location::LISTING_TYPE_PREMIER) ? " panel-disabled" : ''  ?>">
                                                    <?= $this->element('locations/profile/special_announcements') ?>
                                                        <?php if ($isCqPremier): ?>
                                                            <!-- Vidscrips -->
                                                            <div>
                                                                <h2 class="mt20 mb20">Vidscrips</h2>
                                                                <?= $this->Form->control('LocationVidscrips.id',
                                                                    [
                                                                        'type' => 'hidden',
                                                                        'value' => $location->location_vidscrip->id ?? null
                                                                    ])
                                                                ?>
                                                                <div class="clearfix"></div>
                                                                <?= $this->Form->control("LocationVidscrips.vidscrip", [
                                                                        'label' => ['text' => 'Vidscrip ID', 'class' => 'col-sm-3 control-label'],
                                                                        'maxlength' => 30,
                                                                        'required' => false,
                                                                        'class' => 'col-sm-9 mb10',
                                                                        'value' => $location->location_vidscrip->vidscrip ?? null
                                                                    ])
                                                                ?>
                                                                <?= $this->Form->control("LocationVidscrips.email", [
                                                                        'label' => ['text' => 'Vidscrip related email', 'class' => 'col-sm-3 control-label'],
                                                                        'required' => false,
                                                                        'class' => 'col-sm-9',
                                                                        'value' => $location->location_vidscrip->email ?? null
                                                                    ])
                                                                ?>
                                                                <span class="help-block col-md-9 col-md-offset-3">Add Vidscrip ID number and email to access embedded Vidscrip videos.</span>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        <?php endif; ?>
                                                        <hr>
                                                        <!-- Clinic logo -->
                                                        <div>
                                                            <h2 class="mt20 mb20">Clinic logo</h2>
                                                            <table class="table-striped table-bordered col-md-offset-3 col-md-9 p0">
                                                                <tbody class="col-12 p0">
                                                                    <tr class="col-12 p0">
                                                                        <td class="col-12 p20">
                                                                            <img id="logo-imagePreview0" src="<?= $location->logo_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3" alt="Logo Preview" style="<?= $location->logo_url ? '' : "display:none; " ?>max-width: 100px; max-height: 100px;" />
                                                                            <?=
                                                                                $this->Form->control('logo_name', [
                                                                                    'id' => 'logo-imageUpload0',
                                                                                    'class' => 'mt-3',
                                                                                    'type' => 'file',
                                                                                    'required' => false,
                                                                                    'label' => ['text' => 'Update logo']
                                                                                ]);
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <span class="help-block col-md-9 col-md-offset-3">Logos must be JPG format and less than 500KB. To add a logo, click on "Choose File" then select the logo from your computer. For best results, please use logo images that are a minimum of 250 x 250 pixels and a maximum of 800 x 800 pixels. Logos with icons or images are highly recommended over text based logos.</span>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <hr>

                                                        <!-- Photo Album -->
                                                        <div>
                                                            <h2 class="mt20 mb20">Photos</h2>
                                                            <table class="table-striped table-bordered col-md-11 ml20 p0">
                                                                <tbody class="col-12 p0">
                                                                    <?php foreach ($location->location_photos as $key => $photo): ?>
                                                                        <?php if (!empty($photo->photo_url)): ?>
                                                                            <tr>
                                                                                <td class="w-100">
                                                                                    <div class='row mt5 mb10'>
                                                                                        <div class='col-md-9 offset-md-3'>
                                                                                            <img id="photo-thumb-<?= $key ?>" src="<?= $photo->photo_url ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                    echo $this->Form->hidden("location_photos.$key.id");
                                                                                    echo $this->Form->control("location_photos.$key.photo_name", [
                                                                                        'label' => 'File name',
                                                                                        'readonly' => 'readonly',
                                                                                    ]);
                                                                                    echo $this->Form->control("location_photos.$key.alt", [
                                                                                        'label' => 'Description',
                                                                                        'required' => true
                                                                                    ]);
                                                                                    ?>
                                                                                    <span class="help-block col-md-9 col-md-offset-3">Describe your photo in detail. This will be read aloud for the visually impaired. Example: "Inside of [clinic name]", "Outside of [clinic name]", "[clinic name] staff", etc. This is NOT a caption.</span>
                                                                                    <span class="help-block text-danger" style="display:none;" id="photo-add-error-<?= $key ?>">Photo is invalid. Must be a .jpg or .jpeg</span>
                                                                                </td>
                                                                                <td style="width:100px;" class="tac">
                                                                                    <button type="button" id="btn-photo-delete-<?= $key ?>" class="btn btn-md btn-danger ck-location-photo-delete" data-key="<?= $key ?>" data-location-photo-id="<?= $photo->id ?>">Delete</button>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php $key = count($location->location_photos); ?>
                                                                            <div class='row mt5 mb10'>
                                                                                <div class='col-md-9 offset-md-3'>
                                                                                    <img id="photo-thumb-<?= $key ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?=
                                                                                $this->Form->control('location_photos.'.$key.'.photo_name', [
                                                                                    'id' => 'location-photo-imageUpload-' . $key,
                                                                                    'type' => 'file',
                                                                                    'required' => false,
                                                                                    'label' => ['text' => 'Add a photo']
                                                                                ]);
                                                                            ?>
                                                                            <div id="photo-description-<?= $key ?>" style="display:none;">
                                                                                <?php
                                                                                echo $this->Form->control("location_photos.$key.alt", [
                                                                                    'label' => 'Description',
                                                                                    'disabled' => true,
                                                                                    'required' =>true,
                                                                                ]);
                                                                                ?>
                                                                            </div>
                                                                            <span class="help-block col-md-9 col-md-offset-3 hidden">Describe your photo in detail. This will be read aloud for the visually impaired. Example: "Inside of [clinic name]", "Outside of [clinic name]", "[clinic name] staff", etc. This is NOT a caption.</span>
                                                                            <span class="help-block text-danger" style="display:none;" id="photo-add-error-<?= $key ?>">Photo is invalid. Must be a .jpg or .jpeg and less than 2MB.</span>
                                                                        </td>
                                                                        <td style="width:100px;" align="center">
                                                                            <button type="button" class="btn btn-md btn-danger ck-location-photo-delete" data-key="<?= $key ?>" id="btn-photo-delete-<?= $key ?>" style="display:none;">Delete</button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="clearfix"></div>
                                                            <span class="help-block col-md-11 ml20">Photos must be JPG format and less than 2MB. To add a photo, click on "Add a new photo." To remove a photo, click on "Delete."</span>
                                                            <span class="help-block col-md-11 ml20">Need help with photo sizes or formats? Please email them to <a href="mailto:<?= Configure::read('customer-support-email') ?>"><?= Configure::read('customer-support-email') ?></a> and we'll be happy to assist you.</span>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    <?php if (($location->listing_type == Location::LISTING_TYPE_PREMIER && $location->is_cq_premier == true) || $location->feature_content_library): ?>
                                                        <hr>
                                                        <div>
                                                            <h2 class="mt20 mb20">Social Media Sharing Library</h2>
                                                            <div class="col-sm-8">
                                                                <p>Need content for your social media channels? Browse our curated content library to find easy-to-share articles. We've hand-picked a selection of our most recent, relevant and popular articles that may be of interest to your followers.</p>
                                                                <a href="/clinic/library" target="_blank" class="btn btn-print btn-light">Go to Social Media Library</a>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <img style="width:200px;height:210px;margin:0 auto;display:block" src="/img/library-facebook-example.png" class="mb20" alt="Library item example usage">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(Configure::read('country') != 'CA') : ?>
                                            <div class="panel panel-default mt10">
                                                <div class="panel-body m10">
                                                    <div id="hhTv" style="position: absolute; margin-top:-70px"></div>
                                                    <h2 class="mt20 mb20">Prime your patients for hearing care with Healthy Hearing TV</h2>
                                                    <?php if($location->listing_type != 'Basic') : ?>
                                                        <p>We’ve transformed some of Healthy Hearing’s most popular content into a custom video playlist perfect for patients waiting to be seen. Our partner Clear Digital Media (CDM) offers Healthy Hearing TV streamed directly into your waiting room in real-time via high-speed internet on any screen or television.</p>
                                                        <p><strong>Reduced rate just for you!</strong> As a Healthy Hearing customer with an upgraded profile, you can purchase a Healthy Hearing video library at a 33% discount. Use coupon code "HH upgrade" to purchase access for only $59.95 per month for each location. This subscription has no upfront fees, no long-term contracts and includes the media player. <a href="https://cleardigitalmedia.net/healthyhearing/" target="_blank" style="text-decoration: underline"><strong>Subscribe today</strong></a>!</p>
                                                    <?php else: ?>
                                                        <p>Get Healthy Hearing in your waiting room! Clear Digital Media (CDM) has teamed up with Healthy Hearing to launch HHTV, a closed-captioned video streaming channel that can be displayed on any screen via high-speed internet. For only $89.95 per month for each location, you can show HHTV in your waiting room to prime your patients for hearing health as soon as they walk in the door. Learn more here: <a href="https://cleardigitalmedia.net/healthyhearing/" target="_blank">https://cleardigitalmedia.net/healthyhearing/</a>. Upgrade your membership for exclusive discounted pricing.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <?= $this->Form->submit('Save and Publish Profile', ['class' => 'btn btn-lg btn-primary mb10']) ?>
                                        <?= $this->Form->submit('Save Profile', ['id' => 'floatingSave', 'class' => 'btn btn-lg btn-primary']) ?>
                                        <?= $this->Html->link('View Your Public Profile', $location->hh_url, ['target' => '_blank', 'class' => 'btn btn-default mb10']) ?>
                                        <?php if(!$isAdmin && $isClinic) : ?>
                                            <div id="incompleteModal" class="modal-dialog modal-lg modal fade" style="position:fixed; max-height:100vh">
                                                <div class="modal-content">
                                                    <div class="modal-body tac" style="width: 100%">
                                                        <h4>Your profile is <span id="completionPercentage"></span>% complete. Please fill out the following sections:</h4>
                                                        <ul id="completionList" class="p0" style="list-style-type:none;">
                                                        </ul>
                                                        <button type="button" class="close-modal btn btn-lg btn-light" data-bs-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="completeModal" class="modal-dialog modal-lg modal fade" style="position:fixed; max-height:100vh">
                                                <div class="modal-content">
                                                    <div class="modal-body tac" style="width: 100%">
                                                        <h4>Congratulations, this profile is complete.</h4>
                                                        <p>
                                                            You should verify that all information is correct.<br>
                                                            Please bookmark the clinic login page and save your login credentials so you can<br>
                                                            log back in and edit this profile as needed to keep it up to date.
                                                        </p>
                                                        <button type="button" class="close-modal btn btn-lg btn-light" data-bs-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?= $this->Form->end() ?>
                                    <div id="newUserModal" class="modal-dialog modal-lg modal fade <?= ($showModal) ? 'show in' : '' ?>">
                                        <div class="modal-content">
                                            <div class="modal-body tac">
                                                <button type="button" class="close-modal" data-bs-dismiss="modal">X</button>
                                                <h4>Looks like it's your first time here. Please read our clinic FAQ page to understand how to make the most of this <?= $siteName ?> profile:</h4>
                                                <a id="completionList" href="/clinic/pages/faq" target="_blank">FAQ page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="faqTab">
                                        <small><i>Questions about your profile?</i></small><br>
                                        <small>Visit the <a href="/clinic/pages/faq" target="_blank">FAQ page</a>.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
