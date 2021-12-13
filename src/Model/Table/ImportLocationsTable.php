<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportLocations Model
 *
 * @property \App\Model\Table\ImportsTable&\Cake\ORM\Association\BelongsTo $Imports
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ImportLocationProvidersTable&\Cake\ORM\Association\HasMany $ImportLocationProviders
 *
 * @method \App\Model\Entity\ImportLocation newEmptyEntity()
 * @method \App\Model\Entity\ImportLocation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportLocation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ImportLocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportLocation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ImportLocationsTable extends Table
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

        $this->setTable('import_locations');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Imports', [
            'foreignKey' => 'import_id',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('ImportLocationProviders', [
            'foreignKey' => 'import_location_id',
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
            ->scalar('id_external')
            ->maxLength('id_external', 50)
            ->requirePresence('id_external', 'create')
            ->notEmptyString('id_external');

        $validator
            ->scalar('id_oticon')
            ->maxLength('id_oticon', 255)
            ->allowEmptyString('id_oticon');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('subtitle')
            ->maxLength('subtitle', 255)
            ->allowEmptyString('subtitle');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 255)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->allowEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 255)
            ->allowEmptyString('zip');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->allowEmptyString('phone');

        $validator
            ->integer('match_type')
            ->allowEmptyString('match_type');

        $validator
            ->boolean('is_retail')
            ->notEmptyString('is_retail');

        $validator
            ->boolean('is_new')
            ->notEmptyString('is_new');

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
        $rules->add($rules->existsIn('import_id', 'Imports'), ['errorField' => 'import_id']);
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}
