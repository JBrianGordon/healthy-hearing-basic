<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationHours Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\LocationHour newEmptyEntity()
 * @method \App\Model\Entity\LocationHour newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LocationHour[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationHour get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocationHour findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LocationHour patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocationHour[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationHour|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationHour saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationHour[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationHour[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationHour[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationHour[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LocationHoursTable extends Table
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

        $this->setTable('location_hours');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
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
            ->scalar('sun_open')
            ->maxLength('sun_open', 128)
            ->requirePresence('sun_open', 'create')
            ->notEmptyString('sun_open');

        $validator
            ->scalar('sun_close')
            ->maxLength('sun_close', 128)
            ->requirePresence('sun_close', 'create')
            ->notEmptyString('sun_close');

        $validator
            ->boolean('sun_is_closed')
            ->notEmptyString('sun_is_closed');

        $validator
            ->boolean('sun_is_byappt')
            ->notEmptyString('sun_is_byappt');

        $validator
            ->scalar('mon_open')
            ->maxLength('mon_open', 128)
            ->requirePresence('mon_open', 'create')
            ->notEmptyString('mon_open');

        $validator
            ->scalar('mon_close')
            ->maxLength('mon_close', 128)
            ->requirePresence('mon_close', 'create')
            ->notEmptyString('mon_close');

        $validator
            ->boolean('mon_is_closed')
            ->notEmptyString('mon_is_closed');

        $validator
            ->boolean('mon_is_byappt')
            ->notEmptyString('mon_is_byappt');

        $validator
            ->scalar('tue_open')
            ->maxLength('tue_open', 128)
            ->requirePresence('tue_open', 'create')
            ->notEmptyString('tue_open');

        $validator
            ->scalar('tue_close')
            ->maxLength('tue_close', 128)
            ->requirePresence('tue_close', 'create')
            ->notEmptyString('tue_close');

        $validator
            ->boolean('tue_is_closed')
            ->notEmptyString('tue_is_closed');

        $validator
            ->boolean('tue_is_byappt')
            ->notEmptyString('tue_is_byappt');

        $validator
            ->scalar('wed_open')
            ->maxLength('wed_open', 128)
            ->requirePresence('wed_open', 'create')
            ->notEmptyString('wed_open');

        $validator
            ->scalar('wed_close')
            ->maxLength('wed_close', 128)
            ->requirePresence('wed_close', 'create')
            ->notEmptyString('wed_close');

        $validator
            ->boolean('wed_is_closed')
            ->notEmptyString('wed_is_closed');

        $validator
            ->boolean('wed_is_byappt')
            ->notEmptyString('wed_is_byappt');

        $validator
            ->scalar('thu_open')
            ->maxLength('thu_open', 128)
            ->requirePresence('thu_open', 'create')
            ->notEmptyString('thu_open');

        $validator
            ->scalar('thu_close')
            ->maxLength('thu_close', 128)
            ->requirePresence('thu_close', 'create')
            ->notEmptyString('thu_close');

        $validator
            ->boolean('thu_is_closed')
            ->notEmptyString('thu_is_closed');

        $validator
            ->boolean('thu_is_byappt')
            ->notEmptyString('thu_is_byappt');

        $validator
            ->scalar('fri_open')
            ->maxLength('fri_open', 128)
            ->requirePresence('fri_open', 'create')
            ->notEmptyString('fri_open');

        $validator
            ->scalar('fri_close')
            ->maxLength('fri_close', 128)
            ->requirePresence('fri_close', 'create')
            ->notEmptyString('fri_close');

        $validator
            ->boolean('fri_is_closed')
            ->notEmptyString('fri_is_closed');

        $validator
            ->boolean('fri_is_byappt')
            ->notEmptyString('fri_is_byappt');

        $validator
            ->scalar('sat_open')
            ->maxLength('sat_open', 128)
            ->requirePresence('sat_open', 'create')
            ->notEmptyString('sat_open');

        $validator
            ->scalar('sat_close')
            ->maxLength('sat_close', 128)
            ->requirePresence('sat_close', 'create')
            ->notEmptyString('sat_close');

        $validator
            ->boolean('sat_is_closed')
            ->notEmptyString('sat_is_closed');

        $validator
            ->boolean('sat_is_byappt')
            ->notEmptyString('sat_is_byappt');

        $validator
            ->boolean('is_evening_weekend_hours')
            ->notEmptyString('is_evening_weekend_hours');

        $validator
            ->boolean('is_closed_lunch')
            ->notEmptyString('is_closed_lunch');

        $validator
            ->scalar('lunch_start')
            ->maxLength('lunch_start', 128)
            ->requirePresence('lunch_start', 'create')
            ->notEmptyString('lunch_start');

        $validator
            ->scalar('lunch_end')
            ->maxLength('lunch_end', 128)
            ->requirePresence('lunch_end', 'create')
            ->notEmptyString('lunch_end');

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
}
