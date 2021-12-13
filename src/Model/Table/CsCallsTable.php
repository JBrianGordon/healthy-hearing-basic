<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CsCalls Model
 *
 * @property \App\Model\Table\CallsTable&\Cake\ORM\Association\BelongsTo $Calls
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\CsCall newEmptyEntity()
 * @method \App\Model\Entity\CsCall newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CsCall[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CsCall get($primaryKey, $options = [])
 * @method \App\Model\Entity\CsCall findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CsCall patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CsCall[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CsCall|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CsCall saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CsCallsTable extends Table
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

        $this->setTable('cs_calls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Calls', [
            'foreignKey' => 'call_id',
            'joinType' => 'INNER',
        ]);
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
            ->scalar('ad_source')
            ->maxLength('ad_source', 255)
            ->allowEmptyString('ad_source');

        $validator
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->scalar('result')
            ->maxLength('result', 1)
            ->requirePresence('result', 'create')
            ->notEmptyString('result');

        $validator
            ->integer('duration')
            ->requirePresence('duration', 'create')
            ->notEmptyString('duration');

        $validator
            ->scalar('call_type')
            ->maxLength('call_type', 255)
            ->allowEmptyString('call_type');

        $validator
            ->scalar('call_status')
            ->maxLength('call_status', 255)
            ->allowEmptyString('call_status');

        $validator
            ->scalar('leadscore')
            ->maxLength('leadscore', 255)
            ->allowEmptyString('leadscore');

        $validator
            ->scalar('recording_url')
            ->maxLength('recording_url', 255)
            ->allowEmptyString('recording_url');

        $validator
            ->scalar('tracking_number')
            ->maxLength('tracking_number', 16)
            ->requirePresence('tracking_number', 'create')
            ->notEmptyString('tracking_number');

        $validator
            ->scalar('caller_phone')
            ->maxLength('caller_phone', 16)
            ->requirePresence('caller_phone', 'create')
            ->notEmptyString('caller_phone');

        $validator
            ->scalar('clinic_phone')
            ->maxLength('clinic_phone', 16)
            ->requirePresence('clinic_phone', 'create')
            ->notEmptyString('clinic_phone');

        $validator
            ->scalar('caller_firstname')
            ->maxLength('caller_firstname', 255)
            ->allowEmptyString('caller_firstname');

        $validator
            ->scalar('caller_lastname')
            ->maxLength('caller_lastname', 255)
            ->allowEmptyString('caller_lastname');

        $validator
            ->scalar('prospect')
            ->maxLength('prospect', 255)
            ->allowEmptyString('prospect');

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
        $rules->add($rules->existsIn('call_id', 'Calls'), ['errorField' => 'call_id']);
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}
