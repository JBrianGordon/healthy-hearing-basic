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
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . DIRECTORY_SEPARATOR . 'paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Database\Type\StringType;
use Cake\Database\TypeFactory;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorTrap;
use Cake\Error\ExceptionTrap;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Utility\Inflector;

/*
 * See https://github.com/josegonzalez/php-dotenv for API details.
 *
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.example` to `config/.env` and set/modify the
 * variables as required.
 *
 * The purpose of the .env file is to emulate the presence of the environment
 * variables like they would be present in production.
 *
 * If you use .env files, be careful to not commit them to source control to avoid
 * security risks. See https://github.com/josegonzalez/php-dotenv#general-security-information
 * for more information for recommended practices.
*/
// if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
//     $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
//     $dotenv->parse()
//         ->putenv()
//         ->toEnv()
//         ->toServer();
// }

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

if (file_exists(CONFIG . 'hhConfigs/config_core.php')) {
    Configure::load('hhConfigs/config_core', 'default');
}

/*
 * Load an environment local configuration file to provide overrides to your configuration.
 * Notice: For security reasons app_local.php **should not** be included in your git repo.
 */
if (file_exists(CONFIG . 'app_local.php')) {
    Configure::load('app_local', 'default');
}

/* Load the country specific configurations */
if ($country = Configure::read('country')) {
    if (file_exists(CONFIG . 'hhConfigs/config_'.strtolower($country).'.php')) {
        Configure::load('hhConfigs/config_'.strtolower($country), 'default');
    }
}

/* Route configuration */
if (file_exists(CONFIG . 'hhConfigs/config_routes.php')) {
    Configure::load('hhConfigs/config_routes', 'default');
}

/* Sitemap configuration for sitemap_Main.xml */
if (file_exists(CONFIG . 'hhConfigs/config_sitemapMain.php')) {
    Configure::load('hhConfigs/config_sitemapMain', 'default');
}

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
    // disable router cache during development
    Configure::write('Cache._cake_routes_.duration', '+2 seconds');
}

/*
 * Set the default server timezone. Using UTC makes time calculations / conversions easier.
 * Check http://php.net/manual/en/timezones.php for list of valid timezone strings.
 */
date_default_timezone_set(Configure::read('App.defaultTimezone'));

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
(new ErrorTrap(Configure::read('Error')))->register();
(new ExceptionTrap(Configure::read('Error')))->register();

/*
 * Include the CLI bootstrap overrides.
 */
if (PHP_SAPI === 'cli') {
    require CONFIG . 'bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 */
$fullBaseUrl = Configure::read('App.fullBaseUrl');
if (!$fullBaseUrl) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        $fullBaseUrl = 'http' . $s . '://' . $httpHost;
    }
    unset($httpHost, $s);
}
if ($fullBaseUrl) {
    Router::fullBaseUrl($fullBaseUrl);
}
unset($fullBaseUrl);

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Mailer::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/*
 * Setup detectors for mobile and tablet.
 * If you don't use these checks you can safely remove this code
 * and the mobiledetect package from composer.json.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/**
* Returns an array, derived from whatever the input was.  Optionally cleans empties from the array as well.
* @param mixed $input
* @param bool $cleanEmpties
* @return array $inputAsArray
*/
function asArray($input,$cleanEmpties=true) {
	if (!empty($input) || $input==0){
		if (is_object($input)) {
			$input = get_object_vars($input);
		} elseif (!is_array($input)) {
			$input = array($input);
		}
		// get all first level nested objects (if any)
		foreach ( $input as $key => $val ) {
			if (is_object($val)) {
				$input[$key] = asArray($val);
			}
		}
		if ($cleanEmpties) {
			return array_diff((array)$input,array(null,'',' '));
		} else {
			return $input;
		}
	}
	return array();
}

/**
* just a simpler test function.  Tests if something is !emtpy() || == '0'
* @param mixed $data
* @param mixed $allow an array of values or a value which is allowed - if TRUE, we just us empty($data)
* @param bool $onlyAllow only allow values which are in $allow
* @return bool $dataIsNotEmptyOrInAllow
*/
function isValid($data,$allow=true,$onlyAllow=false) {
	if (is_array($data) && count($data)==1) {
		$data = array_shift($data);
	}
	if (is_bool($allow) || is_int($allow)) {
		$allow = array($allow);
	} elseif (!is_array($allow)) {
		$allow = explode(',',strval($allow));
	}
	$disallow = array_diff(array('0000-00-00','0000-00-00 00:00:00','',null,false),$allow);
	if (is_array($data) && $onlyAllow) {
		return Set::check($data,$allow);
	} else {
		if ($onlyAllow) {
			return in_array($data,$allow,true);
		} elseif (!in_array($data,$disallow,true)) {
			if (!empty($data)) {
				return true;
			} else {
				return in_array($data,$allow,(is_bool($data) || $data==null));
			}
		}
	}
	return false;
}

