<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Core\Configure;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `:plugin`, `:controller` and
     * `:action` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', 'Pages::home');

        // Misc pages with simple, content-only templates
        $builder->connect('/about', ['controller' => 'Pages', 'action' => 'about', 'about']);
        $builder->connect('/feeds', ['controller' => 'Pages', 'action' => 'feeds', 'feeds']);
        $builder->connect('/privacy-policy', ['controller' => 'Pages', 'action' => 'privacyPolicy', 'privacyPolicy']);
        $builder->connect('/terms-of-use', ['controller' => 'Pages', 'action' => 'termsOfUse', 'termsOfUse']);

        // Misc pages with more complicated actions, integrations, etc.
        $builder->connect('/contact-us', 'Pages::contactUs');
        $builder->connect('/newsletter', 'Pages::newsletter');
        $builder->connect('/newsletter-success', 'Pages::newsletterSuccess');
        $builder->connect('/clinic', 'Pages::clinicInfo');

        // Corp/manufacturer pages
        $builder->connect('/{slug}', 'Corps::view')
            ->setPass(['slug'])
            ->setPatterns(['slug' => Configure::read('corpsRegex')]);

        // Online hearing test
        $builder->connect('/help/online-hearing-test', ['controller' => 'quizResults', 'action' => 'online_hearing_test']);

        // CKEditor endpoint route
        $builder->connect('/endpoints/ckeditor-endpoint', ['controller' => 'Endpoints', 'action' => 'ckeditorEndpoint']);


        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/:controller', ['action' => 'index']);
         * $builder->connect('/:controller/:action/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    // hearing-aids routes
    $routes->scope('/hearing-aids', function (RouteBuilder $builder) {
        $builder->connect('/', 'Locations::viewFac');
        $builder->connect('/{region}', 'Locations::viewState')
            ->setPass(['region'])
            ->setPatterns(['region' => '[a-zA-Z][a-zA-Z]\-[a-zA-Z\-]+']);
        $builder->connect('/{region}/{city}/{zip}', 'Locations::viewCityZip')
            ->setPass(['region', 'city', 'zip'])
            ->setPatterns(['region' => '[a-zA-Z][a-zA-Z]\-[a-zA-Z\-]+']);
        $builder->connect('/{region}/{city}', 'Locations::viewCityZip')
            ->setPass(['region', 'city'])
            ->setPatterns(['region' => '[a-zA-Z][a-zA-Z]\-[a-zA-Z\-]+']);
        $builder->connect('/{id}-{title}', 'Locations::view')
            ->setPass(['id', 'title'])
            ->setPatterns(['id' => '[0-9]+']);
    });

    // Redirect from /hearing-aids/DC-Dist--Of-Columbia to /hearing-aids/DC-Dist--Of-Columbia/Washington
    $routes->redirect('/hearing-aids/DC-Dist--Of-Columbia', '/hearing-aids/DC-Dist--Of-Columbia/Washington', ['status' => 301]);

    // Ads routes
    $routes->scope('/ads', function (RouteBuilder $builder) {
        $builder->connect(
            '/', [
                'controller' => 'Advertisements'
            ]
        );
        $builder->connect(
            '/{action}/*', [
                'controller' => 'Advertisements'
            ]
        );
    });

    // Content routes
    $routes->scope('/report', function (RouteBuilder $builder) {
        $builder->setExtensions(['rss']);
        $builder->connect('/', 'Content::report_index');
        $builder->connect('/{id}-{slug}', 'Content::view')
            ->setPass(['id', 'slug'])
            ->setPatterns(['id' => '\d+']);
        $builder->connect('/{id}', 'Content::view')
            ->setPass(['id'])
            ->setPatterns(['id' => '\d+']);
    });

    // Corps/manufacturers index page
    // Individual corp/manufacturer routes defined in base path scope above
    $routes->connect('/hearing-aid-manufacturers', 'Corps::index');

    // Wikis routes
    $routes->scope('/help', function (RouteBuilder $builder) {
        $builder->connect('/', 'Wikis::index');
        $builder->connect('/{slug}', 'Wikis::view')
            ->setPass(['slug'])
            ->setPatterns(['slug' => Configure::read('wikiCategoriesRegex') . '.*']);
    });

    // Admin-prefixed routes
    $routes->prefix('Admin', function (RouteBuilder $adminBuilder) {
        $adminBuilder->connect('/', 'Utils::panel');

        $adminBuilder->connect(
            '/ads', [
                'controller' => 'Advertisements'
            ]
        );
        $adminBuilder->connect(
            '/ads/{action}/*', [
                'controller' => 'Advertisements'
            ]
        );

        // All routes here will be prefixed with `/admin`, and
        // have the `'prefix' => 'Admin'` route element added that
        // will be required when generating URLs for these routes
        $adminBuilder->fallbacks(DashedRoute::class);
    });

    // Clinic-prefixed routes
    $routes->prefix('Clinic', function (RouteBuilder $clinicBuilder) {
        $clinicBuilder->connect(
            '/locations/edit/{location_id}',
            'Locations::edit'
        )
        ->setPass(['location_id'])
        ->setPatterns([
            'location_id' => '^81190\d{5}$',
        ]);

        $clinicBuilder->connect(
            '/library',
            'LibraryItems::index'
        );

        $clinicBuilder->connect(
            '/pages/faq',
            'Pages::clinicFaq'
        );

        // All routes here will be prefixed with `/clinic`, and
        // have the `'prefix' => 'Clinic'` route element added that
        // will be required when generating URLs for these routes
        $clinicBuilder->fallbacks(DashedRoute::class);
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
