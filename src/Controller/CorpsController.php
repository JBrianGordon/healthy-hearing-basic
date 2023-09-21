<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Routing\Router;
use Cake\Core\Configure;

/**
 * Corps Controller
 *
 * @property \App\Model\Table\CorpsTable $Corps
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorpsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if (!Configure::read('showManufacturers')) {
            return $this->throw404NotFound();
        }
        if ($_SERVER['REQUEST_URI'] != Router::url(['controller'=>'corps','action'=>'index'])) {
            // Self-heal url
            return $this->redirect(['controller'=>'corps','action'=>'index'], 301);
        }
        $this->pageTitle = 'Hearing aid and cochlear implant companies';
        $this->meta['description'] = "Before buying hearing aids or cochlear implants, it is wise to compare hearing aid manufacturers. Learn more about them here.";
        $this->Content = $this->fetchTable('Content');
        $exclusiveAd = $this->fetchTable('Advertisements')->findAdForCorps();
        if (!empty($exclusiveAd)) {
            // Overwrite the generic ad
            $this->set('ad', $exclusiveAd);
        }
        $corps = $this->Corps->find('all', [
            'conditions' => ['is_active' => 1],
            'order' => ['priority' => 'ASC', 'title' => 'ASC'],
        ])->all();
        $this->set('corps', $corps);
        $this->set('pageContent', $this->fetchTable('Pages')->getContent('manufacturers'));
        $this->set('preferredClinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, true));
        
        $articles = $this->Content->findLatest(4);
        $this->set('articles', $articles);
    }

    /**
     * View method
     *
     * @param string|null $slug Corp slug.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        if (!Configure::read('showManufacturers')) {
            return $this->throw404NotFound();
        }
        $corp = $this->Corps->findBySlug($slug);
        $this->Content = $this->fetchTable('Content');
        $this->set('corp', $corp);

        if (empty($corp)) {
            // This slug did not match an existing corp. Try finding something similar.
            $similarCorp = $this->Corps->find('all', [
                'conditions' => [
                    'is_active' => true,
                    'slug LIKE' => '%'.$slug.'%'
                ],
                'order' => ['priority' => 'ASC']
            ])->first();
            $similarSlug = $similarCorp->slug;
            if (!empty($similarSlug) && $similarSlug != $slug) {
                return $this->redirect("/$similarSlug", 301);
            } else {
                // No similar slug found
                $this->catch404();
                if (http_response_code() != '200') {
                    // A redirect or status code was found
                    return;
                }
                // This was an old corp that is no longer active, and has no specific redirect defined.
                // Redirect to the main Hearing Aid Manufacturers page with no errors displayed.
                return $this->redirect(['action' => 'index'], 301);
            }
        }

        if ($_SERVER['REQUEST_URI'] != Router::url(['controller'=>'corps','action'=>'view','slug'=>$slug])) {
            // Self heal url. Redirect to proper url format.
            return $this->redirect(['controller'=>'corps','action'=>'view','slug'=>$slug], 301);
        }

        // Is there an exclusive advertisement for corp pages?
        $exclusiveAd = $this->fetchTable('Advertisements')->findAdForCorps();
        if (!empty($exclusiveAd)) {
            // Overwrite the generic ad
            $this->set('ad', $exclusiveAd);
        }

        //set up and assign the meta tag info
        $request = env('REQUEST_URI');

        $this->SeoMetaTags = $this->fetchTable('SeoMetaTags');
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
        $this->set('seoMetaTags', $seoMetaTags);

        $this->SeoTitles = $this->fetchTable('SeoTitles');
        $seoTitle = $this->SeoTitles->findTitleByUri($request);
        $this->set('seoTitle', $seoTitle);

        $articles = $this->Content->findLatest(4);
        $this->set('articles', $articles);

        $customVars['type'] = 'manuf';
        $customVars['level|3'] = getWordCount($corp->description);
        $this->meta['description'] = $corp->short;
        $this->socialOptions['og:type'] = 'article';
        $this->socialOptions['article:section'] = 'Hearing Aid (Manufacturers|Products)';
        $this->set('customVars', $customVars);
        $this->set('isPreview', false);
        $this->set('preferredClinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, true));
    }
}
