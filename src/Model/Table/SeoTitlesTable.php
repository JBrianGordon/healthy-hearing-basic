<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoTitles Model
 *
 * @property \App\Model\Table\SeoUrisTable&\Cake\ORM\Association\BelongsTo $SeoUris
 *
 * @method \App\Model\Entity\SeoTitle newEmptyEntity()
 * @method \App\Model\Entity\SeoTitle newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoTitle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoTitle get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoTitle findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoTitle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoTitle[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoTitle|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoTitle saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoTitle[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoTitle[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoTitle[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoTitle[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoTitlesTable extends Table
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

        $this->setTable('seo_titles');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

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

    /**
    * Find the first title tag that matches this URI
    *
    * @param string incoming reuqest uri
    * @return the first title tag to match
    */
    public function findTitleByUri($request = null) {
        return $this->find('all', [
            'conditions' => [
                'uri' => $request,
                'is_approved' => true
            ],
            'contain' => ['SeoUris'],
        ])->first();
    }
}
