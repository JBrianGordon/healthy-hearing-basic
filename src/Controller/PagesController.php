<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactUsForm;
use App\Form\NewsletterForm;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
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
        // page content edited in misc pages
        $content = $this->Pages->findByTitle('home')->first()->content;
        // Content from the Content table for recent articles
        $this->Content = $this->fetchTable('Content');
        $articles = $this->Content->findLatest(5);
        if (empty($title)) {
            $this->set('title', isset($content->title) ? $content->title : $this->siteName);
        }

        $this->set('show_organization_schema', true);
        $this->set('content', $content);
        $this->set('articles', $articles);
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
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
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
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
        $this->set(compact('contactUsForm', 'page'));
        $this->set('articles', $this->fetchTable('Content')->findLatest(4));

        if ($this->request->is('post')) {
            if (!$this->Recaptcha->verify()) {
                $this->Flash->error('reCAPTCHA test failed ("I\'m not a robot"). Please try again!');

                return;
            }

            $requestData = $this->request->getData();
            $this->set('requestData', $requestData);
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
     * RSS feeds page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function feeds() {
        // 404 for Canada
        if (!Configure::read('showReports')) {
            return $this->throw404NotFound();
        }

        $page = $this->Pages->findByTitle('feeds')->first();
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
        $this->set(compact('page'));
        $this->set('show_slider', false);
        $this->set('articles', $this->fetchTable('Content')->findLatest(4));
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
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
        $this->set(compact('newsletterForm', 'page'));
        $this->set('articles', $this->fetchTable('Content')->findLatest(4));

        if ($this->request->is('post')) {
            if (!$this->Recaptcha->verify()) {
                $this->Flash->error('reCAPTCHA test failed ("I\'m not a robot"). Please try again!');

                return;
            }

            $requestData = $this->request->getData();
            if ($newsletterForm->execute($requestData)) {
                $this->Flash->success(
                    'Thank you for subscribing to our newsletter! Look for a confirmation email from us in your inbox.'
                );

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
        $page = true;
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
        $this->set(compact('page'));
        $this->set('articles', $this->fetchTable('Content')->findLatest(4));
        
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
        if (empty($title)) {
            $this->set('title', isset($clinicPage->title) ? $clinicPage->title : $this->siteName);
        }
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

    /**
     * About us page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function about() {
        $page = $this->Pages->findByTitle('about')->first();
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
        $this->set(compact('page'));
        $this->set('show_slider', false);
    }

    /**
     * Privacy policy page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function privacyPolicy() {
        $page = $this->Pages->findByTitle('privacyPolicy')->first();
        $env = Configure::read('env');
        $title = 'Privacy Policy';

        if (!empty($env) && $env != 'prod') {
            $title = $env . ': ' . $title;
        }

        $this->set('title', $title);
        $this->set(compact('page'));
        $this->set('show_slider', false);
    }

    /**
     * Sitemap page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function sitemap()
    {
        // Load the Sitemaps table
        $this->loadModel('Sitemaps');
    
        // Fetch sitemap data
        $sitemapData = $this->Sitemaps->fetchSitemapData();

        $page = true;
        $this->set(compact('page'));
        if (empty($title)) {
            $this->set('title', isset($page->title) ? $page->title : $this->siteName);
        }
    
        // Pass data to the view
        $this->set('sitemapData', $sitemapData);
        $this->set('articles', $this->fetchTable('Content')->findLatest(4));
    }

    /**
     * Terms of use page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function termsOfUse() {
        $page = $this->Pages->findByTitle('termsOfUse')->first();
        $env = Configure::read('env');
        $title = 'Terms of Use';

        if (!empty($env) && $env != 'prod') {
            $title = $env . ': ' . $title;
        }

        $this->set('title', $title);
        $this->set(compact('page'));
        $this->set('show_slider', false);
    }
}
