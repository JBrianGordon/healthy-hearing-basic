<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;
use Cake\Console\ConsoleIo;
use App\Model\Entity\Location;
use App\Model\Entity\CallSource;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use App\Utility\CallSourceUtility;

/**
 * CallSources Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\CallSource newEmptyEntity()
 * @method \App\Model\Entity\CallSource newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CallSource[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CallSource get($primaryKey, $options = [])
 * @method \App\Model\Entity\CallSource findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CallSource patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CallSource[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CallSource|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CallSource saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CallSource[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CallSource[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CallSource[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CallSource[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CallSourcesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('call_sources');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->like('customer_name', [
                'before' => true,
                'after' => true,
            ])
            ->value('location_id')
            ->value('notes')
            ->value('phone_number')
            ->value('target_number')
            ->value('clinic_number')
            ->value('start_date')
            ->value('end_date')
            ->boolean('is_active')
            ->boolean('is_ivr_enabled')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['phone_number', 'target_number', 'clinic_number'],
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('customer_name')
            ->maxLength('customer_name', 255)
            ->requirePresence('customer_name', 'create')
            ->notEmptyString('customer_name');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 25)
            ->requirePresence('phone_number', 'create')
            ->notEmptyString('phone_number');

        $validator
            ->scalar('target_number')
            ->maxLength('target_number', 25)
            ->requirePresence('target_number', 'create')
            ->notEmptyString('target_number');

        $validator
            ->scalar('clinic_number')
            ->maxLength('clinic_number', 25)
            ->requirePresence('clinic_number', 'create')
            ->notEmptyString('clinic_number');

        $validator
            ->scalar('start_date')
            ->maxLength('start_date', 20)
            ->requirePresence('start_date', 'create')
            ->notEmptyString('start_date');

        $validator
            ->scalar('end_date')
            ->maxLength('end_date', 20)
            ->requirePresence('end_date', 'create')
            ->notEmptyString('end_date');

        $validator
            ->boolean('is_ivr_enabled')
            ->notEmptyString('is_ivr_enabled');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }

    /**
    * Loads the callsource datasource API
    * @param boolean use test datasource
    */
    function loadCallSource($test = false) {
        //TODO: Verify unit tests will not use our prod account
        if ($test || !isset($this->Call)) {
            $this->Call = new CallSourceUtility();
        }
    }

    /**
    * Take in a location_id, and save the callsource customer.
    * If we have a callsource for this customer already, find the number and make sure it matches what we have
    * Otherwise we will provision a new number for this location and save it to the database.
    * @param int locationId
    * @return mixed result of save
    */
    function saveCallSource($locationId = null){
        $this->errors = [];
        try {
            if (!$locationId) {
                $this->errors[] = "Location id not specified";
                return false;
            }
            $location = $this->Locations->find('all', [
                'conditions' => ['Locations.id' => $locationId],
                'contain' => ['CallSources']
            ])->first();
            $this->loadCallSource();

            // Only create CS numbers for active Basic/Enhanced/Premier locations
            if (empty($location)) {
                $this->errors[] = "Location id {$locationId} was not found.";
                return false;
            }
            if (!$location->is_active) {
                $this->errors[] = "Location id {$locationId} is not active.";
                return false;
            }
            if ($location->listing_type == Location::LISTING_TYPE_NONE) {
                // Allow a CS number for special locations with LISTING_TYPE_NONE
                if (!in_array($locationId, CallSource::$specialLocations)) {
                    $this->errors[] = "Location id {$locationId} does not have a valid listing type.";
                    return false;
                }
            }
            foreach ($location->call_sources as $callSource) {
                // There should only be 1 CallSource number per location, update the first one we find.
                $callSourceEntity = $callSource;
                break;
            }
            if (empty($callSourceEntity)) {
                // Did not find an existing CallSource entry - create a new one
                $callSourceEntity = $this->newEmptyEntity();
                // Make it active automatically. We no longer have an activation dashboard to test first.
                $callSourceEntity->is_active = true;
                $callSourceEntity->start_date = date('m/d/Y');
            }
            $zip = $location->zip;
            $callSourceEntity->location_id = $locationId;
            $callSourceEntity->customer_name = $this->getCustomerName($locationId);
            $callSourceEntity->target_number = $location->is_call_assist ? Configure::read('postAdfTargetNumber') : tenDigitPhone($location->phone);
            if (strlen($callSourceEntity->target_number) > 10) {
                $this->errors[] = "Target Phone number not valid: {$callSourceEntity->target_number}";
                return false;
            }
            $callSourceEntity->clinic_number = cleanPhone($location->phone);

            $customerCode = $this->getCustomerCode($locationId);
            $call_source = $this->Call->findByCustomerCode($customerCode);
            $customerContact = $this->getCustomerContact($locationId);

            //we have a customer
            if ($call_source['@status'] == 'OK') {
                // Find the active campaign if one exists
                $call_source['Customer']['Campaign'] = $this->getActiveCampaign($locationId);
                // Do we already have a CallSource number?
                if (isset($call_source['Customer']['Campaign']['DID'])) {
                    if (empty($callSourceEntity->id) ||
                        ($call_source['Customer']['Campaign']['DID']['@Number'] != $callSourceEntity->phone_number)) {
                        // Found a valid Call Source number, but it is not saved correctly in our database.
                        $callSourceEntity->phone_number = $call_source['Customer']['Campaign']['DID']['@Number'];
                        $callSourceEntity->end_date = $call_source['Customer']['Campaign']['EndDate'];
                        // Show location automatically
                        $this->Locations->setShow($locationId, true);
                        $this->save($callSourceEntity);
                    }
                    // We have an existing campaign. Make sure it is updated with correct data.
                    return $this->updateCampaign($locationId);
                } else {
                    //Create campaign and add a number to it.
                    $options = [
                        'campaign' => true,
                        'customer_code' => $customerCode,
                        'name' => $callSourceEntity->customer_name,
                        'target' => $callSourceEntity->target_number,
                        'local' => $callSourceEntity->clinic_number,
                        'zip' => $zip,
                        'customerContact' => $customerContact,
                        'isCallAssist' => $location->is_call_assist
                    ];
                    if ($number = $this->createPhoneForCallSource($options, true)) {
                        $callSourceEntity->phone_number = $number;
                        $callSourceEntity->end_date = '';
                        // Show location automatically
                        $this->Locations->setShow($locationId, true);
                        return $this->save($callSourceEntity);
                    }
                    return false;
                }
            } else {
                //else we do not have a customer, create it, then campaign, then the number.
                $options = [
                    'customer' => true,
                    'customer_code' => $customerCode,
                    'name' => $callSourceEntity->customer_name,
                    'target' => $callSourceEntity->target_number,
                    'local' => $callSourceEntity->clinic_number,
                    'zip' => $zip,
                    'customerContact' => $customerContact,
                    'isCallAssist' => $location->is_call_assist
                ];
                if ($number = $this->createPhoneForCallSource($options, true)) {
                    $callSourceEntity->phone_number = $number;
                    $callSourceEntity->end_date = '';
                    // Show location automatically
                    $this->Locations->setShow($locationId, true);
                    return $this->save($callSourceEntity);
                }
                return false;
            }
        } catch (Exception $e){
            echo "Exception caught in saveCallSource(): {$e->getMessage()}";
            $this->errors[] = "Exception caught in saveCallSource(): {$e->getMessage()}";
            error_log('Exception: ' . $e->getMessage());
        }
        return false;
    }

    /**
    * End result is a full callsource number returned back.
    * Create a customer, campaign and number
    * or
    * Create campaign, and number
    * or
    * Create number
    * @param array of options and settings
    * @param boolean return number only (default true)
    * @return mixed results
    */
    function createPhoneForCallSource($options = array(), $returnNumberOnly = true){
        $this->loadCallSource();
        $options = array_merge([
            'customer' => false,
            'campaign' => false,
            'number' => false,
            'campaign_id' => false,
            'customer_code' => false,
            'name' => false,
            'target' => false,
            'local' => false,
            'zip' => false,
            'customerContact' => [],
            'isCallAssist' => false
        ], $options);

        $options['target'] = cleanPhone($options['target']);
        $options['local'] = cleanPhone($options['local']);

        // Always send customer data. If this is a new customer, it will create it.
        // If the customer already exists, then make sure it is updated with the most recent contact info.
        $result = $this->Call->saveCustomer([
            'CustomerCode' => $options['customer_code'],
            'CustomerName' => $options['name'],
            'DefaultTarget' => $options['target'],
            'CustomerContact' => $options['customerContact']
        ]);
        if (!isset($result['@status']) || $result['@status'] != 'OK') {
            $result['location_id'] = $options['customer_code'];
            $result['msg'] = 'Failed to save customer';
            $result['options'] = $options;
            $this->errors[] = $result;
        }

        if($options['customer'] || $options['campaign']){
            $result = $this->Call->createCampaign(
                $options['customer_code'],
                $options['name'],
                $options['zip'],
                $options['isCallAssist']
            );
            if(!isset($result['Campaign']['@ID'])){
                $result['location_id'] = $options['customer_code'];
                $result['msg'] = 'Failed to create campaign';
                $result['options'] = $options;
                $this->errors[] = $result;
                return ($returnNumberOnly) ? false : $result;
            }
            $options['campaign_id'] = $result['Campaign']['@ID'];
        }
        if($options['customer'] || $options['campaign'] || $options['number']){
            $result = $this->Call->addNumberToCampaign($options['campaign_id'], $options['customer_code'], $options['target'], $options['local']);
            if(!isset($result['@status']) || $result['@status'] != 'OK'){
                $result['location_id'] = $options['customer_code'];
                $result['msg'] = 'Failed to add number to campaign';
                $result['options'] = $options;
                $this->errors[] = $result;
                return ($returnNumberOnly) ? false : $result;
            }
            return ($returnNumberOnly) ? $result['Campaign']['DID']['@Number'] : $result;
        }
        return false;
    }

    public function endInvalidCallSourceNumbers(ConsoleIo $io) {
        $io->helper('BaseShell')->title('Ending invalid CallSource numbers');
        $callSources = $this->find('all', [
            'contain' => ['Locations' => ['fields' => ['Locations.id', 'Locations.listing_type', 'Locations.is_active']]],
            //'contain' => ['Locations'],
            //'fields' => ['DISTINCT location_id'],
            'conditions' => []
        ])->all();
        $count = 0;
        // Find invalid call source numbers
        foreach ($callSources as $callSource) {
            $locationId = $callSource->location_id;
            $isValid = true;
            if (empty($callSource->location->id)) {
                // Location does not exist
                $isValid = false;
            } else {
                if ($callSource->location->listing_type == Location::LISTING_TYPE_NONE ||
                    $callSource->location->is_active == false) {
                    // Allow LISTING_TYPE_NONE for special locations
                    if (!in_array($locationId, CallSource::$specialLocations)) {
                        // Location is inactive or listing type None
                        $isValid = false;
                    }
                }
            }
            if (!$isValid) {
                $io->info('Ending numbers for location '.$locationId);
                // This will end the CS numbers and remove the CS number mapping from our database
                if ($this->endCallSource($locationId)) {
                    $count++;
                    $io->success("success");
                } else {
                    $io->error("f:{$locationId}");
                    pr($this->errors);
                }
            }
        }
        $io->out($count." CS numbers ended");
    }

    /**
    * End ALL campaigns associated with this customer
    * @param int location id
    * @param bool inactivateCustomer - true to inactivate the CS customer
    * @param bool deleteThisRecord - true to delete the CS number from our records
    * @return boolean success
    */
    public function endCallSource($locationId = null, $inactivateCustomer = true, $deleteThisRecord = true){
        $this->errors = [];
        $this->loadCallSource();
        try {
            $customerCode = $this->getCustomerCode($locationId);
            $callSource = $this->Call->findByCustomerCode($customerCode);
            if ($callSource['@status'] == 'OK') {
                // Get the active campaign. The getActiveCampaign() function will end any extras if there are more than one.
                $activeCampaign = $this->getActiveCampaign($locationId);
                $retval = false;
                if (empty($activeCampaign)) {
                    // No active campaigns found for this customer
                    $retval = true;
                } else {
                    $campaignId = $activeCampaign['@ID'];
                    $result = $this->Call->endCampaign($campaignId, $customerCode);
                    if ($result['@status'] == 'OK') {
                        $retval = true;
                    } else {
                        $this->errors[] = $result;
                        $retval = false;
                        if ($result['@'] != 'Cannot modify ended campaign.') {
                            // We failed to end the campaign and it's not already ended.
                            // Log the error and keep our record for now.
                            $deleteThisRecord = false;
                        }
                    }
                }
            } else {
                // Could not find this customer
                if (Configure::read('env') == 'prod') {
                    $this->errors[] = $callSource['@'];
                    $retval = false;
                } else {
                    // On test account, fake success if the customer doesn't exist
                    $retval = true;
                }
            }
            if ($deleteThisRecord) {
                if ($inactivateCustomer) {
                    // We successfully ended the campaign(s). Inactivate this customer.
                    $result = $this->Call->inactivateCustomer($customerCode);
                    if ($result['@status'] != 'OK') {
                        $this->errors[] = 'Failed to inactivate customer';
                        $this->errors[] = $result;
                        $retval = false;
                    }
                }

                //Delete all CallSource records for this location.
                $callSourceIds = $this->find('list', [
                    'conditions' => [
                        'CallSources.location_id' => $locationId,
                    ],
                ])->toArray();
                foreach ($callSourceIds as $callSourceId) {
                    $callSourceEntity = $this->get($callSourceId);
                    $this->delete($callSourceEntity);
                }

                // No-show this clinic
                if ($this->Locations->exists(['id'=>$locationId])) {
                    $locationEntity = $this->Locations->get($locationId);
                    $locationEntity->is_show = false;
                    $this->Locations->save($locationEntity);
                }
            }
            return $retval;
        } catch (Exception $e) {
            echo "Exception caught in endCallSource(): {$e->getMessage()}";
            $this->errors[] = "Exception caught in endCallSource(): {$e->getMessage()}";
        }
        return false;
    }

    /**
    * Pull in the location phone number, and change the active callsource number to the new target number
    * @param location_id
    */
    function updateTargetNumber($location_id = null){
        $this->loadCallSource();
        $location = $this->Locations->findById($location_id);
        $customerCode = $this->getCustomerCode($location_id);
        $call_source = $this->Call->findByCustomerCode($customerCode);
    }

    /**
    * Update customer contact data
    * @param location_id
    */
    function updateCustomer($locationId = null){
        $this->loadCallSource();
        try {
            $customerCode = $this->getCustomerCode($locationId);
            $customerName = $this->getCustomerName($locationId);
            $customerContact = $this->getCustomerContact($locationId);
            $data = [
                'CustomerCode' => $customerCode,
                'CustomerName' => $customerName,
                'CustomerContact' => $customerContact
            ];
            $result = $this->Call->saveCustomer($data);
            if ($result['@status'] == 'OK') {
                $retval = true;
            } else {
                $this->errors[] = $result;
                $retval = false;
            }
        } catch(Exception $e){
            pr("\nException caught in updateCustomer(): ".$e->getMessage());
            pr($data);
            $this->errors[] = "Exception caught in updateCustomer(): {$e->getMessage()}";
            $retval = false;
        }
        return $retval;
    }

    /**
    * Just return raw data of data
    */
    function customerLookup($location_id = null){
        $this->loadCallSource();
        $customerCode = $this->getCustomerCode($location_id);
        return $this->Call->findByCustomerCode($customerCode);
    }

    /**
    * There should only be 1 active campaign per clinic.
    * If there are more than one, keep the oldest and end all newer campaigns.
    * @param locationId
    */
    function getActiveCampaign($locationId = null){
        $activeCampaign = null;
        $this->loadCallSource();
        try {
            $customerCode = $this->getCustomerCode($locationId);
            $csCustomerData = $this->Call->findByCustomerCode($customerCode);
            if ($csCustomerData['@status'] == 'OK') {
                if (isset($csCustomerData['Customer']['Campaign']['@ID'])) {
                    if ($csCustomerData['Customer']['Campaign']['Status'] == 'active') {
                        $activeCampaign = $csCustomerData['Customer']['Campaign'];
                    }
                } elseif (isset($csCustomerData['Customer']['Campaign'][0])) {
                    foreach ($csCustomerData['Customer']['Campaign'] as $campaign) {
                        if ($campaign['Status'] == 'active') {
                            $activeCampaign = $campaign;
                        } else {
                            // We already have an active campaign and should not have more than one.
                            $this->Call->endCampaign($campaign['@ID'], $customerCode);
                        }
                    }
                }
            }
        } catch(Exception $e){
            echo "Exception caught in getActiveCampaign(): {$e->getMessage()}";
            $this->errors[] = "Exception caught in getActiveCampaign(): {$e->getMessage()}";

        }
        return $activeCampaign;
    }

    /**
    * Update an existing campaign. Should be called when clinic phone number changes.
    * @param int locationId
    * @return boolean success
    */
    function updateCampaign($locationId){
        $this->errors = [];
        $callSource = $this->find('all', [
            'contain' => [
                'Locations' => [
                    'fields' => ['phone', 'is_call_assist']
                ]
            ],
            'conditions' => ['location_id' => $locationId],
        ])->first();
        if (empty($callSource)) {
            $this->errors[] = 'No CallSource number found for location '.$locationId;
            return false;
        }
        $localNumber = tenDigitPhone($callSource->location->phone);
        if ($callSource->clinic_number != $localNumber) {
            $callSource->clinic_number = $localNumber;
            $this->save($callSource);
        }
        $csPhoneNumber = $callSource->phone_number;
        $targetNumber = $callSource->location->is_call_assist ? Configure::read('postAdfTargetNumber') : $localNumber;
        if ($callSource->target_number != $targetNumber) {
            $callSource->target_number = $targetNumber;
            $this->save($callSource);
        }
        $this->loadCallSource();
        try {
            $customerCode = $this->getCustomerCode($locationId);
            $activeCampaign = $this->getActiveCampaign($locationId);
            $campaignId = $activeCampaign['@ID'];
            if (!empty($campaignId)) {
                // Update active campaign
                $retval = false;
                $result = $this->Call->updateCampaign($campaignId, $customerCode, $csPhoneNumber, $targetNumber, $localNumber, $callSource->location->is_call_assist);
                if ($result['@status'] == 'OK') {
                    $retval = true;
                } else {
                    $this->errors[] = $result;
                    $retval = false;
                }
                return $retval;
            } else {
                $this->errors[] = 'No active campaigns found';
            }
        } catch(Exception $e){
            echo "Exception caught in updateCampaign(): {$e->getMessage()}";
            $this->errors[] = "Exception caught in updateCampaign(): {$e->getMessage()}";
        }
        return false;
    }

    /**
    * Remove any special characters from clinic name
    */
    private function cleanName($name){
        if (!empty($name)) {
            $name = str_replace('&', 'and', $name);
            $name = htmlentities($name);
            $name = str_replace('&rsquo;', '\'', $name);
            $name = str_replace('&nbsp;', ' ', $name);
            $name = str_replace('&ndash;', '-', $name);
            $name = str_replace('&ntilde;', 'n', $name);
            $name = html_entity_decode(trim($name));
        }
        return $name;
    }

    /**
    * End a specific campaign for the given location.
    * @param int location id
    * @param int phone number to end
    * @return boolean success
    */
    function endCampaign($locationId, $phoneNumber){
        $this->errors = [];
        $this->loadCallSource();
        try {
            $deleteThisRecord = true;
            $customerCode = $this->getCustomerCode($locationId);
            $callSource = $this->Call->findByCustomerCode($customerCode);
            if ($callSource['@status'] == 'OK') {
                // Find the campaign
                if (isset($callSource['Customer']['Campaign']['@ID'])) {
                    if (isset($callSource['Customer']['Campaign']['DID']['@Number']) &&
                        ($callSource['Customer']['Campaign']['DID']['@Number'] == $phoneNumber)) {
                        $campaignId = $callSource['Customer']['Campaign']['@ID'];
                    }
                } elseif (isset($callSource['Customer']['Campaign'][0])) {
                    foreach ($callSource['Customer']['Campaign'] as $campaign) {
                        if (isset($campaign['DID']) && ($campaign['DID']['@Number'] == $phoneNumber)) {
                            $campaignId = $campaign['@ID'];
                            break;
                        }
                    }
                }
                // End the campaign
                if (isset($campaignId)) {
                    $result = $this->Call->endCampaign($campaignId, $customerCode);
                    if ($result['@status'] == 'OK') {
                        $retval = true;
                    } else {
                        if ($result['@'] == 'Cannot modify ended campaign.') {
                            $retval = true;
                        } else {
                            // Ending campaign failed for some other reason. Keep our record for now and look into the error.
                            $deleteThisRecord = false;
                            $this->errors[] = $result;
                            $retval = false;
                        }
                    }
                } else {
                    // Did not find the specified campaign. This is likely to happen on dev/qa, but display an error on prod.
                    if (Configure::read('env') == 'prod') {
                        $this->errors[] = 'Did not find the specified campaign: locationId='.$locationId.', phoneNumber='.$phoneNumber;
                        $retval = false;
                    } else {
                        $retval = true;
                    }
                }
            } else {
                // Could not find this customer
                $this->errors[] = $callSource;
                $retval = false;
            }
            // Delete the CallSource record
            if ($deleteThisRecord) {
                $callSource = $this->find('all', [
                    'contain' => [],
                    'conditions' => [
                        'CallSource.location_id' => $locationId,
                        'CallSource.phone_number' => $phoneNumber,
                    ],
                ])->first();
                if (!empty($callSource->id)) {
                    $this->delete($callSource->id);
                }
            }
            return $retval;
        } catch (Exception $e) {
            echo "Exception caught in endCampaign(): {$e->getMessage()}";
            $this->errors[] = "Exception caught in endCampaign(): {$e->getMessage()}";
        }
        return false;
    }

    /**
    * Return the CustomerCode for a given locationId
    * @param locationId
    * @return CustomerCode
    */
    function getCustomerCode($locationId) {
        $customerCodePrefix = Configure::read('callSourcePrefix');
        return $customerCodePrefix.$locationId;
    }

    /**
    * Generate the CustomerName for a given locationId
    * @param locationId
    * @return CustomerName
    */
    function getCustomerName($locationId) {
        $location = $this->Locations->find('all', [
            'contain' => [],
            'conditions' => ['id' => $locationId],
            'fields' => ['title']
        ])->first();
        $customerName = $this->cleanName("{$locationId}-".$location->title);
        if (!empty(Configure::read('callSourcePrefix'))) {
            // Customer names should start with a prefix for Canada. CallSource will use this to split out billing, reporting, etc.
            $customerName = Configure::read('callSourcePrefix') . $customerName;
        }
        return $customerName;
    }

    /**
    * Return the CustomerContact array for a given locationId
    * @param locationId
    * @return CustomerContact
    */
    function getCustomerContact($locationId) {
        $location = $this->Locations->find('all', [
            'contain' => [],
            'conditions' => ['id' => $locationId],
        ])->first();
        $customerContact = [
            'ContactName' => $this->cleanName($location->title),
            'ContactAddress1' => $this->cleanName($location->address),
            'ContactAddress2' => $this->cleanName($location->address_2),
            'ContactCity' => $location->city,
            'ContactState' => $location->state,
            'ContactZIP' => $location->zip,
            'ContactCountry' => Configure::read('country'),
            'ContactPhone' => tenDigitPhone($location->phone),
        ];
        return $customerContact;
    }

    /**
    * Save a new Ad Source
    */
    function saveAdSource($adSource) {
        if (!empty($adSource)) {
            $this->loadCallSource();
            return $this->Call->saveAdSource($adSource);
        }
    }

    // Temporarily allow the test CS account to be written
    // Remember to call disallowCsTest() after
    function allowCsTest(){
        $this->loadCallSource();
        $this->Call->allowCsTest();
    }
    function disallowCsTest(){
        $this->loadCallSource();
        $this->Call->disallowCsTest();
    }
}
