<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Utility\CKBoxUtility;

/**
 * Advertisements Controller
 *
 * @property \App\Model\Table\AdvertisementsTable $Advertisements
 * @method \App\Model\Entity\Advertisement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdvertisementsController extends AppController
{
    public $paginate = [
        'order' => [
            'modified' => 'desc',
        ],
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $advertisements = $this->paginate($this->Advertisements);

        $this->set(compact('advertisements'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $advertisement = $this->Advertisements->newEmptyEntity();

        if ($this->request->is('post')) {
            $uploadedImage = $this->request->getUploadedFile('image');

            $ckBoxApi = new CKBoxUtility();
            $response = $ckBoxApi->uploadImage($uploadedImage);

            $requestData = $this->request->getData();

            $advertisement = $this->Advertisements->patchEntity($advertisement, $this->request->getData());
            $advertisement->src = $response['imageUrls']['default'];

            if ($this->Advertisements->save($advertisement)) {
                $this->Flash->success(__('The advertisement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
        }
        $this->set(compact('advertisement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Advertisement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $advertisement = $this->Advertisements->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $advertisement = $this->Advertisements->patchEntity($advertisement, $this->request->getData());
            if ($this->Advertisements->save($advertisement)) {
                $this->Flash->success(__('The advertisement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
        }
        $this->set(compact('advertisement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Advertisement id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $advertisement = $this->Advertisements->get($id);
        if ($this->Advertisements->delete($advertisement)) {
            $this->Flash->success(__('The advertisement has been deleted.'));
        } else {
            $this->Flash->error(__('The advertisement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
