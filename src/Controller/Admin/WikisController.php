<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Wikis;

/**
 * Wikis Controller
 *
 * @property \App\Model\Table\WikisTable $Wikis
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WikisController extends BaseAdminController
{

    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);

        $this->loadComponent('PersistQueries', [
            'actions' => ['index'],
        ]);
    }

    public $paginate = [
        'order' => [
            'Wikis.priority' => 'ASC',
        ],
    ];
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $requestParams = $this->request->getQueryParams();
        $wikiQuery = $this->Wikis
            ->find('search', [
                'search' => $requestParams,
            ]);

        $this->set('title', 'Help index');
        $this->set('wikis', $this->paginate($wikiQuery));
        $this->set('count', $wikiQuery->count());

        $this->set('fields', $this->Wikis->getAdvSearchFields());
        $this->set('authors', $this->Wikis->Author->authorList());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wiki = $this->Wikis->newEmptyEntity();
        if ($this->request->is('post')) {
            $wiki = $this->Wikis->patchEntity($wiki, $this->request->getData());

            if ($this->Wikis->save($wiki)) {
                $this->Flash->success(__('The wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wiki could not be saved. Please, try again.'));
        }
        $authors = $this->Wikis->Author->authorList();
        $this->set('title', 'Add Help Page');
        $this->set(compact('wiki', 'authors'));
        $this->set('tags', $this->Wikis->Tags->findTagList());
        $this->set('reviewers', $this->Wikis->Author->reviewerList());
    }

    /**
     * Edit method
     *
     * @param string|null $id Wiki id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wiki = $this->Wikis->get($id, [
            'contain' => ['Author', 'Contributors', 'Reviewers', 'Tags'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $wiki = $this->Wikis->patchEntity($wiki, $this->request->getData());

            if ($this->Wikis->save($wiki)) {
                $this->Flash->success(__('The wiki has been saved.'));

                return $this->redirect(['action' => 'edit', $wiki->id]);
            }
            $this->Flash->error(__('The wiki could not be saved. Please, try again.'));
        }
        $authors = $this->Wikis->Author->authorList();
        $this->set('title', 'Edit Help Page');
        $this->set(compact('wiki', 'authors'));
        $this->set('tags', $this->Wikis->Tags->findTagList());
        $this->set('reviewers', $this->Wikis->Author->reviewerList());
    }

    public function preview($id = null)
    {
        $wiki = $this->Wikis->get($id, [
            'contain' => ['Author'],
        ]);
        $this->set('wiki', $wiki);
        $this->set('isPreview', true);

        // Set the template path to the non-prefixed template
        $this->viewBuilder()->setTemplatePath('Wikis');
        $this->render('view');
    }

    /**
     * Delete method
     *
     * @param string|null $id Wiki id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wiki = $this->Wikis->get($id);
        if ($this->Wikis->delete($wiki)) {
            $this->Flash->success(__('The wiki has been deleted.'));
        } else {
            $this->Flash->error(__('The wiki could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Draft method
     *
     * @param int $id Wikis id.
     * @return \Cake\Http\Response|null|void Redirects to existing or newly-created Wikis draft.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function draft(?int $id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $draftId = $this->Wikis->checkForDraft($id);

        if ($draftId > 0) {
            $this->Flash->success('This Help page has an existing draft below.');

            return $this->redirect(['action' => 'edit', $draftId]);
        }

        $newDraft = $this->Wikis->copy($id);

        return $this->redirect(['action' => 'edit', $newDraft->id]);
    }
}