/**
* plucks a valueset from an array, based on the path
* -- this uses Set::check() and returns that value if it's set
* @link http://book.cakephp.org/view/667/check
* @link http://code.cakephp.org/source/cake/tests/cases/libs/set.test.php
* @link http://api.cakephp.org/view_source/set/#line-741
* @param mixed $data
* @param mixed $path eg: /0/Post/name
* @param mixed $default
* @return mixed $pluckedValuesOrDefault
*/
function pluck($data,$path=null,$default=null) {
	$return = null;
	if (is_array($path)) {
		// finds and returns the first match which is not the default
		foreach ( $path as $_path ) {
			$return = pluck($data,$_path,$default);
			if (!$return==$default) {
				return $return;
			}
		}
	} else {
		$path = trim(strval($path));
		$path = str_replace('\\.','[dot]',$path);
		if (strpos($path,"/")!==false) {
			$path = str_replace('.','[dot]',$path);
		}
		$path = str_replace('/','.',$path);
		$path = trim($path,'.');
		if (is_array($data) && isValid($path,0)) {
			if (setCheck($data,$path)) {
				return setCheck($data,$path,false);
			}
		} elseif (empty($path) || $path===true) {
			$return = $data;
		}
	}
	if ($return===null) {
		return $default;
	}
	return $return;
}

/**
* tests the plucked value
* @param mixed $data
* @param mixed $path (see pluck)
* @param mixed $allow an array of values or a value which is allowed - if TRUE, we just us empty($data)
* @param bool $onlyAllow only allow values which are in $allow
* @return bool $dataIsNotEmptyOrInAllow
*/
function pluckIsValid($data,$path=null,$allow=true,$onlyAllow=false) {
	return isValid(pluck($data,$path),$allow,$onlyAllow);
}

/**
* Checks if a particular path is set in an array
*
* @param mixed $data Data to check on
* @param mixed $path A dot-separated string.
* @param boolean $returnBool
* @return mixed if path is found and $returnBool==true,
* 					the value of the path if path is found, false otherwise
* @access public
* @static
*/
function setCheck($data, $path=null, $returnBool=true) {
	if (empty($path) && $path!=0) {
		return $data;
	}
	if (!is_array($path)) {
		$path = trim(strval($path));
		$path = str_replace('\\.','[dot]',$path);
		if (strpos($path,"/")!==false) {
			$path = str_replace('.','[dot]',$path);
		}
		$path = str_replace('/','.',$path);
		$path = trim($path,'.');
		$path = explode('.', $path);
	}
	foreach ($path as $i => $key) {
		if (is_numeric($key) && intval($key) > 0 || $key === '0') {
			$key = intval($key);
		}
		// escaping
		$key = str_replace('[dot]','.',$key);
		if ($i === count($path) - 1 && is_array($data) && array_key_exists($key, $data)) {
			if ($returnBool) {
				return true;
			} else {
				return $data[$key];
			}
		}
		if (!is_array($data) || !array_key_exists($key, $data)) {
			return false;
		}
		$data = $data[$key];
	}
	return true;
}

/*
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
// \Cake\Database\TypeFactory::build('time')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('date')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('datetime')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('timestamp')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('datetimefractional')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('timestampfractional')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('datetimetimezone')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('timestamptimezone')
//    ->useLocaleParser();

// There is no time-specific type in Cake
TypeFactory::map('time', StringType::class);

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);


function formatNumber($sPhone){
    //TODO: REMOVE THIS FUNCTION AFTER PULLING CODE INTO CAKE4
    die('die use formatPhoneNumber() instead of formatNumber()');
}
/**
  * Format the phone number
  */
function formatPhoneNumber($sPhone){
    $extOffset = strpos($sPhone, "x");
    if ($extOffset) {
        // Pull out extensions after 'x' or 'ext'
        $extension = substr($sPhone,$extOffset+1);
        $extension = preg_replace("/[^0-9]/",'',$extension);
        $sPhone = substr($sPhone,0,$extOffset);
    }
    $sPhone = preg_replace("/[^0-9]/",'',$sPhone);
    if (strlen($sPhone) > 10) {
        $firstDigit = substr($sPhone, 0, 1);
        if ($firstDigit == '1') {
            // US and Canada both use country code 1
            $sCountry = '1';
            $sPhone = substr($sPhone, 1);
        }
    }
    if (strlen($sPhone) > 10) {
        // Assume the first 10 digits are phone and the rest is extension
        $extension = substr($sPhone, 10);
        $sPhone = substr($sPhone, 0, 10);
    }
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $retval = "($sArea) $sPrefix-$sNumber";
    if (!empty($sCountry)) {
        $retval = "$sCountry $retval";
    }
    if (!empty($extension)) {
        $retval .= " x$extension";
    }
    return $retval;
}

