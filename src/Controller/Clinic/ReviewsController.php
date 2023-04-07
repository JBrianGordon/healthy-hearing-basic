<?php
declare(strict_types=1);

namespace App\Controller\Clinic;

use App\Controller\AppController;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends BaseClinicController
{

    public $paginate = [
        'order' => [
            'Reviews.created' => 'desc',
        ],
    ];

    /**
     * Index method
     *
     * @param $int|null $locationId Location ID.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($locationId = null)
    {
        $locationId = $this->Authentication
            ->getIdentity()
            ->getOriginalData()
            ->locations[0]['id'];

        $reviews = $this->paginate(
            $this->Reviews->find('all')
                ->where([
                    'location_id' => $locationId
                ])
        );

        $this->set(compact('reviews'));
    }

    /**
     * Respond method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects on successful response, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function respond($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect([
                    'action' => 'index',
                    $review->location_id
                ]);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }

        $this->set(compact('review'));
    }
}
