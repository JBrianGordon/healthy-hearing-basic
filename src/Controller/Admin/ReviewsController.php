<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Log\LogTrait;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{
    use LogTrait;

    public $paginate = [
        'limit' => 50,
        'order' => ['created' => 'desc'],
        'contain' => ['Zips', 'Locations'],
    ];

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
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()
            ->where([
                'model' => 'Reviews',
            ])->toArray();

        $requestParams = $this->request->getQueryParams();

        // Last modified date range
        $hasModifiedDateRange =
            array_key_exists('modified_start', $requestParams) &&
            array_key_exists('modified_end', $requestParams);

        if ($hasModifiedDateRange) {
            $requestParams['modified_date_range'] =
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

        // Denied date range
        $hasDeniedDateRange =
            array_key_exists('denied_date_start', $requestParams) &&
            array_key_exists('denied_date_end', $requestParams);

        if ($hasDeniedDateRange) {
            $requestParams['denied_date_range'] =
                $requestParams['denied_date_start'] . ',' . $requestParams['denied_date_end'];
        }

        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
            $this->set('currentModel', 'Reviews');
        }

        $reviewsQuery = $this->Reviews
            ->find('search', [
                'search' => $requestParams,
            ]);

        $this->set('reviews', $this->paginate($reviewsQuery));
        $this->set('fields', $this->Reviews->getSchema()->typeMap());
        $this->set('crmSearches', $crmSearches);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $review = $this->Reviews->newEmptyEntity();
        if ($this->request->is('post')) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $locations = $this->Reviews->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('review', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity(
                $review,
                $this->request->getData(),
                // [
                //     'fields' => ['body', 'first_name'] // TO-DO: UPDATE 'FIELDS'
                // ]
            );
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }

        $ipMatches = $this->Reviews->findIpMatches($review->id);

        $this->set(compact('review', 'ipMatches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Ignore method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function ignore($id = null)
    {
        $this->request->allowMethod(['post', 'ignore']);
        if ($this->Reviews->ignore($id)) {
            $this->Flash->success(__('The review has been ignored.'));
        } else {
            $this->Flash->error(__('The review could not be ignored. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Approve method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function approve($id = null)
    {
        $this->request->allowMethod(['post']);
        if ($this->Reviews->approve($id)) {
            $this->Flash->success(__('Review approved.'));
        } else {
            $this->Flash->error(__('Review was not approved. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Deny method (approve negative review)
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deny($id = null)
    {
        $this->request->allowMethod(['post']);
        if ($this->Reviews->deny($id)) {
            $this->Flash->success(__('Negative review approved.'));
        } else {
            $this->Flash->error(__('Negative review was not approved. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Spam-marking method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function spam($id = null)
    {
        $this->request->allowMethod(['post']);

        $review = $this->Reviews->get($id);
        $review->is_spam = true;

        if ($this->Reviews->save($review)) {
            $this->Flash->success(__('Review marked as spam.'));
        } else {
            $this->Flash->error(__('Review was not marked as spam. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Multiple review approval method
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function approveAll()
    {
        $this->request->allowMethod(['post']);

        $ids = $this->request->getData('ids');

        try {
            $this->Reviews->approveAll($ids);
        } catch (PersistenceFailedException $e) {
            $this->log($e->getMessage(), 'error');
            $this->Flash->error(
                'Unable to approve selected reviews. Please contact a developer for assistance in troubleshooting.'
            );

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->success('Selected review(s) approved.');

        return $this->redirect(['action' => 'index']);
    }
}
