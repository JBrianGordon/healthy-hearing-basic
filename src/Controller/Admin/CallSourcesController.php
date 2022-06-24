<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CallSources Controller
 *
 * @property \App\Model\Table\CallSourcesTable $CallSources
 * @method \App\Model\Entity\CallSource[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CallSourcesController extends AppController
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
        $this->paginate = [
            'contain' => ['Locations'],
        ];
        $requestParams = $this->request->getQueryParams();
        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
        }
        $callSourcesQuery = $this->CallSources
            ->find('search', [
                'search' => $requestParams,
            ]);
        $this->set('callSources', $this->paginate($callSourcesQuery));
        $this->set('fields', $this->CallSources->getSchema()->typeMap());
    }
}
