<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoginIps Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\LoginIp newEmptyEntity()
 * @method \App\Model\Entity\LoginIp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LoginIp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoginIp get($primaryKey, $options = [])
 * @method \App\Model\Entity\LoginIp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LoginIp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LoginIp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoginIp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LoginIp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LoginIp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LoginIp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LoginIp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LoginIp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LoginIpsTable extends Table
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

        $this->setTable('login_ips');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->allowEmptyString('user_id');

        $validator
            ->allowEmptyString('location_user_id');

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
        // $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
