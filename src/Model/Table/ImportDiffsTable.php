<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportDiffs Model
 *
 * @property \App\Model\Table\ImportsTable&\Cake\ORM\Association\BelongsTo $Imports
 *
 * @method \App\Model\Entity\ImportDiff newEmptyEntity()
 * @method \App\Model\Entity\ImportDiff newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ImportDiff[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportDiff get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportDiff findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ImportDiff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportDiff[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportDiff|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportDiff saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportDiff[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportDiff[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportDiff[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportDiff[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImportDiffsTable extends Table
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

        $this->setTable('import_diffs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Imports', [
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
            ->scalar('model')
            ->maxLength('model', 255)
            ->requirePresence('model', 'create')
            ->notEmptyString('model');

        $validator
            ->scalar('id_model')
            ->maxLength('id_model', 255)
            ->allowEmptyString('id_model');

        $validator
            ->scalar('field')
            ->maxLength('field', 255)
            ->requirePresence('field', 'create')
            ->notEmptyString('field');

        $validator
            ->scalar('value')
            ->allowEmptyString('value');

        $validator
            ->boolean('review_needed')
            ->notEmptyString('review_needed');

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

        return $rules;
    }
}
