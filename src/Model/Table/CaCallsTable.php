<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ConnectionManager;
use Cake\Event\EventInterface;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\CaCall;
use App\Model\Entity\Location;
use App\Utility\GoogleDistanceMatrixUtility;

/**
 * CaCalls Model
 *
 * @property \App\Model\Table\CaCallGroupsTable&\Cake\ORM\Association\BelongsTo $CaCallGroups
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CaCall newEmptyEntity()
 * @method \App\Model\Entity\CaCall newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CaCall[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CaCall get($primaryKey, $options = [])
 * @method \App\Model\Entity\CaCall findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CaCall patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CaCall[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CaCall|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaCall saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
 */
class CaCallsTable extends Table
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

        $this->setTable('ca_calls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);
        $this->addBehavior('CounterCache', [
            'CaCallGroups' => ['ca_call_count'],
        ]);

        $this->belongsTo('CaCallGroups', [
            'foreignKey' => 'ca_call_group_id',
            'joinType' => 'LEFT',
            'className' => 'CaCallGroups',
            'propertyName' => 'ca_call_group'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('ca_call_group_id')
            ->value('user_id', ['multiValue' => true])
            ->value('duration')
            ->value('call_type', ['multiValue' => true])
            ->value('recording_url')
            ->value('recording_duration')
            ->value('CaCallGroups.status', ['multiValue' => true])
            ->value('CaCallGroups.score', ['multiValue' => true])
            ->value('CaCallGroups.location_id')
            ->value('CaCallGroups.caller_first_name')
            ->value('CaCallGroups.caller_last_name')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['CaCallGroups.caller_first_name', 'CaCallGroups.caller_last_name'],
            ])
            ->add('start_time_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["start_time >=" => $args['start_time_start']]);
                }
            ])
            ->add('start_time_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["start_time <=" => $args['start_time_end']]);
                }
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
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->integer('duration')
            ->allowEmptyString('duration');

        $validator
            ->scalar('call_type')
            ->maxLength('call_type', 255)
            ->allowEmptyString('call_type');

        $validator
            ->scalar('recording_url')
            ->maxLength('recording_url', 255)
            ->allowEmptyString('recording_url');

        $validator
            ->integer('recording_duration')
            ->allowEmptyString('recording_duration');

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
        $rules->add($rules->existsIn('ca_call_group_id', 'CaCallGroups'), ['errorField' => 'ca_call_group_id']);
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \ArrayObject<string, mixed> $data
     * @param \ArrayObject<string, mixed> $options
     * @return void
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
        $dateTimeFields = ['start_time'];
        foreach ($dateTimeFields as $key) {
            if (!empty($data[$key]) && is_string($data[$key])) {
                $data[$key] = date('Y-m-d H:i', strtotime($data[$key]));
            }
        }
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            if (empty($entity->duration)) {
                $entity->duration = 0;
            }
            if (empty($entity->recording_duration)) {
                $entity->recording_duration = 0;
            }
        }
        return true;
    }

    /**
    * Get the outbound call type based on current call group status.
    * @param string - status
    * @param string - score
    * @param bool - directBookType
    * @param bool - wantsHearingTest
    * @return string - call type enum
    */
    public function getCallTypeByStatus($status, $score, $directBookType, $wantsHearingTest) {
        $callType = null;
        switch ($status) {
            case CaCallGroup::STATUS_VM_NEEDS_CALLBACK:
            case CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED:
                // We don't know the call type based on status only. Must determine who the voicemail is from.
                $callType = null;
                break;
            case CaCallGroup::STATUS_FOLLOWUP_SET_APPT:
                $callType = CaCall::CALL_TYPE_FOLLOWUP_APPT;
                break;
            case CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM:
                if (($directBookType == Location::DIRECT_BOOK_DM) && $wantsHearingTest) {
                    $callType = CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT;
                } else {
                    $callType = CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST;
                }
                break;
            case CaCallGroup::STATUS_TENTATIVE_APPT:
                $callType = CaCall::CALL_TYPE_FOLLOWUP_TENTATIVE_APPT;
                break;
            case CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER:
                $callType = CaCall::CALL_TYPE_FOLLOWUP_NO_ANSWER;
                break;
            default:
                // This is not a valid outbound call
                return false;
        }
        return $callType;
    }

    /**
    * Finds info about the specified location and puts it into an array for display.
    */
    public function getLocationData($locationId = null) {
        $data = [];
        $this->Locations = TableRegistry::get('Locations');
        $location = $this->Locations->find('all', [
            'contain' => [],
            'conditions' => [
                'id' => $locationId,
            ],
        ])->first();
        if (!empty($location)) {
            $address = $location->address.'<br>'.
                $location->city.', '.$location->state.' '.$location->zip;
            $cityStateStreet = $location->city.', '.$location->state.', '.$location->address;
            $link = "<a href='".Router::url($location->hh_url)."' target='_blank'>".$location->title."</a>";
            $searchTitle = $location->title.' | '.$location->city.', '.$location->state.' '.$location->zip;
            $data['id'] = $location->id;
            $data['title'] = $location->title;
            $data['phone']  = formatPhoneNumber($location->phone);
            $data['address'] = $address;
            $data['link'] = $link;
            $data['landmarks'] = $location->landmarks;
            $data['timezone'] = $this->Locations->getClinicTimezoneAbbr($locationId);
            $data['timezoneOffset'] = $this->Locations->getClinicTimezoneOffset($locationId);
            $data['currentTime'] = $this->Locations->getClinicDateTime($locationId, 'now', 'h:i A');
            $data['searchTitle'] = $searchTitle;
            $data['isYhn'] = $location->is_yhn;
            $data['directBookType'] = $location->direct_book_type;
            $data['directBookUrl'] = $location->direct_book_url;
            $data['cityStateStreet'] = $cityStateStreet;
            $data['hours'] = $this->Locations->getHours($locationId);
            $data['hoursToday'] = $this->Locations->getHoursToday($locationId);
            $data['message'] = trim($location->optional_message);
        }
        return $data;
    }

    /**
    * Finds closest clinics to an originAddress (e.g. customer/patient address)
    * and returns them, ordered by *travel time by car* (Google DistanceMatrix API)
    */
    public function getClosestClinics($originAddress = null) {
        $this->Locations = TableRegistry::get('Locations');
        $originGeocode = $this->Locations->geoLocAddress($originAddress);
        $originLatLon = [
            'lat' => $originGeocode['lat'],
            'lon' => $originGeocode['lon']
        ];

        if (empty($originLatLon['lat']) || empty($originLatLon['lon'])) {
            return [];
        }
        $fields = [
            'Locations.id',
            'Locations.title',
            'Locations.address',
            'Locations.city',
            'Locations.state',
            'Locations.average_rating',
            'Locations.reviews_approved',
            'Locations.lat',
            'Locations.lon',
            'Locations.direct_book_type',
            'Locations.direct_book_url',
        ];

        $closestClinics = [];
        $clinicRange = $clinicRangeDefault = intval(Configure::read('clinicMaxRange'));
        $numZipSearches = 0;
        while (count($closestClinics) < 1) {
            $numZipSearches++;
            $closestClinics = $this->Locations->findAllByGeoLoc($originLatLon, 20, [], [], $fields, $clinicRange);
            $clinicRange += $clinicRangeDefault;
        }

        $clinicLatLons = [];
        foreach ($closestClinics as $location) {
            $clinicLatLons[] = $location->lat.','.$location->lon;
        }

        // Use Google Distance Matrix API to sort clinics by driving distance from the patient
        $distanceMatrixUtility = new GoogleDistanceMatrixUtility();
        $distMatrixResponse = $distanceMatrixUtility->byDistance(
            implode(',', $originLatLon),
            implode('|', $clinicLatLons)
        );
        $distMatrixDestinations = $distMatrixResponse['google']['rows'][0]['elements'];
        foreach ($closestClinics as $key => $clinic) {
            if (isset($distMatrixDestinations[$key])) {
                $clinic->google = $distMatrixDestinations[$key];
                if ($clinic->google['status'] != 'OK') {
                    $clinic->google['distance']['text'] = "Google can't provide directions";
                    $clinic->google['distance']['value'] = 0;
                    $clinic->google['duration']['text'] = "Unknown";
                    $clinic->google['duration']['value'] = 0;
                }
                $closestClinics[$key] = $clinic;
            }
        }
        // Sort by driving duration in ascending order
        usort($closestClinics, function ($a, $b) {
            return $a->google['duration']['value'] <=> $b->google['duration']['value'];
        });
        $closestClinics[] = ['numZipSearches' => $numZipSearches, 'searchRadius' => ($clinicRangeDefault * $numZipSearches)];
        return $closestClinics;
    }
}
