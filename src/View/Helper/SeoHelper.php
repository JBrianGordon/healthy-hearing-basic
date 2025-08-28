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
    function metaTags($metaData = array()) {
        $request = env('REQUEST_URI');
        $retval = "";
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
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
            $retval .= $this->Html->meta($data)."\n";
        }

        if (!empty($metaData)) {
            foreach ($metaData as $name => $content) {
                $retval .= $this->Html->meta(array('name' => $name, 'content' => $content))."\n";
            }
        }
        return $retval;
    }
}
