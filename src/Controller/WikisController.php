<?php
declare(strict_types=1);

namespace App\Controller;

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
        $wikis = $this->paginate($this->Wikis->findByIsActive(1));

        $this->set(compact('wikis'));
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
