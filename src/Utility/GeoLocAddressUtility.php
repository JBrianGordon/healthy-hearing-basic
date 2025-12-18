<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Query\GeocodeQuery;
use GuzzleHttp\Client;

class GeoLocAddressUtility
{
    /**
     * @var array
     */
    private $defaultConfig;

    /**
     * @var \Geo\Geocoder\Geocoder
     */
    private $geocoder;

    public function __construct()
    {
        $this->httpClient = new Client();

        $this->provider = new GoogleMaps($this->httpClient, null, Configure::read('GoogleMaps.WebServicesApiKey'));
    }

    public function byAddress($address)
    {
        $geoLocResult = $this->provider->geocodeQuery(GeocodeQuery::create($address))->first();

        if (empty($geoLocResult->getLocality())) {
            // Unable to locate this address
            return false;
        }

        $geoLocInfo = [
            'zip' => $geoLocResult->getPostalCode(),
            'city' => $geoLocResult->getLocality(),
            'state' => $geoLocResult->getAdminLevels()->first()->getCode(),
            'country' => $geoLocResult->getCountry()->getCode(),
            'lat' => $geoLocResult->getCoordinates()->getLatitude(),
            'lon' => $geoLocResult->getCoordinates()->getLongitude(),
        ];

        return $geoLocInfo;
    }
}
