<?php
declare(strict_types=1);

namespace App\Controller\Clinic;
use App\Model\Entity\Location;

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
     * @param string|null $locationId Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($locationId = null)
    {
        if (empty($locationId)) {
            // TODO: Admin users will be prompted to select a clinic id
            // FOR NOW REDIRECT TO MAIN CLINIC PAGE
            $this->Flash->error("No clinic location ID selected");
            return $this->redirect('/clinic');
        }
        $associations = [
            'CallSources',
            'LocationHours',
            'LocationAds',
            'LocationPhotos',
            'Providers'
        ];
        $location = $this->Locations->get($locationId, [
            'contain' => $associations,
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
        $this->set('uniqueLocationLinks', $this->Locations->findUniqueLocationLinks($locationId));
        $this->set('isCqPremier', $location->is_cq_premier);
        $this->set('couponId', $location->id_coupon);
    }

    /**
    * Clinic user account names & emails
    */
    function account($locationId = null)
    {
        $requestData = $this->request->getData();
        if (!$this->isAdmin) {
            // Clinic users are only allowed to see reports for 1 location
            $userLocationId = $this->user->locations[0]->id;
            if ($locationId != $userLocationId) {
                return $this->redirect(['controller' => 'Locations', 'action' => 'account', $userLocationId]);
            }
        } else {
            // Admin user
            $selectedLocationId = $requestData['location_id'] ?? null;
            if (!empty($selectedLocationId)) {
                if ($locationId != $selectedLocationId) {
                    return $this->redirect(['controller' => 'Locations', 'action' => 'account', $selectedLocationId]);
                }
            }
        }
        if (empty($locationId)) {
            // TODO: Prompt Admin users to select a clinic id
            // FOR NOW REDIRECT TO MAIN CLINIC PAGE
            $this->Flash->error("No clinic location ID selected");
            return $this->redirect('/clinic');
        }
        $location = $this->Locations->get($locationId, [
            'contain' => ['Users', 'LocationEmails']
        ]);
        $isInactiveClinic = (!$location->is_active || !$location->is_show || ($location->listing_type == Location::LISTING_TYPE_NONE));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $requestData, ['associated'=>['Users', 'LocationEmails']]);
            if ($this->Locations->save($location)) {
                $this->Flash->success("Account successfully updated.");
                return $this->redirect(['action' => 'account', $locationId]);
            } else {
                $this->Flash->error("Unable to update account. Please try again.");
            }
        }
        $this->set('location', $location);
        $this->set('locationId', $locationId);
        $this->set('profileComplete', $this->accountComplete());
        $this->set('isInactiveClinic', $isInactiveClinic);
    }
}
