<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

/**
 * Seo helper
 */
class SeoHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        $this->SeoMetaTags = TableRegistry::get('SeoMetaTags');
    }

    /**
    * Show the meta tags designated for this uri
    * @param array of name => content meta tags to merge with giving priority to SEO meta tags
    * @return string of meta tags to show.
    */
    function metaTags() {
        $request = env('REQUEST_URI');
        $retval = "";
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
        $metaData = $this->getView()->get('meta');
        foreach ($seoMetaTags as $tag) {
            if (isset($metaData[$tag->name])) {
                unset($metaData[$tag->name]);
            }
            $data = array();
            if ($tag->is_http_equiv) {
                $data['http-equiv'] = $tag->name;
            } else {
                $data['name'] = $tag->name;
            }
            $data['content'] = $tag->content;
            $retval .= $this->Html->meta($data, null, ['block'=>true])."\n";
        }

        if (!empty($metaData)) {
            foreach ($metaData as $name => $content) {
                $retval .= $this->Html->meta(['name' => $name, 'content' => $content], null, ['block'=>true])."\n";
            }
        }
        return $retval;
    }

    function socialOptions() {
        $retval = "";
        $socialOptions = $this->getView()->get('socialOptions');
        foreach ($socialOptions as $name => $content) {
            $retval .= $this->Html->meta(['property' => $name, 'content' => $content], null, ['block'=>'socialOptions'])."\n";
        }
        return $retval;
    }

    function prefetches() {
        $retval = "";
        $prefetches = $this->getView()->get('prefetches');
        foreach ($prefetches as $content) {
            $retval .= $this->Html->tag('link', '', [
                'rel' => 'dns-prefetch',
                'href' => $content
            ])."\n";
        }
        return $retval;
    }
}
