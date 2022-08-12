<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoRedirects Model
 *
 * @property \App\Model\Table\SeoUrisTable&\Cake\ORM\Association\BelongsTo $SeoUris
 *
 * @method \App\Model\Entity\SeoRedirect newEmptyEntity()
 * @method \App\Model\Entity\SeoRedirect newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoRedirect[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoRedirect get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoRedirect findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoRedirect patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoRedirect[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoRedirect|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoRedirect saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoRedirect[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoRedirect[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoRedirect[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoRedirect[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoRedirectsTable extends Table
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

        $this->setTable('seo_redirects');
        $this->setDisplayField('id');
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
            ->scalar('redirect')
            ->maxLength('redirect', 255)
            ->allowEmptyString('redirect');

        $validator
            ->integer('priority')
            ->notEmptyString('priority');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('callback')
            ->maxLength('callback', 255)
            ->allowEmptyString('callback');

        $validator
            ->boolean('is_nocache')
            ->allowEmptyString('is_nocache');

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
