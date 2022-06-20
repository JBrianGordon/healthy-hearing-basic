<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $locations = $this->paginate($this->Locations);

        $this->set(compact('locations'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => ['CaCallGroups', 'CallSources', 'CsCalls', 'ImportLocations', 'ImportStatus', 'LocationAds', 'LocationEmails', 'LocationHours', 'LocationLinks', 'LocationNotes', 'LocationPhotos', 'LocationProviders', 'LocationUsers', 'LocationVideos', 'LocationVidscrips', 'Reviews'],
        ]);

        $this->set(compact('location'));
    }
}
