<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$logoBorder = Configure::read('logo_border');
$logo = Configure::read('logo');

// $isCqPremier = $listing_type = $featureContentLibrary = $showLibraryLink = false;
// if (!empty($user['location_id'])) {
//     $this->Clinic->setLocation($user['location_id']);
//     $isCqPremier = $this->Clinic->get('is_cq_premier');
//     $listing_type = $this->Clinic->get('listing_type');
//     $featureContentLibrary = $this->Clinic->get('feature_content_library');
// }

// $showLibraryLink = ($isCqPremier && $listing_type === 'Premier') || $featureContentLibrary || $isAdmin;
// if (!Configure::read('showSocialMediaContentLibrary')) {
//     $showLibraryLink = false;
// }
?>
<!-- TODO: set background color variable in CSS -->
<div class="navbar navbar-expand-lg navbar-clinic sticky-top" style="background-color: #fff;">
    <div class="container-fluid">
        <a href="/" class="navbar-brand clinic-portal-logo ms-5 <?php echo Configure::read('country'); ?>" <?php echo $logoBorder; ?>>
            <img src="<?php echo $logo; ?>" alt="<?php echo $siteName; ?>"><br />
            <div class="portal-title">Clinic Administration Portal</div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item ms-auto dropdown clinic-link">
                    <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="bi bi-person-fill"></span>
                            My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!-- TODO: MAKE SURE LINKS BELOW WORK; CREATE ROUTES -->
                        <!-- TODO: USE ROUTING ARRAYS WHERE APPROPRIATE -->
                        <li>
                            <?php
                                echo $this->AuthLink->link(
                                    '<span class="bi bi-globe2"></span> My Profile',
                                    [
                                        'prefix' => 'Clinic',
                                        'controller' => 'Locations',
                                        'action' => 'edit',
                                        $this->Identity->get('locations.0.id'),
                                    ],
                                    [
                                        'escape' => false,
                                        'class' => 'dropdown-item',
                                    ]
                                );
                                ?>
                        </li>
                        <!-- <li><a href="/clinic/locations/edit" class="dropdown-item"><span class="bi bi-globe2"></span> My Profile</a></li> -->
                        <li><a href="/clinic/ca_call_groups/report" class="dropdown-item"><span class="bi bi-list-task"></span> Reporting</a></li>
                        <li><a href="/clinic/reviews" class="dropdown-item"><span class="bi bi-star-fill"></span> Reviews</a></li>
                        <!-- TODO: ADD PERMISSION FOR LIBRARY -->
                        <li><a href="/clinic/library" class="dropdown-item"><span class="bi bi-book-fill"></span> Library</a></li>
                        <li><a href="/clinic/pages/faq" class="dropdown-item"><span class="bi bi-question-circle-fill"></span> Help</a></li>
                        <li><a href="/clinic/pages/about-ida" class="dropdown-item"><span class="bi bi-award-fill"></span> Inspired by Ida</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="/clinic/users/account" class="dropdown-item"><span class="bi bi-person-fill"></span> My Account</a></li>
                        <li>
                            <?= $this->User->logout(
                                '<span class="bi bi-power"></span> Logout',
                                [
                                    'class' => 'dropdown-item',
                                    'escape' => false,
                                ]
                            ) ?>
                        </li>
                    </ul>
                </li>
                <?= $this->element('header/admin_panel_link') ?>
            </ul>
        </div>
    </div>
</div>