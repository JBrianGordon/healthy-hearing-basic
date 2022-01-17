<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Content Controller
 *
 * @property \App\Model\Table\ContentTable $Content
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public $paginate = [
        'limit' => 50,
        'order' => [
            'Content.modified' => 'DESC'
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
            'Content.is_active'
        ]
    ];

    public function reportIndex()
    {
        $reports = $this->Content
            ->find('all')
            ->where(['is_active' => 1]);
        $this->set('reports', $this->paginate($reports));
        // $reports = $this->paginate(
        //     $this->Content
        //         ->find('all')
        //         ->where(['is_active' => 1])
        // );
        // $this->set(compact('reports'));
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $content = $this->paginate($this->Content);

        $this->set(compact('content'));
    }

    /**
     * View method
     *
     * @param string|null $id Content id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['Users', 'Locations', 'Tags'],
        ]);

        $this->set(compact('content'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $content = $this->Content->newEmptyEntity();
        if ($this->request->is('post')) {
            $content = $this->Content->patchEntity($content, $this->request->getData());
            if ($this->Content->save($content)) {
                $this->Flash->success(__('The content has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content could not be saved. Please, try again.'));
        }
        $users = $this->Content->Users->find('list', ['limit' => 200])->all();
        $locations = $this->Content->Locations->find('list', ['limit' => 200])->all();
        $tags = $this->Content->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('content', 'users', 'locations', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['Users', 'Locations', 'Tags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Content->patchEntity($content, $this->request->getData());
            if ($this->Content->save($content)) {
                $this->Flash->success(__('The content has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content could not be saved. Please, try again.'));
        }
        $users = $this->Content->Users->find('list', ['limit' => 200])->all();
        $locations = $this->Content->Locations->find('list', ['limit' => 200])->all();
        $tags = $this->Content->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('content', 'users', 'locations', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $content = $this->Content->get($id);
        if ($this->Content->delete($content)) {
            $this->Flash->success(__('The content has been deleted.'));
        } else {
            $this->Flash->error(__('The content could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
