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
            'Content.modified' => 'DESC',
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

        return $this->render($render);
    }

    /**
     * View method
     *
     * @param int|null $id Content id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?int $id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['PrimaryAuthor', 'Contributors'],
        ]);
        $this->set(compact('content'));
    }
}
