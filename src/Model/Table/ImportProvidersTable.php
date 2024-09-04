<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportProviders Model
 *
 * @property \App\Model\Table\ImportsTable&\Cake\ORM\Association\BelongsTo $Imports
 * @property \App\Model\Table\ProvidersTable&\Cake\ORM\Association\BelongsTo $Providers
 * @property \App\Model\Table\ImportLocationProvidersTable&\Cake\ORM\Association\HasMany $ImportLocationProviders
 *
 * @method \App\Model\Entity\ImportProvider newEmptyEntity()
 * @method \App\Model\Entity\ImportProvider newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ImportProvider[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportProvider get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportProvider findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ImportProvider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportProvider[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportProvider|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportProvider saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportProvider[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportProvider[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportProvider[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportProvider[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ImportProvidersTable extends Table
{
    public $fields = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email'
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('import_providers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Imports', [
            'foreignKey' => 'import_id',
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'provider_id',
        ]);
        $this->hasMany('ImportLocationProviders', [
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

        $validator
            ->integer('id_external')
            ->allowEmptyString('id_external');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('email')   // We are not going to validate email in this table. We may recieve invalid emails in import.
            ->allowEmptyString('email');

        $validator
            ->scalar('aud_or_his')
            ->maxLength('aud_or_his', 255)
            ->allowEmptyString('aud_or_his');

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
        $rules->add($rules->existsIn('provider_id', 'Providers'), ['errorField' => 'provider_id']);

        return $rules;
    }

    public function getByImportLocationId($importLocationId) {
        return $this->find()->matching('ImportLocationProviders', function ($q) use ($importLocationId) {
            return $q->where(['ImportLocationProviders.import_location_id' => $importLocationId]);
        })->all();
    }
}
