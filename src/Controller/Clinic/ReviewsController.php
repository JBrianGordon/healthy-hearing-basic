<?php
declare(strict_types=1);

namespace App\Controller\Clinic;
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
    public function index($username = null)
    {
        //Force recovery email to be filled out.
        if (!$this->hasRecoveryEmail()) {
            $this->Flash->error('You must first fill out your email to continue. ↓');
            $this->redirect(['controller' => 'users', 'action' => 'account']);
        }
        //Only allow you to set the oticon_id if we're admin, otherwise we always pull from our username
        if (!$this->isAdmin) {
            $username = $this->user->username;
        } else {
            // Only set our username if it wasn't passed in.  This only works for admins.
            if (empty($username)) {
                $username = !empty($this->request->getData('username')) ? $this->request->getData('username') : null;
            }
        }

        $this->Locations = $this->fetchTable('Locations');
        $locationId = $this->Locations->findByUsername($username);

        $reviews = null;
        $locationTitle = null;
        $locationProfile = null;
        if (!empty($locationId)) {
            $reviews = $this->paginate('Reviews', [
                'conditions' => [
                    'Reviews.location_id' => $locationId,
                    'Reviews.status IN' => [
                        Review::STATUS_APPROVED,
                        Review::STATUS_DENIED
                    ],
                ],
            ]);
            $location = $this->Locations->get($locationId);
            $locationTitle = $location->title;
            $locationProfile = Router::url($location->hh_url, true);
        }

        $this->set('reviews', $reviews);
        $this->set('locationTitle', $locationTitle);
        $this->set('locationProfile', $locationProfile);
        $this->set('locationId', $locationId);
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
                    $review->location_id,
                ]);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }

        $this->set(compact('review'));
    }
}
