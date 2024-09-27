<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\User;
use Cake\Routing\Router;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;

/**
 * CaCallGroupNotes Model
 *
 * @property \App\Model\Table\CaCallGroupsTable&\Cake\ORM\Association\BelongsTo $CaCallGroups
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CaCallGroupNote newEmptyEntity()
 * @method \App\Model\Entity\CaCallGroupNote newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroupNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroupNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroupNote[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroupNote|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCallGroupNote[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CaCallGroupNotesTable extends Table
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

        $this->setTable('ca_call_group_notes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CaCallGroups', [
            'foreignKey' => 'ca_call_group_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('body')
            ->allowEmptyString('body');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn('ca_call_group_id', 'CaCallGroups'), ['errorField' => 'ca_call_group_id']);
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    /**
    * Add an automated note for the selected call group and currently logged in user
    * @param int caCallGroupId
    * @param string noteBody
    * @param int status
    * @return void
    */
    public function add($caCallGroupId, $noteBody, $status=null) {
        if (!isset($status)) {
            // Get status from the call group
            $caCallGroup = $this->CaCallGroups->get($caCallGroupId);
            $status = $caCallGroup->status;
        }

        $userId = Router::getRequest()->getAttribute('identity')->id;
        $userId = empty($userId) ? User::USER_ID_AUTOMATED_USER : $userId;

        $caCallGroupNote = $this->newEntity([
            'ca_call_group_id' => $caCallGroupId,
            'body' => $noteBody,
            'status' => $status,
            'user_id' => $userId,
        ]);
        $this->save($caCallGroupNote);
    }

    /**
    * Add an automated note for call group status change
    * @param int caCallGroupId
    * @return void
    */
    public function addStatusChangeNote($caCallGroupId, $oldStatus, $newStatus) {
        if (!empty($oldStatus)) {
            $noteBody = 'Status changed from \''.CaCallGroup::$statuses[$oldStatus].'\' to \''.CaCallGroup::$statuses[$newStatus].'\'.';
        } else {
            $noteBody = 'Status is \''.CaCallGroup::$statuses[$newStatus].'\'.';
        }
        $this->add($caCallGroupId, $noteBody, $newStatus);
    }

    /**
    * beforeSave
    */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
        // If we don't have a user_id, save it using session identity
        if (!isset($entity->user_id)) {
            $userId = Router::getRequest()->getAttribute('identity')->id;
            $entity->user_id = empty($userId) ? User::USER_ID_AUTOMATED_USER : $userId;
        }
        // If we don't have a status, get it from the call group
        if (!isset($entity->status) && isset($entity->ca_call_group_id)) {
            $caCallGroup = $this->CaCallGroups->get($entity->ca_call_group_id);
            $entity->status = $caCallGroup->status;
        }
        return true;
    }
}
