<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Enums\Model\Location\LocationReviewStatus;
use App\Enums\Model\Review\ReviewStatus;
use App\Enums\Model\Review\ReviewResponseStatus;
use App\Model\Entity\Review;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\RulesChecker;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Locator\LocatorAwareTrait;
use Search\Model\Filter\Base;

/**
 * Reviews Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @method \App\Model\Entity\Review newEmptyEntity()
 * @method \App\Model\Entity\Review newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Review[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Review get($primaryKey, $options = [])
 * @method \App\Model\Entity\Review findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Review patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Review[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Review|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Review saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReviewsTable extends Table
{
    use LocatorAwareTrait;
    use MailerAwareTrait;

    public $ratings = array(
        1 => '1 (Poor)',
        2 => '2 (Below average)',
        3 => '3 (Average)',
        4 => '4 (Above average)',
        5 => '5 (Excellent)',
    );

    public $reviewLimit = 10;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

        $this->addBehavior('CounterCache', [
            'Locations' => [
                // Total # of approved reviews for a Location (e.g. 17)
                'reviews_approved' => [
                    'conditions' => [
                        'Reviews.status' => ReviewStatus::APPROVED->value
                    ],
                ],
                // Average review rating for a Location (e.g. 4.2)
                'average_rating' => function ($event, $entity, $table, $original) {
                    $reviews = $this->find()
                        ->where([
                            'location_id' => $entity->location_id,
                            'status' => ReviewStatus::APPROVED->value,
                        ])->all();

                    $numerator = 0;
                    foreach($reviews as $review) {
                        $numerator += $review->rating;
                    }
                    if (count($reviews) > 0) {
                        return round($numerator / count($reviews), 2);
                    }
                    return false;
                },
                // Review status for a Location (e.g. 'Review5Plus, Review4Less')
                'review_status' => function ($event, $entity, $table, $original) {
                    $reviewsApprovedCount = $this->find()
                        ->where([
                            'location_id' => $entity->location_id,
                            'status' => ReviewStatus::APPROVED->value,
                        ])->count();
                    if ($reviewsApprovedCount >= 5) {
                        return LocationReviewStatus::REVIEW_STATUS_5_PLUS->value;
                    } else {
                        return LocationReviewStatus::REVIEW_STATUS_4_LESS->value;
                    }
                },
            ]
        ]);

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasOne('Zips', [
            'foreignKey' => 'zip',
            'bindingKey' => 'zip',
            'propertyName' => 'reviewer_zip',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('location_id')
            ->like('body', [
                'before' => true,
                'after' => true,
            ])
            ->value('first_name')
            ->value('last_name')
            ->value('zip')
            ->value('rating', [
                'multiValue' => true
            ])
            ->value('status')
            ->value('origin')
            ->like('response', [
                'before' => true,
                'after' => true,
            ])
            ->value('response_status')
            ->value('ip')
            ->value('character_count')
            ->boolean('is_spam')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['body','first_name','last_name','response'],
            ])
            ->add('listing_type', 'Search.Callback', [
                'callback' => function ($query, $args, $filter) {
                    $listingType = $args['listing_type'];
                    $query->matching('Locations', function ($q) use ($listingType) {
                        return $q->where(['Locations.listing_type LIKE' => '%' . $listingType . '%']);
                    });
                },
            ])
            ->add('modified_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['modified_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Reviews.modified', $startDate, $endDate, 'date');
                    });
                },
            ])
            ->add('created_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['created_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Reviews.created', $startDate, $endDate, 'date');
                    });
                },
            ])
            ->add('denied_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['denied_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Reviews.denied_date', $startDate, $endDate, 'date');
                    });
                },
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
            ->notEmptyString('id');

        $validator
            ->scalar('body')
            ->requirePresence('body')
            ->notEmptyString('body');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name')
            ->notEmptyString('last_name');

        // Country-specific postal code validation
        $country = ucfirst(strtolower(Configure::read('country')));
        $countryValidator = 'Cake\\Localized\\Validation\\' . $country . 'Validation';
        $validator->setProvider(
            'postalCodeValidationProvider',
            $countryValidator
        );
        $validator
            ->add('zip', 'postalCodeRule', [
                'rule' => 'postal',
                'provider' => 'postalCodeValidationProvider',
                'message' => 'Please provide a properly formatted ' . Configure::read('zipLabel') . '.',
            ]);

        $validator
            ->equals('verify', 1, 'Please verify you visited this clinic by checking the box above.');

        $validator
            ->integer('rating')
            ->requirePresence('rating');

        $validator
            ->boolean('is_spam')
            ->notEmptyString('is_spam');

        $validator
            ->nonNegativeInteger('status')
            ->notEmptyString('status');

        $validator
            ->nonNegativeInteger('origin')
            ->notEmptyString('origin');

        $validator
            ->scalar('response')
            ->allowEmptyString('response');

        $validator
            ->nonNegativeInteger('response_status')
            ->notEmptyString('response_status');

        $validator
            ->dateTime('denied_date')
            ->allowEmptyDateTime('denied_date');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 50)
            ->allowEmptyString('ip');

        $validator
            ->nonNegativeInteger('character_count')
            ->notEmptyString('character_count');

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
     * beforeSave() for ReviewsTable
     *
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     *
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $entity->set('sendReviewEmail', false);

        // Check if 'status' OR 'response_status' has changed
        if ($entity->isDirty('status') || $entity->isDirty('response_status')) {
            // Is status 'Approved' (Published)?
            if (ReviewStatus::APPROVED === ReviewStatus::from($entity->get('status'))) {
                // Was the 'response_status' changed from RESPONDED -> PUBLISHED
                if (
                    ReviewResponseStatus::from($entity->getOriginal('response_status')) === ReviewResponseStatus::RESPONSE_STATUS_RESPONDED  &&
                    ReviewResponseStatus::from($entity->get('response_status')) === ReviewResponseStatus::RESPONSE_STATUS_PUBLISHED
                   ) {
                    // A clinic response was approved -> Send response-posted email
                    $entity->set('sendReviewEmail', 'emailReviewResponsePosted');
                // Another 'response_status' change that doesn't trigger an email will return true
                } elseif ($entity->getOriginal('response_status') !== $entity->get('response_status')) {
                    return true;
                // Status changed to Approved - Send positive review email
                } else {
                    $entity->set('sendReviewEmail', 'emailPositiveReviewReceived');
                }
            // Is status 'Denied' (Publish negative review)?
            } elseif (ReviewStatus::DENIED === ReviewStatus::from($entity->get('status'))) {
                // Status changed to 'Denied' (Published Negative) - Send negative review email
                $entity->set('sendReviewEmail', 'emailNegativeReviewReceived');
                $entity->set('denied_date', FrozenTime::now()->format('Y-m-d H:i:s'));
                $entity->set('status', ReviewStatus::APPROVED->value);
            }

            return true;
        }
    }

    /**
     * afterSave() for ReviewsTable
     *
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     *
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $sendReviewEmail = $entity->get('sendReviewEmail');
        if ($sendReviewEmail !== false) {
            $mailer = $this->getMailer('Review');
            match ($sendReviewEmail) {
                'emailPositiveReviewReceived' => $mailer->send('emailPositiveReviewReceived', [$entity]),
                'emailNegativeReviewReceived' => $mailer->send('emailNegativeReviewReceived', [$entity]),
                'emailReviewResponsePosted' => $mailer->send('emailReviewResponsePosted', [$entity]),
            };
        };

        // averageRating()
        // updateReviewCount()
        // updateReviewStatus()
    }

    /**
     * Shortcut function ignore
     *
     * @param int $id Review id
     * @return \App\Model\Table\result of status setting
     */
    public function ignore($id = null)
    {
        $review = $this->get($id);
        $review->status = ReviewStatus::IGNORED->value;

        return $this->save($review);
    }

    /**
     * Approve function for Reviews
     *
     * @param int $id Review id
     * @return \Cake\Datasource\EntityInterface|false of status setting
     */
    public function approve($id = null)
    {
        $review = $this->get($id);
        $review->status = ReviewStatus::APPROVED->value;

        return $this->save($review);
    }

    /**
     * Approve-all function for Reviews
     *
     * @param array $ids Array of Review ids to be approved
     * @return iterable<\Cake\Datasource\EntityInterface> Entities list.
     */
    public function approveAll(array $ids)
    {
        $reviews = $this->find()
            ->where(['id IN' => $ids])
            ->toList();

        // Create patch data array of Review ids and APPROVED statuses
        $patchData = array_fill(0, count($ids), ['status' => ReviewStatus::APPROVED->value]);
        foreach ($patchData as $key => &$entityData) {
            $entityData = array_merge(
                [
                    'id' => $reviews[$key]->id,
                ],
                $entityData
            );
        }

        $patchedEntities = $this->patchEntities(
            $reviews,
            $patchData,
            [
                'fields' => ['status'],
            ]
        );

        return $this->saveManyOrFail($patchedEntities);
    }

    /**
     * Deny (approve negative reviews) function for Reviews
     *
     * @param int $id  Review id
     * @return \App\Model\Table\result of status setting
     */
    public function deny($id = null)
    {
        $review = $this->get($id);
        $review->status = ReviewStatus::DENIED->value;

        return $this->save($review);
    }

    public function findIpMatches($reviewId) {
        $data['ipWarningsFound'] = [];
        $reviewIp = $this->get($reviewId)->ip;
        if (!empty($reviewIp)) {
            // Login IP matches
            $loginMatches = $this->getTableLocator()->get('LoginIps')->find()
                ->where([
                    'ip' => $reviewIp
                ])
                ->order(['login_date' => 'DESC'])
                ->all();
            $data['loginMatches'] = $loginMatches;
            // Review IP matches
            $reviewMatches = $this->find()
                ->where([
                    'id !=' => $reviewId,
                    'ip' => $reviewIp
                ])
                ->order(['created' => 'DESC'])
                ->all();
            $data['reviewMatches'] = $reviewMatches;
            // LocationNote IP matches
            $noteMatches = $this->getTableLocator()->get('LocationNotes')->find()
                ->where([
                    'body LIKE' => '%'.$reviewIp.'%'
                ])
                ->order(['created' => 'DESC'])
                ->all();
            $data['noteMatches'] = $noteMatches;
            if (!empty($loginMatches) || !empty($reviewMatches) || !empty($noteMatches)) {
                $data['ipWarningsFound'] = true;
            }
        }
        return $data;
    }
}
