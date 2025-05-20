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
        $geoLocRaw = $this->provider->geocodeQuery(GeocodeQuery::create($address))->first();

        $latLon = [
            $geoLocRaw->getCoordinates()->getLatitude(),
            $geoLocRaw->getCoordinates()->getLongitude(),
        ];

        return $latLon;
    }
}
