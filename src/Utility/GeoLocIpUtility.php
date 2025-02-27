<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\App;
use Geocoder\Provider\GeoIP2\GeoIP2;
use Geocoder\Provider\GeoIP2\GeoIP2Adapter;
use Geocoder\Query\GeocodeQuery;
use GeoIp2\Database\Reader;
use Cake\Core\Configure;

class GeoLocIpUtility
{
    /**
     * @var array
     */
    private $defaultConfig;

    /**
     * @var \Geocoder\Provider\GeoIP2\GeoIP2\Database\Reader
     */
    private $reader;

    /**
     * @var \Geocoder\Provider\GeoIP2\GeoIP2Adapter
     */
    private $adapter;

    /**
     * @var \Geocoder\Provider\GeoIP2\GeoIP2
     */
    private $geocoder;

    public function __construct()
    {
        $this->reader = new Reader(App::path('ipDatabase')[0]);
        $this->adapter = new GeoIP2Adapter($this->reader);
        $this->geocoder = new GeoIP2($this->adapter);
    }

    public function byIp($ip)
    {
        $geoLocRaw = $this->geocoder->geocodeQuery(GeocodeQuery::create($ip));
        $geoLocInfo = [];

        if ($geoLocRaw->count() > 0) {
            $geoLocResult = $geoLocRaw->first();
            $geoLocInfo = [
                'zip' => $geoLocResult->getPostalCode(),
                'city' => $geoLocResult->getLocality(),
                'state' => $geoLocResult->getAdminLevels()->first()->getCode(),
                'country' => $geoLocResult->getCountry()->getCode(),
                'latitude' => $geoLocResult->getCoordinates()->getLatitude(),
                'longitude' => $geoLocResult->getCoordinates()->getLongitude(),
            ];
            if (!$this->isValidZip($geoLocInfo['zip'])) {
                // Clear zip if not valid
                $geoLocInfo['zip'] = null;
            }
        }

        return $geoLocInfo;
    }

    /**
    * tests a string to see if it is a valid zip code
    * @param string $input - (query)string which will be tested
    * @return bool
    */
    private function isValidZip($input) {
        $country = Configure::read('country');
        if ($country == 'US') {
            $regex = '/^((\d{5}-\d{4})|(\d{5})|([AaBbCcEeGgHhJjKkLlMmNnPpRrSsTtVvXxYy]\d[A-Za-z]\s?\d[A-Za-z]\d))$/';
        } elseif ($country == 'CA') {
            $regex = '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/';
        }
        return (preg_match($regex,$input));
    }
}
