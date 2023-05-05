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
    public $pageTitle = 'Healthy Hearing';
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

    public function beforeFilter(EventInterface $event)
    {
        // Set our language from config (for html tag)
        $this->__language = Configure::read('htmlLanguage');

        //$this->goneRss();
        //$this->goneFullSite();
        //$this->removeIndex();
        //$this->isFullSite(); //handle fullsite rendering conditions
        //$this->isPPC(); // set isPPC session cookie
        //$this->setLanguage();
        $this->host = env('HTTP_HOST');
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
        //$ad = ClassRegistry::init('Ad')->findGenericAd();
        //$this->set('ad', $ad);

        //$this->Configuration->load('HH');
        //$this->fixSubDomain(); //Fix subdomain healthyeharing.com/......
        //$this->addCanonical(); //Add canonical
        //$this->set('user', $this->Auth->user());
        //$this->set('isadmin', $this->isAdmin());
        //$this->set('isitadmin', $this->isItAdmin());
        //$this->set('isagent', $this->isAgent());
        //$this->set('iscallsupervisor', $this->isCallSupervisor());
        //$this->set('isclinic', $this->isClinic());
        //$this->set('iscsa', $this->isCSA());
        //$this->set('iswriter', $this->isWriter());
        //$this->set('isreviewer', $this->isReviewer());

        // Create an array of the permissions the user has.
        //$userPermissions = [];
        //if ($this->isAdmin()) { $userPermissions[] = 'admin'; }
        //if ($this->isItAdmin()) { $userPermissions[] = 'itadmin'; }
        //if ($this->isAgent()) { $userPermissions[] = 'agent'; }
        //if ($this->isCallSupervisor()) { $userPermissions[] = 'callsupervisor'; }
        //if ($this->isClinic()) { $userPermissions[] = 'clinic'; }
        //if ($this->isCSA()) { $userPermissions[] = 'csa'; }
        //if ($this->isWriter()) { $userPermissions[] = 'writer'; }
        //$this->set('userPermissions', $userPermissions);

        $this->set('show_ad', true);
        //$this->set('isInactiveClinic', $this->isInactiveClinic());
        //$this->set('html_lang', $this->getLanguage());
        //$this->set('isCookieFooterClosed', $this->isCookieFooterClosed());
        return parent::beforeFilter($event);
    }

    /**
    * convenience method for adding to or replacing the HTML title of the page.
    * @param string $title_text
    * @param bool $overwrite (if true, replace)
    * @param string $title_text
    */
    public function add_title($title_text=null,$overwrite=false) {
        if (is_array($title_text)) {
            $found_title = pluckValid($title_text,array('headtitle','title_head','title','slug','domain','id',));
            if (empty($found_title)) {
                foreach ( $title_text as $m => $data ) {
                    if (empty($found_title)) {
                        $found_title = pluckValid($data,array('headtitle','title_head','title','slug','domain','id',));
                    }
                }
            }
            $title_text = $found_title;
        }
        if (!empty($title_text)) {
            if ($this->pageTitle == 'Healthy Hearing') {
                $this->pageTitle = ''; //remove the generic Healthy Hearing from all page titles
            }
            if (empty($this->pageTitle) || $overwrite) {
                $this->pageTitle = str_replace('_',' ',trim(strip_tags($title_text)));
            } else {
                $this->pageTitle = str_replace('_',' ',trim(strip_tags($title_text))).' | '.$this->pageTitle;
            }
        }
        return $title_text;
    }
}
