<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoMetaTags Model
 *
 * @property \App\Model\Table\SeoUrisTable&\Cake\ORM\Association\BelongsTo $SeoUris
 *
 * @method \App\Model\Entity\SeoMetaTag newEmptyEntity()
 * @method \App\Model\Entity\SeoMetaTag newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoMetaTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoMetaTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoMetaTag findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoMetaTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoMetaTag[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoMetaTag|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoMetaTag saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoMetaTag[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoMetaTag[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoMetaTag[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoMetaTag[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoMetaTagsTable extends Table
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

        $this->setTable('seo_meta_tags');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SeoUris', [
            'foreignKey' => 'seo_uri_id',
            'joinType' => 'LEFT',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        $validator
            ->boolean('is_http_equiv')
            ->notEmptyString('is_http_equiv');

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
        $rules->add($rules->existsIn('seo_uri_id', 'SeoUris'), ['errorField' => 'seo_uri_id']);

        return $rules;
    }
}
