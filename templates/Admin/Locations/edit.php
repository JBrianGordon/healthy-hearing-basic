<?= $this->element('ckbox_script'); ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
 
use App\Model\Entity\Location;
use App\Model\Entity\Review;
use App\Model\Entity\ImportStatus;
use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Html->script('dist/admin_edit_locations.min', ['block' => true]);
$externalIdLabel = Configure::read('isYhnImportEnabled') ? 'YHN ID' : 'External ID / Retail ID';
$id = $location->id;
$locationAd = $location->location_ad;
$adId = $locationAd->id ?? null;
$couponId = $location->id_coupon;
$showSpecialAnnouncement = (
    ($location->listing_type == Location::LISTING_TYPE_PREMIER) ||
    ($location->feature_special_announcement)
);
$isBasicClinic = $location->listing_type == Location::LISTING_TYPE_BASIC;
$loadAllReviewsAndImports = !empty($this->request->getQuery('loadall'));
?>
<meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">
<style type="text/css">
    .p10 {
        padding: 10px;
    }
    .pt20 {
        padding-top: 20px;
    }
    .clear, .clearfix {
        display: block;
        clear: both;
    }
    .hidden {
        display: none;
    }
    .panel-heading {
        padding: 13px;
        font-size: 18px;
        font-weight: bold;
    }
    .site-body label {
        width: 25%;
        float: left;
        text-align: right;
        padding: 7px 15px 0;
        font-weight: bold;
    }
    .site-body .form-control, .site-body .form-select {
        width: 75%;
        font-size: 16px;
        flex-flow: row-reverse;
    }
    .site-body .form-check.checkbox label {
        width: auto;
    }
    .form-group {
        clear: both;
        margin-bottom: 15px;
    }
    .site-body .form-group {
        display: flex;
        flex-grow: 1;
        margin-bottom: 10px;
    }
    fieldset {
        min-width: 0;
        padding: 0;
        margin: 0;
        border: 0;
    }
    [hh-search], [data-hh-search] {
        display: block;
        float: right;
        overflow: visible;
        position: relative;
        text-align: center;
        width: 46.66666px;
        z-index: 2;

        .search-link {
            color: transparent;
            display: block;
            font-size: 0;
            height: 70px;
            padding: 20px 10px;
            text-decoration: none;

            @media only screen and (max-width: $screen-sm-min) {
            display: none;
            }

            span {
            color: $brand-primary;
            font-size: 22px;
            }

            &:hover, &:active {
            background: $navbar-default-link-hover-bg;
            text-decoration: none;
            }

            &:focus {
            outline-color: transparent;
            outline-style: none;
            }
        }

        .search-wrapper {
            background: $navbar-default-bg;
            display: inline-block;
            height: $navbar-height;
            margin-right: -0.25em;
            position: fixed;
            right: 0;
            top: 0;
            transform: translate(100%, 0);
            transform: translate3d(100%, 0, 0);
            transition: all 0.2s ease-in;
            width: 100vw;

            &.show {
            transform: translate(0, 0);
            transform: translate3d(0, 0, 0);
            transition: all 0.2s ease-out;

            .close-link {
                background: $navbar-default-link-hover-bg;

                &:hover, &:active {
                background: shade($navbar-default-link-hover-bg, 3%);
                text-decoration: none;
                }
            }
            }
        }

        .close-link {
            color: transparent;
            font-size: 0;
            display: inline-block;
            left: 0;
            line-height: $navbar-height;
            position: absolute;
            text-align: center;
            width: $navbar-height;

            span {
            color: $brand-primary;
            font-size: 16px;
            }

            &:focus {
            outline-color: transparent;
            outline-style: none;
            }
        }

        .search-input {
            border: 0;
            box-shadow: inset 0px 0px 6px rgba(0, 0, 0, 0.15);
            font-size: 114%;
            height: $navbar-height;
            left: $navbar-height;
            padding: 1em 2em;
            position: absolute;
            top: 0;
            width: calc(100% - #{$navbar-height});

            &:focus {
            box-shadow: inset 0px 0px 6px rgba(0, 0, 0, 0.15);
            outline: none;
            }
        }
    }
    .pl0 {
        padding-left: 0px !important;
    }
    @media (min-width: 768px) {
        .col-md-2, .col-md-3 {
            float:left;
            position: relative;
        }
        .col-md-2 {
            flex: 0 0 auto;
            width: 16.66666667%;
        }
        .col-md-3 {
            flex: 0 0 auto;
            width: 25%;
        }
        .offset-md-3 {
            margin-left: 25%;
        }
    }
</style>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Locations Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(__(' View'), ['prefix' => false, 'controller' => 'locations', 'action' => 'view', $location->id], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
                <?= $this->Html->link(__(' Clinic Edit'), ['prefix' => 'Clinic', 'controller' => 'locations', 'action' => 'edit', $location->id], ['class' => 'btn btn-default bi bi-pencil-fill', 'target' => '_blank']) ?>
                <?= $this->Html->link(__(' Copy Location Data'), ['action' => 'copy', $location->id], ['class' => 'btn btn-default bi bi-clipboard2-check-fill']) ?>
                <?= $this->Html->link(__(' Calls'), ['prefix' => 'Admin', 'controller' => 'caCalls', 'action' => 'index', $location->id], ['class' => 'btn btn-default bi bi-telephone-fill', 'target' => '_blank']) ?>
                <?= $this->Html->link(__(' Call Call Groups'), ['prefix' => 'Admin', 'controller' => 'caCallGroups', 'action' => 'index', $location->id], ['class' => 'btn btn-default bi bi-telephone-fill', 'target' => '_blank']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="form">
                    <?= $this->Form->create($location, ['type' => 'file', 'id' => 'LocationForm']) ?>
                    <fieldset>
                        <?= $this->Form->control('title') ?>
                        <div class="col-md-2 offset-md-3 pl0">
                            <?= $this->Form->control('is_active') ?>
                         </div>
                         <div class="col-md-3">
                            <?= $this->Form->control('is_show') ?>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 offset-md-3">
                                <?php
                                echo $location->is_yhn ? '<span class="badge bg-yhn bi bi-globe-americas mr5"> YHN ' . $location->yhn_tier . '</span>' : ''; 
                                echo $location->is_cqp ? '<span class="badge bg-cqp bi bi-briefcase-fill mr5">CQP ' . $location->cqp_tier . '</span>' : ''; 
                                echo $location->is_cq_premier ? '<span class="badge bg-cqp mr5">CQ Premier</span>' : '';
                                echo $location->is_iris_plus ? '<span class="badge bg-earq mr5">Iris+</span>' : '';
                                echo $location->is_call_assist ? '<span class="badge bg-success bi bi-telephone-fill mr5"> Call Concierge</span>' : '<span class="badge bg-danger bi bi-telephone-fill"> Not Call Concierge</span>';
                                echo $location->is_retail ? '<span class="badge bg-primary mr5">Retail</span>' : '';
                                ?>
                            </div>
                        </div>
                        <?= $this->Form->control('listing_type', [
                            'type' => 'select',
                            'options' => Location::$listingTypes,
                            'required' => false
                        ]); ?>
                        <?php if (Configure::read('isTieringEnabled')): ?>
                            <div class="col-md-3 offset-md-3 pl0">
                                <?= $this->Form->control('is_listing_type_frozen', ['label' => ' Freeze Listing Type']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $this->Form->control('frozen_expiration', [
                                    'type' => 'date',
                                    'min' => date("Y-m-d", strtotime('today')),
                                    'label' => 'Expires',
                                    'default' => ''
                                ]); ?>
                            </div>
                        <?php endif; ?>
                        <table class="table table-striped table-bordered table-condensed mb5">
                            <tbody>
                                <tr>
                                    <th class="tar" width="25%">Location ID</th>
                                    <td><?= $location->id ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">SF ID</th>
                                    <td><?= $location->id_sf ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">Oticon ID</th>
                                    <td><?= $location->id_oticon ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">YHN ID</th>
                                    <td><?= $location->id_yhn_location ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">CQP Practice ID</th>
                                    <td><?= $location->id_cqp_practice ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">CQP Office ID</th>
                                    <td><?= $location->id_cqp_office ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">Parent Location ID</th>
                                    <td><?= $location->id_parent ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">Location Segment</th>
                                    <td><?= $location->location_segment ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">Profile Status</th>
                                    <td><?= $location->completeness . ' - ' . $location->review_status ?></td>
                                </tr>
                                <tr>
                                    <th class="tar">Location URL</th>
                                    <td><?= $this->Html->link(Router::url($location->hh_url, true), null, array('id' => 'LocationUrl')); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?= $this->Form->control('priority'); ?>
                        <div class="tabbable">
                            <ul class="nav nav-tabs location-tabs clearfix" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-target="#Location" data-bs-toggle="tab" aria-controls="Location" aria-expanded="true" type="button" role="tab">Location</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Details" data-bs-toggle="tab" aria-controls="Details" aria-expanded="false" type="button" role="tab">Details</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Provider" data-bs-toggle="tab" aria-controls="Provider" aria-expanded="false" type="button" role="tab">Provider</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Hours" data-bs-toggle="tab" aria-controls="Hours" aria-expanded="false" type="button" role="tab">Hours</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Payment" data-bs-toggle="tab" aria-controls="Payment" aria-expanded="false" type="button" role="tab">Payment</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Notes" data-bs-toggle="tab" aria-controls="Notes"  aria-expanded="false" type="button" role="tab">Notes</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#CallSource" data-bs-toggle="tab" aria-controls="CallSource" aria-expanded="false" type="button" role="tab">CallSource</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#User" data-bs-toggle="tab" aria-controls="User" aria-expanded="false" type="button" role="tab">User</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Reviews" data-bs-toggle="tab" aria-controls="Reviews" aria-expanded="false" type="button" role="tab">Reviews</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Imports" data-bs-toggle="tab" aria-controls="Imports" aria-expanded="false" type="button" role="tab">Imports</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Filters" data-bs-toggle="tab" aria-controls="Filters" aria-expanded="false" type="button" role="tab">Filters</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#Admin" data-bs-toggle="tab" aria-controls="Admin" aria-expanded="false" type="button" role="tab">Admin</button>
                                </li>
                            </ul>
                            <div class="tab-content mt10">
                                <!-- Location Tab -->
                                <div class="tab-pane active" id="Location">
                                    <div class="form-group">
                                        <div class="col-md-8 offset-md-2 mb10 pl0">
                                            <?= $this->Html->link(' Geocode', ['action' => 'geocode'], ['class' => 'btn btn-xs btn-primary bi bi-geo-alt-fill']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                            echo $this->Form->control('address', [
                                                'label' => ['class' => 'col-form-label col-md-4-override'],
                                                'class' => 'form-control col-md-8-override']);
                                            echo $this->Form->control('city', [
                                                'label' => ['class' => 'form-label col-md-4-override'],
                                                'class' => 'form-control col-md-8-override']);
                                            echo $this->Form->control('zip', [
                                                'label' => ['class' => 'form-label col-md-4-override', 'text' => Configure::read('zipLabel')],
                                                'class' => 'form-control col-md-8-override']);
                                            echo $this->Form->control('radius', [
                                                'label' => ['class' => 'form-label col-md-4-override', 'text' => 'Radius (miles)'],
                                                'class' => 'form-control col-md-8-override mb0',
                                                'spacing' => 'mb0'
                                            ]);
                                            echo '<span id="radiusHelp" class="help-block col-md-12 tar mt0">How far are you willing to travel?</span>';
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->Form->control('address_2') ?>
                                        <?= $this->Form->control('state', [
                                            'label' => ucfirst(Configure::read('stateLabel')),
                                            'options' => Configure::read('states')]) ?>
                                        <div class="col-md-9 offset-md-3 pl0">
                                            <?= $this->Form->control('is_mobile', [
                                                'label' => ' Mobile-only clinic?']) ?>
                                        </div>
                                        <?= $this->Form->control('mobile_text', [
                                            'label' => ['class' => 'form-label', 'text' => 'Mobile clinic description'],
                                            'placeholder' => 'Mobile clinic - we come to you!',
                                            'class' => 'form-control mt10',
                                            'spacing' => 'mb0'
                                        ]) ?>
                                        <span id="addressHelp" class="help-block col-md-12 tar mt0 mb10">This will be displayed instead of street address</span>
                                    </div>
                                </div>
                                    <div class="clearfix"></div>
                                    <div class="row pl0">
                                        <div class="col-md-12">
                                            <?php
                                                echo $this->Form->control('phone', [
                                                    'label' => ['class' => 'form-label col-md-2-override'],
                                                    'class' => 'form-control col-md-10-override']);
                                                echo $this->Form->control('email', [
                                                    'label' => ['class' => 'form-label col-md-2-override'],
                                                    'class' => 'form-control col-md-10-override']);
                                            ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <?= $this->Form->control('lat', [
                                                'label' => [
                                                    'class' => 'form-label col-md-4-override'],
                                                'class' => 'form-control col-md-8-override'
                                            ]) ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <?= $this->Form->control('lon', [
                                                'label' => [
                                                    'class' => 'form-label col-md-2-override'],
                                                'class' => 'form-control col-md-10-override']) ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?= $this->Form->control('timezone', [
                                                'label' => ['class' => 'form-label col-md-2-override'],
                                                'class' => 'form-control col-md-10-override',
                                                'required' => false]) ?>
                                            <?= $this->Form->control('landmarks', [
                                                'label' => ['class' => 'form-label col-md-2-override'],
                                                'class' => 'form-control col-md-10-override'])?>
                                            <span class="help-block col-md-10 offset-md-2">Use this field for landmarks, cross streets, neighborhood or other information that helps patients find your clinic.</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 offset-md-2">
                                            <div class="thumbnail">
                                                <?= $this->element('locations/map', ['location' => $location]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Linked Locations -->
                                    <hr class="mt25">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col col-md-2-override control-label">Linked Locations</label>
                                            <div class="clearfix"></div>
                                            <table class="table-striped table-bordered col-md-10 offset-md-2 p0">
                                                <?php foreach ($uniqueLocationLinks as $key => $linkedLocationId): ?>
                                                    <tbody class="d-table w-100">
                                                        <tr id="tr-link-<?= $key ?>">
                                                            <td>
                                                                <div id="div-link-<?= $key ?>">
                                                                    <?= $this->Clinic->linkedLocationInfo($linkedLocationId) ?>
                                                                    <span class="help-block text-danger" style="display:none;" id="link-error-<?= $key ?>"></span>
                                                                </div>
                                                            </td>
                                                            <td style="width:100px;" align="center">
                                                                <button type="button" class="btn btn-md btn-danger js-link-delete" data-key="<?= $key ?>" data-id="<?= $id ?>" data-link="<?= $linkedLocationId ?>">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                <?php endforeach; ?>
                                                <?php $key = count($uniqueLocationLinks); ?>
                                                <tbody class="d-table w-100">
                                                    <tr id="tr-link-<?= $key ?>">
                                                        <td>
                                                            <div id="div-link-<?= $key ?>">
                                                                <?= $this->Form->hidden('id_linked_location') ?>
                                                                <input class="form-control linked-location w-100" data-key="<?= $key ?>" data-id="<?= $id ?>" />
                                                                <span class="help-block text-danger" style="display:none;" id="link-error-<?= $key ?>"></span>
                                                            </div>
                                                        </td>
                                                        <td style="width:100px;" align="center">
                                                            <div id="div-add-delete-<?= $key ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <span class="help-block col-md-10 offset-md-2">
                                                <?php if (Configure::read('isTieringEnabled')): ?>These are displayed on Enhanced/Premier profiles only. <?php endif; ?>
                                                Search by typing in clinic name, <?= $zipShort ?>, or <?= Configure::read('siteNameAbbr') ?> ID. Select the correct clinic from the drop-down list.
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Details tab -->
                                <div class="tab-pane" id="Details">
                                    <?php
                                        echo $this->Form->control('slogan', ['class' => 'text', 'type' => 'text']);
                                        echo $this->Form->control('url');
                                    ?>
                                    <span class="help-block col-md-9 offset-md-3">Must start with http: or https:</span>
                                    <?php
                                        echo $this->Form->control('facebook');
                                        echo $this->Form->control('youtube');
                                        echo $this->Form->control('services', ['class' => 'editor']);
                                        echo $this->Form->control('about_us', ['class' => 'editor']);
                                    ?>
                                    <div class="panel panel-default pb20">
                                        <div class="panel-heading">Enhanced features</div>
                                        <div class="panel-body m10<?php if ($location->listing_type != 'Enhanced' && $location->listing_type != 'Premier'){echo " panel-disabled";}?>">
                                            <!-- Badges -->
                                            <div class="form-group">
                                                <label class="form-label col-md-3">Badges</label>
                                                <div class="col-md-4">
                                                    <?= $this->element('locations/badges'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (Configure::read('isTieringEnabled')): ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Premier features</div>
                                            <div class="panel-body m10<?php if ($location->listing_type != 'Premier'){echo " panel-disabled";}?>">
                                                <!-- Clinic logo -->
                                                <div>
                                                    <label class="col col-md-3 control-label">Clinic logo</label>
                                                    <table class="table-striped table-bordered col-md-offset-3 col-md-9 p0">
                                                        <tbody class="d-block">
                                                            <tr class="d-block">
                                                                <td class="d-block">
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
                                                    <span class="help-block col-md-9 offset-md-3">Logos must be JPG format and less than 500KB. To add a logo, click on "Choose File" then select the logo from your computer. For best results, please use logo images that are a minimum of 250 x 250 pixels and a maximum of 800 x 800 pixels. Logos with icons or images are highly recommended over text based logos.</span>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <!-- Photo Album -->
                                                <div>
                                                    <label class="col col-md-3 control-label">Photos</label><div class="clearfix"></div>
                                                    <table class="table-striped table-bordered col-md-offset-3 col-md-9 p0">
                                                        <tbody>
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
                                                                    <span class="help-block text-danger" style="display:none;" id="photo-add-error-<?= $key ?>">Photo is invalid. Must be a .jpg or .jpeg and less than 2MB.</span>
                                                                </td>
                                                                <td style="width:100px;" align="center">
                                                                    <button type="button" class="btn btn-md btn-danger ck-location-photo-delete" data-key="<?= $key ?>" id="btn-photo-delete-<?= $key ?>" style="display:none;">Delete</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="help-block col-md-9 offset-md-3">Photos must be JPG format and less than 2MB. To add a photo, click on "Choose File". To remove a photo, click on "Delete".</span>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <?php if ($showSpecialAnnouncement): ?>
                                                    <?= $this->element('locations/profile/special_announcements', ['adId' => $adId, 'couponId' => $couponId]) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php /*if ($isCqPremier): ?>
                                        <!-- Vidscrips -->
                                        <div id="vidscrips">
                                            <?= $this->Form->control('location_vidscrip.id',
                                                [
                                                    'type' => 'hidden',
                                                    'value' => $location->location_vidscrip->id ?? ''
                                                ])
                                            ?>
                                            <label class="form-label col-md-3 mb20">Vidscrips</label>
                                            <div class="clearfix"></div>
                                            <?= $this->Form->control("location_vidscrip.vidscrip", [
                                                    'label' => 'Vidscrip ID',
                                                    'maxlength' => 30,
                                                    'help' => 'Add your Vidscrip ID to access embedded Vidscrip videos.'
                                                ])
                                            ?>
                                            <span class="help-block">Add your Vidscrip ID to access embedded Vidscrip videos.</span>
                                            <?= $this->Form->control("location_vidscrip.email", [
                                                    'label' => 'Vidscrip related email',
                                                    'help' => 'Enter the email address associated with your Vidscrip account.'
                                                ]);
                                            ?>
                                            <span class="help-block">Enter the email address associated with your Vidscrip account.</span>
                                        </div>
                                    <?php endif; */?>
                                </div>
                                
                                <!-- Provider Tab -->
                                <div class="tab-pane" id="Provider">
                                    <?php
                                        $count = count($location->providers);
                                    ?>
                                    <?php foreach ($location->providers as $key => $provider): ?>
                                        <div>
                                            <?= $this->element('locations/provider', ['key' => $key, 'provider' => $provider, 'clinic' => false, 'locationId' => $id, 'isBasicClinic' => $isBasicClinic]) ?>
                                        </div>
                                    <?php endforeach; ?>
                                    <?= $this->element('locations/provider', ['new' => true, 'key' => $count, 'provider' => [], 'clinic' => false, 'isBasicClinic' => $isBasicClinic]) ?>
                                </div>
                                
                                <!-- Hours Tab -->
                                <div class="tab-pane" id="Hours">
                                    <?php if($location->listing_type != Location::LISTING_TYPE_BASIC): ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $this->Form->control('optional_message', [
                                                    'label' => ['class' => 'form-label col-md-2'],
                                                    'rows' => 3,
                                                    'maxlength' => 400,
                                                    'required' => false])
                                                ?>
                                                <span class="help-block col-md-9 offset-md-3">Use this field to highlight a temporary announcement for patients, such as a note about any precautions your clinic is implementing regarding public health concerns. This is also a good place to highlight time-sensitive information such as closures due to illness, power outage, or renovation. The optional message field will only display on your profile if there is text in it.</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="16%">Day of Week</th>
                                            <th width="30%">Open Hrs</th>
                                            <th width="30%">Close Hrs</th>
                                            <th width="12%">Closed</th>
                                            <th width="12%">By Appt</th>
                                        </tr>
                                        <?= $this->Form->hidden('location_hour.id'); ?>
                                        <?php foreach ($days as $day): ?>
                                            <tr>
                                                <td><?= date("l", strtotime($day)) ?></td>
                                                <td class="form-inline">
                                                    <?= $this->Form->control("location_hour.".$day."_open", [
                                                        'label' => false,
                                                        'type' => 'time',
                                                        'step' => 60, //minutes
                                                        'empty' => true,
                                                        'value' => $this->Clinic->convert24hours($location->location_hour->{$day.'_open'}) ?: '08:00'
                                                    ]) ?>
                                                </td>
                                                <td>
                                                    <?= $this->Form->control("location_hour.".$day."_close", [
                                                        'label' => false,
                                                        'type' => 'time',
                                                        'step' => 60, //minutes
                                                        'empty' => true,
                                                        'value' => $this->Clinic->convert24hours($location->location_hour->{$day.'_close'}) ?: '17:00'
                                                    ]) ?>
                                                </td>
                                                <td>
                                                    <?= $this->Form->control("location_hour.".$day."_is_closed", [
                                                        'label' => false,
                                                        'type' => 'checkbox',
                                                        'class' => 'is-closed-checkbox',
                                                        'data-day' => $day,
                                                        'checked' => $location->location_hour->{$day.'_is_closed'}
                                                    ]) ?>
                                                </td>
                                                <td>
                                                    <?= $this->Form->control("location_hour.".$day."_is_byappt", [
                                                        'label' => false,
                                                        'type' => 'checkbox',
                                                        'checked' => $location->location_hour->{$day.'_is_byappt'}
                                                    ]) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="5">
                                                <?= $this->Form->control('location_hour.is_evening_weekend_hours', [
                                                    'type' => 'checkbox',
                                                    'label' => [
                                                        'text' => '<strong class="ml5">Evening and/or weekend hours available by appointment. Please call to schedule.</strong>',
                                                        'escape' => false,
                                                        'class' => 'form-label col-md-12 tal',
                                                    ],
                                                    'checked' => $location->location_hour->is_evening_weekend_hours
                                                ]) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <?= $this->Form->control('location_hour.is_closed_lunch', [
                                                    'type' => 'checkbox',
                                                    'label' => [
                                                        'text' => '<strong class="ml5">Closed for lunch</strong>',
                                                        'escape' => false,
                                                        'class' => 'form-label col-md-12 tal',
                                                    ],
                                                    'checked' => $location->location_hour->is_closed_lunch
                                                ]) ?>
                                                <div id="closedLunch" class="form-group required">
                                                    <label class="col-md-2 tal">Lunch break</label>
                                                    <?= $this->Form->control('location_hour.lunch_start', [
                                                        'type' => 'time',
                                                        'label' => false,
                                                        'empty' => true,
                                                        'autocomplete' => 'off',
                                                        'step' => 60, //minutes
                                                        'value' => $this->Clinic->convert24hours($location->location_hour->lunch_start),
                                                        'class' => 'w-100'
                                                    ]) ?>
                                                    <span class="mr5 ml5 mt10"> - </span>
                                                    <?= $this->Form->control('location_hour.lunch_end', [
                                                        'type' => 'time',
                                                        'label' => false,
                                                        'empty' => true,
                                                        'autocomplete' => 'off',
                                                        'step' => 60, //minutes
                                                        'value' => $this->Clinic->convert24hours($location->location_hour->lunch_end),
                                                        'class' => 'w-100'
                                                    ]) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <!-- Payment Tab -->
                                <div class="tab-pane" id="Payment">
                                    <div class="control-group">
                                        <div class="controls">
                                            <p><strong>Acceptable Methods of Payment</strong></p>
                                            <?= $this->Clinic->paymentForm($location->payment) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Notes Tab -->
                                <div class="tab-pane" id="Notes">
                                    <?php $noteCount = count($location->location_notes); ?>
                                    <div class="notes">
                                        <?php
                                            echo $this->Form->control("location_notes.$noteCount.body", [
                                                'label' => 'New note',
                                                'class' => 'editor',
                                                'required' => false
                                            ]);
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="submit" value="Save Location" class="btn btn-primary btn-lg pull-right">
                                            </div>
                                        </div>
                                        <br>
                                        <?php foreach ($location->location_notes as $note): ?>
                                            <?= $this->element('locations/note', ['note' => $note]) ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- CallSource Tab -->
                                <div class="tab-pane" id="CallSource">
                                    <?php if (Configure::read('isCallAssistEnabled')): ?>
                                        <?php if ($location->is_call_assist): ?>
                                            <div class="well">
                                                <span class="bi bi-check-lg" style="color:limegreen;"></span> Call Concierge is enabled. The CallSource number will route to our call center.
                                            </div>
                                        <?php else: ?>
                                            <div class="well">
                                                <span class="bi bi-x-square-fill" style="color:red;"></span> Call Concierge is disabled. The CallSource number will route directly to clinic.
                                            </div>
                                        <?php endif; ?>
                                        <?= $this->Form->control('direct_book_type', [
                                            'label' => 'Direct book type',
                                            'type' => 'select',
                                            'options' => Location::$directBookTypes,
                                        ]); ?>
                                        <div id="direct-book-links">
                                            <?= $this->Form->control('direct_book_url', [
                                                'label' => 'Direct book URL',
                                                'type' => 'textarea',
                                                'rows' => 4,
                                                'required' => false,
                                            ]); ?>
                                            <?= $this->Form->control('direct_book_iframe', [
                                                'label' => 'Direct book iFrame',
                                                'type' => 'textarea',
                                                'rows' => 4,
                                                'required' => false
                                            ]); ?>
                                        </div>
                                        <hr>
                                    <?php endif; ?>
                                    <div class="control-group mb20">
                                        <div class="controls">
                                            <div class="btn-group">
                                                <?= $this->Html->link('<i class="bi bi-arrow-repeat"></i> Update or Create CS Number',
                                                    ['action' => 'createUpdateCallSource', $id],
                                                    ['escape' => false, 'class' => 'btn btn-xs btn-default']) ?>
                                                <?= $this->Html->link('<i class="bi bi-arrow-repeat"></i> End and create new CS Number',
                                                    ['action' => 'cs_end_create', $id],
                                                    ['escape' => false, 'class' => 'btn btn-xs btn-info'],
                                                    'This will end this CS number, but leaves the CS customer active. Then creates a new CS number. Are you sure?') ?>
                                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i> Raw Lookup',
                                                    ['action' => 'call_source_raw', $id],
                                                    ['class' => 'btn btn-xs btn-default', 'escape' => false]) ?>
                                                <?= $this->Html->link('<i class="bi bi-trash"></i> End CS Number',
                                                    ['action' => 'cs_end', $id],
                                                    ['class' => 'btn btn-xs btn-danger', 'escape' => false],
                                                    'This will end all CallSource campaigns for this location and inactivate this CS customer. Are you sure?') ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-condensed mb10">
                                        <tr>
                                            <th>CallSource tracking number</th>
                                            <th>Target number</th>
                                            <th>Clinic number</th>
                                            <th>Is Active</th>
                                        </tr>
                                        <?php foreach ($location->call_sources as $callSource): ?>
                                            <tr>
                                                <td>
                                                    <?= formatPhoneNumber($callSource->phone_number) ?>
                                                </td>
                                                <td>
                                                    <?= formatPhoneNumber($callSource->target_number) ?>
                                                </td>
                                                <td>
                                                    <?= formatPhoneNumber($callSource->clinic_number) ?>
                                                </td>
                                                <td>
                                                    <?= $callSource->is_active ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>

                                <!-- User Tab -->
                                <div class="tab-pane" id="User">
                                    <?php $user = $location->users[0]; ?>
                                    <div class="form-group mb20">
                                        <div class="controls col-md-9 offset-md-3">
                                            <div class="btn-group">
                                                <?= $this->Html->link('<span class="glyphicon glyphicon-envelope"></span> Send Default Email', ['controller' => 'Users', 'action' => 'default_email', $user->id, $id], ['class' => 'btn btn-xs btn-default', 'escape' => false]) ?>
                                                <?= $this->Html->link('<span class="glyphicon glyphicon-lock"></span> Send Password Reset Email', ['controller' => 'Users', 'action' => 'change_password', $user->id, $id], ['class' => 'btn btn-xs btn-default', 'escape' => false]) ?>
                                                <?= $this->Html->link('<span class="glyphicon glyphicon-retweet"></span> Generate New Password', ['controller' => 'Users', 'action' => 'generate_new_password', $user->id, $id], ['class' => 'btn btn-xs btn-default', 'escape' => false]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h2>Clinic User</h2>
                                    <table class="table table-striped table-bordered table-condensed">
                                        <tr>
                                            <th class="col-md-3 tar">ID</th>
                                            <td class="col-md-9"><?= $user->id ?></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3 tar">Created</th>
                                            <td class="col-md-9"><?= dateTimeCentralToEastern($user->created) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3 tar">Modified</th>
                                            <td class="col-md-9"><?= dateTimeCentralToEastern($user->modified) ?></td>
                                        </tr>
                                    </table>
                                    <?= $this->Form->control('users.0.id', ['value'=>$user->id]) ?>
                                    <?= $this->Form->control('users.0.username', ['value'=>$user->username]) ?>
                                    <?= $this->Form->control('users.0.first_name', ['required' => false, 'value'=>$user->first_name]) ?>
                                    <?= $this->Form->control('users.0.last_name', ['required' => false, 'value'=>$user->last_name]) ?>
                                    <?= $this->Form->control('users.0.email', ['required' => false, 'value'=>$user->email]) ?>
                                    <div class="form-group">
                                        <label class="form-label col-md-3">Last Login</label>
                                        <div class="col-md-9 p0">
                                            <div class="form-control" disabled="true">
                                                <?php
                                                if ($user->lastlogin) {
                                                    echo date('F d Y, g:i a', strtotime($user->lastlogin));
                                                } else {
                                                    echo 'Never Logged In';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="controls w-100">
                                            <h3>Email Notifications</h3>
                                            <hr>
                                            <?php foreach($location->location_emails as $key => $email): ?>
                                                <?php if (!empty($email->email)): /* Only show if we have something to show*/ ?>
                                                    <div class="form-group">
                                                        <div class="col-md-9 offset-md-3">
                                                            <?= $this->Html->link('Delete This Email',['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'deluser', $email->id], [], 'Are you sure?') ?>
                                                        </div>
                                                    </div>
                                                    <?= $this->Form->control("location_emails.$key.id", ['default' => isset($email->id) ? $email->id : '']) ?>
                                                    <?php foreach(['email','first_name','last_name'] as $field): ?>
                                                        <?= $this->Form->control("location_emails.$key.$field", ['default' => isset($email->$field) ? $email->$field : '']) ?>
                                                    <?php endforeach; ?>
                                                    <hr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                
                                            <div class="form-group">
                                                <div class="col-md-9 offset-md-3">
                                                    <?= $this->Html->link('Add Another Email', '#', ['onclick' => '$("#additional-notification").slideDown(); return false;']); ?>
                                                </div>
                                            </div>
                                            <?php $key = count($location->location_emails); ?>
                                            <?php $notificationStyle = !empty($this->validationErrors) ? '' : 'display:none;'; ?>
                                            <div id="additional-notification" style=<?= $notificationStyle ?>>
                                                <?= $this->Form->control("location_emails.$key.id") ?>
                                                <?php foreach(['email','first_name','last_name'] as $field): ?>
                                                    <?= $this->Form->control("location_emails.$key.$field", ['required' => false]) ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h3>Login History</h3>
                                    <div class="form-group">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-striped table-bordered">
                                                    <tr>
                                                        <th>Login</th>
                                                        <th>IP Address</th>
                                                    </tr>
                                                    <?php foreach ($user->login_ips as $loginIp): ?>
                                                        <tr>
                                                            <td><?= $loginIp->login_date ?></td>
                                                            <td><?= $loginIp->ip ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Reviews Tab -->
                                <div class="tab-pane" id="Reviews">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <tr><th class="col-md-3 tar">Reviews Approved</th><td class="col-md-9"><?= $location->reviews_approved ?></td></tr>
                                        <tr><th class="col-md-3 tar">Average Rating</th><td class="col-md-9"><?= $location->average_rating ?></td></tr>
                                    </table>
                                    <div id="reviews" class="pb10">
                                        <div class="control-group">
                                            <div class="controls">
                                            <?php foreach($reviews as $review): ?>
                                                <?= $this->element('locations/review_body', ['review' => $review, 'clinicName' => $location->title]) ?>
                                                <div class="ml20 mt10">
                                                    <span class='label label-default'><?= Review::$statuses[$review->status] ?></span>
                                                    <?= $this->Html->link("<span class='glyphicon glyphicon-pencil'></span> Edit This Review",
                                                        ['controller' => 'reviews', 'action' => 'edit', $review->id],
                                                        ['escape' => false, 'class' => 'btn btn-xs btn-default ml10']) ?>
                                                </div>
                                                <hr>
                                            <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <?php if (!$loadAllReviewsAndImports): ?>
                                                <?= $this->Html->link('<span class="glyphicon glyphicon-retweet"></span> Load All Reviews For This Clinic', [$id, '#' => 'Reviews', '?' => ['loadall' => 1]], ['class' => 'btn btn-xs btn-info', 'escape' => false]) ?>
                                            <?php endif; ?>
                                            <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> Add A Review For This Clinic', ['controller' => 'reviews', 'action' => 'edit', 0, $id], ['class' => 'btn btn-xs btn-primary', 'escape' => false]) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- US Imports Tab -->
                                <div class="tab-pane" id="Imports">
                                    <?php if (Configure::read('isYhnImportEnabled')): ?>
                                        <!-- US Imports -->
                                        <h4>Imports</h4>
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs import-tabs clearfix" role="tablist">
                                                <?php if (Configure::read('isOticonImportEnabled')): ?>
                                                    <li class="nav-item">
                                                        <button class="nav-link active" data-bs-target="#Oticon" data-bs-toggle="tab" aria-controls="Oticon" aria-expanded="true" type="button" role="tab">Oticon</button>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if (Configure::read('isYhnImportEnabled')): ?>
                                                    <li class="nav-item">
                                                        <button class="nav-link" data-bs-target="#YHN" data-bs-toggle="tab" aria-controls="YHN" aria-expanded="true" type="button" role="tab">YHN</button>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if (Configure::read('isCqpImportEnabled')): ?>
                                                    <li class="nav-item">
                                                        <button class="nav-link" data-bs-target="#CQP" data-bs-toggle="tab" aria-controls="CQP" aria-expanded="true" type="button" role="tab">CQP</button>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                            <div class="tab-content mt10">
                                                <!-- Oticon Tab -->
                                                <div class="tab-pane active" id="Oticon">
                                                    <span><strong>Most recent Oticon import:</strong> <?= $lastOticonImportDate ?></span><br><br>
                                                    <?php if (!empty($location->oticon_tier)): ?>
                                                        <!-- Show change status only if this in an active Oticon clinic -->
                                                        <div class="form-group col-md-12">
                                                            <div class="btn-group">
                                                                <?= $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Update Field Statuses Without Accepting Oticon Changes', ['controller' => 'locations', 'action' => 'check_oticon', $id], ['class' => 'btn btn-xs btn-default', 'escape' => false]) ?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <table class="table table-striped table-bordered table-condensed">
                                                            <tr>
                                                                <th>Field</th>
                                                                <th>Status</th>
                                                                <th>HH value</th>
                                                                <th>Oticon value</th>
                                                                <th></th>
                                                            </tr>
                                                            <?php foreach (['email', 'phone', 'title', 'address'] as $field): ?>
                                                                <?php $ucField = ucfirst($field); ?>
                                                                <tr>
                                                                    <td><?php echo $ucField; ?></td>
                                                                    <td><?php echo Location::$changeStatuses[$location->{$field.'_status'}]; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($field == 'address') {
                                                                            echo $location->address.' ';
                                                                            echo $location->address_2.' ';
                                                                            echo $location->city.' ';
                                                                            echo $location->state.' ';
                                                                            echo $location->zip;
                                                                        } else {
                                                                            echo $location->$field;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($field == 'address') {
                                                                            echo $this->Clinic->getOticonField($location->last_xml, 'address').' ';
                                                                            echo $this->Clinic->getOticonField($location->last_xml, 'address_2').' ';
                                                                            echo $this->Clinic->getOticonField($location->last_xml, 'city').' ';
                                                                            echo $this->Clinic->getOticonField($location->last_xml, 'state').' ';
                                                                            echo $this->Clinic->getOticonField($location->last_xml, 'zip');
                                                                        } else {
                                                                            echo $this->Clinic->getOticonField($location->last_xml, $field);
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td nowrap>
                                                                        <?php
                                                                        $confirmMessage = 'Are you sure?';
                                                                        if ($field == 'phone') {
                                                                            $confirmMessage .= ' This will also update the CallSource number for you.';
                                                                        }
                                                                        if ($field == 'address') {
                                                                            $confirmMessage .= ' This will also re-geolocate the clinic for you.';
                                                                        }
                                                                        ?>
                                                                        <?= $this->Html->link('<span class="glyphicon glyphicon-edit"></span> Accept Oticon Change',
                                                                            ['controller' => 'locations', 'action' => 'take_oticon', $location->id, $field],
                                                                            ['class' => 'btn btn-xs btn-danger pull-left m5', 'escape' => false],
                                                                            $confirmMessage);
                                                                        ?>
                                                                        <?= $this->Form->control('is_'.$field.'_ignore', [
                                                                            'label' => 'Ignore '.$ucField.' Changes',
                                                                        ]); ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </table>
                                                        <hr>
                                                    <?php endif; ?>
                    
                                                    <h4>Raw Parsed of Last XML from Oticon:</h4>
                                                    <?php $this->Clinic->printLastXml($location->last_xml); ?>
                    
                                                    <hr>
                                                    <p><strong>Oticon Import Status</strong></p>
                                                    <table class="table table-striped table-bordered table-condensed">
                                                        <tr>
                                                            <th>Import Date</th>
                                                            <th>Status</th>
                                                            <th>Oticon Tier</th>
                                                            <th>HH Listing Type</th>
                                                            <th>Active</th>
                                                            <th>Show</th>
                                                            <th>Grace Period</th>
                                                        </tr>
                                                        <?php foreach($oticonImportStatuses as $importStatus): ?>
                                                            <tr>
                                                                <td><?php echo dateTimeCentralToEastern($importStatus->created); ?></td>
                                                                <td><?= isset($importStatus->status) ? ImportStatus::$statuses[$importStatus->status] : '' ?></td>
                                                                <td><?php echo $importStatus->oticon_tier; ?></td>
                                                                <td><?php echo $importStatus->listing_type; ?></td>
                                                                <td>
                                                                    <?php if (isset($importStatus->is_active) && ($importStatus->is_active !== NULL)): ?>
                                                                        <?= empty($importStatus->is_active) ? "No" : "Yes" ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (isset($importStatus->is_show) && ($importStatus->is_show !== NULL)): ?>
                                                                        <?= empty($importStatus->is_show) ? "No" : "Yes" ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($importStatus->oticon_tier == 3) {
                                                                        if (isset($importStatus->is_grace_period) && ($importStatus->is_grace_period !== NULL)) {
                                                                            echo empty($importStatus->is_grace_period) ? "No" : "Yes";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                    <?php if (!$loadAllReviewsAndImports): ?>
                                                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Load All Statuses For This Clinic', [$id, '#' => 'Oticon', '?' => ['loadall' => 1]], ['class' => 'btn btn-xs btn-info', 'escape' => false]); ?>
                                                    <?php endif; ?>
                                                </div>
                    
                                                <!-- YHN Tab -->
                                                <div class="tab-pane" id="YHN">
                                                    <?php
                                                    $yhnImportOptions = [];
                                                    foreach ($importLocations as $importLocation) {
                                                        if ($importLocation->import->type == 'yhn') {
                                                            $yhnImportOptions[$importLocation->import_id] = date('F d, Y', strtotime($importLocation->import->created));
                                                        }
                                                    }
                                                    echo $this->Form->control('yhnImportSelect', [
                                                        'type' => 'select',
                                                        'options' => $yhnImportOptions,
                                                        'label' => 'YHN Import Date',
                                                        'class' => 'form-select js-import-select'
                                                    ]);
                                                    $hideFields = ['id', 'import_id', 'location_id', 'match_type', 'notes', 'id_cqp_practice', 'id_cqp_office'];
                                                    ?>
                                                    <?php foreach ($importLocations as $importLocation): ?>
                                                        <?php if ($importLocation->import->type == 'yhn'): ?>
                                                            <div class="import col-md-11 offset-md-1" import="<?= $importLocation->import_id; ?>">
                                                                <br><br>
                                                                <table class="table table-striped table-bordered table-condensed">
                                                                    <?php foreach ($importLocation->toArray() as $label => $value): ?>
                                                                        <?php
                                                                        if (is_array($value) || in_array($label, $hideFields)) {
                                                                            continue;
                                                                        }
                                                                        switch ($label) {
                                                                            case "zip":
                                                                                $label = Configure::read('zipLabel');
                                                                                break;
                                                                            case "state":
                                                                                $label = Configure::read('stateLabel');
                                                                                break;
                                                                            case "id_external":
                                                                                $label = $externalIdLabel;
                                                                                break;
                                                                            case "id_oticon":
                                                                                $label = 'Oticon ID';
                                                                                break;
                                                                            default:
                                                                                break;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <th class="text-right col-md-3"><?= ucfirst(str_replace('_', ' ', $label)); ?></th>
                                                                            <td class="col-md-9"><?= isset($value) && $value !== '' && $value !== false  ? $value : '&nbsp;'; ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </table>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <div class="clearfix"></div>
                                                </div>
                    
                                                <!-- CQP Tab -->
                                                <div class="tab-pane" id="CQP">
                                                    <?php
                                                    $cqpImportOptions = [];
                                                    foreach ($importLocations as $importLocation) {
                                                        if ($importLocation->import->type == 'cqp') {
                                                            $cqpImportOptions[$importLocation->import_id] = date('F d, Y', strtotime($importLocation->import->created));
                                                        }
                                                    }
                                                    echo $this->Form->control('cqpImportSelect', [
                                                        'type' => 'select',
                                                        'options' => $cqpImportOptions,
                                                        'label' => 'CQP Import Date',
                                                        'class' => 'form-select js-cqp-import-select'
                                                    ]);
                                                    $hideFields = ['id', 'import_id', 'location_id', 'match_type', 'notes', 'id_external', 'id_oticon', 'is_retail'];
                                                    ?>
                                                    <?php foreach ($importLocations as $importLocation): ?>
                                                        <?php if ($importLocation->import->type == 'cqp'): ?>
                                                            <div class="cqpImport col-md-11 offset-md-1" import="<?= $importLocation->import_id; ?>">
                                                                <br><br>
                                                                <table class="table table-striped table-bordered table-condensed mb30">
                                                                    <?php foreach ($importLocation->toArray() as $label => $value): ?>
                                                                        <?php
                                                                        if (is_array($value) || in_array($label, $hideFields)) {
                                                                            continue;
                                                                        }
                                                                        switch ($label) {
                                                                            case "zip":
                                                                                $label = Configure::read('zipLabel');
                                                                                break;
                                                                            case "state":
                                                                                $label = Configure::read('stateLabel');
                                                                                break;
                                                                            case "id_cqp_office":
                                                                                $label = 'CQP Office ID';
                                                                                break;
                                                                            case "id_cqp_practice":
                                                                                $label = 'CQP Practice ID';
                                                                                break;
                                                                            default:
                                                                                break;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <th class="text-right col-md-3"><?= ucfirst(str_replace('_', ' ', $label)); ?></th>
                                                                            <td class="col-md-9" style="word-break: break-word;"><?= $value; ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </table>
                                                                <?= $this->Clinic->cqpImportNotes($importLocation['notes']); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- CA Imports -->
                                        <?php
                                        $caImportOptions = [];
                                        foreach ($importLocations as $importLocation) {
                                            $caImportOptions[$importLocation->import_id] = date('F d, Y', strtotime($importLocation->import->created));
                                        }
                                        echo $this->Form->control('caImportSelect', [
                                            'type' => 'select',
                                            'options' => $caImportOptions,
                                            'label' => 'Import Date',
                                            'class' => 'form-select js-import-select'
                                        ]);
                                        $hideFields = ['id', 'import_id', 'location_id', 'match_type', 'notes', 'id_cqp_practice', 'id_cqp_office'];
                                        ?>
                                        <?php foreach ($importLocations as $importLocation): ?>
                                            <div class="import col-md-11 offset-md-1" import="<?= $importLocation->import_id ?>">
                                                <br><br>
                                                <table class="table table-striped table-bordered table-condensed">
                                                    <?php foreach ($importLocation->toArray() as $label => $value): ?>
                                                        <?php
                                                        if (is_array($value) || in_array($label, $hideFields)) {
                                                            continue;
                                                        }
                                                        switch ($label) {
                                                            case "zip":
                                                                $label = Configure::read('zipLabel');
                                                                break;
                                                            case "state":
                                                                $label = Configure::read('stateLabel');
                                                                break;
                                                            case "id_external":
                                                                $label = $externalIdLabel;
                                                                break;
                                                            default:
                                                                break;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th class="text-right col-md-3">
                                                                <?php echo ucfirst(str_replace('_', ' ', $label)); ?>
                                                            </th>
                                                            <td class="col-md-9"><?php echo $value; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="clearfix"></div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Filters Tab -->
                                <div class="tab-pane" id="Filters">
                                    <div class="control-group mb20">
                                        <div class="controls">
                                            <div class="btn-group">
                                                <?= $this->Html->link('<span class="glyphicon glyphicon-refresh"></span> Update Filters', ['action' => 'update_filters', $id, '#' => 'Filters'], ['escape' => false, 'class' => 'btn btn-xs btn-default']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-9 offset-md-3">
                                                <?= $this->Form->control('filter_has_photo', [
                                                    'label' => [
                                                        'class' => 'form-label tal',
                                                        'text' => 'Has Photo',
                                                    ],
                                                    'type' => 'checkbox',
                                                    'class' => ''
                                                ]); ?>
                                            </div>
                                            <div class="col-md-9 offset-md-3">
                                                <?= $this->Form->control('filter_insurance', [
                                                    'label' => [
                                                        'class' => 'form-label tal',
                                                        'text' => 'Accepts Insurance',
                                                    ],
                                                    'type' => 'checkbox',
                                                    'class' => ''
                                                ]); ?>
                                            </div>
                                            <div class="col-md-9 offset-md-3">
                                                <?= $this->Form->control('filter_evening_weekend', [
                                                    'label' => [
                                                        'class' => 'form-label tal',
                                                        'text' => 'Evening or Weekend Hours',
                                                    ],
                                                    'type' => 'checkbox',
                                                    'class' => ''
                                                ]); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-9 offset-md-3">
                                                <?= $this->Form->control('filter_adult_hearing_test', [
                                                    'label' => [
                                                        'class' => 'form-label tal',
                                                        'text' => 'Adult Hearing Test',
                                                    ],
                                                    'type' => 'checkbox',
                                                    'class' => ''
                                                ]); ?>
                                            </div>
                                            <div class="col-md-9 offset-md-3">
                                            <?= $this->Form->control('filter_hearing_aid_fitting', [
                                                'label' => [
                                                    'class' => 'form-label tal',
                                                    'text' => 'Hearing Test Aid Fitting',
                                                ],
                                                'type' => 'checkbox',
                                                'class' => ''
                                            ]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Admin Tab -->
                                <div class="tab-pane" id="Admin">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <tr>
                                            <th class="col-md-3 tar">Date Created</th>
                                            <td class="col-md-9"><?= dateTimeCentralToEastern($location->created) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3 tar">Last Modified</th>
                                            <td class="col-md-9"><?= dateTimeCentralToEastern($location->modified) ?></td>
                                        </tr>
                                    </table>
                                    <?= $this->Form->control('redirect'); ?>
                                    <?= $this->Form->control('is_retail', [
                                            'label' => 'WDH Retail',
                                            'type' => 'select',
                                            'options' => [
                                                0 => 'No',
                                                1 => 'Yes',
                                            ],
                                            'default' => 0,
                                        ]);
                                    ?>
                                    <?php if (Configure::read('isYhnImportEnabled')): ?>
                                        <?= $this->Form->control('is_cq_premier', [
                                                'label' => 'CQ Premier',
                                                'type' => 'select',
                                                'options' => [
                                                    0 => 'No',
                                                    1 => 'Yes',
                                                ],
                                                'default' => 0,
                                            ]);
                                        ?>
                                        <?= $this->Form->control('is_iris_plus', [
                                                'label' => 'Iris+',
                                                'type' => 'select',
                                                'options' => [
                                                    0 => 'No',
                                                    1 => 'Yes',
                                                ],
                                                'default' => 0
                                            ]);
                                        ?>
                                        <span class="help-block col-md-9 offset-md-3">If clinic is Iris+, select both "CQ Premier" and "Iris+"</span>
                                    <?php endif; ?>
                                    <?= $this->Form->control('is_junk', [
                                            'label' => 'Junk',
                                            'type' => 'select',
                                            'options' => [
                                                0 => 'No',
                                                1 => 'Yes',
                                            ],
                                            'default' => 0,
                                        ]);
                                    ?>
                                    <div class="col-md-9 offset-md-3 pl0">
                                        <?= $this->Form->control('is_email_allowed', [
                                            'label' => [
                                                'class' => 'form-label',
                                                'text' => 'Allow email notifications for profile updates'
                                            ]
                                        ]); ?>
                                    </div>
                                    <?php if (Configure::read('isTieringEnabled')): ?>
                                        <div class="col-md-9 offset-md-3 pl0">
                                            <?= $this->Form->control('is_service_agreement_signed', [
                                                'label' => [
                                                    'class' => 'form-label',
                                                    'text' => 'Service agreement signed'
                                                ]
                                            ]); ?>
                                        </div>
                                        <strong class="col-md-10 offset-md-2">Premier Features -- Individual purchase</strong>
                                        <?php if ($location->is_cq_premier || $location->is_iris_plus): ?>
                                            <div class="row">
                                                <?php $membership = $location->is_iris_plus ? 'Iris+' : 'CQ Premier'; ?>
                                                <div class="col-md-9 offset-md-3"><span class="glyphicon glyphicon-check"></span> Social Media Library is included in <?= $membership ?> membership</div>
                                            </div>
                                        <?php else: ?>
                                            <div class="row">
                                                <div class="col-md-3 offset-md-3">
                                                    <?= $this->Form->control('feature_content_library', [
                                                        'label' => 'Social media library'
                                                    ]); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $this->Form->control('content_library_expiration', [
                                                        'type' => 'date',
                                                        'min' => date("Y-m-d", strtotime('today')),
                                                        'label' => 'Expires',
                                                        'default' => ''
                                                    ]) ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions tar clearfix">
                        <?= $this->Form->button('Save Location', ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>