<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use GuzzleHttp\Client;
use Cake\Utility\Xml;
use App\Model\Entity\Location;

class CallSourceUtility
{
    /**
     * @var array
     */
    private $defaultConfig;

    public function __construct()
    {
        $this->uri = 'http://xml.callsource.com/services/Provision';
        $this->callSourceUsername = Configure::read('callSourceUsername');
        $this->callSourcePassword = Configure::read('callSourcePassword');
        $this->httpClient = new Client([
            'base_uri' => $this->uri,
            'timeout' => 10,
        ]);
        $this->adSource = Configure::read('callSourceAdSource');
        $this->isTestAccount = ($this->callSourceUsername == 'xmluser_hh') ? true : false;
        $this->whisperFile = $this->isTestAccount ? 'healthyhearingwspr3.wav' : 'healthyhearingwspr2.wav';
        // In most cases we do not want to create customers and campaigns in our test account
        $this->allowTest = false;
        $this->xmlHeader = '<?xml version="1.0" encoding="UTF-8" ?>';
    }

    /**
    * Signed request string to pass to CallSource
    *
    * @var string
    * @access protected
    */
    var $_request = null;

    /**
    * XML string
    * @var string
    * @access protected
    */
    var $_xml = null;

    /**
    * requesting method to use for parsing result
    * @var string
    * @access public
    */
    var $method = null;

    /**
    * Request Logs
    *
    * @var array
    * @access private
    */
    var $__requestLog = [];

    /**
    * Make a call to the CallSource API
    * @param string method name
    * - GetProvisioningInfoRequest
    * - CustomerRequest
    * - CampaignRequest
    * - etc...
    * @param array of data @see buildXmlFromArray for data structure
    * @param array of options for the supplied method.
    */
    function api($method = null, $data = [], $options = []){
        return $this->__request($this->buildXmlFromArray($data), $method, $options);
    }

    /**
    * Find by a customer code
    * @param customer_code to find
    */
    function findByCustomerCode($customer_code = null){
        $data = [
            'CustomerCode|{"contact":"true","target":"true"}' => $customer_code
        ];
        // This API call is always allowed on test account
        return $this->api('GetProvisioningInfoRequest', $data);
    }

    /**
    * Add/Modify a customer
    * @param array of data to save
    * - CustomerCode => 'code',
    * - CustomerName => 'name'
    * - DefaultTarget => '5551234567' # 10 digit number only
    */
    function saveCustomer($data = []){
        // Do not save customer to test account unless allowed
        if (!$this->isTestAccount || $this->allowTest) {
            $data = ['Customer' => $data];
            return $this->api('CustomerRequest', $data);
        } else {
            // When tests are disabled, fake success.
            return ['@status' => 'OK'];
        }
    }

    /**
    * Inactivate a customer - this should be done AFTER ending all campaigns
    * @param customerCode to inactivate
    */
    function inactivateCustomer($customerCode = null){
        $result = $this->saveCustomer([
            'CustomerCode' => $customerCode,
            'Status' => 'inactive'
        ]);
        return $result;
    }

