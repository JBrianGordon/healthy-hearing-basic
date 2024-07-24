<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * Content Controller
 *
 * @property \App\Model\Table\ContentTable $Content
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentController extends AppController
{
    public $paginate = [
        'limit' => 15,
        'order' => [
            'Content.last_modified' => 'DESC',
        ],
        'fields' => [
            'Content.title',
            'Content.slug',
            'Content.short',
            'Content.date',
            'Content.created',
            'Content.modified',
            'Content.last_modified',
            'Content.id',
            'Content.type',
            'Content.is_active',
            'Content.facebook_image',
            'Content.facebook_image_alt',
        ],
    ];

    /**
     * ReportIndex method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @todo Create custom finder for is_active and published articles
     */
    public function reportIndex()
    {
        if (!Configure::read('showReports')) {
            return $this->throw404NotFound();
        }
        //if we pass in anything, mark as 301 to root
        // TODO: DO WE NEED THIS?
        //if ($ignore !== null) {
        //    $redirect = array('action' => 'report_index');
        //    if (isset($this->request->named['page'])) {
        //        $redirect['page'] = $this->request->named['page'];
        //    }
        //    $this->redirect($redirect, 301);
        //}
        $page = $this->request->getQuery('page');
        $ext = $this->request->getParam('_ext');
        $properUrl = Router::url(['prefix'=>false, 'controller'=>'content', 'action'=>'report_index', '?'=>['page'=>$page], '_ext'=>$ext]);
        if ($_SERVER['REQUEST_URI'] != $properUrl) {
            // Self heal url. Redirect to proper format.
            $this->redirect($properUrl, 301);
        }
        $render = 'report_index';
        if ($ext == 'rss') {
            $this->paginate['limit'] = 480;
            // TODO: The rss index template doesn't exist yet
            $render = 'index';
        }
        $paginateSettings = [
            'conditions' => [
                'Content.is_active' => true,
                'Content.last_modified <= CURDATE()'
            ]
        ];
        try {
            $reports = $this->paginate('Content', $paginateSettings);
        } catch(Exception $e) {
            // Page number no longer exists. Redirect to page 1.
            $this->redirect(['prefix'=>false, 'controller'=>'content', 'action'=>'report_index', '_ext'=>$ext], 301);
        }
        if (empty($reports)) {
            $this->redirect(['prefix'=>false, 'controller'=>'content', 'action'=>'report_index', '_ext'=>$ext], 301);
        }
        //Add Title
        $title = "The Healthy Hearing Report";
        $pageDescription = !empty($page) ? "page " . $page . " of " : "";
        $this->meta['description'] = "Browse $pageDescription Healthy Hearing's latest news, articles, and information on hearing loss, hearing aids and hearing clinics from around the US.";
        $this->add_title($title);
        $this->socialOptions['og:updated_time'] = date('Y-m-d 06:00:00', strtotime('today'));
        $this->set('reports', $reports);
        $this->set('preferredClinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, true));
        $this->set('reportIntro', $this->fetchTable('Pages')->getContent('reportIntro'));
        $this->set('articles', $this->Content->findLatest(4));

        return $this->render($render);
    }

    /**
     * View method
     *
     * @param int|null $id Content id.
     * @param string|null $slug Content slug
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $slug = null)
    {
        if (!Configure::read('showReports')) {
            return $this->throw404NotFound();
        }
        if (!is_numeric($id)) {
            // Is there a numeric id within the id string?
            if (preg_match('/[0-9]{2,}/', $id, $matches) == 1) {
                $id = $matches[0];
            }
        }
        if (empty($id) || !is_numeric($id)) {
            return $this->response = $this->response->withStatus(410);
        }

        $content = $this->Content->findByIdSlug($id, $_SERVER['REQUEST_URI']);
        if (empty($content)) {
            if ($redirect = $this->Content->findForRedirectById($id)) {
                if ($_SERVER['REQUEST_URI'] != Router::url($redirect) && $this->Content->isActive($id)) {
                    return $this->redirect($redirect, 301);
                }
            }
            return $this->throw404NotFound();
        }
        if ($content->is_gone) {
            return $this->throw410Gone();
        }

        //set up and assign the meta tag info
        $request = env('REQUEST_URI');

        $this->SeoMetaTags = $this->fetchTable('SeoMetaTags');
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
        $this->set('seoMetaTags', $seoMetaTags);

        $this->SeoTitles = $this->fetchTable('SeoTitles');
        $seoTitle = $this->SeoTitles->findTitleByUri($request);
        $this->set('seoTitle', $seoTitle);

        $this->add_title($content->title_head);
        $this->meta['description'] = (isset($this->meta['description']) ? $this->meta['description'] : null);
        $this->meta['description'] = (!empty($content['Content']['meta_description']) ? $content['Content']['meta_description'] : $this->meta['description']);
        $this->socialOptions['og:type'] = 'article';
        $this->socialOptions['article:section'] = 'HH Report';

        //Prefetches
        $this->prefetches[] = '//connect.facebook.com';
        $this->prefetches[] = '//fbstatic-a.akamaihd.net';
        $this->prefetches[] = '//s-static.ak.facebook.com';
        $this->prefetches[] = '//static.ak.facebook.com';
        $this->prefetches[] = '//www.facebook.com';

        $customVars['type'] = $content->type . '-' . date('Y-m-d', $content->last_modified->timestamp);
        $customVars['category|2'] = $this->Content->tagsForCustomVar($content);
        $customVars['level|3'] = getWordCount($content->body);

        // Is there an exclusive advertisement for this content?
        $tagIds = array_column($content->tags, 'id');
        $exclusiveAd = $this->fetchTable('Advertisements')->findAdByTags($tagIds);
        if (!empty($exclusiveAd)) {
            // Overwrite the generic ad
            $this->set('ad', $exclusiveAd);
        }

        $this->set('wikis', $this->Content->findWikisById($id));
        $this->set('show_header', false);
        $this->set('content', $content);
        $this->set('customVars', $customVars);
        $this->set('cont', $content);
        $this->set('id', $id);
        $this->set('slug', $slug);
        $this->set('isPreview', false);
        $this->set('sameAsSocialLinks', Configure::read('sameAsSocialLinks'));
        $this->set('preferredClinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, true));
        $this->set('articles', $this->Content->findLatest(4));
    }
}
