<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Zipcodes Model
 *
 * @method \App\Model\Entity\Zipcode newEmptyEntity()
 * @method \App\Model\Entity\Zipcode newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Zipcode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Zipcode get($primaryKey, $options = [])
 * @method \App\Model\Entity\Zipcode findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Zipcode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Zipcode[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Zipcode|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Zipcode saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Zipcode[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zipcode[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zipcode[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zipcode[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ZipcodesTable extends Table
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

        $this->setTable('zipcodes');
        $this->setDisplayField('zip');
        $this->setPrimaryKey('zip');
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
            ->allowEmptyString('zip', null, 'create');

        $validator
            ->numeric('lat')
            ->notEmptyString('lat');

        $validator
            ->numeric('lon')
            ->notEmptyString('lon');

        $validator
            ->scalar('city')
            ->maxLength('city', 64)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->scalar('areacode')
            ->maxLength('areacode', 3)
            ->requirePresence('areacode', 'create')
            ->notEmptyString('areacode');

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
        $rules->add($rules->isUnique(['zip', 'lat', 'lon']), ['errorField' => 'zip']);

        return $rules;
    }
}
