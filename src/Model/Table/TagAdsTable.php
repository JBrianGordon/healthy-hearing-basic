<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TagAds Model
 *
 * @property \App\Model\Table\AdsTable&\Cake\ORM\Association\BelongsTo $Ads
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\TagAd newEmptyEntity()
 * @method \App\Model\Entity\TagAd newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\TagAd[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TagAd get($primaryKey, $options = [])
 * @method \App\Model\Entity\TagAd findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\TagAd patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TagAd[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TagAd|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TagAd saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TagAd[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TagAd[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\TagAd[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TagAd[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TagAdsTable extends Table
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

        $this->setTable('tag_ads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Advertisements', [
            'foreignKey' => 'ad_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
        $rules->add($rules->existsIn('ad_id', 'Ads'), ['errorField' => 'ad_id']);
        $rules->add($rules->existsIn('tag_id', 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}
