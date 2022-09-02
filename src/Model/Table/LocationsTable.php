<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;
use App\Model\Entity\Location;

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
 * @property \App\Model\Table\LocationProvidersTable&\Cake\ORM\Association\HasMany $LocationProviders
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
        $this->hasMany('LocationAds', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationEmails', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationHours', [
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
        $this->hasMany('LocationProviders', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationUsers', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationVideos', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('LocationVidscrips', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'location_id',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('id_oticon')
            ->value('id_parent')
            ->value('id_sf')
            ->value('state')
            ->value('zip')
            ->value('phone')
            ->value('email')
            ->value('oticon_tier')
            ->value('yhn_tier')
            ->value('cqp_tier')
            ->value('listing_type')
            ->value('notes')
            ->value('full_name')
            ->value('location_segment')
            ->value('entity_segment')
            ->value('priority')
            ->value('id_yhn_location')
            ->value('cqp_practice_id')
            ->value('cqp_office_id')
            ->value('timezone')
            ->value('covid19_statement')
            ->value('average_rating')
            ->value('reviews_approved')
            ->value('review_status')
            ->value('completeness')
            ->value('last_note_status')
            ->value('last_import_status')
            ->value('grace_period_end')
            ->value('review_needed')
            ->value('email_status')
            ->value('phone_status')
            ->value('address_status')
            ->value('title_status')
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
            ->scalar('covid19_statement')
            ->maxLength('covid19_statement', 400)
            ->requirePresence('covid19_statement', 'create')
            ->notEmptyString('covid19_statement');

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
}
