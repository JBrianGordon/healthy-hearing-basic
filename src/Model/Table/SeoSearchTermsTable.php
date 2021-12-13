<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoSearchTerms Model
 *
 * @method \App\Model\Entity\SeoSearchTerm newEmptyEntity()
 * @method \App\Model\Entity\SeoSearchTerm newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoSearchTerm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoSearchTerm get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoSearchTerm[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoSearchTerm|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoSearchTerm[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoSearchTermsTable extends Table
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

        $this->setTable('seo_search_terms');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('term')
            ->maxLength('term', 255)
            ->requirePresence('term', 'create')
            ->notEmptyString('term');

        $validator
            ->scalar('uri')
            ->maxLength('uri', 255)
            ->requirePresence('uri', 'create')
            ->notEmptyString('uri');

        $validator
            ->integer('count')
            ->requirePresence('count', 'create')
            ->notEmptyString('count');

        return $validator;
    }
}
