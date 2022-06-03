<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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

        $this->addBehavior('Timestamp');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CaCallGroupNotes', [
            'foreignKey' => 'ca_call_group_id',
        ]);
        $this->hasMany('CaCalls', [
            'foreignKey' => 'ca_call_group_id',
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
            ->requirePresence('id_locked_by_user', 'create')
            ->notEmptyString('id_locked_by_user');

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
            ->requirePresence('traffic_medium', 'create')
            ->notEmptyString('traffic_medium');

        $validator
            ->boolean('is_appt_request_form')
            ->notEmptyString('is_appt_request_form');

        $validator
            ->boolean('is_spam')
            ->notEmptyString('is_spam');

        $validator
            ->scalar('id_xml_file')
            ->maxLength('id_xml_file', 30)
            ->requirePresence('id_xml_file', 'create')
            ->notEmptyFile('id_xml_file');

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
}
