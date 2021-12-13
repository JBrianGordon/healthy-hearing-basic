<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoHoneypotVisits Model
 *
 * @method \App\Model\Entity\SeoHoneypotVisit newEmptyEntity()
 * @method \App\Model\Entity\SeoHoneypotVisit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoHoneypotVisit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoHoneypotVisitsTable extends Table
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

        $this->setTable('seo_honeypot_visits');
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('ip', 'create')
            ->notEmptyString('ip');

        return $validator;
    }
}
