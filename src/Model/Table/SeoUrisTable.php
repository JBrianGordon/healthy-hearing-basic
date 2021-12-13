<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoUris Model
 *
 * @property \App\Model\Table\SeoCanonicalsTable&\Cake\ORM\Association\HasMany $SeoCanonicals
 * @property \App\Model\Table\SeoMetaTagsTable&\Cake\ORM\Association\HasMany $SeoMetaTags
 * @property \App\Model\Table\SeoRedirectsTable&\Cake\ORM\Association\HasMany $SeoRedirects
 * @property \App\Model\Table\SeoStatusCodesTable&\Cake\ORM\Association\HasMany $SeoStatusCodes
 * @property \App\Model\Table\SeoTitlesTable&\Cake\ORM\Association\HasMany $SeoTitles
 *
 * @method \App\Model\Entity\SeoUri newEmptyEntity()
 * @method \App\Model\Entity\SeoUri newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoUri[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoUri get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoUri findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoUri patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoUri[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoUri|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoUri saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoUri[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoUri[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoUri[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoUri[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoUrisTable extends Table
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

        $this->setTable('seo_uris');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('SeoCanonicals', [
            'foreignKey' => 'seo_uri_id',
        ]);
        $this->hasMany('SeoMetaTags', [
            'foreignKey' => 'seo_uri_id',
        ]);
        $this->hasMany('SeoRedirects', [
            'foreignKey' => 'seo_uri_id',
        ]);
        $this->hasMany('SeoStatusCodes', [
            'foreignKey' => 'seo_uri_id',
        ]);
        $this->hasMany('SeoTitles', [
            'foreignKey' => 'seo_uri_id',
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
            ->scalar('uri')
            ->maxLength('uri', 255)
            ->allowEmptyString('uri')
            ->add('uri', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('is_approved')
            ->notEmptyString('is_approved');

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
        $rules->add($rules->isUnique(['uri'], ['allowMultipleNulls' => true]), ['errorField' => 'uri']);

        return $rules;
    }
}
