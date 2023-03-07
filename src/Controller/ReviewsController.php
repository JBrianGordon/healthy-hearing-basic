<?php
declare(strict_types=1);

namespace App\Controller;

use App\Enums\Model\Review\ReviewStatus;
use App\Enums\Model\Review\ReviewOrigin;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('review'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    //TODO: THIS WILL BE AN AJAX FUNCTION TO ADD A NEW REVIEW FROM FRONT END
    public function add()
    {
        $review = $this->Reviews->newEmptyEntity();
        if ($this->request->is('post')) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $locations = $this->Reviews->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('review', 'locations'));
    }

    /**
     * Add Review method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addReview()
    {
        // TO-DO: This currently requires manual AJAX-ing from the console with something like:
        // fetch('/reviews/add-review', {
        //   method: 'POST',
        //   headers: {
        //     'Content-Type': 'application/json',
        //     'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest'
        //   },
        //   body: JSON.stringify({
        //     location_id: 8119030851,
        //     first_name: 'Bill',
        //     last_name: 'Talkington',
        //     zip: 15401,
        //     rating: 5,
        //     body: 'This is a great clinic!!!!!!',
        //   })
        // }).then(response => response.text())
        //   .then(data => console.log(data))
        //   .catch(error => console.error(error));
        $this->viewBuilder()->setLayout('ajax');

        $review = $this->Reviews->newEmptyEntity();

        $jsonData = (string)$this->request->getBody();

        $jsonRequestData = json_decode($jsonData, true);

        $jsonRequestData['status'] = ReviewStatus::PENDING->value;
        $jsonRequestData['origin'] = ReviewOrigin::ORIGIN_ONLINE->value;

        $review = $this->Reviews->patchEntity($review, $jsonRequestData);

        if ($this->Reviews->save($review)) {
            return $this->response->withStringBody('Successfully saved!');
        }
        return $this->response->withStringBody('Failure on save!');

    }
}
