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
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        // Corp/manufacturer pages
        $builder->connect('/{corp}', 'Corps::view')
            ->setPass(['corp'])
            ->setPatterns(['corp' => Configure::read('corpsRegex') . '.*']);
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

    // Content routes
    $routes->scope('/report', function (RouteBuilder $builder) {
        $builder->connect('/', 'Content::report_index');
        $builder->connect('/{id}-{slug}', 'Content::view')
            ->setPass(['id', 'slug'])
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
    $routes->prefix('Admin', function (RouteBuilder $routes) {
        // All routes here will be prefixed with `/admin`, and
        // have the `'prefix' => 'Admin'` route element added that
        // will be required when generating URLs for these routes
        $routes->fallbacks(DashedRoute::class);
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
