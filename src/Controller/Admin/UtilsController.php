<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Http\Session\Session;

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
}
