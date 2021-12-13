<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportStatus Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\ImportStatus newEmptyEntity()
 * @method \App\Model\Entity\ImportStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ImportStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ImportStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImportStatusTable extends Table
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

        $this->setTable('import_status');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
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
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->integer('oticon_tier')
            ->requirePresence('oticon_tier', 'create')
            ->notEmptyString('oticon_tier');

        $validator
            ->scalar('listing_type')
            ->maxLength('listing_type', 20)
            ->requirePresence('listing_type', 'create')
            ->notEmptyString('listing_type');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->boolean('is_show')
            ->allowEmptyString('is_show');

        $validator
            ->boolean('is_grace_period')
            ->allowEmptyString('is_grace_period');

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
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}
