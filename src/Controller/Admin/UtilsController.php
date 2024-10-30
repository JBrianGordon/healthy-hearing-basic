<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Http\Session\Session;
use Cake\Core\Configure;
use CakeDC\Users\Plugin;

/**
 * Utils Controller
 *
 * @method \App\Model\Entity\Util[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UtilsController extends BaseAdminController
{
    /**
     * Panel method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function panel()
    {
    }

    public function inlineajax() {
        if ($this->request->is('ajax')) {
            list($model, $field, $id) = explode("|", $this->request->getData('id'));
            if ($model && $field && $id) {
                $value = $this->request->getData('value');
                $modelTable = TableRegistry::get($model);
                $entity = $modelTable->get($id);
                $entity->$field = $value;
                $modelTable->save($entity);
                echo $value;
            }
            exit();
        }
        die('Do not access directly');
    }

    public function cache(){
        ini_set('max_execution_time', 600);
        $Folder = new Folder(CACHE);
        $files = $Folder->find('[a-zA-Z0-9_\-]+');
        $this->set('files', $files);
    }

    public function cacheView($key = null){
        $file = CACHE . $key;
        $contents = file_get_contents($file);
        $this->set('title', 'View Cache');
        $this->set('key', $key);
        $this->set('cache_contents', $contents);
    }

    public function cacheDelete($key = null){
        $file = CACHE . $key;
        if(strpos($file, '..') === false && file_exists($file) && unlink($file)){
            $this->Flash->success($key . ' Cleared.');
        } else {
            $this->Flash->danger('Error clearing cache: ' . $key);
        }
        return $this->redirect(['admin' => true, 'action' => 'cache']);
    }

    public function clearSession() {
        // Get the session
        $session = $this->getRequest()->getSession();
        $session->delete('zip');
        $this->Flash->success('Session Data Deleted.');
        return $this->redirect("/admin");
    }

    public function queuedJobs() {
        $this->QueuedJobs = TableRegistry::get('Queue.QueuedJobs');
        $queryParams = $this->request->getQueryParams();
        $archived = empty($queryParams['archived']) ? false : true;
        if ($archived) {
            $conditions = ['completed IS NOT NULL'];
        } else {
            $conditions = ['completed IS NULL'];
        }
        $queuedJobsQuery = $this->QueuedJobs->find('all', [
            'conditions' => $conditions,
            'contain' => []
        ]);
        $queuedJobs = $this->paginate($queuedJobsQuery);
        $this->set('title', 'Queued Jobs');
        $this->set('queuedJobs', $queuedJobs);
        $this->set('count', $queuedJobsQuery->count());
        $this->set('archived', $archived);
    }

    /**
     * Run a queued job
     */
    public function runQueuedJobs() {
        $this->QueuedJobs = TableRegistry::get('Queue.QueuedJobs');
        exec('cd '.ROOT.' && bin/cake queue run', $output);
        $output = r_implode('<br>', $output);
        $output = 'Queued jobs ran<br><br>'.$output;
        $options['escape'] = false;
        $this->Flash->success($output, $options);
        return $this->redirect(['admin' => true, 'action' => 'queuedJobs']);
    }

    /**
     * View a queued job
     */
    public function viewQueuedJob($id = null) {
        $this->QueuedJobs = TableRegistry::get('Queue.QueuedJobs');
        if (!$this->QueuedJobs->exists($id)) {
            throw new NotFoundException(__('Invalid queue task'));
        }
        $queuedJob = $this->QueuedJobs->get($id);
        $this->set('title', 'Queued Job');
        $this->set('queuedJob', $queuedJob);
    }

    /**
     * Delete method
     *
     * @param int|null $id Queued Job id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function deleteQueuedJob($id = null) {
        $this->QueuedJobs = TableRegistry::get('Queue.QueuedJobs');
        $this->request->allowMethod(['post', 'delete']);
        $queuedJob = $this->QueuedJobs->get($id);
        if ($this->QueuedJobs->delete($queuedJob)) {
            $this->Flash->success('The queued job has been deleted.');
        } else {
            $this->Flash->error('The queued job could not be deleted. Please try again.');
        }

        return $this->redirect(['action' => 'queuedJobs']);
    }
}
