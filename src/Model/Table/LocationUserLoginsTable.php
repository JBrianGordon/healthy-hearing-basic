<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationUserLogins Model
 *
 * @property \App\Model\Table\LocationUsersTable&\Cake\ORM\Association\BelongsTo $LocationUsers
 *
 * @method \App\Model\Entity\LocationUserLogin newEmptyEntity()
 * @method \App\Model\Entity\LocationUserLogin newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LocationUserLogin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationUserLogin get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocationUserLogin findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LocationUserLogin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocationUserLogin[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationUserLogin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationUserLogin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationUserLogin[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationUserLogin[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationUserLogin[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationUserLogin[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LocationUserLoginsTable extends Table
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

        $this->setTable('location_user_logins');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('LocationUsers', [
            'foreignKey' => 'location_user_id',
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
            ->dateTime('login_date')
            ->allowEmptyDateTime('login_date');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 50)
            ->allowEmptyString('ip');

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
        $rules->add($rules->existsIn('location_user_id', 'LocationUsers'), ['errorField' => 'location_user_id']);

        return $rules;
    }
}
