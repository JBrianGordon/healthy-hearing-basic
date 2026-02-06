<?php
declare(strict_types=1);

namespace App\Controller\Clinic;

class LocationEmailsController extends BaseClinicController
{
    /**
     * Delete method
     *
     * @param string|null $id Location Email id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $locationEmail = $this->LocationEmails->get($id);
        $locationId = $locationEmail->location_id;
        $email = $locationEmail->email;
        if ($this->LocationEmails->delete($locationEmail)) {
            $this->Flash->success('The email '.$email.' has been deleted.');
        } else {
            $this->Flash->error(__('The email could not be deleted. Please, try again.'));
        }
        return $this->redirect(['clinic' => true, 'controller' => 'users', 'action' => 'account', $locationId]);
    }
}
