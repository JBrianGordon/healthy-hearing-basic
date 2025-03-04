<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Content;
use Cake\Routing\Router;
use Cake\Mailer\MailerAwareTrait;

/**
 * Content Controller
 *
 * @property \App\Model\Table\ContentTable $Content
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentController extends BaseAdminController
{
    use MailerAwareTrait;
    
    public $paginate = [
        'order' => [
            'Content.last_modified' => 'desc',
        ],
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
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()
            ->where([
                'model' => 'Content',
            ])->toArray();

        $requestParams = $this->request->getQueryParams();

        // Last modified date range
        $hasLastmodDateRange =
            array_key_exists('last_modified_start', $requestParams) &&
            array_key_exists('last_modified_end', $requestParams);

        if ($hasLastmodDateRange) {
            $requestParams['last_mod_date_range'] =
                $requestParams['last_modified_start'] . ',' . $requestParams['last_modified_end'];
        }

        // Created date range
        $hasCreatedDateRange =
            array_key_exists('created_start', $requestParams) &&
            array_key_exists('created_end', $requestParams);

        if ($hasCreatedDateRange) {
            $requestParams['created_date_range'] =
                $requestParams['created_start'] . ',' . $requestParams['created_end'];
        }

        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
            $this->set('currentModel', 'Content');
        }

        $contentQuery = $this->Content
            ->find('search', [
                'search' => $requestParams,
            ])
            ->contain(['PrimaryAuthor']);

        $this->set('title', 'Content index');
        $this->set('content', $this->paginate($contentQuery));
        $this->set('count', $contentQuery->count());
        $this->set('authors', $this->Content->PrimaryAuthor->authorList('Content', 'Report'));
        $this->set('fields', $this->Content->getSchema()->typeMap());
        $this->set('crmSearches', $crmSearches);
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
                $this->Flash->success(__('The report has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The report could not be saved. Please, try again.'));
        }
        $this->set('title', 'Add Report');
        $this->set('tags', $this->Content->Tags->findTagList());
        $this->set('types', Content::$typeOptions);
        $this->set('authors', $this->Content->PrimaryAuthor->authorList('Content', 'Report'));
        $this->set(compact('content'));
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
        $content = null;
        if (!empty($id)) {
            $content = $this->Content->get($id, [
                'contain' => ['PrimaryAuthor', 'Contributors', 'Tags'],
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Content->patchEntity($content, $this->request->getData());
            if ($this->Content->save($content)) {
                /*** TODO: possibly add notify field for this condition ***/
				if (!empty($this->request->getData('saveForApproval'))/* && !empty($this->request->data['Content']['notify'])*/) {
                    // Send the email
                    $mailer = $this->getMailer('ContentReadyApprove');
                    $mailer->send('contentReadyApprove', [$content]);
				}
                $this->Flash->success(__('The content has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content could not be saved. Please, try again.'));
        }
        $this->set(compact('content'));
        if (!empty($content->hh_url)) {
            $seoUrlSlug =  Router::url($this->Content->findForRedirectById($id));
            $seoRedirect = $this->fetchTable('SeoRedirects')->find('all', [
                'contain' => ['SeoUris'],
                'conditions' => [
                    'SeoUris.uri' => $seoUrlSlug
                ]
            ])->first();
            $this->set('seoRedirect', $seoRedirect);
        }
        $this->set('title', 'Edit Content');
        $this->set('tags', $this->Content->Tags->findTagList());
        $this->set('types', Content::$typeOptions);
        $this->set('authors', $this->Content->PrimaryAuthor->authorList('Content', 'Report'));
    }

    public function preview($id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['Tags','PrimaryAuthor','Contributors'],
        ]);
        $this->set('content', $content);
        $this->set('isPreview', true);

        // Set the template path to the non-prefixed template
        $this->viewBuilder()->setTemplatePath('Content');
        $this->render('view');
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

    /**
     * Draft method
     *
     * @param int $id Content id.
     * @return \Cake\Http\Response|null|void Redirects to existing or newly-created Content draft.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function draft(?int $id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $draftId = $this->Content->checkForDraft($id);

        if ($draftId > 0) {
            $this->Flash->success('This report has an existing draft below.');

            return $this->redirect(['action' => 'edit', $draftId]);
        }

        $newDraft = $this->Content->copy($id);

        return $this->redirect(['action' => 'edit', $newDraft->id]);
    }

    /** DO WE NEED A PUBLISH CONTROLLER ACTION - ONLY PUBLISH BY CRON JOB/SCRIPT? **/
    /**
     * Publish method
     *
     * @param int $id Content draft id.
     * @return \Cake\Http\Response|null|void Redirects to existing or newly-created Content draft.
     */
    public function publish(int $id)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->Flash->success('Republish successful!');

        return $this->redirect(['action' => 'edit', 1]);
    }

    /**
    * Export content data to CSV
    */
    function export() {
        $this->autoRender = false;
        $requestParams = $this->request->getQueryParams();

        $this->Export->setIgnoreFields(['body', 'bodyclass']);
        $this->Export->setAdditionalFields(['hh_url']);
        $this->Export->exportCsv('export_reports.csv');
        die();
    }
}
