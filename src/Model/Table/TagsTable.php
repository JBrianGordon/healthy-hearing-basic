<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * Tags Model
 *
 * @property \App\Model\Table\TagAdsTable&\Cake\ORM\Association\HasMany $TagAds
 * @property \App\Model\Table\TagWikisTable&\Cake\ORM\Association\HasMany $TagWikis
 * @property \App\Model\Table\ContentTable&\Cake\ORM\Association\BelongsToMany $Content
 *
 * @method \App\Model\Entity\Tag newEmptyEntity()
 * @method \App\Model\Entity\Tag newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Tag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tag get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tag findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Tag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tag[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tag|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tag saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TagsTable extends Table
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

        $this->setTable('tags');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('TagAds', [
            'foreignKey' => 'tag_id',
        ]);
        $this->hasMany('TagWikis', [
            'foreignKey' => 'tag_id',
        ]);
        $this->belongsToMany('Content', [
            'through' => 'ContentTags',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->boolean('is_category')
            ->notEmptyString('is_category');

        $validator
            ->boolean('is_sub_category')
            ->notEmptyString('is_sub_category');

        $validator
            ->scalar('header')
            ->allowEmptyString('header');

        $validator
            ->scalar('display_header')
            ->maxLength('display_header', 255)
            ->requirePresence('display_header', 'create')
            ->notEmptyString('display_header');

        $validator
            ->scalar('ribbon_header')
            ->maxLength('ribbon_header', 255)
            ->requirePresence('ribbon_header', 'create')
            ->notEmptyString('ribbon_header');

        return $validator;
    }

    /**
    * Get a list of all tags for display
    */
    public function findTagList(){
        $tags = $this->find('all', [
            'order' => ['display_header' => 'ASC']
        ])->all();
        $tagList = [];
        foreach ($tags as $tag) {
            $tagList[$tag->id] = '<strong>'.$tag->display_header.'</strong><br><small>('.$tag->name.')</small>';
        }
        return $tagList;
    }
}