/**
* Removes non-numeric characters from phone number
*/
function cleanPhone($phone){
    return preg_replace("/[^0-9]/",'',$phone);
}

/**
* Removes non-numeric characters from phone number and strips off the country code and extensions
*/
function tenDigitPhone($phone){
    $extOffset = strpos($phone, "x");
    if ($extOffset) {
        // Remove extensions after 'x' or 'ext'
        $phone = substr($phone, 0, $extOffset);
    }
    $phone = preg_replace("/[^0-9]/",'',$phone);
    if (strlen($phone) > 10) {
        $firstDigit = substr($phone, 0, 1);
        if ($firstDigit == '1') {
            // US and Canada both use country code 1
            // Remove the country code
            $phone = substr($phone, 1);
        }
    }
    // truncate to 10 digits
    $phone = substr($phone, 0, 10);
    return $phone;
}

/**
* Inserts a new key/value after the key in the array.
*
* @param $key - key to insert after
* @param $array - array to insert into
* @param $newKey - key to insert
* @param $newValue - value to insert
*
* @return - new array if the key exists, false otherwise.
*/
function arrayInsertAfter($key, array $array, $newKey, $newValue) {
    if (array_key_exists($key, $array)) {
        $newArray = [];
        foreach ($array as $k => $value) {
            $newArray[$k] = $value;
            if ($k == $key) {
                $newArray[$newKey] = $newValue;
            }
        }
        return $newArray;
    }
    return false;
}

// Recursively parses through an array and filters out null values.
// Does not filter out value=0.
function arrayFilterRecursive($array) {
    if (!is_array($array)) {
        return $array;
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = arrayFilterRecursive($array[$key]);
        }
        if ($array[$key] == null) {
            unset($array[$key]);
        }
    }
    return $array;
}

// Recursively implode a multi-dimensional array
function r_implode($glue, $pieces) {
    $retVal = array();
    foreach ($pieces as $r_pieces) {
        if (is_array( $r_pieces )) {
            $retVal[] = r_implode( $glue, $r_pieces );
        }   else {
            $retVal[] = $r_pieces;
        }
    }
    return implode( $glue, $retVal );
}

/**
* Convert a slug to human readable form
*/
function humanize($input){
	$input = str_replace("-","_", $input);
	$input = strtolower($input);
	return Inflector::humanize($input);
}

/**
* Returns a datetime formatted to display in the specified timezone
*/
function getDateTime($datetime, $timezone='America/New_York', $format='m/d/Y g:i a T') {
    if (is_string($datetime)) {
        $date = new DateTime($datetime, new DateTimeZone($timezone));
        return $date->format($format);
    } else { // frozenTime passed in
        return $datetime->setTimezone($timezone)->format($format);
    }
}

/**
* Returns a datetime formatted to display as eastern time (EST or EDT depending on date)
*/
function dateTimeEastern($datetime, $format='m/d/Y g:i a T') {
    return getDateTime($datetime, 'America/New_York', $format);
}

/**
* Takes a date/time saved in Central timezone (server time).
* Returns a time converted to Eastern timezone and formatted.
*/
function dateTimeCentralToEastern($datetime, $format='M. d Y, H:i T') {
    $datetime .= ' +1 hour';
    return getDateTime($datetime, 'America/New_York', $format);
}

/**
* Get the eastern timezone abbreviation (EST/EDT)
*/
function getEasternTimezone() {
    return date('I') ? 'EDT' : 'EST';
}

/**
* Get the eastern timezone offset in hours from UTC (4/5)
*/
function getEasternTimezoneOffset() {
    return date('I') ? 4 : 5;
}

/**
* Get the current datetime in eastern (Y-m-d H:i:s format)
*/
function getCurrentEasternTime($format = 'Y-m-d H:i:s') {
    return dateTimeEastern('now', $format);
}

