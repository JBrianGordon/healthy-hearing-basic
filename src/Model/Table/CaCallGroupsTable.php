<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\CaCallGroup;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;

/**
 * CaCallGroups Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\CaCallGroupNotesTable&\Cake\ORM\Association\HasMany $CaCallGroupNotes
 * @property \App\Model\Table\CaCallsTable&\Cake\ORM\Association\HasMany $CaCalls
 *
 * @method \App\Model\Entity\CaCallGroup newEmptyEntity()
 * @method \App\Model\Entity\CaCallGroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\CaCallGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CaCallGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CaCallGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaCallGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CaCallGroupsTable extends Table
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

        $this->setTable('ca_call_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors(['Timestamp', 'Search.Search']);

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('CaCallGroupNotes', [
            'foreignKey' => 'ca_call_group_id',
        ]);
        $this->hasMany('CaCalls', [
            'foreignKey' => 'ca_call_group_id',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('location_id')
            ->value('caller_phone')
            ->like('caller_first_name')
            ->like('caller_last_name')
            ->boolean('is_patient')
            ->like('patient_first_name')
            ->like('patient_last_name')
            ->boolean('refused_name')
            ->value('email')
            ->boolean('wants_hearing_test')
            ->value('prospect')
            ->boolean('is_prospect_override')
            ->like('front_desk_name')
            ->value('score', ['multiValue' => true])
            ->value('status', ['multiValue' => true])
            ->boolean('is_bringing_third_party')
            ->boolean('is_review_needed')
            ->value('ca_call_count')
            ->value('clinic_followup_count')
            ->value('patient_followup_count')
            ->value('clinic_outbound_count')
            ->value('patient_outbound_count')
            ->value('vm_outbound_count')
            ->boolean('is_locked')
            ->value('question_visit_clinic')
            ->value('question_what_for')
            ->value('question_purchase')
            ->value('question_brand')
            ->value('question_brand_other')
            ->boolean('did_they_want_help')
            ->value('traffic_source')
            ->value('traffic_medium')
            ->boolean('is_appt_request_form')
            ->boolean('is_spam')
            // appt_date
            ->add('appt_date_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["appt_date >=" => $args['appt_date_start']]);
                }
            ])
            ->add('appt_date_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["appt_date <=" => $args['appt_date_end']]);
                }
            ])
            // scheduled_call_date
            ->add('scheduled_call_date_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["scheduled_call_date >=" => $args['scheduled_call_date_start']]);
                }
            ])
            ->add('scheduled_call_date_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["scheduled_call_date <=" => $args['scheduled_call_date_end']]);
                }
            ])
            // final_score_date
            ->add('final_score_date_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["final_score_date >=" => $args['final_score_date_start']]);
                }
            ])
            ->add('final_score_date_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["final_score_date <=" => $args['final_score_date_end']]);
                }
            ])
            // created
            ->add('created_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["CaCallGroups.created >=" => $args['created_start']]);
                }
            ])
            ->add('created_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["CaCallGroups.created <=" => $args['created_end']]);
                }
            ])
            // modified
            ->add('modified_start', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["CaCallGroups.modified >=" => $args['modified_start']]);
                }
            ])
            ->add('modified_end', 'Search.Callback', [
                'callback' => function (\Cake\ORM\Query $query, array $args, \Search\Model\Filter\Base $filter) {
                    $query->andWhere(["CaCallGroups.modified <=" => $args['modified_end']]);
                }
            ]);
        $topics = array_merge(array_keys(CaCallGroup::$col1Topics), array_keys(CaCallGroup::$col2Topics));
        foreach ($topics as $topic) {
            $this->searchManager()->boolean($topic);
        }
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
            ->scalar('caller_phone')
            ->maxLength('caller_phone', 20)
            ->allowEmptyString('caller_phone');

        $validator
            ->scalar('caller_first_name')
            ->maxLength('caller_first_name', 255)
            ->allowEmptyString('caller_first_name');

        $validator
            ->scalar('caller_last_name')
            ->maxLength('caller_last_name', 255)
            ->allowEmptyString('caller_last_name');

        $validator
            ->boolean('is_patient')
            ->notEmptyString('is_patient');

        $validator
            ->scalar('patient_first_name')
            ->maxLength('patient_first_name', 255)
            ->allowEmptyString('patient_first_name');

        $validator
            ->scalar('patient_last_name')
            ->maxLength('patient_last_name', 255)
            ->allowEmptyString('patient_last_name');

        $validator
            ->boolean('refused_name')
            ->notEmptyString('refused_name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->boolean('topic_wants_appt')
            ->notEmptyString('topic_wants_appt');

        $validator
            ->boolean('topic_clinic_hours')
            ->notEmptyString('topic_clinic_hours');

        $validator
            ->boolean('topic_insurance')
            ->notEmptyString('topic_insurance');

        $validator
            ->boolean('topic_clinic_inquiry')
            ->notEmptyString('topic_clinic_inquiry');

        $validator
            ->boolean('topic_aid_lost_old')
            ->notEmptyString('topic_aid_lost_old');

        $validator
            ->boolean('topic_aid_lost_new')
            ->notEmptyString('topic_aid_lost_new');

        $validator
            ->boolean('topic_warranty_old')
            ->notEmptyString('topic_warranty_old');

        $validator
            ->boolean('topic_warranty_new')
            ->notEmptyString('topic_warranty_new');

        $validator
            ->boolean('topic_batteries')
            ->notEmptyString('topic_batteries');

        $validator
            ->boolean('topic_parts')
            ->notEmptyString('topic_parts');

        $validator
            ->boolean('topic_cancel_appt')
            ->notEmptyString('topic_cancel_appt');

        $validator
            ->boolean('topic_reschedule_appt')
            ->notEmptyString('topic_reschedule_appt');

        $validator
            ->boolean('topic_appt_followup')
            ->notEmptyString('topic_appt_followup');

        $validator
            ->boolean('topic_medical_records')
            ->notEmptyString('topic_medical_records');

        $validator
            ->boolean('topic_tinnitus')
            ->notEmptyString('topic_tinnitus');

        $validator
            ->boolean('topic_medical_inquiry')
            ->notEmptyString('topic_medical_inquiry');

        $validator
            ->boolean('topic_solicitor')
            ->notEmptyString('topic_solicitor');

        $validator
            ->boolean('topic_personal_call')
            ->notEmptyString('topic_personal_call');

        $validator
            ->boolean('topic_request_fax')
            ->notEmptyString('topic_request_fax');

        $validator
            ->boolean('topic_request_name')
            ->notEmptyString('topic_request_name');

        $validator
            ->boolean('topic_remove_from_list')
            ->notEmptyString('topic_remove_from_list');

        $validator
            ->boolean('topic_foreign_language')
            ->notEmptyString('topic_foreign_language');

        $validator
            ->boolean('topic_other')
            ->notEmptyString('topic_other');

        $validator
            ->boolean('topic_declined')
            ->notEmptyString('topic_declined');

        $validator
            ->boolean('wants_hearing_test')
            ->notEmptyString('wants_hearing_test');

        $validator
            ->scalar('prospect')
            ->maxLength('prospect', 255)
            ->allowEmptyString('prospect');

        $validator
            ->boolean('is_prospect_override')
            ->notEmptyString('is_prospect_override');

        $validator
            ->scalar('front_desk_name')
            ->maxLength('front_desk_name', 255)
            ->allowEmptyString('front_desk_name');

        $validator
            ->scalar('score')
            ->maxLength('score', 255)
            ->allowEmptyString('score');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmptyString('status');

        $validator
            ->dateTime('appt_date')
            ->allowEmptyDateTime('appt_date');

        $validator
            ->dateTime('scheduled_call_date')
            ->allowEmptyDateTime('scheduled_call_date');

        $validator
            ->dateTime('final_score_date')
            ->allowEmptyDateTime('final_score_date');

        $validator
            ->boolean('is_bringing_third_party')
            ->notEmptyString('is_bringing_third_party');

        $validator
            ->boolean('is_review_needed')
            ->notEmptyString('is_review_needed');

        $validator
            ->integer('ca_call_count')
            ->notEmptyString('ca_call_count');

        $validator
            ->integer('clinic_followup_count')
            ->notEmptyString('clinic_followup_count');

        $validator
            ->integer('patient_followup_count')
            ->notEmptyString('patient_followup_count');

        $validator
            ->integer('clinic_outbound_count')
            ->notEmptyString('clinic_outbound_count');

        $validator
            ->integer('patient_outbound_count')
            ->notEmptyString('patient_outbound_count');

        $validator
            ->integer('vm_outbound_count')
            ->notEmptyString('vm_outbound_count');

        $validator
            ->boolean('is_locked')
            ->notEmptyString('is_locked');

        $validator
            ->dateTime('lock_time')
            ->allowEmptyDateTime('lock_time');

        $validator
            ->integer('id_locked_by_user')
            ->allowEmptyString('id_locked_by_user');

        $validator
            ->numeric('outbound_priority')
            ->allowEmptyString('outbound_priority');

        $validator
            ->scalar('question_visit_clinic')
            ->maxLength('question_visit_clinic', 255)
            ->allowEmptyString('question_visit_clinic');

        $validator
            ->scalar('question_what_for')
            ->maxLength('question_what_for', 255)
            ->allowEmptyString('question_what_for');

        $validator
            ->scalar('question_purchase')
            ->maxLength('question_purchase', 255)
            ->allowEmptyString('question_purchase');

        $validator
            ->scalar('question_brand')
            ->maxLength('question_brand', 255)
            ->allowEmptyString('question_brand');

        $validator
            ->scalar('question_brand_other')
            ->maxLength('question_brand_other', 255)
            ->allowEmptyString('question_brand_other');

        $validator
            ->boolean('did_they_want_help')
            ->notEmptyString('did_they_want_help');

        $validator
            ->scalar('traffic_source')
            ->allowEmptyString('traffic_source');

        $validator
            ->scalar('traffic_medium')
            ->maxLength('traffic_medium', 50)
            ->allowEmptyString('traffic_medium');

        $validator
            ->boolean('is_appt_request_form')
            ->notEmptyString('is_appt_request_form');

        $validator
            ->boolean('is_spam')
            ->notEmptyString('is_spam');

        $validator
            ->scalar('id_xml_file')
            ->maxLength('id_xml_file', 30)
            ->allowEmptyString('id_xml_file');

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
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            if (empty($entity->id_locked_by_user)) {
                $entity->id_locked_by_user = 0;
            }
            if (empty($entity->id_xml_file)) {
                $entity->id_xml_file = '';
            }
            if (empty($entity->traffic_medium)) {
                $entity->traffic_medium = '';
            }
        }
        return true;
    }

    /**
    * Get the 10 most recent calls for the specified location id. Or the 10 most recent calls (all locations) if no id specified.
    * @param location id - leave empty to find calls for all locations
    * @param followupOnly - true to only find 'followup to set appt' calls
    * @return array of previous calls
    */
    function getPreviousCalls($locationId = null, $followupOnly = false) {
        $previousCalls = [];
        $conditions = [];
        if (!empty($locationId)) {
            // Find calls for this clinic only
            $conditions['location_id'] = $locationId;
        }
        $now = getDateTime('now', 'GMT', 'Y-m-d H:i:s');
        if ($followupOnly) {
            // Find followup calls only
            $conditions['OR'] = [
                [
                    'status IN' => [CaCallGroup::STATUS_FOLLOWUP_SET_APPT, CaCallGroup::STATUS_TENTATIVE_APPT, /*CaCallGroup::STATUS_OUTBOUND_CLINIC_ATTEMPTED*/]
                ],
                /* HIDE SURVEY CALLS #15351
                [
                    // Survey calls
                    'status' => [CaCallGroup::STATUS_APPT_SET],
                    'appt_date <=' => $now,
                ],*/
            ];
        } else {
            // Find all calls that are not 'complete'
            $conditions['OR'] = [
                [
                    'final_score_date <' => '2000-01-01'
                ],
                [
                    'status IN' => [CaCallGroup::STATUS_INCOMPLETE],
                ],
            ];
        }
        // Find 10 most recent calls
        $callGroups = $this->find('all', [
            'contain' => [],
            'conditions' => $conditions,
            'order' => 'created DESC',
            'limit' => 10,
        ])->all();
        foreach ($callGroups as $callGroup) {
            $callDescription = $callGroup->created->format("n/d/y g:i A");
            if (!empty($callGroup->caller_first_name) || !empty($callGroup->caller_last_name)) {
                $callDescription .= " - ".$callGroup->caller_first_name." ".$callGroup->caller_last_name;
            }
            if (!empty($callGroup->patient_first_name) || !empty($callGroup->patient_last_name)) {
                $callDescription .= " calling for ".$callGroup->patient_first_name." ".$callGroup->patient_last_name;
            }
            $status = empty($callGroup->status) ? "Incomplete" : CaCallGroup::$statuses[$callGroup->status];
            $callDescription .= " (".$status.")";
            $previousCalls[$callGroup->id] = $callDescription;
        }
        return $previousCalls;
    }
}
