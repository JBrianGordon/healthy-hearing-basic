<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CountMetrics Model
 *
 * @method \App\Model\Entity\CountMetric newEmptyEntity()
 * @method \App\Model\Entity\CountMetric newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CountMetric[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CountMetric get($primaryKey, $options = [])
 * @method \App\Model\Entity\CountMetric findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CountMetric patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CountMetric[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CountMetric|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountMetric saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountMetric[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountMetric[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountMetric[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountMetric[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CountMetricsTable extends Table
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

        $this->setTable('count_metrics');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('type')
            ->maxLength('type', 16)
            ->notEmptyString('type');

        $validator
            ->scalar('metric')
            ->maxLength('metric', 32)
            ->notEmptyString('metric');

        $validator
            ->scalar('name')
            ->maxLength('name', 128)
            ->notEmptyString('name');

        $validator
            ->scalar('sub_name')
            ->maxLength('sub_name', 32)
            ->notEmptyString('sub_name');

        $validator
            ->nonNegativeInteger('count')
            ->notEmptyString('count');

        return $validator;
    }
}
