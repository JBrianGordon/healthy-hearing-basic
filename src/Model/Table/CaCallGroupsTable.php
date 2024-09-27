<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\CaCall;
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
            ->value('vm_outbound_count')
            ->boolean('is_locked')
            ->boolean('did_they_want_help')
            ->value('traffic_source')
            ->value('traffic_medium')
            ->boolean('is_appt_request_form')
            ->boolean('is_spam')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['Locations.title', 'caller_first_name', 'caller_last_name', 'patient_first_name', 'patient_last_name'],
            ])
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
            ->notEmptyString('caller_first_name');

        $validator
            ->scalar('caller_last_name')
            ->maxLength('caller_last_name', 255)
            ->notEmptyString('caller_last_name');

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
        // TODO: We want to allow location_id = 0 also
        //$rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id', 'allowNullableNulls' => true]);

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
        if (!$entity->isNew() && !empty($entity->topic_cancel_appt) && empty($entity->topic_wants_appt)) {
            if (!empty($entity->getOriginal('topic_wants_appt'))) {
                // Patient called to cancel an existing appt
                // Leave as prospect/wants appt/appt set
                $entity->prospect = CaCallGroup::PROSPECT_YES;
                $entity->topic_wants_appt = true;
                $entity->status = CaCallGroup::STATUS_APPT_SET;
            }
        }
        if ($entity->isDirty('prospect')) {
            // Prospect value has changed
            if (in_array($entity->prospect, [CaCallGroup::PROSPECT_NO, CaCallGroup::PROSPECT_DISCONNECTED])) {
                $entity->final_score_date = gmdate('Y-m-d H:i:s');
            }
        }
        if ($entity->isDirty('score')) {
            // Score value has changed
            if (in_array($entity->score, [CaCallGroup::SCORE_DISCONNECTED, CaCallGroup::SCORE_MISSED_OPPORTUNITY, CaCallGroup::SCORE_APPT_SET, CaCallGroup::SCORE_APPT_SET_DIRECT])) {
                $entity->final_score_date = gmdate('Y-m-d H:i:s');
            } elseif (in_array($entity->score, [CaCallGroup::SCORE_TENTATIVE_APPT, CaCallGroup::SCORE_NOT_REACHED])) {
                $entity->final_score_date = null;
            }
        }
        if (isset($entity->status)) {
            $priority = null;
            switch ($entity->status) {
                case CaCallGroup::STATUS_VM_NEEDS_CALLBACK:
                case CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED:
                case CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER:
                    $priority = 1;
                    break;
                case CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM:
                case CaCallGroup::STATUS_FOLLOWUP_SET_APPT:
                case CaCallGroup::STATUS_TENTATIVE_APPT: // should be 2.5?
                    $priority = 2;
                    break;
                case CaCallGroup::STATUS_APPT_SET:
                    if (isset($entity->score)) {
                        $score = $entity->score;
                    } else {
                        $score = $entity->getOriginal('score');
                    }
                    if ($score == CaCallGroup::SCORE_APPT_SET_DIRECT) {
                        $priority = 3.5;
                    } else {
                        $priority = 3.0;
                    }
                    break;
            }
            $entity->outbound_priority = $priority;
            if ($entity->isDirty('status')) {
                // Status has changed
                if (in_array($entity->status, [CaCallGroup::STATUS_WRONG_NUMBER, CaCallGroup::STATUS_INCOMPLETE])) {
                    $entity->final_score_date = gmdate('Y-m-d H:i:s');
                }
            }
        }
        // Save scheduled call date and appt date in UTC/GMT
        if (isset($entity->scheduled_call_date)) {
            // Scheduled call date/time is currently in eastern timezone. Save in UTC/GMT.
            // TODO: I think this is already formatted as UTC so this can be removed. Need to test and verify.
            //$entity->scheduled_call_date = $entity->scheduled_call_date->i18nFormat('yyyy-MMM-dd HH:mm:ss', 'UTC');
        }
        if (isset($entity->appt_date)) {
            // Appointment date/time is currently in clinic's timezone. Save in UTC/GMT.
            if (!empty($entity->location_id)) {
                $clinicTimezoneOffset = $this->Location->getClinicTimezoneOffset($entity->location_id);
            } else {
                $clinicTimezoneOffset = getEasternTimezoneOffset();
            }
            $utc_date = strtotime($entity->appt_date.'+'.$clinicTimezoneOffset.'hours');
            $entity->appt_date = date('Y-m-d H:i:s', $utc_date);
        }
        if (isset($entity->is_patient) && ($entity->is_patient == 1)) {
            $entity->patient_first_name = '';
            $entity->patient_last_name = '';
        }

        return true;
    }

    /**
     * afterSave() for CaCallGroupsTable
     *
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     *
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isDirty('status')) {
            $location = empty($entity->location) ? $this->Locations->get($entity->location_id) : $entity->location;
            // Status has changed. Save an automated note.
            $this->CaCallGroupNotes->addStatusChangeNote($entity->id, $entity->getOriginal('status'), $entity->status);
            // If status changed to Followup No Answer, send an automated email
            if ($entity->status == CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER) {
                $url = router::url('/admin/ca_call_groups/view/'.$this->id, true);
                $this->sendEmail(
                    Configure::read('ca-supervisor-email'), //to
                    Configure::read('email'), //from
                    'ca_clinic_no_answer', //template
                    'Location did not answer followup call attempts', //subject
                    [
                        'locationId' => $entity->location_id,
                        'locationTitle' => $location->title,
                        'caCallGroupId' => $entity->id,
                        'url' => $url
                    ]
                );
            }

            // If status changed to New, send an automated email to Becky to investigate
            if ($entity->status == CaCallGroup::STATUS_NEW) {
                $message = 'Becky,<br>'.
                    '<strong>Please investigate.</strong> CA Call Group '.$entity->id.
                    ' was saved with "New" status.<br>'.
                    '<pre>'.json_encode($entity, JSON_PRETTY_PRINT).'</pre>';
                $this->sendEmail(
                    'blemons@healthyhearing.com', //to
                    Configure::read('email'), //from
                    'generic', //template
                    "'New' status found in call group", //subject
                    [
                        'message' => $message,
                    ]
                );
            }
        }
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
                    'status IN' => [CaCallGroup::STATUS_FOLLOWUP_SET_APPT, CaCallGroup::STATUS_TENTATIVE_APPT]
                ],
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

    /**
    * Lock the record to the current user
    */
    function lock($id = null, $userId = null) {
        $caCallGroup = $this->get($id);
        if ($this->isLocked($id, $userId)) {
            return false;
        }
        $caCallGroup->is_locked = true;
        $caCallGroup->id_locked_by_user = $userId;
        $caCallGroup->lock_time = str2datetime();
        if ($this->save($caCallGroup)) {
            return true;
        }
        return false;
    }

    /**
    * Is this Call Group locked by someone other than the current user
    */
    function isLocked($id = null, $userId = null) {
        $caCallGroup = $this->get($id);
        if ($caCallGroup->is_locked && ($caCallGroup->id_locked_by_user != $userId)) {
            return true;
        }
        return false;
    }

    /**
    * Unlock the record
    */
    function unlock($id = null) {
        $caCallGroup = $this->get($id);
        $caCallGroup->is_locked = false;
        $caCallGroup->id_locked_by_user = 0;
        $caCallGroup->lock_time = null;
        if ($this->save($caCallGroup)) {
            return true;
        }
        return false;
    }

    /**
    * Find the admin report based on data passed in
    *
    * @param string start date
    * @param string end date
    * @return array of results formatted for easy viewing.
    */
    public function getAdminReport($startDate, $endDate) {
        // Set selected start & end date, and dates for averaged data
        $startDate      = str2datetime($startDate);
        $endDate        = str2datetime($endDate . " 23:59:59");
        $initialCallDates = [
            'CaCallGroups.created >=' => $startDate,
            'CaCallGroups.created <=' => $endDate,
        ];
        $finalScoreDates = [
            'CaCallGroups.final_score_date >=' => $startDate,
            'CaCallGroups.final_score_date <=' => $endDate,
        ];

        // Inbound Calls and VMs
        $reportData['all_inbound_calls']['column_label'][0] = 'Created in selected dates';
        $reportData['all_inbound_calls']['column_label'][1] = 'Finalized in selected dates';
        $reportData['all_inbound_calls']['total']['init_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type IN' => [CaCall::CALL_TYPE_INBOUND, CaCall::CALL_TYPE_INBOUND_VM, CaCall::CALL_TYPE_APPT_REQUEST_FORM, CaCall::CALL_TYPE_ONLINE_BOOK]
            ], $initialCallDates),
        ])->count();
        $reportData['all_inbound_calls']['total']['final_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type IN' => [CaCall::CALL_TYPE_INBOUND, CaCall::CALL_TYPE_INBOUND_VM, CaCall::CALL_TYPE_APPT_REQUEST_FORM, CaCall::CALL_TYPE_ONLINE_BOOK]
            ], $finalScoreDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_calls']['init_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_INBOUND
            ], $initialCallDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_calls']['final_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_INBOUND
            ], $finalScoreDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_calls']['init_percent'] = divide($reportData['all_inbound_calls']['inbound_calls']['init_total'], $reportData['all_inbound_calls']['total']['init_total']);
        $reportData['all_inbound_calls']['inbound_calls']['final_percent'] = divide($reportData['all_inbound_calls']['inbound_calls']['final_total'], $reportData['all_inbound_calls']['total']['final_total']);
        $reportData['all_inbound_calls']['inbound_voicemails']['init_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_INBOUND_VM
            ], $initialCallDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_voicemails']['final_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_INBOUND_VM
            ], $finalScoreDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_voicemails']['init_percent'] = divide($reportData['all_inbound_calls']['inbound_voicemails']['init_total'], $reportData['all_inbound_calls']['total']['init_total']);
        $reportData['all_inbound_calls']['inbound_voicemails']['final_percent'] = divide($reportData['all_inbound_calls']['inbound_voicemails']['init_total'], $reportData['all_inbound_calls']['total']['init_total']);
        $reportData['all_inbound_calls']['inbound_forms']['init_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_APPT_REQUEST_FORM
            ], $initialCallDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_forms']['final_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_APPT_REQUEST_FORM
            ], $finalScoreDates),
        ])->count();
        $reportData['all_inbound_calls']['inbound_forms']['init_percent'] = divide($reportData['all_inbound_calls']['inbound_forms']['init_total'], $reportData['all_inbound_calls']['total']['init_total']);
        $reportData['all_inbound_calls']['inbound_forms']['final_percent'] = divide($reportData['all_inbound_calls']['inbound_forms']['final_total'], $reportData['all_inbound_calls']['total']['final_total']);
        $reportData['all_inbound_calls']['direct_book_online']['init_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_ONLINE_BOOK
            ], $initialCallDates),
        ])->count();
        $reportData['all_inbound_calls']['direct_book_online']['final_total'] = $this->CaCalls->find('all', [
            'contain' => ['CaCallGroups'],
            'conditions' => array_merge([
                'CaCalls.call_type' => CaCall::CALL_TYPE_ONLINE_BOOK
            ], $finalScoreDates),
        ])->count();
        $reportData['all_inbound_calls']['direct_book_online']['init_percent'] = divide($reportData['all_inbound_calls']['direct_book_online']['init_total'], $reportData['all_inbound_calls']['total']['init_total']);
        $reportData['all_inbound_calls']['direct_book_online']['final_percent'] = divide($reportData['all_inbound_calls']['direct_book_online']['final_total'], $reportData['all_inbound_calls']['total']['final_total']);

        // Call Groups
        $reportData['call_groups']['total']['init_total'] = $this->find('all', [
            'conditions' => $initialCallDates,
        ])->count();
        $reportData['call_groups']['total']['final_total'] = $this->find('all', [
            'conditions' => $finalScoreDates,
        ])->count();
        $reportData['call_groups']['prospects_other']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'OR' => [
                    'CaCallGroups.prospect IS NULL',
                    'CaCallGroups.prospect IN' => [CaCallGroup::PROSPECT_DISCONNECTED, CaCallGroup::PROSPECT_UNKNOWN]
                ]
            ], $initialCallDates),
        ])->count();
        $reportData['call_groups']['prospects_other']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'OR' => [
                    'CaCallGroups.prospect IS NULL',
                    'CaCallGroups.prospect IN' => [CaCallGroup::PROSPECT_DISCONNECTED, CaCallGroup::PROSPECT_UNKNOWN]
                ]
            ], $finalScoreDates),
        ])->count();
        $reportData['call_groups']['prospects_other']['init_percent'] = divide($reportData['call_groups']['prospects_other']['init_total'], $reportData['call_groups']['total']['init_total']);
        $reportData['call_groups']['prospects_other']['final_percent'] = divide($reportData['call_groups']['prospects_other']['final_total'], $reportData['call_groups']['total']['final_total']);
        $reportData['call_groups']['adjusted_total']['init_total'] = 0;
        $reportData['call_groups']['adjusted_total']['final_total'] = 0;
        $reportData['call_groups']['non_prospects']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.prospect' => CaCallGroup::PROSPECT_NO,
            ], $initialCallDates),
        ])->count();
        $reportData['call_groups']['non_prospects']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.prospect' => CaCallGroup::PROSPECT_NO,
            ], $finalScoreDates),
        ])->count();
        $prospectInitConditions = array_merge([
            'CaCallGroups.prospect' => CaCallGroup::PROSPECT_YES,
        ], $initialCallDates);
        $prospectFinalConditions = array_merge([
            'CaCallGroups.prospect' => CaCallGroup::PROSPECT_YES,
        ], $finalScoreDates);
        $reportData['call_groups']['prospects']['init_total'] = $this->find('all', [
            'conditions' => $prospectInitConditions,
        ])->count();
        $reportData['call_groups']['prospects']['final_total'] = $this->find('all', [
            'conditions' => $prospectFinalConditions,
        ])->count();
        $reportData['call_groups']['adjusted_total']['init_total'] = $reportData['call_groups']['non_prospects']['init_total'] + $reportData['call_groups']['prospects']['init_total'];
        $reportData['call_groups']['adjusted_total']['final_total'] = $reportData['call_groups']['non_prospects']['final_total'] + $reportData['call_groups']['prospects']['final_total'];
        $reportData['call_groups']['non_prospects']['init_percent'] = divide($reportData['call_groups']['non_prospects']['init_total'], $reportData['call_groups']['adjusted_total']['init_total']);
        $reportData['call_groups']['non_prospects']['final_percent'] = divide($reportData['call_groups']['non_prospects']['final_total'], $reportData['call_groups']['adjusted_total']['final_total']);
        $reportData['call_groups']['prospects']['init_percent'] = divide($reportData['call_groups']['prospects']['init_total'], $reportData['call_groups']['adjusted_total']['init_total']);
        $reportData['call_groups']['prospects']['final_percent'] = divide($reportData['call_groups']['prospects']['final_total'], $reportData['call_groups']['adjusted_total']['final_total']);

        // Prospects
        $reportData['prospects']['total']['init_total'] = $reportData['call_groups']['prospects']['init_total'];
        $reportData['prospects']['total']['final_total'] = $reportData['call_groups']['prospects']['final_total'];
        $reportData['prospects']['disconnected']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score IN' => [CaCallGroup::SCORE_DISCONNECTED, '']
            ], $prospectInitConditions),
        ])->count();
        $reportData['prospects']['disconnected']['init_percent'] = divide($reportData['prospects']['disconnected']['init_total'], $reportData['prospects']['total']['init_total']);
        $reportData['prospects']['disconnected']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score IN' => [CaCallGroup::SCORE_DISCONNECTED, '']
            ], $prospectFinalConditions),
        ])->count();
        $reportData['prospects']['disconnected']['final_percent'] = divide($reportData['prospects']['disconnected']['final_total'], $reportData['prospects']['total']['final_total']);
        $reportData['prospects']['clinic_not_reached']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_NOT_REACHED,
            ], $prospectInitConditions),
        ])->count();
        $reportData['prospects']['clinic_not_reached']['init_percent'] = divide($reportData['prospects']['clinic_not_reached']['init_total'], $reportData['prospects']['total']['init_total']);
        $reportData['prospects']['clinic_not_reached']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_NOT_REACHED,
            ], $prospectFinalConditions),
        ])->count();
        $reportData['prospects']['clinic_not_reached']['final_percent'] = divide($reportData['prospects']['clinic_not_reached']['final_total'], $reportData['prospects']['total']['final_total']);
        $reportData['prospects']['missed_opportunities']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_MISSED_OPPORTUNITY,
            ], $prospectInitConditions),
        ])->count();
        $reportData['prospects']['missed_opportunities']['init_percent'] = divide($reportData['prospects']['missed_opportunities']['init_total'], $reportData['prospects']['total']['init_total']);
        $reportData['prospects']['missed_opportunities']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_MISSED_OPPORTUNITY,
            ], $prospectFinalConditions),
        ])->count();
        $reportData['prospects']['missed_opportunities']['final_percent'] = divide($reportData['prospects']['missed_opportunities']['final_total'], $reportData['prospects']['total']['final_total']);
        $reportData['prospects']['tentative_appointments']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_TENTATIVE_APPT,
            ], $prospectInitConditions),
        ])->count();
        $reportData['prospects']['tentative_appointments']['init_percent'] = divide($reportData['prospects']['tentative_appointments']['init_total'], $reportData['prospects']['total']['init_total']);
        $reportData['prospects']['tentative_appointments']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_TENTATIVE_APPT,
            ], $prospectFinalConditions),
        ])->count();
        $reportData['prospects']['tentative_appointments']['final_percent'] = divide($reportData['prospects']['tentative_appointments']['final_total'], $reportData['prospects']['total']['final_total']);
        $reportData['prospects']['appointments_set']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score IN' => [CaCallGroup::SCORE_APPT_SET, CaCallGroup::SCORE_APPT_SET_DIRECT],
            ], $prospectInitConditions),
        ])->count();
        $reportData['prospects']['appointments_set']['init_percent'] = divide($reportData['prospects']['appointments_set']['init_total'], $reportData['prospects']['total']['init_total']);
        $reportData['prospects']['appointments_set']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score IN' => [CaCallGroup::SCORE_APPT_SET, CaCallGroup::SCORE_APPT_SET_DIRECT],
            ], $prospectFinalConditions),
        ])->count();
        $reportData['prospects']['appointments_set']['final_percent'] = divide($reportData['prospects']['appointments_set']['final_total'], $reportData['prospects']['total']['final_total']);

        // Appointments Set
        $reportData['appointments_set']['total']['init_total'] = $reportData['prospects']['appointments_set']['init_total'];
        $reportData['appointments_set']['total']['final_total'] = $reportData['prospects']['appointments_set']['final_total'];
        $byClinicCallGroupsInit = $this->find('all', [
            'contain' => ['CaCalls'],
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_APPT_SET,
            ], $prospectInitConditions),
            'fields' => ['id', 'score', 'created', 'final_score_date']
        ])->all();
        $byClinicCallGroupsFinal = $this->find('all', [
            'contain' => ['CaCalls'],
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_APPT_SET,
            ], $prospectFinalConditions),
            'fields' => ['id', 'score', 'created', 'final_score_date']
        ])->all();
        $reportData['appointments_set']['by_clinic']['init_total'] = 0;
        $reportData['appointments_set']['by_clinic']['final_total'] = 0;
        $reportData['appointments_set']['by_clinic_form']['init_total'] = 0;
        $reportData['appointments_set']['by_clinic_form']['final_total'] = 0;
        foreach ($byClinicCallGroupsInit as $group) {
            if ($group['ca_calls'][0]['call_type'] == CaCall::CALL_TYPE_APPT_REQUEST_FORM) {
                $reportData['appointments_set']['by_clinic_form']['init_total']++;
            } else { // inbound call or voicemail
                $reportData['appointments_set']['by_clinic']['init_total']++;
            }
        }
        foreach ($byClinicCallGroupsFinal as $group) {
            if ($group['ca_calls'][0]['call_type'] == CaCall::CALL_TYPE_APPT_REQUEST_FORM) {
                $reportData['appointments_set']['by_clinic_form']['final_total']++;
            } else { // inbound call or voicemail
                $reportData['appointments_set']['by_clinic']['final_total']++;
            }
        }
        $reportData['appointments_set']['by_clinic']['init_percent'] = divide($reportData['appointments_set']['by_clinic']['init_total'], $reportData['appointments_set']['total']['init_total']);
        $reportData['appointments_set']['by_clinic']['final_percent'] = divide($reportData['appointments_set']['by_clinic']['final_total'], $reportData['appointments_set']['total']['final_total']);
        $reportData['appointments_set']['by_clinic_form']['init_percent'] = divide($reportData['appointments_set']['by_clinic_form']['init_total'], $reportData['appointments_set']['total']['init_total']);
        $reportData['appointments_set']['by_clinic_form']['final_percent'] = divide($reportData['appointments_set']['by_clinic_form']['final_total'], $reportData['appointments_set']['total']['final_total']);
        $directBookCallGroupsInit = $this->find('all', [
            'contain' => ['CaCalls'],
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_APPT_SET_DIRECT,
            ], $prospectInitConditions),
            'fields' => ['id', 'score', 'created', 'final_score_date']
        ]);
        $directBookCallGroupsFinal = $this->find('all', [
            'contain' => ['CaCalls'],
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_APPT_SET_DIRECT,
            ], $prospectFinalConditions),
            'fields' => ['id', 'score', 'created', 'final_score_date']
        ]);
        $reportData['appointments_set']['by_direct']['init_total'] = 0;
        $reportData['appointments_set']['by_direct']['final_total'] = 0;
        $reportData['appointments_set']['by_direct_form']['init_total'] = 0;
        $reportData['appointments_set']['by_direct_form']['final_total'] = 0;
        $reportData['appointments_set']['by_direct_online']['init_total'] = 0;
        $reportData['appointments_set']['by_direct_online']['final_total'] = 0;
        foreach ($directBookCallGroupsInit as $group) {
            if ($group['ca_calls'][0]['call_type'] == CaCall::CALL_TYPE_APPT_REQUEST_FORM) {
                $reportData['appointments_set']['by_direct_form']['init_total']++;
            } elseif ($group['ca_calls'][0]['call_type'] == CaCall::CALL_TYPE_ONLINE_BOOK) {
                $reportData['appointments_set']['by_direct_online']['init_total']++;
            } else { // inbound call or voicemail
                $reportData['appointments_set']['by_direct']['init_total']++;
            }
        }
        foreach ($directBookCallGroupsFinal as $group) {
            if ($group['ca_calls'][0]['call_type'] == CaCall::CALL_TYPE_APPT_REQUEST_FORM) {
                $reportData['appointments_set']['by_direct_form']['final_total']++;
            } elseif ($group['ca_calls'][0]['call_type'] == CaCall::CALL_TYPE_ONLINE_BOOK) {
                $reportData['appointments_set']['by_direct_online']['final_total']++;
            } else { // inbound call or voicemail
                $reportData['appointments_set']['by_direct']['final_total']++;
            }
        }
        $reportData['appointments_set']['by_direct']['init_percent'] = divide($reportData['appointments_set']['by_direct']['init_total'], $reportData['appointments_set']['total']['init_total']);
        $reportData['appointments_set']['by_direct']['final_percent'] = divide($reportData['appointments_set']['by_direct']['final_total'], $reportData['appointments_set']['total']['final_total']);
        $reportData['appointments_set']['by_direct_form']['init_percent'] = divide($reportData['appointments_set']['by_direct_form']['init_total'], $reportData['appointments_set']['total']['init_total']);
        $reportData['appointments_set']['by_direct_form']['final_percent'] = divide($reportData['appointments_set']['by_direct_form']['final_total'], $reportData['appointments_set']['total']['final_total']);
        $reportData['appointments_set']['by_direct_online']['init_percent'] = divide($reportData['appointments_set']['by_direct_online']['init_total'], $reportData['appointments_set']['total']['init_total']);
        $reportData['appointments_set']['by_direct_online']['final_percent'] = divide($reportData['appointments_set']['by_direct_online']['final_total'], $reportData['appointments_set']['total']['final_total']);

        // Direct Book
        $reportData['direct_book']['total']['init_total'] = $reportData['appointments_set']['by_direct']['init_total'] + $reportData['appointments_set']['by_direct_form']['init_total'] + $reportData['appointments_set']['by_direct_online']['init_total'];
        $reportData['direct_book']['total']['final_total'] = $reportData['appointments_set']['by_direct']['final_total'] + $reportData['appointments_set']['by_direct_form']['final_total'] + $reportData['appointments_set']['by_direct_online']['final_total'];
        $reportData['direct_book']['third_party']['init_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_APPT_SET_DIRECT,
                'CaCallGroups.is_bringing_third_party' => true,
            ], $prospectInitConditions),
        ])->count();
        $reportData['direct_book']['third_party']['final_total'] = $this->find('all', [
            'conditions' => array_merge([
                'CaCallGroups.score' => CaCallGroup::SCORE_APPT_SET_DIRECT,
                'CaCallGroups.is_bringing_third_party' => true,
            ], $prospectFinalConditions),
        ])->count();
        $reportData['direct_book']['third_party']['init_percent'] = divide($reportData['direct_book']['third_party']['init_total'], $reportData['direct_book']['total']['init_total']);
        $reportData['direct_book']['third_party']['final_percent'] = divide($reportData['direct_book']['third_party']['final_total'], $reportData['direct_book']['total']['final_total']);

        // Completed report data
        return $reportData;
    }
}
