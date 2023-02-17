<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;
use App\Model\Entity\Review;
use App\Enums\Model\Review\ReviewStatus;

/**
 * Reviews Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
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
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReviewsTable extends Table
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

        $this->setTable('reviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

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
            ->value('body')
            ->value('first_name')
            ->value('last_name')
            ->value('zip')
            ->value('rating')
            ->value('status')
            ->value('origin')
            ->value('response')
            ->value('response_status')
            ->value('created')
            ->value('modified')
            ->value('denied_date')
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
                    $query->matching('Locations', function ($q) use($listingType) {
                        return $q->where(['Locations.listing_type LIKE' => '%'.$listingType.'%']);
                    });
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
            ->scalar('body')
            ->allowEmptyString('body');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 10)
            ->allowEmptyString('zip');

        $validator
            ->integer('rating')
            ->notEmptyString('rating');

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
    * Set the status of a review, quickly
    */
    function setStatus($id = null, $status = null){
        if ($this->exists($id) && in_array($status, array_keys(Review::$statuses))){
            $review = $this->get($id);
            $review = $this->patchEntity($review, ['status' => $status]);
            return $this->save($review);
        }
        return false;
    }

    /**
    * Shortcut function ignore
    * @param int id
    * @return result of status setting
    */
    function ignore($id = null){
        return $this->setStatus($id, Review::STATUS_IGNORED);
    }


    /**
    * Approve function for Reviews
    * @param int id
    * @return result of status settinfg
    */
    function approve($id = null){
        $review = $this->get($id);
        $review->status = ReviewStatus::APPROVED->value;

        return $this->save($review);
    }

}
