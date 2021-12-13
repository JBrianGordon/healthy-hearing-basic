<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Wikis Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ConsumerGuidesTable&\Cake\ORM\Association\BelongsTo $ConsumerGuides
 * @property \App\Model\Table\TagWikisTable&\Cake\ORM\Association\HasMany $TagWikis
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Wiki newEmptyEntity()
 * @method \App\Model\Entity\Wiki newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Wiki[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Wiki get($primaryKey, $options = [])
 * @method \App\Model\Entity\Wiki findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Wiki patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Wiki[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Wiki|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Wiki saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WikisTable extends Table
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

        $this->setTable('wikis');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('ConsumerGuides', [
            'foreignKey' => 'consumer_guide_id',
        ]);
        $this->hasMany('TagWikis', [
            'foreignKey' => 'wiki_id',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'wiki_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'users_wikis',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('responsive_body')
            ->allowEmptyString('responsive_body');

        $validator
            ->scalar('body')
            ->allowEmptyString('body');

        $validator
            ->scalar('short')
            ->allowEmptyString('short');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->integer('id_draft_parent')
            ->notEmptyString('id_draft_parent');

        $validator
            ->integer('order')
            ->notEmptyString('order');

        $validator
            ->scalar('title_head')
            ->maxLength('title_head', 255)
            ->requirePresence('title_head', 'create')
            ->notEmptyString('title_head');

        $validator
            ->scalar('title_h1')
            ->maxLength('title_h1', 255)
            ->requirePresence('title_h1', 'create')
            ->notEmptyString('title_h1');

        $validator
            ->scalar('background_file')
            ->maxLength('background_file', 255)
            ->allowEmptyFile('background_file');

        $validator
            ->scalar('meta_description')
            ->maxLength('meta_description', 255)
            ->allowEmptyString('meta_description');

        $validator
            ->scalar('facebook_title')
            ->maxLength('facebook_title', 255)
            ->allowEmptyString('facebook_title');

        $validator
            ->scalar('facebook_image')
            ->maxLength('facebook_image', 255)
            ->allowEmptyFile('facebook_image');

        $validator
            ->boolean('facebook_image_bypass')
            ->allowEmptyFile('facebook_image_bypass');

        $validator
            ->integer('facebook_image_width')
            ->notEmptyFile('facebook_image_width');

        $validator
            ->integer('facebook_image_height')
            ->notEmptyFile('facebook_image_height');

        $validator
            ->scalar('facebook_image_alt')
            ->maxLength('facebook_image_alt', 255)
            ->allowEmptyFile('facebook_image_alt');

        $validator
            ->scalar('facebook_description')
            ->maxLength('facebook_description', 255)
            ->allowEmptyString('facebook_description');

        $validator
            ->dateTime('last_modified')
            ->allowEmptyDateTime('last_modified');

        $validator
            ->scalar('background_alt')
            ->maxLength('background_alt', 150)
            ->requirePresence('background_alt', 'create')
            ->notEmptyString('background_alt');

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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('consumer_guide_id', 'ConsumerGuides'), ['errorField' => 'consumer_guide_id']);

        return $rules;
    }
}
