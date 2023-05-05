<?php
declare(strict_types=1);

namespace App\Controller;

use App\Enums\Model\Review\ReviewStatus;
use App\Enums\Model\Review\ReviewOrigin;
use Cake\View\JsonView;
use Cake\Log\LogTrait;
use Cake\Log\Log;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{
    // public function viewClasses(): array
    // {
    //     return [JsonView::class];
    // }
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

    /**
     * Add Review method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function addReview()
    {
        $review = $this->Locations->Reviews->newEmptyEntity();

        $jsonRequestData = $this->request->getData('reviews');
        $jsonRequestData['status'] = ReviewStatus::PENDING->value;
        $jsonRequestData['origin'] = ReviewOrigin::ORIGIN_ONLINE->value;

        $review = $this->Locations->Reviews->patchEntity($review, $jsonRequestData);

        if ($this->Locations->Reviews->save($review)) {
            return $this->response->withStringBody('Successfully saved!');
        }

        return $this->response->withStringBody('Failure on save!');
    }
}
