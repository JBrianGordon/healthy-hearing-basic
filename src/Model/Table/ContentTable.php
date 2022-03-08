<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Content Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsToMany $Locations
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @method \App\Model\Entity\Content newEmptyEntity()
 * @method \App\Model\Entity\Content newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Content[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Content get($primaryKey, $options = [])
 * @method \App\Model\Entity\Content findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Content patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Content[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Content|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Content saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\DraftBehavior
 * @mixin \Duplicatable\Model\Behavior\DuplicatableBehavior
 */
class ContentTable extends Table
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

        $this->setTable('content');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehaviors([
            'Timestamp',
            'Draft',
        ]);
        $this->addBehavior('Duplicatable.Duplicatable', [
            'set' => [
                'is_active' => 0,
            ],
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Locations', [
            'foreignKey' => 'content_id',
            'targetForeignKey' => 'location_id',
            'joinTable' => 'content_locations',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'content_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'content_tags',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'content_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'content_users',
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
        // $validator
        //     ->integer('id')
        //     ->allowEmptyString('id', null, 'create');

        // $validator
        //     ->integer('id_brafton')
        //     ->allowEmptyString('id_brafton');

        $validator
            ->scalar('type')
            ->requirePresence('type', true, 'Type is a required field')
            ->notEmptyString('type', 'Type cannot be left blank');

        // $validator
        //     ->date('date')
        //     ->allowEmptyDate('date');

        $validator
            ->dateTime('last_modified')
            ->allowEmptyDateTime('last_modified');

        $validator
            ->requirePresence('title', true, 'Title is a required field')
            ->scalar('title')
            // ->maxLength('title', 128)
            ->notEmptyString('title', 'Title cannot be left blank');

        // $validator
        //     ->scalar('alt_title')
        //     ->maxLength('alt_title', 128)
        //     ->requirePresence('alt_title', 'create')
        //     ->notEmptyString('alt_title');

        // $validator
        //     ->scalar('title_head')
        //     ->maxLength('title_head', 128)
        //     ->requirePresence('title_head', 'create')
        //     ->notEmptyString('title_head');

        // $validator
        //     ->scalar('slug')
        //     ->maxLength('slug', 128)
        //     ->notEmptyString('slug');

        // $validator
        //     ->scalar('short')
        //     ->requirePresence('short', 'create')
        //     ->notEmptyString('short');

        $validator
            ->scalar('body')
            ->requirePresence('body', true, 'Main content section (body) is a required field')
            ->notEmptyString('body', 'Main content section (body) cannot be left blank');

        // $validator
        //     ->scalar('meta_description')
        //     ->maxLength('meta_description', 255)
        //     ->notEmptyString('meta_description');

        // $validator
        //     ->scalar('bodyclass')
        //     ->maxLength('bodyclass', 64)
        //     ->requirePresence('bodyclass', 'create')
        //     ->notEmptyString('bodyclass');

        // $validator
        //     ->boolean('is_active')
        //     ->notEmptyString('is_active');

        // $validator
        //     ->boolean('is_library_item')
        //     ->notEmptyString('is_library_item');

        // $validator
        //     ->scalar('library_share_text')
        //     ->maxLength('library_share_text', 250)
        //     ->requirePresence('library_share_text', 'create')
        //     ->notEmptyString('library_share_text');

        // $validator
        //     ->boolean('is_gone')
        //     ->notEmptyString('is_gone');

        // $validator
        //     ->scalar('facebook_title')
        //     ->maxLength('facebook_title', 100)
        //     ->allowEmptyString('facebook_title');

        // $validator
        //     ->scalar('facebook_description')
        //     ->maxLength('facebook_description', 255)
        //     ->allowEmptyString('facebook_description');
////////
        // // TO-DO
        // $validator
        //     ->scalar('facebook_image')
        //     ->maxLength('facebook_image', 100)
        //     ->allowEmptyFile('facebook_image');

        // // TO-DO
        // $validator
        //     ->integer('facebook_image_width')
        //     ->notEmptyFile('facebook_image_width');
////////
        // $validator
        //     ->boolean('facebook_image_width_override')
        //     ->allowEmptyFile('facebook_image_width_override');

        // $validator
        //     ->integer('facebook_image_height')
        //     ->notEmptyFile('facebook_image_height');

        $validator
            ->scalar('facebook_image_alt')
            // ->maxLength('facebook_image_alt', 255)
            ->requirePresence('facebook_image_alt', true, 'Facebook image alt is a required field')
            ->notEmptyString('facebook_image_alt', 'Facebook image alt text cannot be left blank');

        // $validator
        //     ->integer('comment_count')
        //     ->notEmptyString('comment_count');

        // $validator
        //     ->integer('like_count')
        //     ->notEmptyString('like_count');

        // $validator
        //     ->boolean('old_url')
        //     ->notEmptyString('old_url');

        // $validator
        //     ->integer('id_draft_parent')
        //     ->notEmptyString('id_draft_parent');

        // $validator
        //     ->boolean('is_frozen')
        //     ->allowEmptyString('is_frozen');

        // // TO-DO
        // $validator for 'user_id' in addition to rules checker

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
        // $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    /**
     * Returns a query for the latest N articles/reports/Content items
     *
     * @param \Cake\ORM\Query $query The Query object to be modified
     * @param array $options List of options to pass to the finder
     * @return \Cake\ORM\Query Modified Query object
     */
    public function findLatest(Query $query, array $options)
    {
        return $query
            ->where(['is_active' => 1])
            ->limit($options['numArticles'] ?? 4)
            ->order(['last_modified' => 'DESC']);
    }
}
