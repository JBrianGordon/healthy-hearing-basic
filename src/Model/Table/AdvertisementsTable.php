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

        $this->hasMany('TagAds', [
            'foreignKey' => 'ad_id',
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
            ->maxLength('title', 128)
            ->notEmptyString('title');

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
    * Find an advertisement to display with no exclusivity tags.
    * If more than one found, it will randomly select one. If none are found, returns null.
    */
    function findGenericAd() {
        $allAds = $this->find('all', [
            'contain' => ['TagAds.Tags'],
            'conditions' => [
                'is_active' => true,
                'tag_corps' => false,
                'tag_basic' => false,
            ]
        ])->all();
        $genericAds = [];
        foreach ($allAds as $ad) {
            // Don't include ads with an exclusivity tag
            if (empty($ad->tag_ads)) {
                $genericAds[] = $ad;
            }
        }
        if (empty($genericAds)) {
            return null;
        } else {
            // Randomly select one of the generic ads in this array
            $key = array_rand($genericAds);
            return $genericAds[$key];
        }
    }

    /**
    * Find an advertisement to display based on exclusivity tag.
    * If more than one found, it will randomly select one. If none are found, returns null.
    * @param $tags array of tags
    */
    function findAdByTags($tags) {
        /* TODO:
        $allExclusiveAds = [];
        $uniqueAdIds = [];
        foreach ($tags as $tag) {
            $ads = ClassRegistry::init('TagAd')->find('all', [
                'contain' => ['Ad'],
                'conditions' => [
                    'TagAd.tag_id' => $tag,
                    'Ad.is_active' => true
                ]
            ]);
            foreach ($ads as $ad) {
                if (!in_array($ad['Ad']['id'], $uniqueAdIds)) {
                    $allExclusiveAds[]['Ad'] = $ad['Ad'];
                    $uniqueAdIds[] = $ad['Ad']['id'];
                }
            }
        }
        if (empty($allExclusiveAds)) {
            return null;
        } else {
            // Randomly select one of the exclusive ads in this array
            $key = array_rand($allExclusiveAds);
            return $allExclusiveAds[$key];
        }*/
    }

    /**
    * Find an advertisement to display that is tagged for corp pages.
    * If more than one found, it will randomly select one. If none are found, returns null.
    */
    function findAdForCorps() {
        /* TODO:
        $allCorpAds = ClassRegistry::init('Ad')->find('all', [
            'contain' => [],
            'conditions' => [
                'Ad.is_active' => true,
                'Ad.tag_corps' => true,
            ]
        ]);
        if (empty($allCorpAds)) {
            return null;
        } else {
            // Randomly select one of the corp ads in this array
            $key = array_rand($allCorpAds);
            return $allCorpAds[$key];
        }*/
    }

    /**
    * Find an advertisement to display that is tagged for basic profile pages.
    * If more than one found, it will randomly select one. If none are found, returns null.
    */
    function findAdForBasicProfile() {
        $allBasicAds = $this->find('all', [
            'conditions' => [
                'is_active' => true,
                'tag_basic' => true,
            ]
        ])->toArray();
        if (empty($allBasicAds)) {
            return null;
        } else {
            // Randomly select one of the basic ads in this array
            $key = array_rand($allBasicAds);
            return $allBasicAds[$key];
        }
    }
}
