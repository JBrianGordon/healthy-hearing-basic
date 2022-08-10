<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Geo\Geocoder\Geocoder;

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
        $this->defaultConfig = [
            'allowInconclusive' => true,
            'minAccuracy' => Geocoder::TYPE_POSTAL,
            'apiKey' => Configure::read('GoogleMap.key'),
        ];
        $this->geocoder = new Geocoder($this->defaultConfig);
    }

    public function byAddress($address)
    {
        return $this->geocoder->geocode($address);
    }
}
