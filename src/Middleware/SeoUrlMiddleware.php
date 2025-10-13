<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\GoneException;

/**
 * SeoUrl middleware
 */
class SeoUrlMiddleware implements MiddlewareInterface
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
        $path = $request->getUri()->getPath();

        $seoUrlsTable = TableRegistry::getTableLocator()->get('SeoUrls');

        $seoUrl = $seoUrlsTable->find()
            ->where(['url' => $path])
            ->first();

        if ($seoUrl && $seoUrl->is_410) {
            throw new GoneException();
        }

        return $handler->handle($request);
    }
}
