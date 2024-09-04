<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use App\Middleware\BeforeLoginMiddleware;
use App\Middleware\GeoLocSessionMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Middlewares\TrailingSlash;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Event\EventInterface;
use Muffin\Footprint\Middleware\FootprintMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }
        $this->addPlugin('Muffin/Footprint');

        $this->addPlugin(\CakeDC\Users\Plugin::class, ['routes' => true, 'bootstrap' => true]);
        Configure::write('Users.config', ['users']);

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            Configure::write('DebugKit.safeTld', ['loc']);
            Configure::write('DebugKit.variablesPanelMaxDepth', 8);
            $this->addPlugin('DebugKit');
          //  $this->addPlugin('IdeHelper'); TEMPORARILY DISABLE FOR DEBUGKIT TO WORK ON dev4
        }
        $this->addPlugin('BootstrapUI');
        $this->addPlugin('Cake/Localized');
        $this->addPlugin('Search');
        $this->addPlugin('Sitemap', ['routes' => true]);
        $this->addPlugin('Recaptcha');
        $this->addPlugin('CsvView');
        $this->addPlugin('Queue', ['routes' => false]);

        // Listener for CakeDC/users plugin Events
        $this->getEventManager()->on(new \App\Event\UsersListener());

        $this->getEventManager()->on(
            'Server.buildMiddleware',
            function (EventInterface $event, MiddlewareQueue $middleware) {
                $middleware->insertAfter(AuthenticationMiddleware::class, FootprintMiddleware::class);
            }
        );
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $csrf = new CsrfProtectionMiddleware(['httponly'=>true]);
        // Token check will be skipped when callback returns `true`.
        $csrf->skipCheckCallback(function($request) {
            $controller = $request->getParam('controller');
            $action = $request->getParam('action');
            if (is_null($controller) || is_null($action)) {
                return false;
            }
            // TODO: Is it okay to skip CSRF for ajax?
            // Skip CSRF token check for inlineajax
            if (($controller=='Utils') && ($action=='inlineajax')) {
                return true;
            }

            if ($controller === 'Endpoints') {
                return true;
            }
            return false;
        });
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Geolocation
            // Save geolcation info about vistors in session.
            ->add(new GeoLocSessionMiddleware())

            // Remove trailing slashes from URIs
            // TO-DO: Thoroughly check SEO implications of this
            ->add((new TrailingSlash())->redirect())

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add(new RoutingMiddleware($this))

            // Parse various types of encoded request bodies so that they are
            // available as array through $request->getData()
            // https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
            ->add(new BodyParserMiddleware())

            // This middleware intercepts the 'login' action and sets the 'loginIp' session variable.
            // 'loginIp' is used in UsersListener to record clinic login IPs.
            // It may be redundant to the session variable 'clientIp' set in GeoLocSessionMiddleware,
            // but it **may** be a good idea to explicitly record the IP at login to ensure we're
            // capturing it and not one already in the session.
            ->add(new BeforeLoginMiddleware())

            // Cross Site Request Forgery (CSRF) Protection Middleware
            // https://book.cakephp.org/4/en/controllers/middleware.html#cross-site-request-forgery-csrf-middleware
            ->add($csrf);

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
    }

    /**
     * Bootstrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        $this->addOptionalPlugin('Cake/Repl');
        $this->addOptionalPlugin('Bake');

        $this->addPlugin('Migrations');
        //$this->addPlugin('IdeHelper'); //Commented out for testing Deployer
    }
}
