<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\MailerAwareTrait;
use Cake\Log\Log;

/**
 * QuizResults Controller
 *
 * @property \App\Model\Table\QuizResultsTable $QuizResults
 * @method \App\Model\Entity\QuizResult[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuizResultsController extends AppController
{
    use MailerAwareTrait;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $quizResults = $this->paginate($this->QuizResults);

        $this->set(compact('quizResults'));
    }

    /**
     * View method
     *
     * @param string|null $id Quiz Result id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $quizResult = $this->QuizResults->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('quizResult'));
    }

    public function onlineHearingTest() {
        $this->set('canonical', ['controller' => 'quiz_results', 'action' => 'online_hearing_test']);
        $this->socialOptions['og:type'] = 'article';
        $this->socialOptions['og:image'] = '/img/quiz/hh19-free-online-hearing-test.jpg';
        $this->socialOptions['article:section'] = 'Hearing Help';
        $this->set('preferredClinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, true));
        $this->set('show_ad', false);
        $this->set('show_slider', false);
    }

    public function emailResults()
    {
        $this->viewBuilder()->disableAutoLayout();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $results = json_decode($data['results'], true);
            $name = $results['firstName'] . ' ' . $results['lastName'];
            $hearingResult = $results['hearingResult'];
            $toEmail = $results['email'];
            $symptoms = $results['emailSymptoms'];

            // Save results
            $quizResult = $this->QuizResults->newEmptyEntity();
            $entityData = [];
            $entityData['results'] = $data['results'];
            $quizResult = $this->QuizResults->patchEntity($quizResult, $entityData);

            if ($this->QuizResults->save($quizResult)) {
                $this->getRequest()->getSession()->write('OnlineTest', $data['results']);
            } // TO-DO: Some sort of log/alert to admins for QuizResult save failures?

            // Email results
            $mailer = $this->getMailer('QuizResults');
            if ($mailer->send('sendQuizResult', [$name, $hearingResult, $toEmail, $symptoms])) {
                return $this->response->withStringBody('true');
            } else {
                $this->Flash->error('Unable to email results, please try another email address.');
            }
        }
        return $this->redirect('/help/online-hearing-test');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $quizResult = $this->QuizResults->newEmptyEntity();
        if ($this->request->is('post')) {
            $quizResult = $this->QuizResults->patchEntity($quizResult, $this->request->getData());
            if ($this->QuizResults->save($quizResult)) {
                $this->Flash->success(__('The quiz result has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The quiz result could not be saved. Please, try again.'));
        }
        $this->set(compact('quizResult'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Quiz Result id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $quizResult = $this->QuizResults->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $quizResult = $this->QuizResults->patchEntity($quizResult, $this->request->getData());
            if ($this->QuizResults->save($quizResult)) {
                $this->Flash->success(__('The quiz result has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The quiz result could not be saved. Please, try again.'));
        }
        $this->set(compact('quizResult'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Quiz Result id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $quizResult = $this->QuizResults->get($id);
        if ($this->QuizResults->delete($quizResult)) {
            $this->Flash->success(__('The quiz result has been deleted.'));
        } else {
            $this->Flash->error(__('The quiz result could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
