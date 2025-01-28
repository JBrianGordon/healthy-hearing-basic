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
            'contain' => [
                'CallSources',
                'LocationHours',
                'LocationAds',
                'LocationPhotos',
                'Providers'
            ],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // convert payment array to json string
            $data['payment'] = isset($data['payment']) ? json_encode($data['payment']) : "";

            // remove empty providers
            foreach ($data['providers'] as $key => $provider) {
                if (empty($provider['id']) && empty($provider['first_name'])) {
                    unset($data['providers'][$key]);
                }
            }

            // remove last empty/new LocationPhoto
            array_pop($data['location_photos']);

            // Delete LocationAd records if no custom ad/special announcement is uploaded
            if ($data['location_ad']['title'] === '' &&
                $data['location_ad']['description'] === '' &&
                ($data['location_ad']['image_name'])->getClientFilename() === '') {
                if (!empty($data->location_ad)) {
                    $this->Locations->LocationAds->delete($data->location_ad);
                }
                unset($data['location_ad']);
            }

            $location = $this->Locations->patchEntity(
                $location,
                $data,
                ['associated' => $associations]
            );
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect($this->request->referer());
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set('title', $location->id . ' | ' . $location->title);
        $this->set(compact('location'));
        $this->set('days', $this->Locations->LocationHours->days);
        $this->set('uniqueLocationLinks', $this->Locations->findUniqueLocationLinks($id));
        $this->set('isCqPremier', $location->is_cq_premier);
        $this->set('couponId', $location->id_coupon);
    }
}
