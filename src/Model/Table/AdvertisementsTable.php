<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Advertisements Model
 *
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\BelongsTo $Corps
 *
 * @method \App\Model\Entity\Advertisement newEmptyEntity()
 * @method \App\Model\Entity\Advertisement newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Advertisement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Advertisement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Advertisement findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Advertisement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Advertisement[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Advertisement|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Advertisement saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Advertisement[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Advertisement[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Advertisement[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Advertisement[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdvertisementsTable extends Table
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

        $this->setTable('advertisements');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Corps', [
            'foreignKey' => 'corp_id',
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
            ->integer('modified_by')
            ->notEmptyString('modified_by');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 128)
            ->notEmptyString('slug');

        $validator
            ->scalar('type')
            ->maxLength('type', 8)
            ->notEmptyString('type');

        $validator
            ->scalar('src')
            ->maxLength('src', 255)
            ->notEmptyString('src');

        $validator
            ->scalar('dest')
            ->maxLength('dest', 255)
            ->notEmptyString('dest');

        $validator
            ->scalar('slot')
            ->maxLength('slot', 64)
            ->notEmptyString('slot');

        $validator
            ->scalar('height')
            ->maxLength('height', 32)
            ->notEmptyString('height');

        $validator
            ->scalar('width')
            ->maxLength('width', 32)
            ->notEmptyString('width');

        $validator
            ->scalar('alt')
            ->maxLength('alt', 128)
            ->notEmptyString('alt');

        $validator
            ->scalar('class')
            ->maxLength('class', 128)
            ->notEmptyString('class');

        $validator
            ->scalar('style')
            ->maxLength('style', 32)
            ->notEmptyString('style');

        $validator
            ->scalar('onclick')
            ->maxLength('onclick', 32)
            ->notEmptyString('onclick');

        $validator
            ->scalar('onmouseover')
            ->maxLength('onmouseover', 32)
            ->notEmptyString('onmouseover');

        $validator
            ->integer('weight')
            ->notEmptyString('weight');

        $validator
            ->date('active_expires')
            ->allowEmptyDate('active_expires');

        $validator
            ->scalar('restrict_path')
            ->allowEmptyString('restrict_path');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('is_ao')
            ->notEmptyString('is_ao');

        $validator
            ->boolean('is_hh')
            ->notEmptyString('is_hh');

        $validator
            ->boolean('is_sp')
            ->notEmptyString('is_sp');

        $validator
            ->boolean('is_ei')
            ->notEmptyString('is_ei');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->boolean('tag_corps')
            ->notEmptyString('tag_corps');

        $validator
            ->boolean('tag_basic')
            ->notEmptyString('tag_basic');

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
        $rules->add($rules->existsIn('corp_id', 'Corps'), ['errorField' => 'corp_id']);

        return $rules;
    }
}
