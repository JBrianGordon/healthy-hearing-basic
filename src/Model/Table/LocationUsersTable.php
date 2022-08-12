<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationUsers Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\LocationUserLoginsTable&\Cake\ORM\Association\HasMany $LocationUserLogins
 *
 * @method \App\Model\Entity\LocationUser newEmptyEntity()
 * @method \App\Model\Entity\LocationUser newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LocationUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocationUser findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LocationUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocationUser[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationUser[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationUser[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationUser[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationUser[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LocationUsersTable extends Table
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

        $this->setTable('location_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('LocationUserLogins', [
            'foreignKey' => 'location_user_id',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('username')
            ->value('password')
            ->value('first_name')
            ->value('last_name')
            ->value('email')
            ->value('created')
            ->value('modified')
            ->value('lastlogin')
            ->boolean('is_active')
            ->value('reset_url')
            ->value('reset_expiration_date')
            ->value('clinic_password')
            ->value('location_id')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['username', 'first_name', 'last_name'],
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
            ->scalar('username')
            ->maxLength('username', 128)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 128)
            ->notEmptyString('password');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 128)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 128)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->dateTime('lastlogin')
            ->allowEmptyDateTime('lastlogin');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('reset_url')
            ->maxLength('reset_url', 25)
            ->allowEmptyString('reset_url');

        $validator
            ->dateTime('reset_expiration_date')
            ->allowEmptyDateTime('reset_expiration_date');

        $validator
            ->scalar('clinic_password')
            ->maxLength('clinic_password', 10)
            ->allowEmptyString('clinic_password');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}