    /**
    * Always create a new campaign
    * @param customerCode
    * @param name of campaign
    * @param zipcode to use.
    * @param bool - isCallAssist
    * @return mixed result
    */
    function createCampaign($customerCode, $name, $zip, $isCallAssist) {
        // Add a new zip code ad source.
        // Note: do not save a duplicate of the main ad source (healthyhearing.com/hearingdirectory.ca)
        //if (!empty($zip)) {
        //  $this->saveAdSource($zip, 'Zip Code');
        //}
        if (Configure::read('country') == 'CA') {
            // All Canadian clinics will use leadscore and call recording, but no whisper message. Calls are sent to clinic.
            $callReviewKey = 'CallReview|{"enabled":"true"}';
            $whisperKey = 'Whisper|{"enabled":"false"}';
            $whisperValue = '';
            $postAdfKey = 'PostADF|{"enabled":"false"}';
            $postAdfValue = '';
        } elseif (in_array($customerCode, Location::$northGeorgiaAudiology)) {
            // North Georgia Audiology will not use call recording, whisper or leadscore. Calls are sent to clinic.
            $callReviewKey = 'CallReview|{"enabled":"false"}';
            $whisperKey = 'Whisper|{"enabled":"false"}';
            $whisperValue = '';
            $postAdfKey = 'PostADF|{"enabled":"false"}';
            $postAdfValue = '';
        } elseif (!$isCallAssist) {
            // US non-Call Assist clinics will use leadscore, call recording, and whisper message. Calls are sent to clinic.
            $callReviewKey = 'CallReview|{"enabled":"true"}';
            $whisperKey = 'Whisper|{"enabled":"true"}';
            $whisperValue = [
                'Type' => 'begin',
                'File' => $this->whisperFile
            ];
            $postAdfKey = 'PostADF|{"enabled":"false"}';
            $postAdfValue = '';
        } else {
            // US Call Assist clinics will use call recording, but not leadscore or whisper message. Calls are sent to call center with XML.
            $callReviewKey = 'CallReview|{"enabled":"true"}';
            $whisperKey = 'Whisper|{"enabled":"false"}';
            $whisperValue = '';
            $postAdfKey = 'PostADF|{"enabled":"true"}';
            $postAdfValue = [
                'Timing' => 'start',
                'Template' => 'ADFEmailTemplateXML.txt',
                'URL' => 'http://budevsupport01.callsource.com/crmtools/crm_re-direct.php?url=https://hhcs.oticon.com/PostXmlData.aspx'
            ];
        }
        $data = [
            'Customer' => [
                'CustomerCode' => $customerCode
            ],
            'Campaign|{"ID":"new"}' => [
                'Name' => $name,
                'StartDate' => date('m/d/Y'),
                'EndDate' => date('m/d/Y', strtotime('01/01/2025')),
                'AdSource|{"dimension":"Ad Source"}' => $this->adSource,
                'AdSource|{"dimension":"Zip Code"}' => '0',
                'MailMaster' => 'true',
                'EmailADF|{"enabled":"false"}' => '',
                $postAdfKey => $postAdfValue,
                'VoiceMail|{"enabled":"false"}' => '',
                $callReviewKey => '',
                $whisperKey => $whisperValue
            ]
        ];
        if ($this->isTestAccount) {
            // The test account does not have a Zip Code ad source
            unset($data['Campaign|{"ID":"new"}']['AdSource|{"dimension":"Zip Code"}']);
        }
        return $this->saveCampaign($data);
    }

    /**
    * Save a campaign to a customer
    * @param array of data to save
    * - 'Customer' => array('CustomerCode' => 'code'),
    * - 'Campaign' => array()
    */
    function saveCampaign($data = []){
        // Do not save campaigns to test account unless allowed
        if (!$this->isTestAccount || $this->allowTest) {
            return $this->api('CampaignRequest', $data, ['autoCreateIfNew' => 'true', 'returnResult' => 'true']);
        } else {
            // When tests are disabled, fake success.
            return ['@status' => 'OK'];
        }
    }

    /**
    * Save an adsource to callsource
    * @param string name
    * @param string dimension
    */
    function saveAdSource($name = null, $dimension = 'Ad Source'){
        // Do not save adsource to test account unless allowed
        if (!$this->isTestAccount || $this->allowTest) {
            return $this->api('AdSourceRequest', ['AdSource|{"dimension":"'.$dimension.'"}' => $name]);
        } else {
            // When tests are disabled, fake success.
            return ['@status' => 'OK'];
        }
    }

