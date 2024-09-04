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
class CallSourcesController extends BaseAdminController
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

        $this->loadComponent('Export', [
            'actions' => ['export']
        ]);

        $this->loadComponent('PersistQueries', [
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
            $this->set('currentModel', 'CallSources');
        }

        $fieldsToCheck = ['q', 'phone_number', 'target_number', 'clinic_number'];

        foreach ($fieldsToCheck as $field) {
            if (isset($requestParams[$field])) {
                $requestParams[$field] = preg_replace('/\D/', '', $requestParams[$field]); // Remove non-numeric characters
            }
        }

        $callSourcesQuery = $this->CallSources
            ->find('search', [
                'search' => $requestParams,
            ]);

        $this->set('title', 'Call Sources Index');
        $this->set('callSources', $this->paginate($callSourcesQuery));
        $this->set('count', $callSourcesQuery->count());
        $this->set('fields', $this->CallSources->getSchema()->typeMap());
    }

    /**
    * Export a list of calls to CSV
    */
    function export() {
        $this->autoRender = false;
        $requestParams = $this->request->getQueryParams();

        //$this->Export->setIgnoreFields();
        //$this->Export->setAdditionalFields();
        //$this->Export->setOverwriteLabels();
        $this->Export->exportCsv('export_call_sources.csv');
        die();
    }
}
