<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Providers Model
 *
 * @property \App\Model\Table\ImportProvidersTable&\Cake\ORM\Association\HasMany $ImportProviders
 * @property \App\Model\Table\LocationProvidersTable&\Cake\ORM\Association\HasMany $LocationProviders
 *
 * @method \App\Model\Entity\Provider newEmptyEntity()
 * @method \App\Model\Entity\Provider newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Provider[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Provider get($primaryKey, $options = [])
 * @method \App\Model\Entity\Provider findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Provider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Provider[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Provider|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Provider saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProvidersTable extends Table
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

        $this->setTable('providers');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ImportProviders', [
            'foreignKey' => 'provider_id',
        ]);
        $this->hasMany('LocationProviders', [
            'foreignKey' => 'provider_id',
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
            ->scalar('first_name')
            ->maxLength('first_name', 128)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('middle_name')
            ->maxLength('middle_name', 128)
            ->allowEmptyString('middle_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 128)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('credentials')
            ->maxLength('credentials', 128)
            ->allowEmptyString('credentials');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->allowEmptyString('title');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('micro_url')
            ->maxLength('micro_url', 128)
            ->allowEmptyString('micro_url');

        $validator
            ->scalar('square_url')
            ->maxLength('square_url', 128)
            ->allowEmptyString('square_url');

        $validator
            ->scalar('thumb_url')
            ->maxLength('thumb_url', 128)
            ->allowEmptyString('thumb_url');

        $validator
            ->scalar('image_url')
            ->maxLength('image_url', 128)
            ->allowEmptyFile('image_url');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 16)
            ->allowEmptyString('phone');

        $validator
            ->integer('order')
            ->notEmptyString('order');

        $validator
            ->scalar('aud_or_his')
            ->maxLength('aud_or_his', 255)
            ->allowEmptyString('aud_or_his');

        $validator
            ->scalar('caqh_number')
            ->maxLength('caqh_number', 255)
            ->allowEmptyString('caqh_number');

        $validator
            ->scalar('npi_number')
            ->maxLength('npi_number', 255)
            ->allowEmptyString('npi_number');

        $validator
            ->boolean('show_npi')
            ->notEmptyString('show_npi');

        $validator
            ->boolean('is_ida_verified')
            ->notEmptyString('is_ida_verified');

        $validator
            ->scalar('licenses')
            ->allowEmptyString('licenses');

        $validator
            ->boolean('show_license')
            ->notEmptyString('show_license');

        $validator
            ->integer('id_yhn_provider')
            ->allowEmptyString('id_yhn_provider');

        return $validator;
    }
}
