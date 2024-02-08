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
                                <div class="row card-row hidden">
                                    <div class="review-card">
                                        <div class="review-border">
                                            <h2 class="text-center">THANK YOU</h2>
                                            <h3 class="text-center">FOR CHOOSING</h3>
                                            <h4 class="text-center clinic-name"><?= $location->title ?></h4>
                                            <p class="mb5">Please share your feedback about your experience here and help others to choose us, too. To write a review, type this into your internet browser:</p>
                                            <p class="text-center clinic-url mb10"><?=$shortReviewUrl ?></p>
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
                                                    <td><?= $location->oticon_id ?></td>
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
                                        echo $this->Form->hidden('Location.id');
                                        echo $this->Form->hidden('Location.oticon_id');
                                        echo $this->Form->control('Location.title', ['value' => $location->title, 'class' => 'col-sm-9 mb10', 'label' => ['class' => 'col-sm-3 control-label']]);
                                        echo $this->Form->control('Location.slogan', ['value' => $location->slogan, 'class' => 'col-sm-9 mb10', 'type' => 'text', 'label' => ['class' => 'col-sm-3 control-label']]);
                                        ?>
                                        <div class="form-group">
                                            <label class="col col-sm-3 p0 control-label">Mobile-only clinic?</label>
                                            <div class="col-sm-9" style="margin-left: -24px;">
                                                <?= $this->Form->control('is_mobile', ['label' => ['text' => '<span class="ml5 mt0 help-block">Check this to hide your street address from your profile</span>', 'class' => 'mt5', 'escape' => false], 'value' => $location->is_mobile, 'class' => 'ml0 mt10'])?>
                                            </div>
                                        </div>
                                        <div id="radius" class="hidden">
                                            <?= $this->Form->control('radius', [
                                                'label' => Configure::read('isMetric') ? 'Radius (km)' : 'Radius (miles)',
                                                'div' => 'form-group required',
                                                'min' => 0,
                                                'help_block' => 'How far are you willing to travel from '.$location->city.'?',
                                                'value' => $location->radius
                                            ]) ?>
                                            <?= $this->Form->control('mobile_text', [
                                                'label' => 'Mobile clinic description',
                                                'placeholder' => Location::$mobileTextDefault,
                                                'help_block' => 'This will be displayed instead of street address',
                                                'required' => false,
                                                'value' => $location->mobile_text
                                            ]) ?>
                                        </div>
                                        <?php
                                        echo $this->Form->control('Location.landmarks', [
                                            'label' => ['text' => 'Landmarks <a data-toggle="popover" data-bs-trigger="hover" data-container="body" data-bs-placement="right" data-bs-content="Use this field for landmarks, cross streets, neighborhood or other information that helps patients find your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>',
                                                'escape' => false, 'class' => 'col-sm-3 control-label'
                                            ],
                                            'rows' => 2,
                                            'value' => $location->landmarks,
                                            'class' => 'col-sm-9 mb10'
                                            ]);
                                        echo '<span id="urlAnchor" class="clinic-anchor"></span>';
                                        echo $this->Form->control('Location.url', [
                                            'label' => ['text' => 'Website URL', 'class' => 'col-sm-3 control-label'],
                                            'help_block' => 'Must start with http:// or https://',
                                            'div' => 'form-group mb5',
                                            'value' => $location->url,
                                            'class' => 'col-sm-9 mb10'
                                        ]);
                                        echo $this->Form->control('Location.facebook', [
                                            'label' => ['text' => 'Facebook', 'class' => 'col-sm-3 control-label'],
                                            'placeholder' => 'Copy and paste the entire URL into this field',
                                            'beforeInput' => '<div class="input-group col-xs-12">',
                                            'afterInput' => '</div>',
                                            'value' => $location->facebook,
                                            'class' => 'col-sm-9 mb10'
                                            ]);
                                        echo $this->Form->control('Location.twitter', [
                                            'label' => ['text' => 'Twitter', 'class' => 'col-sm-3 control-label'],
                                            'placeholder' => 'Copy and paste the entire URL into this field',
                                            'beforeInput' => '<div class="input-group col-xs-12">',
                                            'afterInput' => '</div>',
                                            'value' => $location->twitter,
                                            'class' => 'col-sm-9 mb10'
                                            ]);
                                        echo $this->Form->control('Location.youtube', [
                                            'label' => ['text' => 'YouTube', 'class' => 'col-sm-3 control-label'],
                                            'placeholder' => 'Copy and paste the entire URL into this field',
                                            'beforeInput' => '<div class="input-group col-xs-12">',
                                            'afterInput' => '</div>',
                                            'value' => $location->youtube,
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
                                        <?php echo $this->Form->control('Location.about_us', ['value' => $location->about_us, 'label' => false, 'class' => 'editor']); 
                                        echo '<span id="upsellMessageAbout" class="text-danger pb20 col-xs-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';?>
                                        <span id="services" class="clinic-anchor"></span>
                                        <h2 class="mt20 mb0" id="servicesLabel">Services</h2>
                                        <small>This should be an <a data-toggle="popover" data-bs-trigger="hover" data-container="body" data-bs-placement="right" title="Original content" data-bs-content="Please do not paste copied text from your clinic website into this form. Having the exact same text in two different places has the potential to reduce your search engine rankings.">original</a> list of services your clinic provides.</small>
                                        <?php
                                        echo $this->Form->control('Location.services', [
                                            'label' => false,
                                            'value' => $location->services,
                                            'class' => 'editor'
                                        ]); 
                                        echo '<span id="upsellMessageServices" class="text-danger pb20 col-xs-12 tar" style="display:none">Want to add more text? Upgrade your profile to remove the character limits. Click <a href="/clinic/pages/faq#upgrades" target="_blank">here</a> to learn more about upgrading.</span>';
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
                                                            'data-day' => ucfirst($day),
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
                                                            'class' => 'col col-md-12 control-label tal p0',
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
                                                            'class' => 'col col-md-12 control-label tal p0',
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
                                                        'value' => $location->optional_message
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
                                                            <tbody class="col-xs-12 p0">
                                                                <?php foreach ($uniqueLocationLinks as $key => $linkedLocationId): ?>
                                                                    <tr id="tr-link-<?= $key ?>" class="col-xs-12 p0 flex">
                                                                        <td class="col-xs-8">
                                                                            <div id="div-link-<?= $key ?>">
                                                                                <?= $this->Clinic->linkedLocationInfo($linkedLocationId) ?>
                                                                                <span class="help-block text-danger hidden" id="link-error-<?= $key ?>"></span>
                                                                            </div>
                                                                        </td>
                                                                        <td class="col-xs-4 mt5" align="center">
                                                                            <button type="button" class="btn btn-md btn-danger js-link-delete alignment-content-stretch" data-key="<?= $key ?>" data-id="<?= $locationId ?>" data-link="<?= $linkedLocationId ?>">Delete</button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                <?php $key = count($uniqueLocationLinks); ?>
                                                                <tr id="tr-link-<?= $key ?>" class="col-xs-12 p0">
                                                                    <td class="col-sm-8 p0">
                                                                        <div id="div-link-<?= $key ?>">
                                                                            <?= $this->Form->hidden('linked_location_id') ?>
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
                                                        <!-- Special announcements / Flex space / Coupons -->
                                                        <div id="specialAnnouncements" data-iscqpremier="<?= $isCqPremier ?>" data-adid="<?= $adId ?>" data-couponid="<?= $couponId ?>">
                                                            <h2 class="mt20 mb10">Special Announcement</h2>
                                                            <?php
                                                            $helpText = "This is your \"flex space\" to use to promote any aspect of your business you wish. You can use the space with or without an image.";
                                                            if ($isCqPremier) {
                                                                $helpText .= " As a courtesy, CQ Partners has provided offers you may choose to use in this space if they apply to your clinic.";
                                                            }
                                                            ?>
                                                            <span class="help-block col-md-11 ml20"><?= $helpText ?></span>
                                                            <div class="clearfix"></div>
                                                            <div id="couponLibrary" class="hidden">
                                                                <div class="row mb20 pr20 pl20">
                                                                    <div class="col-md-3">
                                                                        <div class="panel panel-light text-center mb5" style="height:373px;">
                                                                            <div class="text-center pt150">
                                                                                <button type="button" class="btn btn-large btn-primary text-center js-choose-own-coupon">Choose my own</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(1) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(2) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(3) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb20 pr20 pl20">
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(4) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(5) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(6) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(7) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row pr20 pl20">
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(8) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?= $this->Clinic->previewCoupon(9) ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="couponSelected" class="hidden">
                                                                <?= $this->Form->hidden("Location.coupon_id", ['id' => 'location-coupon-id']) ?>
                                                                <div class='col-md-offset-4 col-md-3'>
                                                                    <?= $this->Clinic->previewCoupon($couponId, false, true) ?>
                                                                </div>
                                                                <div class='col-md-5'></div>
                                                            </div>
                                                            <div id="uploadCoupon">
                                                                <?php if (!empty($adId)): ?>
                                                                    <?= $this->Form->control('LocationAd.id',
                                                                        [
                                                                            'type' => 'hidden',
                                                                            'value' => $adId
                                                                        ])
                                                                    ?>
                                                                <?php endif; ?>
                                                                <?php if ($isCqPremier): ?>
                                                                    <div class="col-md-offset-3 mb20"><button type="button" class="btn btn-md btn-primary js-show-coupon-library mt5">View Coupon Options</button></div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($locationAd->photo_url) || !empty($locationAd->title) || !empty($locationAd->description)): ?>
                                                                    <div class='row mb20' id='location-ad-preview'>
                                                                        <div class='col-md-offset-3 col-md-3'>
                                                                            <div class="panel panel-light text-center mb5">
                                                                                <?php if (!empty($locationAd->title)): ?>
                                                                                    <div class="panel-heading"><?= $locationAd->title ?></div>
                                                                                <?php endif; ?>
                                                                                <?php if (!empty($locationAd->photo_url)): ?>
                                                                                    <div class="panel-body">
                                                                                        <img class="coupon-image" src="/cloudfiles/clinics/<?= $locationAd->photo_url ?>">
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                <?php if (!empty($locationAd->description)): ?>
                                                                                    <div class="panel-footer"><?= $locationAd->description ?></div>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="text-center"><button type="button" class="btn btn-md btn-danger js-ad-delete mt5">Delete announcement /<br>Choose another</button></div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?= $this->Form->control("LocationAd.photo_url", [
                                                                        'label' => ['text' => 'File name', 'class' => 'col-sm-3 tar'],
                                                                        'readonly' => 'readonly',
                                                                        'help-block' => 'help',
                                                                        'class' => 'col-sm-7',
                                                                        'value' => ($locationAd->photo_url ?? null)
                                                                    ])
                                                                ?>
                                                                <label class="btn btn-sm btn-default ml10">
                                                                    <span>Upload image</span>
                                                                    <input type="file" name="data[LocationAd][file]" class="form-control hidden" id="LocationAdFile">
                                                                </label>
                                                                <span class="help-block col-sm-offset-3 col-sm-9 mb20">Images must be JPG format, less than 500kb, and under 700 pixels in width.<br><span class="text-danger hidden" id="location-ad-error">Image is invalid. Must be a .jpg or .jpeg and less than 500kb.</span></span>
                                                                <?= $this->Form->control("LocationAd.title", [
                                                                        'label' => ['text' => 'Title', 'class' => 'col-sm-3 tar'],
                                                                        'maxlength' => 50,
                                                                        'required' => false,
                                                                        'class' => 'col-sm-9',
                                                                        'value' => ($locationAd->title ?? null)
                                                                    ]);
                                                                ?>
                                                                <span class="help-block col-sm-offset-3 col-sm-9 mb20">This text will appear in the header of this space. 50 characters max.</span>
                                                                <?= $this->Form->control("LocationAd.description", [
                                                                        'type' => 'textarea',
                                                                        'rows' => 2,
                                                                        'label' => ['text' => 'Message', 'class' => 'col-sm-3 tar'],
                                                                        'maxlength' => 500,
                                                                        'required' => false,
                                                                        'class' => 'col-sm-9',
                                                                        'value' => ($locationAd->description ?? null)
                                                                    ]);
                                                                ?>
                                                                <span class="help-block col-sm-offset-3 col-sm-9 mb20">This text will appear below the image in this space. 500 characters max.</span>
                                                                <div class="form-group">
                                                                    <label for="LocationAdBorder" class="col col-md-3 control-label">Border</label>
                                                                    <input type="hidden" name="data[LocationAd][border]" id="LocationAdBlank_" value="">
                                                                    <div class="col col-md-9">
                                                                        <div class="col-md-3 border-radio<?= (isset($locationAd->border) && ($locationAd->border == 'blank' || $locationAd->border == '' || $locationAd->border === null)) ? ' selected-border' : '' ?>">
                                                                            <label for="LocationAdBlank" class="col control-label">
                                                                                <input type="radio" name="data[LocationAd][border]" value="blank" id="LocationAdBlank"<?php
                                                                                echo ($locationAd->border ?? '') == 'blank' ? ' checked' : '';
                                                                                ?>>
                                                                                No Border
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-md-3 border-radio<?= (isset($locationAd->border) && $locationAd->border == 'border-dashed') ? ' selected-border' : '' ?>">
                                                                            <label for="LocationAdDashed" class="col control-label border-dashed">
                                                                                <input type="radio" name="data[LocationAd][border]" value="border-dashed" id="LocationAdDashed"<?php
                                                                                echo ($locationAd->border ?? '') == 'border-dashed' ? ' checked' : '';
                                                                                ?>>
                                                                                Dashed
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-md-3 border-radio<?= (isset($locationAd->border) && $locationAd->border == 'border-dotted') ? ' selected-border' : '' ?>">
                                                                            <label for="LocationAdDotted" class="col control-label border-dotted">
                                                                                <input type="radio" name="data[LocationAd][border]" value="border-dotted" id="LocationAdDotted"<?php
                                                                                echo ($locationAd->border ?? '') == 'border-dotted' ? ' checked' : '';
                                                                                ?>>
                                                                                Dotted
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-md-3 border-radio<?= (isset($locationAd->border) && $locationAd->border == 'border-inset') ? ' selected-border' : '' ?>">
                                                                            <label for="LocationAdInset" class="col control-label border-inset">
                                                                                <input type="radio" name="data[LocationAd][border]" value="border-inset" id="LocationAdInset"<?php
                                                                                echo ($locationAd->border ?? '') == 'border-inset' ? ' checked' : '';
                                                                                ?>>
                                                                                Inset
                                                                            </label>
                                                                        </div>
                                                                        <span class="help-block">Select a border for the image.</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <hr>
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
                                                                <tbody class="col-xs-12 p0">
                                                                    <tr class="col-xs-12 p0">
                                                                        <td class="col-xs-12 p20">
                                                                            <img class="ml60 mb10" id="photo-thumb-logo" src="<?= (!empty($location->logo_url)) ? '/cloudfiles/clinics/' . $location->logo_url : '' ?>">
                                                                            <?= $this->Form->control("logo_file", [
                                                                                    'type' => 'file',
                                                                                    'label' => ['text' => 'File name', 'class' => 'col-sm-3 control-label'],
                                                                                    'class' => 'form-control photo-url col-sm-9',
                                                                                    'id' => 'LocationLogo0Url'
                                                                                ])
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
                                                                <tbody class="col-xs-12 p0">
                                                                    <?php foreach ($location->location_photos as $key => $photo): ?>
                                                                        <tr class="col-xs-12 p0 flex">
                                                                            <td class="col-sm-10 p0">
                                                                                <?= $this->Form->hidden("LocationPhoto.$key.id") ?>
                                                                                <div>
                                                                                    <?= $this->Form->control("LocationPhoto.$key.photo_url", [
                                                                                        'label' => false,
                                                                                        'div' => false,
                                                                                        'value' => $photo->photo_url
                                                                                    ]) ?>
                                                                                </div>
                                                                                <img src="/cloudfiles/clinics/<?= $photo->photo_url ?>" alt>
                                                                                <div id="photo-description-<?= $key ?>">
                                                                                    <?= $this->Form->control("LocationPhoto.$key.alt", [
                                                                                        'label' => ['text' => 'Description', 'class' => 'col-sm-3 control-label'],
                                                                                        'required' =>true,
                                                                                        'class' => 'col-sm-9',
                                                                                        'oninput' => 'validatePhotoAlt('.$key.')',
                                                                                        'value' => $photo->alt
                                                                                    ])
                                                                                    ?>
                                                                                    <span class="help-block col-sm-9 col-sm-offset-3">Describe your photo in detail. This will be read aloud for the visually impaired. Example: "Inside of [clinic name]", "Outside of [clinic name]", "[clinic name] staff", etc. This is NOT a caption.</span>
                                                                                    <span class="help-block-desc-<?= $key ?> text-danger col-md-9 col-md-offset-3 hidden"><strong>You must remove the phone number in the red field, above, before you can save the profile.</strong></span>
                                                                                </div>
                                                                            </td>
                                                                            <td align="center" class="col-sm-2 pt20 alignment-content-stretch">
                                                                                <button type="button" class="btn btn-md btn-danger js-photo-delete" data-key="<?= $key ?>">Delete</button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                    <tr class="col-xs-12 p0">
                                                                        <td class="col-sm-10 p0">
                                                                            <?php $key = count($location->location_photos); ?>
                                                                            <div class='row mt5 mb10'>
                                                                                <div class='col-sm-offset-3 col-sm-9'>
                                                                                    <img id="photo-thumb-<?= $key ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="col col-sm-3 mb20" id="file-input-<?= $key ?>">
                                                                                    <label class="btn btn-default pull-right col-xs-12 p0">
                                                                                        <span class="col-xs-12 p0 pt10 pb10" style="margin-bottom:-10px">Add a new photo</span>
                                                                                        <?= $this->Form->control("LocationPhoto." . $key . ".file", [
                                                                                            'type' => 'file',
                                                                                            'label' => false,
                                                                                            'div' => false,
                                                                                            'class' => 'form-control photo-url hidden'
                                                                                        ])
                                                                                        ?>
                                                                                    </label>
                                                                                </div>
                                                                                <label class="col col-sm-3 control-label hidden" id="filename-label-<?= $key ?>">File name</label>
                                                                                <div class="col col-md-9">
                                                                                    <span class="upload-text-<?= $key ?>"> Click the button to choose a photo from your computer.</span>
                                                                                </div>
                                                                            </div>
                                                                            <div id="photo-description-<?= $key ?>" class="hidden">
                                                                                <?= $this->Form->control("LocationPhoto.$key.alt", [
                                                                                    'label' => 'Description',
                                                                                    'help_block' => 'Describe your photo in detail. This will be read aloud for the visually impaired. Example: "Inside of [clinic name]", "Outside of [clinic name]", "[clinic name] staff", etc.',
                                                                                    'disabled' => true,
                                                                                    'required' =>true,
                                                                                    'oninput' => 'validatePhotoAlt('.$key.')'
                                                                                ])
                                                                                ?>
                                                                                <span class="help-block-desc-<?= $key ?> text-danger col-md-9 col-md-offset-3 hidden"><strong>You must remove the phone number in the red field, above, before you can save the profile.</strong></span>
                                                                            </div>
                                                                            <span class="help-block text-danger hidden" id="photo-add-error-<?= $key ?>">Photo is invalid. Must be a .jpg or .jpeg and less than 2MB.</span>
                                                                        </td>
                                                                        <td align="center" class="col-sm-2">
                                                                            <button class="btn btn-md btn-danger js-photo-delete hidden mb20" data-key="<?= $key ?>" id="btn-photo-delete-<?= $key ?>">Delete</button>
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
                                                        <button type="button" class="close-modal btn btn-lg btn-light" data-dismiss="modal" aria-hidden="true">Ok</button>
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
                                                        <button type="button" class="close-modal btn btn-lg btn-light" data-dismiss="modal" aria-hidden="true">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?= $this->Form->end() ?>
                                    <div id="newUserModal" class="modal-dialog modal-lg modal fade <?= ($showModal) ? 'show in' : '' ?>">
                                        <div class="modal-content">
                                            <div class="modal-body tac">
                                                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">X</button>
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