    /**
    * End a campaign by setting the endDate to today.
    * @param string campaign_id
    * @param string customer_code
    * @return mixed result
    */
    function endCampaign($campaign_id = null, $customer_code = null){
        if ($this->isTestAccount) {
            // Test account campaigns do not need a referral period
            return $this->endCampaignNoReferral($campaign_id, $customer_code);
        }
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'EndDate' => date('m/d/Y'),
                'ReferralEndDate' => date('m/d/Y', strtotime('+1 month')),
            ]
        ];
        return $this->saveCampaign($data);
    }

    /**
    * End a campaign with no referral by setting the endDate and ReferralEndDate to today.
    * @param string campaign_id
    * @param string customer_code
    * @return mixed result
    */
    function endCampaignNoReferral($campaign_id = null, $customer_code = null){
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'EndDate' => date('m/d/Y'),
                'ReferralEndDate' => date('m/d/Y'),
            ]
        ];
        // Allow ending campaigns on test account
        $this->allowCsTest();
        $result = $this->saveCampaign($data);
        $this->disallowCsTest();
        return $result;
    }

    /**
    * End a campaign by setting the endDate to today.
    * @param string campaign_id
    * @param string customer_code
    * @param datetime endDate
    * @return mixed result
    */
    function changeCampaignEndDate($campaign_id = null, $customer_code = null, $endDate = null){
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'EndDate' => date('m/d/Y', $endDate),
            ]
        ];
        return $this->saveCampaign($data);
    }

    /**
    * Disconnect the callsource number
    * @param string campaign_id
    * @param string customer_code
    * @param string target_number
    * @return mixed result
    */
    function disconnectNumber($campaign_id = null, $customer_code = null, $target_number = null){
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'DID|{"Number":"'.$target_number.'","Disconnected":"true"}' => ''
            ]
        ];
        return $this->saveCampaign($data);
    }

    /**
    * Reconnect the callsource number
    * @param string campaign_id
    * @param string customer_code
    * @param string target_number
    * @return mixed result
    */
    function reconnectNumber($campaign_id = null, $customer_code = null, $target_number = null){
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'DID|{"Number":"'.$target_number.'","Disconnected":"false"}' => ''
            ]
        ];
        return $this->saveCampaign($data);
    }

    /**
    * Change the target number to a campaign
    * @param campaign_id
    * @param customer_code
    * @param did_number (callsource number)
    * @param target_number
    * @return mixed result
    */
    function changeTargetToCampaign($campaign_id = null, $customer_code = null, $did_number = null, $target_number = null){
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'DID|{"Number":"'.$did_number.'","Local":"true"}' => [
                    'Target|{"Number":"'.$target_number.'","Timezone":"US/Eastern"}' => ''
                ]
            ]
        ];
        return $this->saveCampaign($data);
    }

    /**
    * Update an existing campaign. Used when the clinic phone number changes.
    * @param campaignId
    * @param customerCode
    * @param didNumber (callsource number)
    * @param targetNumber
    * @param localNumber (clinic direct phone)
    * @param isCallAssist
    * @return mixed result
    */
    function updateCampaign($campaignId, $customerCode, $didNumber, $targetNumber, $localNumber, $isCallAssist) {
        if (Configure::read('country') == 'CA') {
            // All Canadian clinics will use leadscore and call recording, but no whisper message. Calls are sent to clinic.
            $callReviewKey = 'CallReview|{"enabled":"true"}';
            $whisperKey = 'Whisper|{"enabled":"false"}';
            $whisperValue = '';
            $postAdfKey = 'PostADF|{"enabled":"false"}';
            $postAdfValue = '';
        } elseif (in_array($customerCode, Location::$northGeorgiaAudiology)) {
            // North Georgia Audiology will not use call recording, whisper or leadscore. Calls are sent to clinic.
            $callReviewKey = 'CallReview|{"enabled":"false"}';
            $whisperKey = 'Whisper|{"enabled":"false"}';
            $whisperValue = '';
            $postAdfKey = 'PostADF|{"enabled":"false"}';
            $postAdfValue = '';
        } elseif (!$isCallAssist) {
            // US non-Call Assist clinics will use leadscore, call recording, and whisper message. Calls are sent to clinic.
            $callReviewKey = 'CallReview|{"enabled":"true"}';
            $whisperKey = 'Whisper|{"enabled":"true"}';
            $whisperValue = [
                'Type' => 'begin',
                'File' => $this->whisperFile
            ];
            $postAdfKey = 'PostADF|{"enabled":"false"}';
            $postAdfValue = '';
        } else {
            // US Call Assist clinics will use call recording, but not leadscore or whisper message. Calls are sent to call center with XML.
            $callReviewKey = 'CallReview|{"enabled":"true"}';
            $whisperKey = 'Whisper|{"enabled":"false"}';
            $whisperValue = '';
            $postAdfKey = 'PostADF|{"enabled":"true"}';
            $postAdfValue = [
                'Timing' => 'start',
                'Template' => 'ADFEmailTemplateXML.txt',
                'URL' => 'http://budevsupport01.callsource.com/crmtools/crm_re-direct.php?url=https://hhcs.oticon.com/PostXmlData.aspx'
            ];
        }
        $data = [
            'Customer' => [
                'CustomerCode' => $customerCode
            ],
            'Campaign|{"ID":"'.$campaignId.'"}' => [
                $callReviewKey => '',
                'AdSource|{"dimension":"Ad Source"}' => $this->adSource,
                'AdSource|{"dimension":"Zip Code"}' => '0',
                $whisperKey => $whisperValue,
                $postAdfKey => $postAdfValue,
                'DID|{"Number":"'.$didNumber.'"}' => [
                    'Target|{"Number":"'.$targetNumber.'","Timezone":"US/Eastern"}' => '',
                    'ExtensionRouting|{"autoActivate":"false"}' => ''
                ]
            ]
        ];
        if ($this->isTestAccount) {
            // The test account does not have a Zip Code ad source
            unset($data['Campaign|{"ID":"'.$campaignId.'"}']['AdSource|{"dimension":"Zip Code"}']);
        }
        return $this->saveCampaign($data);
    }

    /**
    * Add a number to a campaign
    * @param campaign_id
    * @param customer_code
    * @param target_number
    * @param local_number - to force areacode/nxx to be different from target number
    * @return mixed result
    */
    function addNumberToCampaign($campaign_id = null, $customer_code = null, $target_number = null, $local_number = null){
        if (!empty($local_number)) {
            $area_code = substr($local_number, 0, 3);
            $nxx = substr($local_number, 3, 3);
        } else {
            $area_code = substr($target_number, 0, 3);
            $nxx = substr($target_number, 3, 3);
        }
        $localHub = Configure::read('callSourceLocalHub');

        // A: Try to find the closest local number within the same NPA
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'DID|{"Number":"new","Local":"true"}' => [
                    'NPA' => $area_code,
                    'NXX' => $nxx,
                    'LocalMatchType|{"matchNPA":"true"}' => 'Local',
                    'Target|{"Number":"'.$target_number.'","Timezone":"US/Eastern"}' => '',
                    'ExtensionRouting|{"autoActivate":"false"}' => ''
                ]
            ]
        ];
        if (!empty($localHub)) {
            $data['Campaign|{"ID":"'.$campaign_id.'"}']['DID|{"Number":"new","Local":"true"}']['Hub'] = $localHub;
        }
        $result = $this->apiAddNumberToCampaign($data);
        if ($result['@status'] == 'OK') {
            return $result;
        }

        // B: If that failed, try to find a number within overlay areas (close other NPA)
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'DID|{"Number":"new","Local":"true"}' => [
                    'NPA' => $area_code,
                    'NXX' => $nxx,
                    'LocalMatchType|{"matchNPA":"false"}' => 'Local',
                    'Target|{"Number":"'.$target_number.'","Timezone":"US/Eastern"}' => '',
                    'ExtensionRouting|{"autoActivate":"false"}' => ''
                ]
            ]
        ];
        if (!empty($localHub)) {
            $data['Campaign|{"ID":"'.$campaign_id.'"}']['DID|{"Number":"new","Local":"true"}']['Hub'] = $localHub;
        }
        $result = $this->apiAddNumberToCampaign($data);
        if ($result['@status'] == 'OK') {
            return $result;
        }

        // C: If that failed, try to find any number within same NPA (could result in a toll-charge)
        if (Configure::read('allowTollCharges')) {
            $data = [
                'Customer' => [
                    'CustomerCode' => $customer_code
                ],
                'Campaign|{"ID":"'.$campaign_id.'"}' => [
                    'DID|{"Number":"new","Local":"true"}' => [
                        'NPA' => $area_code,
                        'NXX' => $nxx,
                        'LocalMatchType' => 'NPA',
                        'Target|{"Number":"'.$target_number.'","Timezone":"US/Eastern"}' => '',
                        'ExtensionRouting|{"autoActivate":"false"}' => ''
                    ]
                ]
            ];
            if (!empty($localHub)) {
                $data['Campaign|{"ID":"'.$campaign_id.'"}']['DID|{"Number":"new","Local":"true"}']['Hub'] = $localHub;
            }
            $result = $this->apiAddNumberToCampaign($data);
            if ($result['@status'] == 'OK') {
                return $result;
            }
        }

        // D: If that failed, try to find a toll-free number
        $data = [
            'Customer' => [
                'CustomerCode' => $customer_code
            ],
            'Campaign|{"ID":"'.$campaign_id.'"}' => [
                'DID|{"Number":"new","Local":"false"}' => [
                    'Target|{"Number":"'.$target_number.'","Timezone":"US/Eastern"}' => '',
                    'ExtensionRouting|{"autoActivate":"false"}' => ''
                ]
            ]
        ];
        $result = $this->apiAddNumberToCampaign($data);
        if ($result['@status'] == 'OK') {
            return $result;
        }

        return false;
    }

    /**
    * Call the API to add a number to a campaign
    * @param array of data to save
    */
    function apiAddNumberToCampaign($data = []){
        // Do not add numbers to test account unless allowed
        if (!$this->isTestAccount || $this->allowTest) {
            return $this->api('AddNumberToCampaignRequest', $data, ['returnResult' => 'true']);
        } else {
            // When tests are disabled, fake success.
            return ['@status' => 'OK'];
        }
    }

    /**
    * Build the XML with the method call.
    * @param xml to put in body
    * @param parent method to call
    * @param options to pass into method
    * @return boolean success
    */
    function buildXml($xml = null, $method = null, $options = []){
        if($method){
            $this->method = $method;
        }
        if(!empty($this->method)){
            $this->_xml = $this->elem('CallSourceService', [],
                $this->elem($this->method, $options,
                    $xml
                )
            );
            return true;
        }
        return false;
    }

    /**
    * Build a full XML document from associative array
    * @param array of data to create xml document out of
    * @example:
    *   $data = array(
    *       'CallSource' => array(
    *           'Customer' => array(
    *               'CustomerCode|{"flag":"true"}' => 'sample_code1',
    *               'CustomerName' => 'Test Clinic',
    *               'DefaultTarget' => '5057023639'
    *           ),
    *           'Campaign|{"returnResult":"true"}' => array(
    *               'SomeTag' => 'value'
    *           ),
    *           'Username' => 'username'
    *       )
    *   );
    * @param boolean include headers (default false)
    */
    function buildXmlFromArray($array = [], $headers = false){
        $retval = $headers ? $this->xmlHeader : "";
        foreach($array as $tag_options => $value){
            if(strpos($tag_options,"|")){
                list($tag, $options) = explode("|", $tag_options);
                $options = json_decode($options, true);
            }   else {
                $tag = $tag_options;
                $options = [];
            }
            if(is_array($value)){
                $retval .= $this->elem($tag, $options, $this->buildXmlFromArray($value, false));
            }   else {
                $retval .= $this->elem($tag, $options, $value);
            }
        }
        return $retval;
    }

    /**
    * Preform the request to the API
    * @param string xml to request
    * @param string method
    * @param array of options to pass into method
    * @param mixed result of request
    */
    function __request($xml = null, $method = null, $options = []){
        if($this->buildXml($xml, $method, $options)){
            $this->__signRequest();
            $this->__requestLog[] = $this->_request;
            $result = $this->httpClient->post($this->uri, ['body'=>$this->_request]);
            return $this->__parseResult($result);
        }
        return false;
    }

    /**
    * Parse the result of API call
    * @param returning xml result
    * @return deep result of query
    */
    function __parseResult($result){
        $result = Xml::toArray(Xml::build($result->getBody()->getContents()));
        $key = str_replace("Request",'Response', $this->method);
        return isset($result['CallSource']['CallSourceService'][$key]) ? $result['CallSource']['CallSourceService'][$key] : $result;
    }

    /**
    * Sign the request username and authentication token
    */
    function __signRequest(){
        $username = $this->elem('Username', [], $this->callSourceUsername);
        $authentication = $this->elem('Authentication', [], $this->authenticationToken());
        $callsource = $this->elem('CallSource', ['version' => 'E'], $username . $authentication . $this->_xml);
        $this->_request = $this->xmlHeader . $callsource;
    }

    /**
    * Generate the Authentication Token
    * username-password-current time-entire contents of CallSourceService tag
    */
    function authenticationToken(){
        $current_time = gmdate("YmdH");
        $string_to_token = "{$this->callSourceUsername}-{$this->callSourcePassword}-$current_time-" . $this->_xml;
        $token = strtoupper(md5($string_to_token));
        return $token;
    }

    private function elem($name, $attributes = [], $content = null){
        $attributes['@'] = $content;
        $data = [
            $name => $attributes
        ];
        $retval = Xml::fromArray($data, ['format' => 'attribute', 'encoding' => ''])->asXML();
        $retval = str_replace(["<?xml version=\"1.0\"?>","\n"], "", $retval);
        return html_entity_decode($retval);
    }

    // Temporarily allow the test CS account to be written
    // Remember to call disallowCsTest() after
    function allowCsTest(){
        $this->allowTest = true;
    }
    function disallowCsTest(){
        $this->allowTest = false;
    }
}
