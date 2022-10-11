<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Imports Model
 *
 * @property \App\Model\Table\ImportDiffsTable&\Cake\ORM\Association\HasMany $ImportDiffs
 * @property \App\Model\Table\ImportLocationProvidersTable&\Cake\ORM\Association\HasMany $ImportLocationProviders
 * @property \App\Model\Table\ImportLocationsTable&\Cake\ORM\Association\HasMany $ImportLocations
 * @property \App\Model\Table\ImportProvidersTable&\Cake\ORM\Association\HasMany $ImportProviders
 *
 * @method \App\Model\Entity\Import newEmptyEntity()
 * @method \App\Model\Entity\Import newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Import[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Import get($primaryKey, $options = [])
 * @method \App\Model\Entity\Import findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Import patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Import[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Import|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Import saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Import[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Import[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Import[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Import[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImportsTable extends Table
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

        $this->setTable('imports');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ImportDiffs', [
            'foreignKey' => 'import_id',
        ]);
        $this->hasMany('ImportLocationProviders', [
            'foreignKey' => 'import_id',
        ]);
        $this->hasMany('ImportLocations', [
            'foreignKey' => 'import_id',
        ]);
        $this->hasMany('ImportProviders', [
            'foreignKey' => 'import_id',
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
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->nonNegativeInteger('total_locations')
            ->allowEmptyString('total_locations');

        $validator
            ->nonNegativeInteger('new_locations')
            ->allowEmptyString('new_locations');

        $validator
            ->nonNegativeInteger('updated_locations')
            ->allowEmptyString('updated_locations');

        $validator
            ->nonNegativeInteger('total_providers')
            ->allowEmptyString('total_providers');

        $validator
            ->nonNegativeInteger('new_providers')
            ->allowEmptyString('new_providers');

        $validator
            ->nonNegativeInteger('updated_providers')
            ->allowEmptyString('updated_providers');

        return $validator;
    }

    public function getLatestImportId() {
        $latestImport = $this->find('all', [
            'contain' => [],
            'conditions' => ['type !=' => 'cqp'],
            'order' => ['Imports.created' => 'DESC']
        ])->first();
        return $latestImport->id;
    }

    public function getLatestCqpImportId() {
        $latestCqpImport = $this->find('all', [
            'contain' => [],
            'conditions' => ['type' => 'cqp'],
            'order' => ['Imports.created' => 'DESC']
        ])->first();
        return !empty($latestCqpImport->id) ? $latestCqpImport->id : null;
    }
}
