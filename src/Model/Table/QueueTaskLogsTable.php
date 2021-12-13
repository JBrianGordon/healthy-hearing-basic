<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QueueTaskLogs Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\QueueTaskLog newEmptyEntity()
 * @method \App\Model\Entity\QueueTaskLog newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\QueueTaskLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QueueTaskLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\QueueTaskLog findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\QueueTaskLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QueueTaskLog[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\QueueTaskLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueTaskLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueTaskLog[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueueTaskLog[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueueTaskLog[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueueTaskLog[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QueueTaskLogsTable extends Table
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

        $this->setTable('queue_task_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('id')
            ->maxLength('id', 36)
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('executed')
            ->allowEmptyDateTime('executed');

        $validator
            ->dateTime('scheduled')
            ->allowEmptyDateTime('scheduled');

        $validator
            ->dateTime('scheduled_end')
            ->allowEmptyDateTime('scheduled_end');

        $validator
            ->scalar('reschedule')
            ->maxLength('reschedule', 50)
            ->allowEmptyString('reschedule');

        $validator
            ->allowEmptyString('start_time');

        $validator
            ->allowEmptyString('end_time');

        $validator
            ->integer('cpu_limit')
            ->allowEmptyString('cpu_limit');

        $validator
            ->boolean('is_restricted')
            ->notEmptyString('is_restricted');

        $validator
            ->integer('priority')
            ->notEmptyString('priority');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('command')
            ->requirePresence('command', 'create')
            ->notEmptyString('command');

        $validator
            ->scalar('result')
            ->allowEmptyString('result');

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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
