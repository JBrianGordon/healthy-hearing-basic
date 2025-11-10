<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $prefetches = [];
    public $meta = [];
    public $socialOptions = [];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // TO-DO: Figure out if we can get rid of the RequestHandler (on deprecation list)
        //$this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        parent::beforeRender($event);

        $seo = $this->request->getAttribute('seo') ?? [];
        $seoTitle = $seo['title'] ?? null;

        if ($seoTitle !== null) {
            $title = $seoTitle;
            $this->set('title', $title);
        }
        $this->set('meta', $this->meta);
    }

    public function beforeFilter(EventInterface $event)
    {
        // Set our language from config (for html tag)
        $this->__language = Configure::read('htmlLanguage');

        //$this->goneRss();
        //$this->goneFullSite();
        //$this->removeIndex();
        //$this->isFullSite(); //handle fullsite rendering conditions
        $this->isPPC(); // set isPPC session cookie
        //$this->setLanguage();
        $this->host = env('HTTP_HOST');
        $this->isMobileDevice = $this->isMobileDevice();
        $this->set('isMobileDevice', $this->isMobileDevice);
        // special functionality for different RequestHandling
        if (isset($this->RequestHandler)) {
            //if ($this->RequestHandler->isRss() && ($this->request->ext == 'rss')) {
                //Configure::write('debug',0);
                //$this->layout = 'rss';
            //}
            //if ($this->RequestHandler->isAjax()) {
                //Configure::write('debug',0);
                //$this->isajax = true;
                //$this->header('Pragma: no-cache');
                //$this->header('Cache-control: no-cache');
                //$this->header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            //}
        }

        // Load the settings configuration
        //$this->settings = Configure::read('International');
        //$this->settings['country'] = empty($this->settings['country']) ? 'US' : $this->settings['country'];
        //$this->set('settings', $this->settings);
        $this->stateLabel = Configure::read('stateLabel');
        $this->set('stateLabel', $this->stateLabel);
        $this->zipShort = Configure::read('zipShort');
        $this->set('zipShort', $this->zipShort);
        $this->siteName = Configure::read('siteName');
        $this->set('siteName', $this->siteName);

        // Find a random generic ad with no exclusivity tags
        $ad = $this->fetchTable('Advertisements')->findGenericAd();
        $this->set('ad', $ad);

        //$this->Configuration->load('HH');
        //$this->fixSubDomain(); //Fix subdomain healthyeharing.com/......
        //$this->addCanonical(); //Add canonical
        $this->user = $this->getRequest()->getAttribute('identity');
        $userRole = empty($this->user->role) ? '' : $this->user->role;
        $this->isAdmin = ($userRole == 'admin');
        $this->isClinic = ($userRole == 'clinic');
        $this->isItAdmin = ($userRole == 'it_admin');
        $this->isAgent = ($userRole == 'agent');
        $this->isCallSupervisor = ($userRole == 'call_supervisor');
        $this->isCsa = ($userRole == 'csa');
        $this->isWriter = ($userRole == 'writer');
        $this->isReviewer = ($userRole == 'reviewer');
        $this->adminAccessAllowed = in_array($userRole, ['admin', 'it_admin', 'agent', 'call_supervisor', 'csa', 'writer']);
        $this->set('user', $this->user);
        $this->set('isAdmin', $this->isAdmin);
        $this->set('isClinic', $this->isClinic);
        $this->set('isItAdmin', $this->isItAdmin);
        $this->set('isAgent', $this->isAgent);
        $this->set('isCallSupervisor', $this->isCallSupervisor);
        $this->set('isCsa', $this->isCsa);
        $this->set('isWriter', $this->isWriter);
        $this->set('isReviewer', $this->isReviewer);
        $this->set('adminAccessAllowed', $this->adminAccessAllowed);

        $this->set('show_ad', true);
        //$this->set('isInactiveClinic', $this->isInactiveClinic());
        //$this->set('html_lang', $this->getLanguage());
        //$this->set('isCookieFooterClosed', $this->isCookieFooterClosed());
        $this->set('clinicsNearMe', $this->fetchTable('Locations')->findClinicsNearMe(4, false));
        return parent::beforeFilter($event);
    }

    /**
    * checks if host is the host we're on
    * www1.healthyhearing.com is false
    * www.healthyhearing.com is true (in production)
    */
    public function isPrimaryHost() {
        $default_host = Configure::read('host');
        return $default_host == $this->getHost();
    }

    /**
    * Get the current host
    */
    public function getHost() {
        $host = "";
        foreach (array(/*'SERVER_NAME',*/ 'HTTP_HOST') as $key) {
            if (isset($_SERVER[$key]) && !empty($_SERVER[$key])) {
                $host = $_SERVER[$key];
                break;
            }
        }
        //TODO:
        if (empty($host) && $this->Session->host) {
            $host = $this->Session->host;
        }
        return $host;
    }

    /**
    * Sets the Meta Tag for me.
    * @param string name of key for meta tag
    * @param string content of the meta tag
    * @param boolean overwrite, if already set overwrite it, (default false)
    */
    public function setMeta($name, $content, $overwrite = false) {
        if ($name == 'robots' && !$this->isPrimaryHost()) {
            return false;
        }
        if (isset($this->meta[$name]) && !$overwrite) {
            return false;
        }
        $this->meta[$name] = $content;
        return true;
    }

    public function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); 
    }

    /**
    * Is the source PPC?
    * @return true if referrer is PPC
    */
    public function isPPC() {
        if (isset($_COOKIE['isPPC'])) {
            return true;
        }
        $gclid = isset($this->request->query['gclid']) ? $this->request->query['gclid'] : '';
        $utm_source = isset($this->request->query['utm_source']) ? $this->request->query['utm_source'] : '';
        $utm_medium = isset($this->request->query['utm_medium']) ? $this->request->query['utm_medium'] : '';
        if (!empty($gclid) ||
            ($utm_medium == 'cpc') ||
            ($utm_source == 'adroll')) {
            setcookie('isPPC', 1, 0, "/", "", true, ""); // expires at end of session
            return true;
        }
        return false;
    }

    public function hasRecoveryEmail() {
        return (!empty($this->user->email));
    }
}
