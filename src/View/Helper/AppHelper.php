<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

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
    protected $helpers = [];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function isMobileDevice() { 
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); 
    }

    public function splitBy($array = array(), $by = 2) {
        if (is_object($array)) {
            $array = json_decode(json_encode($array), true);
        }
        if (empty($array)) {
            $retval = array();
            for ($i = 0; $i < count($by); $i++) {
                $retval[$i] = array();
            }
            return $retval;
        }
        $length = (int)ceil(count($array)/$by);
        return array_chunk($array, $length, true);
    }

    /**
    * Return the username from userId
    */
    public function getUserName($userId = null){
        if (!$userId) {
            return null;
        }
        $user = TableRegistry::getTableLocator()->get('Users')->get($userId);
        return $user->username;
    }
}
