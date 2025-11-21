<?php
declare(strict_types=1);

namespace App\Middleware\UnauthorizedHandler;

use Authorization\Exception\Exception as AuthorizationException;
use Cake\Http\Exception\NotFoundException;
use CakeDC\Users\Middleware\UnauthorizedHandler\DefaultRedirectHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Custom unauthorized handler that returns 404 for non-existent actions
 * instead of redirecting to login. This class overrides/extends the default
 * behavior of the CakeDC/users plugin's DefaultRedirectHandler.
 */
class Custom404AwareHandler extends DefaultRedirectHandler
{
    /**
     * Handle unauthorized access
     *
     * @param \Authorization\Exception\Exception $exception Authorization exception
     * @param \Psr\Http\Message\ServerRequestInterface $request Server request
     * @param array $options Handler options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(
        AuthorizationException $exception,
        ServerRequestInterface $request,
        array $options = []
    ): ResponseInterface {
        if (str_starts_with($request->getParam('_matchedRoute'), '/{controller}')) {
            // Return a 404 response instead of redirecting to login
            throw new NotFoundException('Controller action not found.');
        }

        // If action exists, use default redirect behavior (to login)
        return parent::handle($exception, $request, $options);
    }
}