/**
* slugify - makes a string a Slug-Friendly string
*   Leaves capital letters. For a lowercase-only slug, try Inflector::delimit()
* @param mixed $input
* @param string $splitter
* @return string $slugFormattedInput
*/
function slugify($input='', $splitter = "-") {
    if (is_array($input)) {
        foreach ( $input as $key => $val ) {
            $val = ucwords(strtolower($val));
            $input[$key] = trim(preg_replace('/[^A-Za-z0-9-]+/', $splitter, $val));
        }
        return $input;
    } else {
        $input = ucwords(strtolower($input));
        return trim(preg_replace('/[^A-Za-z0-9-]+/', $splitter, $input));
    }
}
/**
* Slugify a region NM-New-Mexico
* @param region with state abbreviation string.
*/
function slugifyRegion($region = null){
    $region = str_replace(' ', '-', $region);
    $region = str_replace('.', '', $region);
    $region_parts = explode('-',$region);
    $region_parts[0] = strtoupper($region_parts[0]);
    for($i = 1; $i < count($region_parts); $i++){
        $region_parts[$i] = slugify($region_parts[$i]);
    }
    return implode('-',$region_parts);
}
/**
* Slugify a city Wilkes-Barre and Albuquerque
*/
function slugifyCity($city){
    $city = cleanCityName($city);
    $city = str_replace(' ', '-', $city);
    $city_parts = explode('-',$city);
    for($i = 0; $i < count($city_parts); $i++){
        $city_parts[$i] = slugify($city_parts[$i]);
    }
    $city = implode('-',$city_parts);
    $city = ($city == 'Coeur-Dalene') ? 'Coeur-dAlene' : $city;
    return $city;
}
function cleanCityName($city) {
    // Remove accents
    $city = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $city);

    // No apostrophes, periods or hyphens.  This breaks things.
    $find = ["'", "’", "‛", "`", "."];
    $city = str_replace($find, "", $city);
    $city = str_replace("-", " ", $city);

    // Remove accents
    $city = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $city);

    // Each word is upper case
    $city = ucwords(strtolower($city));

    // Remove spaces from beginning/end
    $city = trim($city);

    // Remove space from Mc (Should be McCity not Mc City)
    $city = str_replace('Mc ', 'Mc', $city);
    // Uppercase after Mc
    if (strpos($city, 'Mc') === 0) {
        $city = 'Mc'.ucwords(substr($city, 2));
    }

    // Fort should not be spelled out
    $city = str_replace('Fort ', 'Ft ', $city);

    // Saint should not be spelled out
    $city = str_replace('Saint ', 'St ', $city);
    $city = str_replace('Sainte ', 'Ste ', $city);

    // Special case for Coeur d'Alene
    if ($city == 'Coeur Dalene') {
        $city = 'Coeur dAlene';
    }

    return $city;
}
/**
* Clean zip for display
*/
function cleanZip($zip = null){
    $zip = str_replace('-', ' ', $zip);
    if (Configure::read('country') == 'US') {
        // Only use first 5 digits of zip
        $zip = substr($zip, 0, 5);
    }
    return $zip;
}
/**
* Slugify a zip
*/
function slugifyZip($zip = null){
    $zip = str_replace(' ', '-', $zip);
    if (Configure::read('country') == 'US') {
        // Only use first 5 digits of US zip
        $zip = substr($zip, 0, 5);
    }
    return $zip;
}
/**
* Get the word count of a text block
* @param string
* @return int word count of body.
*/
function getWordCount($body) {
    if (!is_string($body)) {
        return 0;
    }
    $body = htmlspecialchars_decode($body);
    $body = html_entity_decode($body);
    $body = strip_tags($body);
    $body = trim($body);
    return str_word_count($body);
}

/**
* Determine if a Configurations-table-based feature is
* 1) turned ON or OFF,
* 2) supposed to be on TODAY,
* 3) and supposed to be on at this TIME
*/
function isFeatureOn($featureName) {
    $configuration = TableRegistry::get('Configurations');
    if (!$configuration->isFeatureEnabled($featureName)) {
        return false;
    }
    if (!$configuration->isFeatureDay($featureName)) {
        return false;
    }
    if (!$configuration->isFeatureTime($featureName)) {
        return false;
    }
    return true;
}

/**
* Search for keywords like [or] in our search queries. Reformat the search correctly.
* @param search query
* @return reformatted search query
*/
function formatSearchQuery($searchQuery) {
    // TODO: Handle '!'
    foreach ($searchQuery as $key => $value) {
        if (!is_array($value) && str_contains($value, '[or]')) {
            $searchQuery[$key] = explode('[or]', $value);
        }
    }
    return $searchQuery;
}

/**
* String to datetime stamp
* @param string that is parsable by str2time
* @return date time string for MYSQL
*/
function str2datetime($str = 'now') {
    if (is_array($str) && isset($str['month']) && isset($str['day']) && isset($str['year'])) {
        $str = "{$str['month']}/{$str['day']}/{$str['year']}";
    }
    return date("Y-m-d H:i:s", strtotime($str));
}

/**
* Divide two numbers, but avoids division by zero. Returns 0 if denom=0.
* @param int numerator
* @param int denominator
* @return float result
*/
function divide($num, $denom) {
    return (!$denom) ? 0 : $num / $denom;
}

/**
* If value is a string, trim it. Otherwise return value.
*/
function trimIfString($value) {
    return is_string($value) ? trim($value) : $value;
}
