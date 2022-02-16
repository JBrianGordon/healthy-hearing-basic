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
        $wikis = $this->paginate($this->Wikis);

        $this->set(compact('wikis'));
    }

    /**
     * View method
     *
     * @param string|null $id Wiki id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wiki = $this->Wikis->get($id, [
            'contain' => ['Users', 'TagWikis'],
        ]);

        $this->set(compact('wiki'));
    }
}
