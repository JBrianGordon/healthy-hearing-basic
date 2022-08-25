<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
            ->requirePresence('duration', 'create')
            ->notEmptyString('duration');

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
            ->requirePresence('recording_duration', 'create')
            ->notEmptyString('recording_duration');

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
}
