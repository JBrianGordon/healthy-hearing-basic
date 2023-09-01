<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Providers Controller
 *
 * @property \App\Model\Table\ProvidersTable $Providers
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProvidersController extends AppController
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
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $requestParams = $this->request->getQueryParams();

        // Last modified date range
        $hasLastmodDateRange =
            array_key_exists('modified_start', $requestParams) &&
            array_key_exists('modified_end', $requestParams);

        if ($hasLastmodDateRange) {
            $requestParams['mod_date_range'] =
                $requestParams['modified_start'] . ',' . $requestParams['modified_end'];
        }

        // Created date range
        $hasCreatedDateRange =
            array_key_exists('created_start', $requestParams) &&
            array_key_exists('created_end', $requestParams);

        if ($hasCreatedDateRange) {
            $requestParams['created_date_range'] =
                $requestParams['created_start'] . ',' . $requestParams['created_end'];
        }

        $providerQuery = $this->Providers
            ->find('search', [
                'search' => $requestParams,
            ])
            ->contain(['Locations']);
        $this->set('fields', $this->Providers->getSchema()->typeMap());
        $this->set('providers', $this->paginate($providerQuery));
    }

    public function duplicateEmailProvidersCsv()
    {
        $query = $this->Providers->find();
        $duplicateEmails = $query
            ->select([
                'email',
                'count' => $query->func()->count('*')]
            )
            ->group(['email'])
            ->order(['count' => 'DESC'])
            ->all()
            ->skip(2); // Removes the first two rows which have summed values from the COUNT operation.

        $this->setResponse($this->getResponse()->withDownload('duplicateEmailProviders.csv'));

        $this->set(compact('duplicateEmails'));

        $this->viewBuilder()
            ->setClassName('CsvView.Csv')
            ->setOption('serialize', 'duplicateEmails');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $provider = $this->Providers->newEmptyEntity();
        if ($this->request->is('post')) {
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('The provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The provider could not be saved. Please, try again.'));
        }
        $locations = $this->Providers->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('provider', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => ['Locations'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('The provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The provider could not be saved. Please, try again.'));
        }
        $locations = $this->Providers->Locations->find('list')->all();
        $this->set(compact('provider', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provider = $this->Providers->get($id);
        if ($this->Providers->delete($provider)) {
            $this->Flash->success(__('The provider has been deleted.'));
        } else {
            $this->Flash->error(__('The provider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
