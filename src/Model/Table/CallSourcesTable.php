<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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

        $this->addBehavior('Timestamp');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER',
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
}
