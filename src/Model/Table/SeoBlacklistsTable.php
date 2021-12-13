<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoBlacklists Model
 *
 * @method \App\Model\Entity\SeoBlacklist newEmptyEntity()
 * @method \App\Model\Entity\SeoBlacklist newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoBlacklist[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoBlacklist get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoBlacklist findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoBlacklist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoBlacklist[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoBlacklist|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoBlacklist saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoBlacklist[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoBlacklist[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoBlacklist[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoBlacklist[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoBlacklistsTable extends Table
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

        $this->setTable('seo_blacklists');
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
            ->requirePresence('ip_range_start', 'create')
            ->notEmptyString('ip_range_start');

        $validator
            ->requirePresence('ip_range_end', 'create')
            ->notEmptyString('ip_range_end');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        return $validator;
    }
}
