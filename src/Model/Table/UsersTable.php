<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use CakeDC\Users\Model\Table\UsersTable as CakeDcUsersTable;

/**
 * Users Model
 *
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\BelongsTo $Corps
 * @property \App\Model\Table\CaCallGroupNotesTable&\Cake\ORM\Association\HasMany $CaCallGroupNotes
 * @property \App\Model\Table\CaCallsTable&\Cake\ORM\Association\HasMany $CaCalls
 * @property \App\Model\Table\ContentTable&\Cake\ORM\Association\HasMany $Content
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\HasMany $Corps
 * @property \App\Model\Table\CrmSearchesTable&\Cake\ORM\Association\HasMany $CrmSearches
 * @property \App\Model\Table\DraftsTable&\Cake\ORM\Association\HasMany $Drafts
 * @property \App\Model\Table\IcingVersionsTable&\Cake\ORM\Association\HasMany $IcingVersions
 * @property \App\Model\Table\LocationNotesTable&\Cake\ORM\Association\HasMany $LocationNotes
 * @property \App\Model\Table\PagesTable&\Cake\ORM\Association\HasMany $Pages
 * @property \App\Model\Table\QueueTaskLogsTable&\Cake\ORM\Association\HasMany $QueueTaskLogs
 * @property \App\Model\Table\QueueTasksTable&\Cake\ORM\Association\HasMany $QueueTasks
 * @property \App\Model\Table\WikisTable&\Cake\ORM\Association\HasMany $Wikis
 * @property \App\Model\Table\ContentTable&\Cake\ORM\Association\BelongsToMany $Content
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\BelongsToMany $Corps
 * @property \App\Model\Table\WikisTable&\Cake\ORM\Association\BelongsToMany $Wikis
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends CakeDcUsersTable
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Corps', [
            'foreignKey' => 'corp_id',
        ]);
        $this->hasMany('CaCallGroupNotes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CaCalls', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Content', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Corps', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CrmSearches', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Drafts', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('IcingVersions', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('LocationNotes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Pages', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('QueueTaskLogs', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('QueueTasks', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Wikis', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Content', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'content_id',
            'joinTable' => 'content_users',
        ]);
        $this->belongsToMany('Corps', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'corp_id',
            'joinTable' => 'corps_users',
        ]);
        $this->belongsToMany('Wikis', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'wiki_id',
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
            ->scalar('username')
            ->maxLength('username', 128)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 128)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->integer('level')
            ->notEmptyString('level');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 128)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('middle_name')
            ->maxLength('middle_name', 128)
            ->allowEmptyString('middle_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 128)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('degrees')
            ->maxLength('degrees', 128)
            ->allowEmptyString('degrees');

        $validator
            ->scalar('credentials')
            ->maxLength('credentials', 128)
            ->allowEmptyString('credentials');

        $validator
            ->scalar('title_dept_company')
            ->allowEmptyString('title_dept_company');

        $validator
            ->scalar('company')
            ->maxLength('company', 128)
            ->allowEmptyString('company');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 32)
            ->allowEmptyString('phone');

        $validator
            ->scalar('address')
            ->maxLength('address', 128)
            ->allowEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 128)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 128)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 128)
            ->allowEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 32)
            ->allowEmptyString('zip');

        $validator
            ->scalar('country')
            ->maxLength('country', 2)
            ->allowEmptyString('country');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('bio')
            ->allowEmptyString('bio');

        $validator
            ->scalar('image_url')
            ->maxLength('image_url', 128)
            ->allowEmptyFile('image_url');

        $validator
            ->scalar('thumb_url')
            ->maxLength('thumb_url', 128)
            ->allowEmptyString('thumb_url');

        $validator
            ->scalar('square_url')
            ->maxLength('square_url', 128)
            ->allowEmptyString('square_url');

        $validator
            ->scalar('micro_url')
            ->maxLength('micro_url', 128)
            ->allowEmptyString('micro_url');

        $validator
            ->integer('modified_by')
            ->notEmptyString('modified_by');

        $validator
            ->dateTime('lastlogin')
            ->allowEmptyDateTime('lastlogin');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->boolean('is_hardened_password')
            ->notEmptyString('is_hardened_password');

        $validator
            ->boolean('is_admin')
            ->notEmptyString('is_admin');

        $validator
            ->boolean('is_it_admin')
            ->notEmptyString('is_it_admin');

        $validator
            ->boolean('is_agent')
            ->notEmptyString('is_agent');

        $validator
            ->boolean('is_call_supervisor')
            ->notEmptyString('is_call_supervisor');

        $validator
            ->boolean('is_author')
            ->notEmptyString('is_author');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        $validator
            ->boolean('is_csa')
            ->notEmptyString('is_csa');

        $validator
            ->boolean('is_writer')
            ->notEmptyString('is_writer');

        $validator
            ->scalar('recovery_email')
            ->maxLength('recovery_email', 100)
            ->allowEmptyString('recovery_email');

        $validator
            ->scalar('clinic_password')
            ->maxLength('clinic_password', 10)
            ->allowEmptyString('clinic_password');

        $validator
            ->integer('timezone_offset')
            ->notEmptyString('timezone_offset');

        $validator
            ->scalar('timezone')
            ->maxLength('timezone', 3)
            ->allowEmptyString('timezone');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('corp_id', 'Corps'), ['errorField' => 'corp_id']);

        return $rules;
    }
}
