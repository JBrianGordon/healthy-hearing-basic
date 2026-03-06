<?php

return [
    'CakeDC/Auth.permissions' => [
/****************************************************
*************** Non-HH CakePHP routes ***************
*****************************************************/

        /*******************************
        * CakeDC/Users Plugin routes
        ********************************/
        [
            'prefix' => false,
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => [
                'login',
                'logout',
                'changePassword',
                'resetPassword',
                'requestResetPassword',
            ],
            'bypassAuth' => true,
        ],

        /*******************************
        * DebugKit Plugin routes
        ********************************/
        [
            'role' => '*', // add 'admin' as a layer of protection?
            'plugin' => 'DebugKit',
            'controller' => '*',
            'action' => '*',
            'bypassAuth' => true,
        ],

/****************************************************
*************** ROLE: 'admin' routes ***************
*****************************************************/

        //admin role allowed to all the things
        [
            'role' => 'admin',
            'prefix' => '*',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],

/****************************************************
*************** ROLE: 'clinic' routes ***************
*****************************************************/

        /*******************************
        * Clinic - Clinic/Locations
        ********************************/
        [
            // Clinics can only access their clinic's location edit page when logged in
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'Locations',
            'action' => ['edit', 'account'],
            'allowed' => new \CakeDC\Auth\Rbac\Rules\Owner([
                'table' => 'LocationsUsers',
                'id' => 'location_id',
                'ownerForeignKey' => 'user_id',
            ]),
        ],
        [
            // Clinics can only delete additional emails from their clinic
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'LocationEmails',
            'action' => 'delete',
            'allowed' => function ($user, $role, \Cake\Http\ServerRequest $request) {
                $locationEmailId = $request->getParam('pass.0');
                $locationEmail = \Cake\ORM\TableRegistry::get('LocationEmails')
                    ->find('all')
                    ->where(['id' => $locationEmailId])
                    ->first();
                $userLocationId = $user->locations[0]->id;
                if (!empty($locationEmail->location_id) && !empty($userLocationId)) {
                    return $userLocationId == $locationEmail->location_id;
                }
                return false;
            }
        ],

        /*******************************
        * Clinic - Clinic/Reviews
        ********************************/
        [ // Clinics can only access their clinic's review index page
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'Reviews',
            'action' => 'index',
            'allowed' => new \CakeDC\Auth\Rbac\Rules\Owner([
                'table' => 'LocationsUsers',
                'id' => 'location_id',
                'ownerForeignKey' => 'user_id',
            ]),
        ],
        [ // Clinics can only access the 'respond' pages for their clinic's reviews
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'Reviews',
            'action' => 'respond',
            'allowed' => function ($user, $role, \Cake\Http\ServerRequest $request) {
                $reviewId = $request->getParam('pass.0');
                $review = \Cake\ORM\TableRegistry::get('Reviews')->get($reviewId);
                $userId = $user['id'];
                $locationsUsersRecord = \Cake\ORM\TableRegistry::get('LocationsUsers')
                    ->find('all')
                    ->where(['location_id' => $review->location_id])
                    ->first();
                if (!empty($locationsUsersRecord)) {
                    return $userId === $locationsUsersRecord->user_id;
                }
                return false;
            }
        ],

        /*******************************
        * Clinic - Clinic/LibraryItems
        ********************************/
        [ // Clinics can access the sharing library
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'LibraryItems',
            'action' => 'index',
        ],

        /*******************************
        * Clinic - Clinic/Pages
        ********************************/
        [ // Clinics can access clinic FAQ
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'Pages',
            'action' => 'clinicFaq',
        ],

        [ // Clinics can only delete Providers and Provider images from their clinic
            'role' => 'clinic',
            'prefix' => 'Admin',
            'controller' => 'Providers',
            'action' => ['deleteProviderFromClinic', 'deleteProviderImage'],
            'allowed' => function ($user, $role, \Cake\Http\ServerRequest $request) {
                $providerId = $request->getData('providerId');
                $locationsProvidersRecord = \Cake\ORM\TableRegistry::get('LocationsProviders')
                    ->find('all')
                    ->where(['provider_id' => $providerId])
                    ->first();
                $userLocationId = $user->locations[0]->id;

                if (!empty($locationsProvidersRecord) && !empty($userLocationId)) {
                    return $userLocationId === $locationsProvidersRecord->location_id;
                }
                return false;
            }
        ],

        [ // Clinics can only delete LocationPhoto images from their clinic
            'role' => 'clinic',
            'prefix' => 'Admin',
            'controller' => 'Locations',
            'action' => 'deleteLocationPhoto',
            'allowed' => function ($user, $role, \Cake\Http\ServerRequest $request) {
                $locationPhotoId = $request->getData('locationPhotoId');
                $locationPhotosRecord = \Cake\ORM\TableRegistry::get('LocationPhotos')->get($locationPhotoId);

                $userLocationId = $user->locations[0]->id;

                if (!empty($locationPhotosRecord) && !empty($userLocationId)) {
                    return $userLocationId === $locationPhotosRecord->location_id;
                }
                return false;
            }
        ],

        [ // Clinics can only delete LocationAd images from their clinic
            'role' => 'clinic',
            'prefix' => 'Admin',
            'controller' => 'Locations',
            'action' => 'deleteLocationAd',
            'allowed' => function ($user, $role, \Cake\Http\ServerRequest $request) {
                $locationAdId = $request->getData('locationAdId');
                $locationAdsRecord = \Cake\ORM\TableRegistry::get('LocationAds')->get($locationAdId);

                $userLocationId = $user->locations[0]->id;

                if (!empty($locationAdsRecord) && !empty($userLocationId)) {
                    return $userLocationId === $locationAdsRecord->location_id;
                }
                return false;
            }
        ],

        /*******************************
        * Clinic - clinic/ca-call-groups/
        ********************************/
        [ // Clinics can only access their clinic's review index page
            'role' => 'clinic',
            'prefix' => 'Clinic',
            'controller' => 'CaCallGroups',
            'action' => 'report',
        ],

/********************************************
*************** Public routes ***************
*********************************************/

        /*******************************
        * Public - Content
        ********************************/
        [
            'prefix' => false,
            'controller' => 'Content',
            'action' => ['reportIndex', 'view'],
            'bypassAuth' => true,
        ],

        /*******************************
        * Public - Corps
        ********************************/
        [
            'prefix' => false,
            'controller' => 'Corps',
            'action' => ['index', 'view'],
            'bypassAuth' => true,
        ],

        /*******************************
        * Public - Locations
        ********************************/
        [
            'prefix' => false,
            'controller' => 'Locations',
            'action' => '*',
            'bypassAuth' => true,
        ],

        /*******************************
        * Public - Pages
        ********************************/
        [
            'prefix' => false,
            'controller' => 'Pages',
            'action' => [
                'about',
                'clinicInfo',
                'contactUs',
                'feeds',
                'home',
                'newsletter',
                'newsletterSuccess',
                'privacyPolicy',
                'termsOfUse'
            ],
            'bypassAuth' => true,
        ],

        /*******************************
        * Public - Online Hearing Test
        ********************************/
        [
            'prefix' => false,
            'controller' => 'QuizResults',
            'action' => [
                'onlineHearingTest',
                'emailResults',
            ],
            'bypassAuth' => true,
        ],

        /*******************************
        * Public - Sitemap
        ********************************/
        [
            'prefix' => false,
            'controller' => 'Sitemaps',
            'action' => [
                'index',
                'main',
                'view',
            ],
            'bypassAuth' => true,
        ],

        /*******************************
        * Public - Wikis
        ********************************/
        [
            'prefix' => false,
            'controller' => 'Wikis',
            'action' => ['index', 'view'],
            'bypassAuth' => true,
        ],
    ],
];
