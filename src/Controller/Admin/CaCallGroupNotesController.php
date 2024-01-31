<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CaCallGroups Controller
 *
 * @property \App\Model\Table\CaCallGroupsTable $CaCallGroups
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallGroupNotesController extends BaseAdminController
{
    /**
     * Delete method
     *
     * @param string|null $id Ca Call Group Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $caCallGroupNote = $this->CaCallGroupNotes->get($id);
        if ($this->CaCallGroupNotes->delete($caCallGroupNote)) {
            $this->Flash->success('Note deleted');
        } else {
            $this->Flash->error('Note was not deleted');
        }
        return $this->redirect(['controller' => 'ca_call_groups', 'prefix' => 'Admin', 'action' => 'edit', $caCallGroupNote->ca_call_group_id]);
    }
}
