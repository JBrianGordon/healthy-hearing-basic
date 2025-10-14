<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

/**
 * Wikis Controller
 *
 * @property \App\Model\Table\WikisTable $Wikis
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WikisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($_SERVER['REQUEST_URI'] != Router::url(['controller'=>'wikis','action'=>'index'])) {
            // Self-heal url
            return $this->redirect(['controller'=>'wikis','action'=>'index'], 301);
        }
        $this->layout = 'simple';
        $this->meta['description'] = "Read our most comprehensive articles on the topics of hearing loss, hearing aids and tinnitus. All reviewed by our staff editors and audiologists.";
        $this->setMeta('robots', 'INDEX, FOLLOW');
        if (empty($title)) {
            $this->set('title', $this->siteName . " help: Hearing loss, hearing aids, tinnitus and more");
        }

        $this->set('articles', $this->fetchTable('Content')->findLatest(4));
        $this->set('wikis', $this->Wikis->findForIndex());
    }

    /**
     * View method
     *
     * @param string|null $slug Wiki slug.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        if (empty($slug)) {
            return $this->redirect(array('action' => 'index'), 301);
        }
        // Check for any SEO redirects
        //todo
        //$this->checkRedirect();
        $redirect = $this->Wikis->findRedirectBySlug($slug);
        if ($redirect) {
            if (Router::url($redirect) != $_SERVER['REQUEST_URI']) {
                // Self heal. Redirect to proper url.
                return $this->redirect($redirect, 301);
            }
        } else {
            // Invalid slug
            return $this->redirect(array('action' => 'index'), 301);
        }

        // TO-DO/REFACTOR LATER? If correct, findRedirectBySlug() above checks for
        // is_active === 1/true.
        // If false, it redirects to the "parent" wiki, which should mean that the
        // admin-bypass in findBySlug() can't/won't be evaluated.
        if ($wiki = $this->Wikis->findBySlug($slug, $_SERVER['REQUEST_URI'], $this->isAdmin)) {
            //set up contents for sidebar
            $tagIds = array_column($wiki->tags, 'id');
            $this->set('tags', $tagIds);
            $this->Content = $this->fetchTable('Content');

            $contents = $this->Content->findByTags($tagIds, 6);

            $this->set('contents', $contents);
            $tagname = isset($wiki->tags[0]) ? $wiki->tags[0]->name : '';
            $this->set('tagname', $tagname);
            // Is there an exclusive advertisement for these tags?
            $exclusiveAd = $this->fetchTable('Advertisements')->findAdByTags($tagIds);
            if (!empty($exclusiveAd)) {
                // Overwrite the generic ad
                $this->set('ad', $exclusiveAd);
            }

            $articles = $this->Content->findLatest(4);
            $this->set('articles', $articles);

            //set up and assign the meta tag info
            $request = env('REQUEST_URI');

            if (empty($title)) {
                $title = isset($wiki->title_head) ? $wiki->title_head : $this->siteName;

                $env = Configure::read('env');
                if (!empty($env) && $env != 'prod') {
                    $title = $env . ': ' . $title;
                }

                $this->set('title', $title);
            }

            if (!empty($wiki->short)) {
                $this->meta['description'] = $wiki->short;
            }
            $customVars['type'] = 'wiki';
            $customVars['category|2'] = $this->Wikis->tagsForCustomVar($wiki);
            $customVars['level|3'] = getWordCount($wiki->body);
            $this->set('customVars', $customVars);
            $this->set('isPreview', false);
            $this->set('wiki', $wiki);
            $this->socialOptions['og:type'] = 'article';
            $this->socialOptions['article:section'] = 'Hearing Help';
            $this->set('sameAsSocialLinks', Configure::read('sameAsSocialLinks'));
        } else {
            throw new NotFoundException();
        }
        $this->set('preferredClinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, true));
    }
}
