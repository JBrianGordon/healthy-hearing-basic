<?php
declare(strict_types=1);

namespace App\Controller\Clinic;

use App\Enums\Model\Review\ReviewResponseStatus;
use App\Model\Entity\Review;
use Cake\Routing\Router;

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
     * Show reviews for clinic
     */
    public function index($locationId = null)
    {

        // TO-DO: SHOULD WE DO THIS EMAIL REQUIRING SOMEWHERE ELSE?
        // //Force recovery email to be filled out.
        // if (!$this->hasRecoveryEmail()) {
        //     $this->Flash->error('You must first fill out your email to continue. ↓');
        //     return $this->redirect(['controller' => 'locations', 'action' => 'account']);
        // }

        $reviews = $this->paginate('Reviews', [
            'contain' => ['Locations'],
            'conditions' => [
                'Reviews.location_id' => $locationId,
                'Reviews.status IN' => [
                    Review::STATUS_APPROVED,
                    Review::STATUS_DENIED
                ],
            ],
        ]);

        $location = $this->Reviews->Locations->get($locationId);

        $this->set(compact('reviews', 'location'));
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
            $review->set('response', $this->request->getData('response'));

            // Set response_status to RESPONSE_STATUS_RESPONDED if response field is changed by clinic
            if ($review->isDirty('response')) {
                $review->response_status = ReviewResponseStatus::RESPONSE_STATUS_RESPONDED->value;
            }

            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('Response saved. It will be published soon.'));

                return $this->redirect([
                    'action' => 'index',
                    $review->location_id,
                ]);
            }
            $this->Flash->error(__('Unable to save response. Please try again.'));
        }

        $location = $this->Reviews->Locations->get($review->location_id);

        $this->set(compact('review', 'location'));
    }
}
