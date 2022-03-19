<?php
declare(strict_types=1);

namespace App\Controller;

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
        $corps = $this->paginate($this->Corps->findByIsActiveAndIdDraftParent(1, 0));

        $this->set(compact('corps'));
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
        $corp = $this->Corps->findBySlug($slug)->first();

        if (!$corp) {
            return $this->redirect(['controller' => 'Corps', 'action' => 'index']);
        }

        $this->set(compact('corp'));
    }
}
