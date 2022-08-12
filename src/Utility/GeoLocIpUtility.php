<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\App;
use Geocoder\Provider\GeoIP2\GeoIP2;
use Geocoder\Provider\GeoIP2\GeoIP2Adapter;
use Geocoder\Query\GeocodeQuery;
use GeoIp2\Database\Reader;

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
        }

        return $geoLocInfo;
    }
}
