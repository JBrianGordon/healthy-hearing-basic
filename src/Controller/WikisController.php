<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Core\Configure;

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
        $title = Configure::read('siteName')." help: Hearing loss, hearing aids, tinnitus and more";
        $this->add_title($title);
        $this->backgroundHeight = '1200px';
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
        $wiki = $this->Wikis->findBySlug($slug)->first();

        if (!$wiki) {
            return $this->redirect('/help');
        }

        $this->set(compact('wiki'));
    }
}
