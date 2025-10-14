<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\GoneException;
use Cake\Http\Response;

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

        // Check for 410
        if ($seoUrl && $seoUrl->is_410) {
            throw new GoneException();
        }

        // Check for redirect
        if ($seoUrl->redirect_is_active && isset($seoUrl->redirect_url)) {
            return (new Response())->withStatus(301)->withHeader('Location', $seoUrl->redirect_url);
        }

        // Attach SEO data as a namespaced array
        if ($seoUrl) {
            $seoData = [];

            if (!empty($seoUrl->seo_title)) {
                $seoData['title'] = $seoUrl->seo_title;
            }

            if (!empty($seoUrl->seo_meta_description)) {
                $seoData['metaDescription'] = $seoUrl->seo_meta_description;
            }

            if (!empty($seoData)) {
                $request = $request->withAttribute('seo', $seoData);
            }
        }


        return $handler->handle($request);
    }
}
