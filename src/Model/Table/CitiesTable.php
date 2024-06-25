<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;

/**
 * Cities Model
 *
 * @method \App\Model\Entity\City newEmptyEntity()
 * @method \App\Model\Entity\City newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\City[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\City get($primaryKey, $options = [])
 * @method \App\Model\Entity\City findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\City patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\City[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\City|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\City saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CitiesTable extends Table
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

        $this->setTable('cities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

        // Setup search filter using search manager
        $this->searchManager()
            ->like('city', [
                'before' => true,
                'after' => true,
            ])
            ->value('state')
            ->value('zip')
            ->value('country')
            ->value('lat')
            ->value('lon')
            ->boolean('is_near_location')
            ->boolean('is_featured')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['city', 'state'],
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
            ->scalar('city')
            ->maxLength('city', 128)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 5)
            ->requirePresence('zip', 'create')
            ->notEmptyString('zip');

        $validator
            ->scalar('country')
            ->maxLength('country', 2)
            ->requirePresence('country', 'create')
            ->notEmptyString('country');

        $validator
            ->numeric('lon')
            ->notEmptyString('lon');

        $validator
            ->numeric('lat')
            ->notEmptyString('lat');

        $validator
            ->integer('population')
            ->notEmptyString('population');

        $validator
            ->boolean('is_near_location')
            ->notEmptyString('is_near_location');

        $validator
            ->boolean('is_featured')
            ->notEmptyString('is_featured');

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
        $rules->add($rules->isUnique(['city', 'state', 'country']), ['errorField' => 'city']);

        return $rules;
    }

    /**
    * Find cities by state
    * @param state abbreviation
    * @return array of cities.
    */
    public function findAllByState($state = null, $ignore_near_location = false) {
        $order = ['city'=>'ASC'];
        $retval = $this->find('all', [
            'conditions' => [
                'is_near_location' => true,
                'state LIKE' => $state
            ],
            'order' => $order,
        ])->all();

        if ($ignore_near_location && empty($retval)) {
            $retval = $this->find('all', [
                'conditions' => [
                    'state LIKE' => $state
                ],
                'fields' => $fields,
                'order' => $order
            ])->all();
        }

        return $retval;
    }

    /**
    * Find a single city by the city name, could be lower or uppercase
    * @param string city
    * @return cities.
    */
    public function findByCity($city = null, $state = '%') {
        $state = TableRegistry::getTableLocator()->get('Locations')->parseStateSlug($state);
        $city = str_replace("_"," ", $city);
        $city = str_replace("-"," ", $city);
        return $this->find('all', [
            'conditions' => [
                'Cities.city LIKE' => $city.'%',
                'Cities.state LIKE' => $state
            ],
            'contain' => []
        ])->first();
    }
}
