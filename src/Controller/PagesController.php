<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactUsForm;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 * @method \App\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{
    /**
     * Homepage
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function home()
    {
        $content = $this->Pages->findByTitle('home')->first()->content;
        $this->set('content', $content);
    }

    /**
     * View method
     *
     * @param string|null $page Page title.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($page = null)
    {
        $page = $this->Pages->findByTitle($page)->first();
        $this->set(compact('page'));
    }

    /**
     * Contact Us method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function contactUs()
    {
        $contactUsForm = new ContactUsForm();
        $page = $this->Pages->findByTitle('contactUs')->first();

        if ($this->request->is('post')) {
            if ($contactUsForm->execute($this->request->getData())) {
                $this->Flash->success('We will get back to you soon.');
            } else {
                $this->Flash->error('There was a problem submitting your form.');
            }
        }

        $this->set(compact('contactUsForm'));
        $this->set(compact('page'));
    }
}
