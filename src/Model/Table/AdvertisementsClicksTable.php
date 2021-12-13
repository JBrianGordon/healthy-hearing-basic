<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdvertisementsClicks Model
 *
 * @property \App\Model\Table\AdsTable&\Cake\ORM\Association\BelongsTo $Ads
 *
 * @method \App\Model\Entity\AdvertisementsClick newEmptyEntity()
 * @method \App\Model\Entity\AdvertisementsClick newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AdvertisementsClick[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdvertisementsClick get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdvertisementsClick[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdvertisementsClick|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AdvertisementsClick[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdvertisementsClicksTable extends Table
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

        $this->setTable('advertisements_clicks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ads', [
            'foreignKey' => 'ad_id',
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
            ->scalar('ref')
            ->maxLength('ref', 255)
            ->notEmptyString('ref');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 16)
            ->notEmptyString('ip');

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

        return $rules;
    }
}
