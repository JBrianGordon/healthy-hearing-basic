<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Admin helper
 */
class AppHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Identity'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function isAdmin() {
        return ($this->Identity->is('admin', 'role'));
    }

    public function isClinic() {
        return ($this->Identity->is('clinic', 'role'));
    }

    public function isMobileDevice() { 
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); 
    } 
}
