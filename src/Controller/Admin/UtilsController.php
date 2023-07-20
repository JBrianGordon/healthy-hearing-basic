<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Utils Controller
 *
 * @method \App\Model\Entity\Util[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UtilsController extends AppController
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
}
