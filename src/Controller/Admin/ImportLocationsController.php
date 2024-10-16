<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * ImportLocations Controller
 *
 * @property \App\Model\Table\ImportLocationsTable $ImportLocations
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportLocationsController extends BaseAdminController
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

        $this->paginate = [
            'order' => ['ImportLocations.id' => 'DESC']
        ];
    }
    /**
     * Index method - Dashboard
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $requestParams = $this->request->getQueryParams();
        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
            $this->set('currentModel', 'ImportLocations');
        }
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()->where(['model' => 'ImportLocations'])->toArray();

        // Import type: All, YHN, CQP
        $selectedImportType = isset($requestParams['Imports']['type']) ? $requestParams['Imports']['type'] : 'all';
        // Filter: All, Unlinked, Review Needed, Reviewed
        $selectedFilter = isset($requestParams['filter']) ? $requestParams['filter'] : 'all';

        // Only show the most recent import(s) - unless import_id is specified
        if (!isset($requestParams['import_id'])) {
            $importId = $this->ImportLocations->Imports->getLatestImportId();
            $imports = [$importId];
            if (Configure::read('isCqpImportEnabled')) {
                $cqpImportId = $this->ImportLocations->Imports->getLatestCqpImportId();
                if (!empty($cqpImportId)) {
                    if ($selectedImportType == 'cqp') {
                        // Display CQP imports only
                        $imports = [$cqpImportId];
                    } elseif ($selectedImportType == 'all') {
                        // Display all import types
                        $imports[] = $cqpImportId;
                    }
                }
            }
            $requestParams['import_id'] = $imports;
        }
        $typeSearch = $this->ImportLocations->typeSearch($selectedFilter);
        $requestParams = array_merge($requestParams, $typeSearch);
        unset($requestParams['filter']);
        $importLocationsQuery = $this->ImportLocations->find('search', [
            'search' => $requestParams,
            'contain' => [
                'Imports',
                'Locations' => ['fields' => ['is_junk', 'review_needed']]
            ]
        ]);
        $importLocations = $this->paginate($importLocationsQuery);
        // Set to current index page with any applied filters
        $this->request->getSession()->write('importIndexReferer', Router::url());
        $this->set('title', 'Import Locations Index');
        $this->set('importLocations', $importLocations);
        $this->set('selectedImportType', $selectedImportType);
        $this->set('selectedFilter', $selectedFilter);
        $this->set('crmSearches', $crmSearches);
        $this->set('fields', $this->ImportLocations->getSchema()->typeMap());
        $this->set('count', $importLocationsQuery->count());
    }
}
