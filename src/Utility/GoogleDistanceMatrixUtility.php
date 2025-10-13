<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Query\GeocodeQuery;
use GuzzleHttp\Client;

class GoogleDistanceMatrixUtility
{
    private $apiKey;
    private $googleDistanceMatrix;
    private $httpClient;

    public function __construct()
    {
        $this->apiKey = Configure::read('GoogleMaps.WebServicesApiKey');
        $this->googleDistanceMatrix = 'https://maps.googleapis.com/maps/api/distancematrix/json';
        $this->httpClient = new Client([
            'timeout' => 2000,
        ]);
    }

    /**
    * Takes origin and destination addresses and returns distance and travel time between them (by car).
    * @param string address fragment
    * @return mixed result of geolocation from google
    */
    public function byDistance($origin, $destination) {
        if ($origin && $destination) {
            $request = $this->googleDistanceMatrix . '?units=imperial&origins=' . urlencode($origin) . '&destinations=' . urlencode($destination) . '&key=' . $this->apiKey;
            $this->__requestLog[] = $request;
            try {
                $response = $this->httpClient->get($request);
                $statusCode = $response->getStatusCode();
                $responseData = json_decode($response->getBody()->getContents(), true);
            } catch (Exception $e) {
                return false;
            }
            if ($statusCode == 200) {
                $retval = [
                    'google' => $responseData
                ];
                return $retval;
            }
        }
        return false;
    }
}
