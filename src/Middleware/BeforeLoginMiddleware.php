<?php
declare(strict_types=1);

namespace App\Middleware;

use CakeDC\Users\Utility\UsersUrl;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * BeforeLogin middleware
 */
class BeforeLoginMiddleware implements MiddlewareInterface
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
        if (!(new UsersUrl())->checkActionOnRequest('login', $request)) {
            return $handler->handle($request);
        }

        $session = $request->getSession();
        $session->write('loginIp', $request->clientIp());

        return $handler->handle($request);
    }
}
