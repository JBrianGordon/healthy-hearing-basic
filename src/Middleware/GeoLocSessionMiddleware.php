<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Utility\GeoLocIpUtility;
use Cake\Core\Configure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * GeoLocSession middleware
 */
class GeoLocSessionMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $session = $request->getSession();

        // Return client's geolocation data if present
        if ($session->check('geoLocData')) {
            return $handler->handle($request);
        }

        // Generate client's geolocation data from their IP address
        $clientIp = Configure::read('localIp') ?: $request->clientIp();

        $ipGeocoder = new GeoLocIpUtility();

        $ipGeoLocResult = $ipGeocoder->byIp($clientIp);

        $session->write('geoLocData', $ipGeoLocResult);

        return $handler->handle($request);
    }
}
