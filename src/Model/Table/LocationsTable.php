<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;
use App\Model\Entity\Location;
use App\Enums\Model\Review\ReviewStatus;
use Cake\Core\Configure;
use Cake\Cache\Cache;
use Cake\Console\ConsoleIo;
use Cake\Routing\Router;
use DateTime;
use DateTimeZone;

/**
 * Locations Model
 *
 * @property \App\Model\Table\CaCallGroupsTable&\Cake\ORM\Association\HasMany $CaCallGroups
 * @property \App\Model\Table\CallSourcesTable&\Cake\ORM\Association\HasMany $CallSources
 * @property \App\Model\Table\CsCallsTable&\Cake\ORM\Association\HasMany $CsCalls
 * @property \App\Model\Table\ImportLocationsTable&\Cake\ORM\Association\HasMany $ImportLocations
 * @property \App\Model\Table\ImportStatusTable&\Cake\ORM\Association\HasMany $ImportStatus
 * @property \App\Model\Table\LocationAdsTable&\Cake\ORM\Association\HasMany $LocationAds
 * @property \App\Model\Table\LocationEmailsTable&\Cake\ORM\Association\HasMany $LocationEmails
 * @property \App\Model\Table\LocationHoursTable&\Cake\ORM\Association\HasMany $LocationHours
 * @property \App\Model\Table\LocationLinksTable&\Cake\ORM\Association\HasMany $LocationLinks
 * @property \App\Model\Table\LocationNotesTable&\Cake\ORM\Association\HasMany $LocationNotes
 * @property \App\Model\Table\LocationPhotosTable&\Cake\ORM\Association\HasMany $LocationPhotos
 * @property \App\Model\Table\LocationUsersTable&\Cake\ORM\Association\HasMany $LocationUsers
 * @property \App\Model\Table\LocationVideosTable&\Cake\ORM\Association\HasMany $LocationVideos
 * @property \App\Model\Table\LocationVidscripsTable&\Cake\ORM\Association\HasMany $LocationVidscrips
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entity\Location newEmptyEntity()
 * @method \App\Model\Entity\Location newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location get($primaryKey, $options = [])
 * @method \App\Model\Entity\Location findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Location[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LocationsTable extends Table
{
    public $payments; // Defined in initialize()

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('locations');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

        // Associations
        $this->hasMany('CaCallGroups', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('CallSources', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('CsCalls', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('ImportLocations', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('ImportStatus', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasOne('LocationAds', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationEmails', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasOne('LocationHours', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationLinks', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationNotes', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationPhotos', [
            'foreignKey' => 'location_id',
        ]);
        $this->belongsToMany('Providers', [
            'foreignKey' => 'location_id',
            'targetForeignKey' => 'provider_id',
            'joinTable' => 'locations_providers',
            'sort' => ['Providers.priority' => 'ASC']
        ]);
        $this->hasMany('LocationUsers', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationVideos', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasOne('LocationVidscrips', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'location_id',
        ]);
        $this->belongsToMany('Users');

        // Allow us to search for multiple values using '[or]'
        $defaultOptions = ['multiValue'=>true, 'multiValueSeparator'=>'[or]'];

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id', $defaultOptions)
            ->value('id_oticon', $defaultOptions)
            ->value('id_parent', $defaultOptions)
            ->value('id_sf', $defaultOptions)
            ->value('state', $defaultOptions)
            ->value('zip', $defaultOptions)
            ->value('phone', $defaultOptions)
            ->value('email', $defaultOptions)
            ->value('oticon_tier', $defaultOptions)
            ->value('yhn_tier', $defaultOptions)
            ->value('cqp_tier', $defaultOptions)
            ->value('listing_type', $defaultOptions)
            ->value('notes', $defaultOptions)
            ->value('full_name', $defaultOptions)
            ->value('location_segment', $defaultOptions)
            ->value('entity_segment', $defaultOptions)
            ->value('priority', $defaultOptions)
            ->value('id_yhn_location', $defaultOptions)
            ->value('id_cqp_practice', $defaultOptions)
            ->value('id_cqp_office', $defaultOptions)
            ->value('timezone', $defaultOptions)
            ->value('optional_message', $defaultOptions)
            ->value('average_rating', $defaultOptions)
            ->value('reviews_approved', $defaultOptions)
            ->value('review_status', $defaultOptions)
            ->value('completeness', $defaultOptions)
            ->value('last_note_status', $defaultOptions)
            ->value('last_import_status', $defaultOptions)
            ->value('grace_period_end', $defaultOptions)
            ->value('review_needed', $defaultOptions)
            ->value('email_status', $defaultOptions)
            ->value('phone_status', $defaultOptions)
            ->value('address_status', $defaultOptions)
            ->value('title_status', $defaultOptions)
            ->boolean('is_mobile')
            ->boolean('is_listing_type_frozen')
            ->boolean('is_ida_verified')
            ->boolean('is_active')
            ->boolean('is_show')
            ->boolean('filter_has_photo')
            ->boolean('filter_insurance')
            ->boolean('is_oticon')
            ->boolean('is_retail')
            ->boolean('is_hh')
            ->boolean('is_cqp')
            ->boolean('is_cq_premier')
            ->boolean('is_iris_plus')
            ->boolean('is_bypassed')
            ->boolean('is_call_assist')
            ->boolean('is_service_agreement_signed')
            ->boolean('is_last_edit_by_owner')
            ->boolean('is_grace_period')
            ->boolean('is_title_ignore')
            ->boolean('is_address_ignore')
            ->boolean('is_phone_ignore')
            ->boolean('is_email_ignore')
            ->boolean('feature_content_library')
            ->boolean('feature_special_announcement')
            ->boolean('badge_coffee')
            ->boolean('badge_wifi')
            ->boolean('badge_parking')
            ->boolean('badge_curbside')
            ->boolean('badge_wheelchair')
            ->boolean('badge_service_pets')
            ->boolean('badge_cochlear_implants')
            ->boolean('badge_ald')
            ->boolean('badge_pediatrics')
            ->boolean('badge_mobile_clinic')
            ->boolean('badge_financing')
            ->boolean('badge_telehearing')
            ->boolean('badge_asl')
            ->boolean('badge_tinnitus')
            ->boolean('badge_balance')
            ->boolean('badge_home')
            ->boolean('badge_remote')
            ->boolean('badge_mask')
            ->boolean('badge_spanish')
            ->boolean('badge_french')
            ->boolean('badge_russian')
            ->boolean('badge_chinese')
            ->boolean('using_logo')
            ->boolean('using_photos')
            ->boolean('using_videos')
            ->boolean('using_badges')
            ->boolean('using_flex_space')
            ->boolean('using_linked_locations')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['title', 'city', 'state', 'zip'],
            ])
            // frozen_expiration
            ->add('frozen_expiration_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["frozen_expiration >=" => strtotime($args['frozen_expiration_start'])]);
                }
            ])
            ->add('frozen_expiration_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["frozen_expiration <=" => strtotime($args['frozen_expiration_end'])]);
                }
            ])
            // grace_period_end
            ->add('grace_period_end_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["grace_period_end >=" => strtotime($args['grace_period_end_start'])]);
                }
            ])
            ->add('grace_period_end_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["grace_period_end <=" => strtotime($args['grace_period_end_end'])]);
                }
            ])
            // content_library_expiration
            ->add('content_library_expiration_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["content_library_expiration >=" => strtotime($args['content_library_expiration_start'])]);
                }
            ])
            ->add('content_library_expiration_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["content_library_expiration <=" => strtotime($args['content_library_expiration_end'])]);
                }
            ])
            // special_announcement_expiration
            ->add('special_announcement_expiration_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["special_announcement_expiration >=" => strtotime($args['special_announcement_expiration_start'])]);
                }
            ])
            ->add('special_announcement_expiration_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["special_announcement_expiration <=" => strtotime($args['special_announcement_expiration_end'])]);
                }
            ])
            // last_review_date
            ->add('last_review_date_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["last_review_date >=" => strtotime($args['last_review_date_start'])]);
                }
            ])
            ->add('last_review_date_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["last_review_date <=" => strtotime($args['last_review_date_end'])]);
                }
            ])
            // modified
            ->add('modified_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["Locations.modified >=" => strtotime($args['modified_start'])]);
                }
            ])
            ->add('modified_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["Locations.modified <=" => strtotime($args['modified_end'])]);
                }
            ])
            // last_contact_date
            ->add('last_contact_date_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["last_contact_date >=" => strtotime($args['last_contact_date_start'])]);
                }
            ])
            ->add('last_contact_date_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["last_contact_date <=" => strtotime($args['last_contact_date_end'])]);
                }
            ])
            // last_edit_by_owner_date
            ->add('last_edit_by_owner_date_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["last_edit_by_owner_date >=" => strtotime($args['last_edit_by_owner_date_start'])]);
                }
            ])
            ->add('last_edit_by_owner_date_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["last_edit_by_owner_date <=" => strtotime($args['last_edit_by_owner_date_end'])]);
                }
            ])
            ->add('has_url', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    if ($args['has_url']) {
                        $query->andWhere(['LENGTH(Locations.url) >' => 0]);
                    } else {
                        $query->andWhere([
                            'OR' => [
                                'Locations.url' => '',
                                'Locations.url IS NULL'
                            ]
                        ]);
                    }
                }
            ])
            ->add('is_oticon', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    if ($args['is_oticon']) {
                        $query->andWhere(['Locations.last_xml IS NOT NULL']);
                    } else {
                        $query->andWhere(['Locations.last_xml IS NULL']);
                    }
                }
            ])
            ->add('using_logo', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    if ($args['using_logo']) {
                        $query->andWhere([
                            'Locations.listing_type' => Location::LISTING_TYPE_PREMIER,
                            'Locations.logo_url IS NOT NULL']);
                    } else {
                        $query->andWhere([
                            'OR' => [
                                'Locations.listing_type !=' => Location::LISTING_TYPE_PREMIER,
                                'Locations.logo_url IS NULL'
                            ]
                        ]);
                    }
                }
            ])
            ->add('using_photos', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $locationList = $this->LocationPhotos->find('list', ['valueField' => 'location_id'])->toArray();
                    $uniqueList = array_unique($locationList);
                    if ($args['using_photos']) {
                        $query->andWhere([
                            'Locations.listing_type' => Location::LISTING_TYPE_PREMIER,
                            'Locations.id IN' => $uniqueList]);
                    } else {
                        $query->andWhere([
                            'OR' => [
                                'Locations.listing_type !=' => Location::LISTING_TYPE_PREMIER,
                                'Locations.id NOT IN' => $uniqueList,
                            ]
                        ]);
                    }
                }
            ])
            ->add('using_videos', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $locationList = $this->LocationVideos->find('list', ['valueField' => 'location_id'])->toArray();
                    $uniqueList = array_unique($locationList);
                    if ($args['using_videos']) {
                        $query->andWhere([
                            'Locations.listing_type' => Location::LISTING_TYPE_PREMIER,
                            'Locations.id IN' => $uniqueList]);
                    } else {
                        $query->andWhere([
                            'OR' => [
                                'Locations.listing_type !=' => Location::LISTING_TYPE_PREMIER,
                                'Locations.id NOT IN' => $uniqueList,
                            ]
                        ]);
                    }
                }
            ])
            ->add('using_badges', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    if ($args['using_badges']) {
                        $arrayBadgeFieldsTrue = [];
                        foreach (Location::$badgeFields as $badgeField) {
                            $arrayBadgeFieldsTrue['Locations.'.$badgeField] = true;
                        }
                        $query->andWhere([
                            'Locations.listing_type' => Location::LISTING_TYPE_PREMIER,
                            'OR' => $arrayBadgeFieldsTrue]);
                    } else {
                        $arrayBadgeFieldsFalse = [];
                        foreach (Location::$badgeFields as $badgeField) {
                            $arrayBadgeFieldsFalse['Locations.'.$badgeField] = false;
                        }
                        $query->andWhere([
                            'OR' => [
                                'Locations.listing_type !=' => Location::LISTING_TYPE_PREMIER,
                                'AND' => $arrayBadgeFieldsFalse,
                            ]
                        ]);
                    }
                }
            ])
            ->add('using_flex_space', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $locationList = $this->LocationAds->find('list', ['valueField' => 'location_id'])->toArray();
                    $uniqueList = array_unique($locationList);
                    if ($args['using_flex_space']) {
                        $query->andWhere([
                            'OR' => [
                                'Locations.listing_type' => Location::LISTING_TYPE_PREMIER,
                                'Locations.feature_special_announcement' => true,
                            ]
                        ]);
                        $query->andWhere([
                            'OR' => [
                                'Locations.id_coupon IS NOT NULL',
                                'Locations.id IN' => $uniqueList
                            ]
                        ]);
                    } else {
                        $query->andWhere([
                            'OR' => [
                                '0' => [
                                    'Locations.listing_type !=' => Location::LISTING_TYPE_PREMIER,
                                    'Locations.feature_special_announcement' => false,
                                ],
                                '1' => [
                                    'Locations.id_coupon IS NULL',
                                    'Locations.id NOT IN' => $uniqueList
                                ],
                            ]
                        ]);
                    }
                }
            ])
            ->add('using_linked_locations', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $locationList = $this->LocationLinks->find('list', ['valueField' => 'location_id'])->toArray();
                    $uniqueList = array_unique($locationList);
                    if ($args['using_linked_locations']) {
                        $query->andWhere([
                            'Locations.listing_type IN' => [Location::LISTING_TYPE_ENHANCED, Location::LISTING_TYPE_PREMIER],
                            'Locations.id IN' => $uniqueList
                        ]);
                    } else {
                        $query->andWhere([
                            'OR' => [
                                'Locations.listing_type NOT IN' => [Location::LISTING_TYPE_ENHANCED, Location::LISTING_TYPE_PREMIER],
                                'Locations.id NOT IN' => $uniqueList
                            ]
                        ]);
                    }
                }
            ]);

        // Accepted forms of payments options at a clinic
        $this->payments = [
            2 => ['name' => 'Visa', 'icon' => 'card2.gif'],
            4 => ['name' => 'MasterCard', 'icon' => 'card1.gif'],
            8 => ['name' => 'American Express', 'icon' => 'card4.gif'],
            16 => ['name' => 'Discover', 'icon' => 'card6.gif'],
            //32 => array('name' => 'Diners Club', 'icon' => ''),
            64 => ['name' => 'Cash', 'icon' => ''],
            128 => ['name' => Configure::read('checkPayment'), 'icon' => ''],
            256 => ['name' => 'Debit', 'icon' => 'card3.gif'],
            512 => ['name' => 'Financial aid', 'icon' => ''],
            1024 => ['name' => 'Financing available for those who qualify', 'icon' => ''],
            2048 => ['name' => 'Insurance accepted, please call for details', 'icon' => ''],
        ];
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('id_oticon')
            ->maxLength('id_oticon', 50)
            ->requirePresence('id_oticon', 'create')
            ->notEmptyString('id_oticon');

        $validator
            ->scalar('id_parent')
            ->maxLength('id_parent', 50)
            ->requirePresence('id_parent', 'create')
            ->notEmptyString('id_parent');

        $validator
            ->scalar('id_sf')
            ->maxLength('id_sf', 50)
            ->allowEmptyString('id_sf');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('subtitle')
            ->maxLength('subtitle', 128)
            ->allowEmptyString('subtitle');

        $validator
            ->scalar('address')
            ->maxLength('address', 128)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 128)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 256)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 10)
            ->requirePresence('zip', 'create')
            ->notEmptyString('zip');

        $validator
            ->scalar('country')
            ->maxLength('country', 2)
            ->requirePresence('country', 'create')
            ->notEmptyString('country');

        $validator
            ->boolean('is_mobile')
            ->notEmptyString('is_mobile');

        $validator
            ->scalar('mobile_text')
            ->maxLength('mobile_text', 400)
            ->requirePresence('mobile_text', 'create')
            ->notEmptyString('mobile_text');

        $validator
            ->integer('radius')
            ->notEmptyString('radius');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 16)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->numeric('lat')
            ->allowEmptyString('lat');

        $validator
            ->numeric('lon')
            ->allowEmptyString('lon');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('logo_url')
            ->maxLength('logo_url', 128)
            ->allowEmptyString('logo_url');

        $validator
            ->scalar('url')
            ->maxLength('url', 256)
            ->allowEmptyString('url');

        $validator
            ->scalar('facebook')
            ->maxLength('facebook', 256)
            ->allowEmptyString('facebook');

        $validator
            ->scalar('twitter')
            ->maxLength('twitter', 256)
            ->allowEmptyString('twitter');

        $validator
            ->scalar('youtube')
            ->maxLength('youtube', 256)
            ->allowEmptyString('youtube');

        $validator
            ->boolean('is_listing_type_frozen')
            ->notEmptyString('is_listing_type_frozen');

        $validator
            ->date('frozen_expiration')
            ->allowEmptyDate('frozen_expiration');

        $validator
            ->integer('oticon_tier')
            ->notEmptyString('oticon_tier');

        $validator
            ->integer('yhn_tier')
            ->notEmptyString('yhn_tier');

        $validator
            ->integer('cqp_tier')
            ->notEmptyString('cqp_tier');

        $validator
            ->scalar('listing_type')
            ->maxLength('listing_type', 20)
            ->requirePresence('listing_type', 'create')
            ->notEmptyString('listing_type');

        $validator
            ->boolean('is_ida_verified')
            ->notEmptyString('is_ida_verified');

        $validator
            ->scalar('location_segment')
            ->maxLength('location_segment', 50)
            ->requirePresence('location_segment', 'create')
            ->notEmptyString('location_segment');

        $validator
            ->scalar('entity_segment')
            ->maxLength('entity_segment', 50)
            ->requirePresence('entity_segment', 'create')
            ->notEmptyString('entity_segment');

        $validator
            ->integer('title_status')
            ->notEmptyString('title_status');

        $validator
            ->integer('address_status')
            ->notEmptyString('address_status');

        $validator
            ->integer('phone_status')
            ->notEmptyString('phone_status');

        $validator
            ->boolean('is_title_ignore')
            ->notEmptyString('is_title_ignore');

        $validator
            ->boolean('is_address_ignore')
            ->notEmptyString('is_address_ignore');

        $validator
            ->boolean('is_phone_ignore')
            ->notEmptyString('is_phone_ignore');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->boolean('is_show')
            ->notEmptyString('is_show');

        $validator
            ->boolean('is_grace_period')
            ->notEmptyString('is_grace_period');

        $validator
            ->date('grace_period_end')
            ->allowEmptyDate('grace_period_end');

        $validator
            ->boolean('is_geocoded')
            ->notEmptyString('is_geocoded');

        $validator
            ->boolean('filter_has_photo')
            ->notEmptyString('filter_has_photo');

        $validator
            ->boolean('filter_insurance')
            ->notEmptyString('filter_insurance');

        $validator
            ->boolean('filter_evening_weekend')
            ->notEmptyString('filter_evening_weekend');

        $validator
            ->boolean('filter_adult_hearing_test')
            ->notEmptyString('filter_adult_hearing_test');

        $validator
            ->boolean('filter_hearing_aid_fitting')
            ->notEmptyString('filter_hearing_aid_fitting');

        $validator
            ->boolean('badge_coffee')
            ->notEmptyString('badge_coffee');

        $validator
            ->boolean('badge_wifi')
            ->notEmptyString('badge_wifi');

        $validator
            ->boolean('badge_parking')
            ->notEmptyString('badge_parking');

        $validator
            ->boolean('badge_curbside')
            ->notEmptyString('badge_curbside');

        $validator
            ->boolean('badge_wheelchair')
            ->notEmptyString('badge_wheelchair');

        $validator
            ->boolean('badge_service_pets')
            ->notEmptyString('badge_service_pets');

        $validator
            ->boolean('badge_cochlear_implants')
            ->notEmptyString('badge_cochlear_implants');

        $validator
            ->boolean('badge_ald')
            ->notEmptyString('badge_ald');

        $validator
            ->boolean('badge_pediatrics')
            ->notEmptyString('badge_pediatrics');

        $validator
            ->boolean('badge_mobile_clinic')
            ->notEmptyString('badge_mobile_clinic');

        $validator
            ->boolean('badge_financing')
            ->notEmptyString('badge_financing');

        $validator
            ->boolean('badge_telehearing')
            ->notEmptyString('badge_telehearing');

        $validator
            ->boolean('badge_asl')
            ->notEmptyString('badge_asl');

        $validator
            ->boolean('badge_tinnitus')
            ->notEmptyString('badge_tinnitus');

        $validator
            ->boolean('badge_balance')
            ->notEmptyString('badge_balance');

        $validator
            ->boolean('badge_home')
            ->notEmptyString('badge_home');

        $validator
            ->boolean('badge_remote')
            ->notEmptyString('badge_remote');

        $validator
            ->boolean('badge_mask')
            ->notEmptyString('badge_mask');

        $validator
            ->boolean('badge_spanish')
            ->notEmptyString('badge_spanish');

        $validator
            ->boolean('badge_french')
            ->notEmptyString('badge_french');

        $validator
            ->boolean('badge_russian')
            ->notEmptyString('badge_russian');

        $validator
            ->boolean('badge_chinese')
            ->notEmptyString('badge_chinese');

        $validator
            ->boolean('feature_content_library')
            ->notEmptyString('feature_content_library');

        $validator
            ->date('content_library_expiration')
            ->allowEmptyDate('content_library_expiration');

        $validator
            ->boolean('feature_special_announcement')
            ->notEmptyString('feature_special_announcement');

        $validator
            ->date('special_announcement_expiration')
            ->allowEmptyDate('special_announcement_expiration');

        $validator
            ->scalar('payment')
            ->allowEmptyString('payment');

        $validator
            ->scalar('services')
            ->allowEmptyString('services');

        $validator
            ->scalar('slogan')
            ->allowEmptyString('slogan');

        $validator
            ->scalar('about_us')
            ->allowEmptyString('about_us');

        $validator
            ->numeric('average_rating')
            ->notEmptyString('average_rating');

        $validator
            ->integer('reviews_approved')
            ->notEmptyString('reviews_approved');

        $validator
            ->scalar('review_status')
            ->maxLength('review_status', 50)
            ->requirePresence('review_status', 'create')
            ->notEmptyString('review_status');

        $validator
            ->date('last_review_date')
            ->allowEmptyDate('last_review_date');

        $validator
            ->scalar('last_xml')
            ->allowEmptyString('last_xml');

        $validator
            ->integer('last_note_status')
            ->allowEmptyString('last_note_status');

        $validator
            ->integer('last_import_status')
            ->allowEmptyString('last_import_status');

        $validator
            ->dateTime('last_contact_date')
            ->allowEmptyDateTime('last_contact_date');

        $validator
            ->boolean('is_last_edit_by_owner')
            ->notEmptyString('is_last_edit_by_owner');

        $validator
            ->dateTime('last_edit_by_owner_date')
            ->allowEmptyDateTime('last_edit_by_owner_date');

        $validator
            ->scalar('priority')
            ->maxLength('priority', 50)
            ->allowEmptyString('priority');

        $validator
            ->scalar('completeness')
            ->maxLength('completeness', 50)
            ->requirePresence('completeness', 'create')
            ->notEmptyString('completeness');

        $validator
            ->scalar('redirect')
            ->maxLength('redirect', 255)
            ->allowEmptyString('redirect');

        $validator
            ->scalar('landmarks')
            ->allowEmptyString('landmarks');

        $validator
            ->integer('email_status')
            ->notEmptyString('email_status');

        $validator
            ->boolean('is_email_ignore')
            ->notEmptyString('is_email_ignore');

        $validator
            ->scalar('id_yhn_location')
            ->maxLength('id_yhn_location', 50)
            ->requirePresence('id_yhn_location', 'create')
            ->notEmptyString('id_yhn_location');

        $validator
            ->integer('review_needed')
            ->allowEmptyString('review_needed');

        $validator
            ->boolean('is_retail')
            ->notEmptyString('is_retail');

        $validator
            ->scalar('direct_book_type')
            ->maxLength('direct_book_type', 20)
            ->requirePresence('direct_book_type', 'create')
            ->notEmptyString('direct_book_type');

        $validator
            ->scalar('direct_book_url')
            ->maxLength('direct_book_url', 300)
            ->requirePresence('direct_book_url', 'create')
            ->notEmptyString('direct_book_url');

        $validator
            ->scalar('direct_book_iframe')
            ->maxLength('direct_book_iframe', 400)
            ->requirePresence('direct_book_iframe', 'create')
            ->notEmptyString('direct_book_iframe');

        $validator
            ->boolean('is_yhn')
            ->notEmptyString('is_yhn');

        $validator
            ->boolean('is_hh')
            ->notEmptyString('is_hh');

        $validator
            ->boolean('is_cqp')
            ->notEmptyString('is_cqp');

        $validator
            ->boolean('is_cq_premier')
            ->notEmptyString('is_cq_premier');

        $validator
            ->boolean('is_iris_plus')
            ->notEmptyString('is_iris_plus');

        $validator
            ->boolean('is_bypassed')
            ->notEmptyString('is_bypassed');

        $validator
            ->boolean('is_call_assist')
            ->notEmptyString('is_call_assist');

        $validator
            ->scalar('timezone')
            ->maxLength('timezone', 50)
            ->requirePresence('timezone', 'create')
            ->notEmptyString('timezone');

        $validator
            ->scalar('optional_message')
            ->maxLength('optional_message', 400)
            ->requirePresence('optional_message', 'create')
            ->notEmptyString('optional_message');

        $validator
            ->boolean('is_service_agreement_signed')
            ->notEmptyString('is_service_agreement_signed');

        $validator
            ->boolean('is_junk')
            ->notEmptyString('is_junk');

        $validator
            ->integer('id_coupon')
            ->allowEmptyString('id_coupon');

        $validator
            ->boolean('is_email_allowed')
            ->notEmptyString('is_email_allowed');

        return $validator;
    }

    /**
    * Calculate the listing types for all location ids
    */
    public function calculateListingTypes(ConsoleIo $io) {
        $io->hr();
        $io->out('Calculate listing types for all locations');
        $io->hr();
        $locations = $this->find('all', [
            'contain' => [],
            'fields' => ['id', 'yhn_tier', 'oticon_tier', 'cqp_tier', 'is_grace_period', 'listing_type', 'is_listing_type_frozen', 'is_show']
        ])->all();
        foreach ($locations as $location) {
            $this->calculateListingType($location);
            echo '.';
        }

        $io->out();
        $io->out('Done.');
    }

    /**
    * Calculate the listing type for this location id, based on oticon
    * @param entity object location or int locationId
    */
    public function calculateListingType($location) {
        if (!is_object($location)) {
            // Location ID was passed
            $location = $this->get($location);
        }
        if (!Configure::read('isTieringEnabled')) {
            // For Canada, if the clinic came in on most recent import, mark it Enhanced. Otherwise None.
            $listingType = Location::LISTING_TYPE_NONE;
            if ($this->isLocationInLatestImport($location->id, 'ca')) {
                $listingType = Location::LISTING_TYPE_ENHANCED;
            }
        } else {
            // US
            $listingType = Location::LISTING_TYPE_NONE;
            if ($location->is_listing_type_frozen) {
                $listingType = $location->listing_type;
            } else if (($location->yhn_tier == 2) ||
                ($location->cqp_tier == 2) ||
                ($location->oticon_tier == 1) ||
                ($location->oticon_tier == 2) ||
                (($location->oticon_tier == 3) && $location->is_grace_period)) {
                $listingType = Location::LISTING_TYPE_BASIC;
            }
        }
        if (empty($location->id)) {
            // New location. Return listing type without saving.
            return $listingType;
        } else {
            $location->listing_type = $listingType;
            // LISTING_TYPE_NONE locations should be no-show
            if ($listingType == Location::LISTING_TYPE_NONE) {
                $location->is_show = false;
            }
            $this->save($location);
            return $listingType;
        }
    }

    /**
    * Make sure all locations that are LISTING_TYPE_NONE or inactive are also no-show.
    */
    public function noShowLocations(ConsoleIo $io) {
        $io->helper('BaseShell')->title('Find locations that should be no-show');
        // Make sure Quick Pick and Return Call from Clinic are not shown
        foreach (['1111', '2222'] as $locationId) {
            $locationEntity = $this->get($locationId);
            if ($locationEntity->is_show == true) {
                $locationEntity->is_show = false;
                $this->save($locationEntity);
                $this->out('WARNING: Location '.$locationId.' was shown. Marked as no-show.');
            }
        }
        $locationIds = $this->find('list', [
            'conditions' => [
                'Locations.is_show' => true,
                'OR' => [
                    'Locations.listing_type' => Location::LISTING_TYPE_NONE,
                    'Locations.is_active' => false
                ]
            ]
        ])->toArray();
        foreach ($locationIds as $locationId) {
            $locationEntity = $this->get($locationId);
            $locationEntity->is_show = false;
            $this->save($locationEntity);
        }
        $io->out('Found and marked '.count($locationIds).' locations no-show.');
    }

    // Show clinics that have an active CS number
    function showClinicsWithActiveCS(ConsoleIo $io) {
        $io->helper('BaseShell')->title('Show all clinics that have an active CS number');
        $callSources = $this->CallSources->find('all', [
            'contain' => [
                'Locations' => [
                    'fields' => ['Locations.id', 'Locations.listing_type', 'Locations.is_active', 'Locations.is_show']
                ]
            ],
            'conditions' => [
                'CallSources.is_active' => true,
                'Locations.is_active' => true,
                'Locations.listing_type !=' => Location::LISTING_TYPE_NONE,
                'Locations.is_show' => false
            ]
        ])->all();
        foreach ($callSources as $callSource) {
            $locationEntity = $this->get($callSource->location->id);
            $locationEntity->is_show = true;
            $this->save($locationEntity);
        }
        $io->out("Done. Found ".count($callSources)." locations to mark is_show.");
    }

    public function updateAllFilters(ConsoleIo $io) {
        $io->helper('BaseShell')->title('Update filters');
        $locations = $this->find('list')->toArray();
        $progress = $io->helper('Progress')->init(['total'=> count($locations)]);
        foreach ($locations as $locationId => $locationTitle) {
            $this->updateFilters($locationId);
            $progress->increment()->draw();
        }
        $io->out();
        $io->out('Done.');
    }

    /**
    * Set the boolean filters true or false based on current data of the location.
    * URL and Reviews filter is based on their actual fiels (url, reviews_approved) and is not set by this
    * @param int id of Location
    * @return boolean success
    */
    public function updateFilters($locationId) {
        $locationEntity = $this->get($locationId, [
            'contain' => [
                'LocationHours',
                'LocationProviders.Providers'
            ]
        ]);
        if (empty($locationEntity)) {
            return false;
        }

        //FYI Url and reviews are based on Locations.url and Locations.reviews_approved, Not a filter boolean.
        //This function is only checking for the boolean filters we've setup for the location
        $locationEntity->filter_has_photo = false;
        $locationEntity->filter_insurance = false;
        $locationEntity->filter_evening_weekend = false;
        $locationEntity->filter_adult_hearing_test = false;
        $locationEntity->filter_hearing_aid_fitting = false;

        //Check photo
        foreach ($locationEntity->location_providers as $locationProvider) {
            if (!empty($locationProvider->provider->thumb_url)) {
                $locationEntity->filter_has_photo = true;
            }
        }
        //Check insurance
        if (!empty($locationEntity->payment)) {
            if (strpos($locationEntity->payment,'"2048":"1"')) {
                $locationEntity->filter_insurance = true;
            }
        }
        //Check evening/weekend hours
        if (!empty($locationEntity->location_hour)) {
            if ($locationEntity->location_hour->is_evening_weekend_hours) {
                $locationEntity->filter_evening_weekend = true;
            } else {
                $hour = $locationEntity->location_hour;
                if ($hour->sat_open!="" && $hour->sat_close!="" && $hour->sat_is_closed!=true) {
                    // Open Sat
                    $locationEntity->filter_evening_weekend = true;
                }
                if ($hour->sun_open!="" && $hour->sun_close!="" && $hour->sun_is_closed!=true) {
                    // Open Sun
                    $locationEntity->filter_evening_weekend = true;
                }
            }
        }
        //Check Adult Hearing
        $locationEntity->filter_adult_hearing_test = true;
        $locationEntity->filter_hearing_aid_fitting = true;

        //TODO: Previously this save() used callbacks=false because updateFilters() is called from afterSave(). We need to test if this still functions correctly or creates a loop.
        return $this->save($locationEntity);
    }

    /**
    * Build the region from a state abbr or region
    * @param string state (NM, NM-New, etc..)
    * @return string NM-New-Mexico
    */
    public function stateRegion($state) {
        $abbr = $this->parseStateSlug($state);
        $full = $this->stateFull($abbr);
        if (empty($full)) {
            return null;
        }
        return slugifyRegion($abbr . ' ' . $full);
    }

    /**
    * Parse back the abbreviation of a ST-State-Name slug
    * @param string state slug
    * @return string ST
    */
    public function parseStateSlug($stateslug) {
        if (strpos($stateslug,"-")) {
            $array = explode("-", $stateslug);
            if (strcasecmp(substr($array[0], 0, 1), substr($array[1], 0, 1)) != 0) {
                // Invalid $stateslug. Abbr and full name do not start with same letter.
                return null;
            }
            return array_shift($array);
        }   else {
            return $stateslug;
        }
    }

    /**
    * Handy shortcut function to return a full state by searching through the states array
    * @param string $state_input
    * @return string $state_full
    */
    public function stateFull($state_input) {
        return $this->state('full',$state_input);
    }
    /**
    * Handy shortcut function to return a abbr state by searching through the states array
    * @param string $state_input
    * @return string $state_full
    */
    public function stateAbbr($state_input) {
        return $this->state('abbr',$state_input);
    }

    /**
    * Create the stateSlug for URL based on input state
    * @param string state
    * @return string slug of state ST_State_Name
    */
    public function stateSlug($state) {
        return strtoupper($this->stateAbbr($state)) . "-" . slugify($this->stateFull($state));
    }

    /**
    * Handy shortcut function to return a full/abbr state by searching through the states array
    * @param string $state_input
    * @return string $state_full
    */
    public function state($get,$stateInput) {
        $stateInput = trim($stateInput);
        $states = Configure::read('states');
        foreach ($states as $state => $stateFull) {
            if (strtoupper($stateInput) == strtoupper($state) || strtoupper($stateInput)==strtoupper($stateFull)) {
                if ($get=='full') {
                    return $stateFull;
                } else {
                    return $state;
                }
            }
        }
        return null;
    }

    /**
    * Get the state region based on the state_input
    * @param string state input (NM, NM-New-Mexico, NM-New)
    * @return string region the state belongs to (West, Midwest, etc..)
    */
    public function googleRegion($state) {
        $state = $this->parseStateSlug($state);
        $regions = Configure::read('regions');
        foreach ($regions as $region => $regionStates) {
            if (in_array($state, $regionStates)) {
                return $region;
            }
        }
        return null;
    }

    /**
    * Find a location based off it's id and uri
    * @param int id
    */
    public function findByIdSlug($id = null, $uri = null) {
        if ($uri === Router::url($this->findForRedirectById($id))) {
            return $this->findByIdForView($id);
        }
        return array();
    }

    /**
    * Find the redirect based off an id
    * @param int location id (full or 5-digit)
    * @return string url or false
    */
    public function findForRedirectById($id) {
        $location = $this->find('all', [
            'conditions' => [
                'Locations.id IN' => [$id, Location::$oticonPrefix.$id]
            ],
            'contain' => [],
            'fields' => [
                'Locations.state',
                'Locations.city',
                'Locations.zip',
                'Locations.id',
                'Locations.title',
                'Locations.redirect',
                'Locations.is_active',
                'Locations.is_show'
            ],
            'order' => ['Locations.id' => 'DESC']
        ])->first();
        if (empty($location)) {
            return false;
        }
        if (!empty($location->redirect)) {
            return $location->redirect;
        }
        if (!$location->is_active || !$location->is_show) {
            // inactive or noshow location
            return false;
        }
        return isset($location->hh_url) ? $location->hh_url : false;
    }

    /**
    * Find location for id
    * @param int id
    * @return the result of the find
    */
    public function findByIdForView($id = null){
        $locationId = $this->findById(Location::$oticonPrefix.$id)->count() ? Location::$oticonPrefix.$id : $id;
        $location = $this->find('all', [
            'conditions' => [
                'Locations.id' => $locationId,
                'Locations.listing_type !=' => Location::LISTING_TYPE_NONE,
                'Locations.is_active' => true,
                'Locations.is_show' => true,
            ],
            'contain' => [
                'CallSources',
                'LocationHours',
                'LocationProviders.Providers' => [
                    // TODO fix provider order
                    //'order' => 'Providers.priority ASC, Providers.id ASC'
                ],
                'Reviews' => [
                    'conditions' => [
                        'Reviews.status' => ReviewStatus::APPROVED->value
                    ],
                    'Zips' => [
                        'fields' => ['city','state']
                    ],
                ]
            ]
        ])->first();
        if (!empty($location)) {
            // Optional premier features for non-Premier locations
            if ($location->listing_type !== Location::LISTING_TYPE_PREMIER) {
                // Get ads/coupons/special announcements
                $location->location_ad = $this->LocationAds->find('all', [
                    'conditions' => ['location_id' => $locationId]
                ])->first();
            }
            // Premier features ('Premier' listings only)
            if ($location->listing_type == Location::LISTING_TYPE_PREMIER) {
                // Get videos
                $location->location_videos = $this->LocationVideos->find('all', [
                    'contain' => [],
                    'conditions' => ['location_id' => $locationId]
                ])->all();

                // Get photos
                $location->location_photos = $this->LocationPhotos->find('all', [
                    'contain' => [],
                    'conditions' => ['location_id' => $locationId]
                ])->all();

                // Get ads/coupons/special announcements
                $location->location_ad = $this->LocationAds->find('all', [
                    'contain' => [],
                    'conditions' => ['location_id' => $locationId]
                ])->first();
            }
            //Get vidscrips
            if ($location->is_cq_premier) {
                $location->location_vidscrip = $this->LocationVidscrips->find('all', [
                    'contain' => [],
                    'conditions' => ['location_id' => $locationId]
                ])->first();
            }
        }
        return $location;
    }

    /**
    * Find all linked locations for the given locationId
    * @param int locationId
    */
    public function findLocationLinks($locationId) {
        $links = $this->LocationLinks->find('all', [
            'contain' => [],
            'conditions' => [
                'OR' => [
                    'location_id' => $locationId,
                    'id_linked_location' => $locationId
                ],
            ],
        ])->all();
        return $links;
    }

    /**
    * Find unique linked locations for the given locationId
    * @param int locationId
    */
    public function findLocationLinksByDistance($locationId) {
        $links = $this->findLocationLinks($locationId);
        $linksByDistance = [];
        foreach ($links as $link) {
            if ($link->location_id == $locationId) {
                $linksByDistance[$link->id_linked_location] = $link->distance;
            } else {
                $linksByDistance[$link->location_id] = $link->distance;
            }
        }
        asort($linksByDistance);
        return $linksByDistance;
    }

    /**
    * Get the timezone abbreviation of this clinic (America/New_York, America/Los_Angeles, etc..))
    * @return string timezone for display
    */
    public function getClinicTimezone($id) {
        $locationEntity = $this->get($id);
        $timezone = $locationEntity->timezone;

        if (empty($timezone)) {
            // Get the timezone from Google API for this lat/lon
            $lat = $locationEntity->lat;
            $lon = $locationEntity->lon;
            $timestamp = time();
            // Only access google api on prod
            $apiKey = (Configure::read('env') == 'prod') ? Configure::read('googleMapsWebServicesApiKey') : '';
            $url = "https://maps.googleapis.com/maps/api/timezone/json?location=".$lat.",".$lon."&amp;timestamp=".$timestamp."&sensor=false&key=".$apiKey;
            $apiResult = json_decode(file_get_contents($url));
            if (!empty($apiResult->timeZoneId)) {
                $timezone = $apiResult->timeZoneId;
                $locationEntity->timezone = $timezone;
                $this->save($locationEntity);
            }
        }

        if (empty($timezone)) {
            // If we didn't find the timezone, default to eastern timezone for now, but don't save it to database
            $timezone = 'America/New_York';
        }

        $date = new DateTime('now', new DateTimeZone($timezone));
        return $date->format('T');
    }

    /**
    * TODO: DELETE
    */
    public function getTimezoneByState($state) {
        // TODO: This function can be deleted. Leaving here temporarily to catch any calls to this function as we pull code over.
        // Previously we used geoip_time_zone_by_country_and_region() to find the timezone for this state. This isn't accurate or recommended anymore because some states have 2 timezones.
        // Going forward, let's use getClinicTimezone() which I am updating to call the Google Timestamp API.
        die('die: getTimezoneByState() should not be used anymore');
    }

    /**
    * Get the timezone offset of this clinic
    * @return int timezone offset
    */
    public function getClinicTimezoneOffset($id) {
        $offset = null;
        $timezone = $this->getClinicTimezone($id);
        $dateTimeZone = new DateTimeZone($timezone);
        $offset = $dateTimeZone->getOffset(new DateTime);
        $offset = abs($offset/60/60);
        return $offset;
    }

    /**
    * Use geoIP lookup or cached zip to find clinics near you.
    * @param int limit - Number of clinics to find
    * @param bool preferredOnly - true to only find Enhanced/Premier clinics
    * @return array list of clinics near you
    */
    public function findClinicsNearMe($limit = 4, $preferredOnly = false) {
        $geoLocData = [];

        if (empty($_SESSION['geoLocData'])) {
            return [];
        }

        // Check if visitor is from another country and if that country
        // is one for which we have referral links/text available and set
        // in constants.php
        $visitorCountry = $_SESSION['geoLocData']['country'];
        if ($visitorCountry !== Configure::read('country') && in_array($visitorCountry, array_keys(Configure::read('oticonCountries')))) {
            return [
                'country' => $_SESSION['geoLocData']['country']
            ];
        }
        $geoLocData = [
            'zip' => empty($_SESSION['geoLocData']['zip']) ? null : $_SESSION['geoLocData']['zip'],
            'region' => empty($_SESSION['geoLocData']['state']) ? null : $this->stateRegion($_SESSION['geoLocData']['state']),
            'city' => empty($_SESSION['geoLocData']['city']) ? null : slugifyCity($_SESSION['geoLocData']['city']),
        ];

        $sort = $preferredOnly ? 'preferred' : 'distance';
        $cacheKey = 'top_nav_' . implode('_', $geoLocData) . '_' . $sort . '_' . $limit;
        if (false/*$TODO: cache = Cache::read($cacheKey)*/) {
            return $cache;
        } else {
            $options['zip'] = $geoLocData['zip'];
            $options['region'] = $geoLocData['region'];
            $options['city'] = $geoLocData['city'];
            $fields = ['Locations.id', 'listing_type', 'lat', 'lon', 'average_rating', 'reviews_approved', 'title', 'address', 'address_2', 'city', 'state', 'zip', 'is_mobile', 'mobile_text'];
            $conditions = [];
            if ($preferredOnly) {
                $conditions['Locations.listing_type !='] = Location::LISTING_TYPE_BASIC;
            }
            $cache = $this->findAllByGeoLoc($options, $limit, $conditions, [], $fields);
            Cache::write($cacheKey, $cache);
            return $cache;
        }
    }

    /**
    * Find all locations based on lat/lon, zip, or region/city
    * @param array options (lat/lon, zip, or region/city)
    * @param int limit (default=40)
    * @param array conditions
    * @param array contain
    * @param array fields
    * @param int maxRange
    */
    public function findAllByGeoLoc($options = [], $limit = null, $conditions = [], $contain = [], $fields = [], $maxRange = null) {
        $options = array_merge([
            'lat' => null,
            'lon' => null,
            'zip' => null,
            'region' => null,
            'city' => null
        ], $options);
        // Reverted to old syntax (pre-??) for #16574 fix
        // $limit = $limit ?? 40;
        $limit = $limit ? $limit : 40;
        $conditions = array_merge([
            'Locations.is_active' => true,
            'Locations.is_show' => true
        ], $conditions);

        /*
        TODO: IMPLEMENT RANGEABLE BEHAVIOR


        // Reverted to old syntax (pre-??) for #16574 fix
        // $maxRange = $maxRange ?? Configure::read('clinicMaxRange');
        $maxRange = $maxRange ? $maxRange : Configure::read('clinicMaxRange');
        if (!empty($options['lat']) && !empty($options['lon'])) {
            $conditions['Locations.lat'] = $options['lat'];
            $conditions['Locations.lon'] = $options['lon'];
        } else if (!empty($options['zip']) && $this->isValidZip($options['zip'])) {
            $zip = TableRegistry::get('Zips')->get($options['zip']);
            if (!empty($zip['lat']) && !empty($zip['lon'])) {
                $conditions['Locations.lat'] = $zip['lat'];
                $conditions['Locations.lon'] = $zip['lon'];
            } else {
                // This zip code does not exist in our zip table
                return [];
            }
        } else if (!empty($options['city']) && !empty($options['region'])) {
            //force case sensitivity -- google duplicate content issue
            if (($options['region'] !== slugifyRegion($options['region'])) ||
                ($options['city'] !== slugifyCity($options['city']))) {
                return [];
            }
            $options['region'] = $this->parseStateSlug($options['region']);
            $city = ClassRegistry::init('City')->findByCity($options['city'], $options['region']);
            if (!empty($city) && !empty($city['City']['lat'] && !empty($city['City']['lon']))) {
                $conditions['Locations.lat'] = $city['City']['lat'];
                $conditions['Locations.lon'] = $city['City']['lon'];
            } else {
                // we can't find lat/lon for this city
                return [];
            }
        } else {
            // We don't have a lat/lon, zip, or region/city
            return [];
        }

        $clinicFindSettings = [
            'conditions' => $conditions,
            'fields' => $fields,
            'range' => $maxRange,
            'range_out_till_count_is' => false, //disable range-out
            'order_by_distance' => true,
            'contain' => $contain,
            'limit' => $limit
        ];
        return $this->find('range', $clinicFindSettings);
        */

        //TODO TEMPORARY - Just return the first $limit locations in my state
        // Remove this when rangeable is working
        //--------------------------------------------------------------
        $state = $this->parseStateSlug($options['region']);
        $conditions['Locations.state'] = $state;
        $locations = $this->find('all', [
            'contain' => $contain,
            'conditions' => $conditions,
            'limit' => $limit
        ])->all()->toArray();
        //--------------------------------------------------------------
        return $locations;
    }

    /**
    * tests a string to see if it is a valid zip code
    * @param string $input - (query)string which will be tested
    * @return bool
    */
    public function isValidZip($input) {
        if (Configure::read('country') == 'US') {
            $regex = '/^((\d{5}-\d{4})|(\d{5})|([AaBbCcEeGgHhJjKkLlMmNnPpRrSsTtVvXxYy]\d[A-Za-z]\s?\d[A-Za-z]\d))$/';
        } elseif ($settings['country'] == 'CA') {
            $regex = '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/';
        }
        return (preg_match($regex,$input));
    }

    /**
    * Find a redirect array based on zip, region, and city
    * @param array of options
    * @return array of slugged zip, region, and city
    */
    public function findRedirectByRegionCityZip($options = array(), $url=null) {
        $options = array_merge(
            array(
                'zip' => null,
                'region' => null,
                'city' => null
            ),
            $options
        );
        $retval = $options;
        if (!empty($options['region'])) {
            $retval['region'] = slugifyRegion($options['region']);
        }
        if (!empty($options['city'])) {
            $retval['city'] = slugifyCity($options['city']);
        }
        if (!empty($options['zip'])) {
            $zip = TableRegistry::get('Zips')->get($options['zip']);
            $zip_city = $zip->city;
            if ($zip_city) {
                $retval['city'] = slugifyCity($zip_city);
            }
            if (Configure::read('country') == 'CA' && strlen($options['zip']) == 6) {
                $options['zip'] = substr($options['zip'], 0, 3) . '-' . substr($options['zip'], 3, 3);
            }
            // Change "A1A 1A1" to "A1A-1A1" in the URL
            $retval['zip'] = str_replace(' ', '-', $options['zip']);
        }

        //Special Case for tier 0 issues, pull out the city from the title-city-st format in city
        /*
        /hearing-aids/MA-Massachusetts/Quincy-Center-Quincy-Ma
        /hearing-aids/OH-Ohio/Audiology-Associates-Ltd-Toledo-Ohio
        /hearing-aids/MA-Massachusetts/Service-Inc-Brockton-Ma
        /hearing-aids/WI-Wisconsin/Lakeshore-Medical-Clinic-Mequon-Wi
        /hearing-aids/NJ-New-Jersey/Advanced-Solutions-Englishtown-Nj
        /hearing-aids/OH-Ohio/Roger-Isla-Md-Inc-Pleasant-City-Oh -> Pleasant-City
        /hearing-aids//UT-Utah/House-Of-West-Jordan-Ut -> West Jordan (but Jordan is a valid city)
        */
        if ($retval['city'] && $retval['region'] && strpos($retval['city'], "-")) {
            $title = explode("-",$retval['city']);
            $st = array_pop($title);
            list($region_st, $region_state) = explode("-", $retval['region']);
            if (strtolower($st) == strtolower($region_st) || strtolower($st) == strtolower($region_state)) {
                $city = array_pop($title);
                if (!TableRegistry::get('Cities')->hasAny(array('City.city' => $city, 'City.state' => $region_st))) {
                    $retval['city'] = array_pop($title) . "-" . $city;
                } else {
                    $retval['city'] = $city;
                }
            }
        }
        $url = str_replace('%20', ' ', $url);
        if (empty($url)) {
            // original url
            $url = Router::url(['prefix'=>false,'plugin'=>false,'controller'=>'locations','action'=>'viewCityZip','region'=>$options['region'],'city'=>$options['city'],'zip'=>$options['zip']]);
        }

        // Do not redirect to what we already came in on
        if ($url == Router::url(['prefix'=>false,'plugin'=>false,'controller'=>'locations','action'=>'viewCityZip','region'=>$retval['region'],'city'=>$retval['city'],'zip'=>$retval['zip']])) {
            return false;
        }
        return $retval;
    }

    /**
    * Extract the total count of reviews from a set of locations returned by the zip finder
    * @param array of locations
    * @return int of total approved reviews for the set
    */
    public function reviewCountLocations($locations) {
        $reviews = 0;
        foreach ($locations as $location) {
            if ($location->listing_type != Location::LISTING_TYPE_NONE) {
                $reviews += $location->reviews_approved;
            }
        }
        return $reviews;
    }

    /**
    * Find unique linked locations for the given locationId
    * @param int locationId
    */
    public function findUniqueLocationLinks($locationId) {
        $links = $this->findLocationLinks($locationId);
        $uniqueLinks = [];
        foreach ($links as $link) {
            if ($link->location_id == $locationId) {
                $uniqueLinks[] = $link->id_linked_location;
            } else {
                $uniqueLinks[] = $link->location_id;
            }
        }
        $uniqueLinks = array_unique($uniqueLinks);
        return $uniqueLinks;
    }

    public function linkedLocationInfo($linkedLocationId) {
        $location = $this->find('all', [
            'contain' => [],
            'fields' => ['id', 'title', 'address', 'address_2', 'city', 'state', 'zip'],
            'conditions' => [
                'id' => $linkedLocationId,
            ]
        ])->first();
        if ($location) {
            $retval = '<strong>'.$location->id.'</strong><br>'.
                $location->title.'<br>'.
                $location->address.' '. $location->address_2.'<br>'.
                $location->city.', '.$location->state.' '.$location->zip;
        } else {
            $retval = 'Location '.$linkedLocationId.' not found.';
        }
        return $retval;
    }

    /**
    * Generate an array of email data for a list of clinics. This will be exported to a CSV file.
    */
    public function exportEmails($options = []) {
        $locations = $this->find('search', $options)->all();
        $uniqueEmails = [];
        $data = [];
        foreach ($locations as $location) {
            // Get email from Provider
            foreach ($location->providers as $provider) {
                if (!empty($provider->email) && !in_array($provider->email, $uniqueEmails)) {
                    $uniqueEmails[] = $provider->email;
                    $data[] = [
                        'hhid' => $location->id,
                        'clinic_title' => $location->title,
                        'first_name' => $provider->first_name,
                        'last_name' => $provider->last_name,
                        'email' => $provider->email,
                    ];
                }
            }
            // Get email from LocationEmail
            foreach ($location->location_emails as $locationEmail) {
                if (!empty($locationEmail->email) && !in_array($locationEmail->email, $uniqueEmails)) {
                    $uniqueEmails[] = $locationEmail->email;
                    $data[] = [
                        'hhid' => $location->id,
                        'clinic_title' => $location->title,
                        'first_name' => $locationEmail->first_name,
                        'last_name' => $locationEmail->last_name,
                        'email' => $locationEmail->email,
                    ];
                }
            }
            // Get email from LocationUser recovery email
            foreach ($location->location_users as $locationUser) {
                if (!empty($locationUser->email) && !in_array($locationUser->email, $uniqueEmails)) {
                    $uniqueEmails[] = $locationUser->email;
                    $data[] = [
                        'hhid' => $location->id,
                        'clinic_title' => $location->title,
                        'first_name' => $locationUser->first_name,
                        'last_name' => $locationUser->last_name,
                        'email' => $locationUser->email,
                    ];
                }
            }
            // Get email from Location
            if (!empty($location->email) && !in_array($location->email, $uniqueEmails)) {
                $uniqueEmails[] = $location->email;
                $data[] = [
                    'hhid' => $location->id,
                    'clinic_title' => $location->title,
                    'first_name' => '',
                    'last_name' => '',
                    'email' => $location->email,
                ];
            }
        }
        return $data;
    }
}
