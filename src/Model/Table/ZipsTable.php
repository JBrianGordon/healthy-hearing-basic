<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;

/**
 * Zips Model
 *
 * @method \App\Model\Entity\Zip newEmptyEntity()
 * @method \App\Model\Entity\Zip newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Zip[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Zip get($primaryKey, $options = [])
 * @method \App\Model\Entity\Zip findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Zip patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Zip[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Zip|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Zip saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ZipsTable extends Table
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

        $this->setTable('zips');
        $this->setDisplayField('zip');

        $this->addBehaviors(['Search.Search']);

        // Setup search filter using search manager
        $this->searchManager()
            ->like('city', [
                'before' => true,
                'after' => true,
            ])
            ->value('state')
            ->value('zip')
            ->value('country_code')
            ->value('lat')
            ->value('lon')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['zip', 'city'],
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
            ->scalar('zip')
            ->maxLength('zip', 10)
            ->notEmptyString('zip');

        $validator
            ->numeric('lat')
            ->allowEmptyString('lat');

        $validator
            ->numeric('lon')
            ->allowEmptyString('lon');

        $validator
            ->scalar('city')
            ->maxLength('city', 64)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->allowEmptyString('state');

        $validator
            ->scalar('country_code')
            ->maxLength('country_code', 2)
            ->allowEmptyString('country_code');

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
        $rules->add($rules->isUnique(['zip']));

        return $rules;
    }
}
