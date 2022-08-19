<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Corps Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AdvertisementsTable&\Cake\ORM\Association\HasMany $Advertisements
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @method \App\Model\Entity\Corp newEmptyEntity()
 * @method \App\Model\Entity\Corp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Corp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Corp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\DraftBehavior
 * @mixin \Duplicatable\Model\Behavior\DuplicatableBehavior
 */
class CorpsTable extends Table
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

        $this->setTable('corps');
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
        $this->addBehavior('Sitemap.Sitemap', [
            'conditions' => [
                'is_active' => true,
            ],
            'fields' => ['id', 'priority', 'slug', 'title'],
            'order' => ['priority' => 'ASC', 'title' => 'ASC'],
            'priority' => 0.7,
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Advertisements', [
            'foreignKey' => 'corp_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'corp_id',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'corp_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'corps_users',
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
        //     ->scalar('type')
        //     ->maxLength('type', 16)
        //     ->requirePresence('type', 'create')
        //     ->notEmptyString('type');

        // $validator
        //     ->dateTime('last_modified')
        //     ->allowEmptyDateTime('last_modified');

        // $validator
        //     ->integer('modified_by')
        //     ->notEmptyString('modified_by');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->requirePresence('title', true, 'Title is a required field')
            ->notEmptyString('title', 'Title cannot be left blank');

        // $validator
        //     ->scalar('title_long')
        //     ->maxLength('title_long', 255)
        //     ->requirePresence('title_long', 'create')
        //     ->notEmptyString('title_long');

        // $validator
        //     ->scalar('slug')
        //     ->maxLength('slug', 128)
        //     ->requirePresence('slug', 'create')
        //     ->notEmptyString('slug');

        // $validator
        //     ->scalar('abbr')
        //     ->maxLength('abbr', 3)
        //     ->requirePresence('abbr', 'create')
        //     ->notEmptyString('abbr');

        // $validator
        //     ->scalar('short')
        //     ->allowEmptyString('short');

        // $validator
        //     ->scalar('description')
        //     ->allowEmptyString('description');

        // $validator
        //     ->scalar('notify_email')
        //     ->maxLength('notify_email', 128)
        //     ->allowEmptyString('notify_email');

        // $validator
        //     ->scalar('approval_email')
        //     ->maxLength('approval_email', 128)
        //     ->allowEmptyString('approval_email');

        // $validator
        //     ->scalar('phone')
        //     ->maxLength('phone', 64)
        //     ->allowEmptyString('phone');

        // $validator
        //     ->scalar('website_url')
        //     ->maxLength('website_url', 255)
        //     ->requirePresence('website_url', 'create')
        //     ->notEmptyString('website_url');

        // $validator
        //     ->scalar('website_url_description')
        //     ->maxLength('website_url_description', 255)
        //     ->allowEmptyString('website_url_description');

        // $validator
        //     ->scalar('pdf_all_url')
        //     ->maxLength('pdf_all_url', 128)
        //     ->allowEmptyString('pdf_all_url');

        // $validator
        //     ->scalar('favicon')
        //     ->maxLength('favicon', 128)
        //     ->allowEmptyString('favicon');

        // $validator
        //     ->scalar('address')
        //     ->maxLength('address', 255)
        //     ->allowEmptyString('address');

        // $validator
        //     ->scalar('thumb_url')
        //     ->maxLength('thumb_url', 128)
        //     ->allowEmptyString('thumb_url');

        // $validator
        //     ->scalar('facebook_title')
        //     ->maxLength('facebook_title', 100)
        //     ->allowEmptyString('facebook_title');

        // $validator
        //     ->scalar('facebook_description')
        //     ->maxLength('facebook_description', 255)
        //     ->allowEmptyString('facebook_description');

        // $validator
        //     ->scalar('facebook_image')
        //     ->maxLength('facebook_image', 100)
        //     ->allowEmptyFile('facebook_image');

        // $validator
        //     ->dateTime('date_approved')
        //     ->allowEmptyDateTime('date_approved');

        // $validator
        //     ->integer('id_old')
        //     ->notEmptyString('id_old');

        // $validator
        //     ->integer('is_approvalrequired')
        //     ->notEmptyString('is_approvalrequired');

        // $validator
        //     ->boolean('is_active')
        //     ->notEmptyString('is_active');

        // $validator
        //     ->boolean('is_featured')
        //     ->notEmptyString('is_featured');

        // $validator
        //     ->integer('id_draft_parent')
        //     ->notEmptyString('id_draft_parent');

        // $validator
        //     ->scalar('wbc_config')
        //     ->allowEmptyString('wbc_config');

        $validator
            ->integer('priority')
            ->requirePresence('priority', true, 'Priority is a required field')
            ->notEmptyString('priority', 'Priority cannot be left blank');

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
}
