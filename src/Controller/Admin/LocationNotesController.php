<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * LocationNotes Controller
 *
 * @property \App\Model\Table\LocationNotesTable $LocationNotes
 * @method \App\Model\Entity\LocationNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationNotesController extends BaseAdminController
{
    /**
     * Delete method
     *
     * @param string|null $id Location Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationNote = $this->LocationNotes->get($id);
        $locationId = $locationNote->location_id;
        if ($this->LocationNotes->delete($locationNote)) {
            $this->Flash->success(__('The note has been deleted.'));
        } else {
            $this->Flash->error(__('The note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'locations', 'action' => 'edit', $locationId, '#' => 'Notes']);
    }
}
