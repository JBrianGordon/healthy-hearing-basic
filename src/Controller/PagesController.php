<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactUsForm;
use Cake\Mailer\MailerAwareTrait;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 * @method \App\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{
    use MailerAwareTrait;

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
            $requestData = $this->request->getData();
            if ($contactUsForm->execute($requestData)) {
                $this->Flash->success('We will get back to you soon.');
                $this->getMailer('ContactUs')->send('notifyAdmin', compact('requestData'));
                $this->getMailer('ContactUs')->send('thanksVisitor', compact('requestData'));
;
            } else {
                $this->Flash->error('There was a problem submitting your form.');
            }
        }

        $this->set(compact('contactUsForm'));
        $this->set(compact('page'));
    }
}
