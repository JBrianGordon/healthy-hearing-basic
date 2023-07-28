<?php
declare(strict_types=1);

namespace App\Controller\Clinic;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends BaseClinicController
{
    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => ['CallSources', 'LocationHours', 'LocationAds', 'LocationPhotos', 'LocationVidscrips', 'Providers'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set(compact('location'));
        $this->set('days', $this->Locations->LocationHours->days);
        $this->set('uniqueLocationLinks', $this->Locations->findUniqueLocationLinks($id));
        $this->set('isCqPremier', $location->is_cq_premier);
        $this->set('couponId', $location->coupon_id);
    }
}
