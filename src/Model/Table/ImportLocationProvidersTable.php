<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportLocationProviders Model
 *
 * @property \App\Model\Table\ImportsTable&\Cake\ORM\Association\BelongsTo $Imports
 * @property \App\Model\Table\ImportLocationsTable&\Cake\ORM\Association\BelongsTo $ImportLocations
 * @property \App\Model\Table\ImportProvidersTable&\Cake\ORM\Association\BelongsTo $ImportProviders
 *
 * @method \App\Model\Entity\ImportLocationProvider newEmptyEntity()
 * @method \App\Model\Entity\ImportLocationProvider newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocationProvider[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocationProvider get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocationProvider[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocationProvider|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocationProvider[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ImportLocationProvidersTable extends Table
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

        $this->setTable('import_location_providers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Imports', [
            'foreignKey' => 'import_id',
        ]);
        $this->belongsTo('ImportLocations', [
            'foreignKey' => 'import_location_id',
        ]);
        $this->belongsTo('ImportProviders', [
            'foreignKey' => 'import_provider_id',
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
        $rules->add($rules->existsIn('import_location_id', 'ImportLocations'), ['errorField' => 'import_location_id']);
        $rules->add($rules->existsIn('import_provider_id', 'ImportProviders'), ['errorField' => 'import_provider_id']);

        return $rules;
    }
}
