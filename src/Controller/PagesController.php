<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactUsForm;
use App\Form\NewsletterForm;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;
use Cake\Http\Exception\NotFoundException;

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
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent(
            'Recaptcha.Recaptcha',
            [
                'enable' => true,
                'sitekey' => Configure::read('recaptchaPublicKey'),
                'secret' => Configure::read('recaptchaPrivateKey'),
                'type' => 'image',
                'theme' => 'light',
                'lang' => 'en',
                'size' => 'normal',
            ]
        );
    }

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
        $this->set(compact('contactUsForm', 'page'));

        if ($this->request->is('post')) {
            if (!$this->Recaptcha->verify()) {
                $this->Flash->error('reCAPTCHA test failed ("I\'m not a robot"). Please try again!');

                return;
            }

            $requestData = $this->request->getData();
            if ($contactUsForm->execute($requestData)) {
                $this->Flash->success('We will get back to you soon.');

                return $this->redirect('/contact-us', 301);
            } else {
                $this->Flash->error('There was a problem submitting your form.');

                return;
            }
        }
    }

    /**
     * Newsletter method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function newsletter()
    {
        if (!Configure::read('showNewsletter')) {
            throw new NotFoundException();
        }

        $newsletterForm = new newsletterForm();
        $page = $this->Pages->findByTitle('newsletter')->first();
        $this->set(compact('newsletterForm', 'page'));

        if ($this->request->is('post')) {
            if (!$this->Recaptcha->verify()) {
                $this->Flash->error('reCAPTCHA test failed ("I\'m not a robot"). Please try again!');

                return;
            }

            $requestData = $this->request->getData();
            if ($newsletterForm->execute($requestData)) {
                $this->Flash->success('Thank you for subscribing to our newsletter! Look for a confirmation email from us in your inbox.');

                return $this->redirect('/newsletter-success');
            } else {
                $this->Flash->error('There was a problem submitting your form.');

                return;
            }

        }
    }

    /**
     * Success page for newsletter sign-ups
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function newsletterSuccess()
    {
        if (!Configure::read('showNewsletter')) {
            throw new NotFoundException();
        }
        //TO-DO: function for on-the-fly title changes in controller
        // Title for this page: 'Thank you for subscribing to the Healthy Hearing newsletter!''
    }

    /**
     * Information for clinics page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function clinicInfo()
    {
        $clinicPage = $this->Pages->findByTitle('clinicPage')->first()->content;
        $basicFeatures = $this->Pages->findByTitle('basicFeatures')->first()->content;
        $enhancedFeatures = $this->Pages->findByTitle('enhancedFeatures')->first()->content;
        $premierFeatures = $this->Pages->findByTitle('premierFeatures')->first()->content;

        // TODO:
        // Retrieve prices for different profile listing type plans
        /*
        $planPrices = $this->Configuration->getPlanPrices();
        if (!empty($planPrices)) {
            // Strip 'plan_' from plan type when setting view variables
            foreach ($planPrices as $planType => $premium) {
                $this->set(str_replace('plan_', '', $planType), $premium);
            }
        }*/
        // TEMP: Hard code plan prices for now
        $this->set('monthly_enhanced', '85');
        $this->set('monthly_premier', '160');

        $this->set('clinicPage', $clinicPage);
        $this->set('basicFeatures', $basicFeatures);
        $this->set('enhancedFeatures', $enhancedFeatures);
        $this->set('premierFeatures', $premierFeatures);
    }
}
