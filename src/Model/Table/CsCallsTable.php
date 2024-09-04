<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\CsCall;

/**
 * CsCalls Model
 *
 * @property \App\Model\Table\CallsTable&\Cake\ORM\Association\BelongsTo $Calls
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\CsCall newEmptyEntity()
 * @method \App\Model\Entity\CsCall newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CsCall[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CsCall get($primaryKey, $options = [])
 * @method \App\Model\Entity\CsCall findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CsCall patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CsCall[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CsCall|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CsCall saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CsCallsTable extends Table
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

        $this->setTable('cs_calls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Search.Search');

        $this->belongsTo('Calls', [
            'foreignKey' => 'call_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('call_id')
            ->value('location_id')
            ->like('leadscore')
            ->like('caller_firstname')
            ->like('caller_lastname')
            ->like('prospect')
            ->add('start_time_range', 'Search.Callback', [
                    'callback' => function (Query $query, array $args, \Search\Model\Filter\Callback $filter) {
                    [$start, $end] = explode(',', $args['start_time_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('start_time', $startDate, $endDate, 'date');
                    });
                },
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
            ->scalar('ad_source')
            ->maxLength('ad_source', 255)
            ->allowEmptyString('ad_source');

        $validator
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->scalar('result')
            ->maxLength('result', 1)
            ->requirePresence('result', 'create')
            ->notEmptyString('result');

        $validator
            ->integer('duration')
            ->requirePresence('duration', 'create')
            ->notEmptyString('duration');

        $validator
            ->scalar('call_type')
            ->maxLength('call_type', 255)
            ->allowEmptyString('call_type');

        $validator
            ->scalar('call_status')
            ->maxLength('call_status', 255)
            ->allowEmptyString('call_status');

        $validator
            ->scalar('leadscore')
            ->maxLength('leadscore', 255)
            ->allowEmptyString('leadscore');

        $validator
            ->scalar('recording_url')
            ->maxLength('recording_url', 255)
            ->allowEmptyString('recording_url');

        $validator
            ->scalar('tracking_number')
            ->maxLength('tracking_number', 16)
            ->requirePresence('tracking_number', 'create')
            ->notEmptyString('tracking_number');

        $validator
            ->scalar('caller_phone')
            ->maxLength('caller_phone', 16)
            ->requirePresence('caller_phone', 'create')
            ->notEmptyString('caller_phone');

        $validator
            ->scalar('clinic_phone')
            ->maxLength('clinic_phone', 16)
            ->requirePresence('clinic_phone', 'create')
            ->notEmptyString('clinic_phone');

        $validator
            ->scalar('caller_firstname')
            ->maxLength('caller_firstname', 255)
            ->allowEmptyString('caller_firstname');

        $validator
            ->scalar('caller_lastname')
            ->maxLength('caller_lastname', 255)
            ->allowEmptyString('caller_lastname');

        $validator
            ->scalar('prospect')
            ->maxLength('prospect', 255)
            ->allowEmptyString('prospect');

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
        $rules->add($rules->existsIn('call_id', 'Calls'), ['errorField' => 'call_id']);
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }

    /**
    * Find the admin report based on data passed in
    *
    * @param string start date
    * @param string end date
    * @param string averaged data start date
    * @param string averaged data end date
    * @return array of results formatted for easy viewing.
    */
    public function getAdminReport($startDate, $endDate, $adStartDate, $adEndDate) {
        // Set selected start & end date, and dates for averaged data
        $startDate      = str2datetime($startDate);
        $endDate        = str2datetime($endDate . " 23:59:59");
        $adStartDate    = str2datetime($adStartDate);
        $adEndDate      = str2datetime($adEndDate . " 23:59:59");
        $conditions = [
            'start_time >=' => $startDate,
            'start_time <=' => $endDate,
        ];

        // All calls
        $reportData['all_calls']['total'] = $this->find('all', [
            'conditions' => $conditions,
        ])->count();
        $reportData['all_calls']['prospects_other']['total'] = $this->find('all', [
            'conditions' => array_merge([
                'OR' => [
                    'prospect IS NULL',
                    'prospect' => CsCall::PROSPECT_UNKNOWN
                ]
            ], $conditions),
        ])->count();
        $reportData['all_calls']['adjusted_total'] = [];
        $reportData['all_calls']['non_prospects']['total'] = $this->find('all', [
            'conditions' => array_merge([
                'prospect' => CsCall::PROSPECT_NO,
            ], $conditions),
        ])->count();
        $prospectConditions = array_merge([
            'prospect' => CsCall::PROSPECT_YES,
        ], $conditions);
        $reportData['all_calls']['prospects']['total'] = $this->find('all', [
            'conditions' => $prospectConditions,
        ])->count();
        $reportData['all_calls']['adjusted_total'] = $reportData['all_calls']['non_prospects']['total'] + $reportData['all_calls']['prospects']['total'];
        $reportData['all_calls']['non_prospects']['percent'] = divide($reportData['all_calls']['non_prospects']['total'], $reportData['all_calls']['adjusted_total']);
        $reportData['all_calls']['prospects']['percent'] = divide($reportData['all_calls']['prospects']['total'], $reportData['all_calls']['adjusted_total']);
        $reportData['all_calls']['prospects_other']['percent'] = divide($reportData['all_calls']['prospects_other']['total'], $reportData['all_calls']['total']);

        // Prospects
        $reportData['prospects']['total'] = $reportData['all_calls']['prospects']['total'];

        $reportData['prospects']['unknown']['total'] = $this->find('all', [
            'conditions' => array_merge([
                'leadscore NOT IN' => [CsCall::LEADSCORE_MISSED_OPPORTUNITY, CsCall::LEADSCORE_APPT_SET]
            ], $prospectConditions),
        ])->count();
        $reportData['prospects']['unknown']['percent'] = divide($reportData['prospects']['unknown']['total'], $reportData['prospects']['total']);
        $reportData['prospects']['missed_opportunities']['total'] = $this->find('all', [
            'conditions' => array_merge([
                'leadscore' => CsCall::LEADSCORE_MISSED_OPPORTUNITY,
            ], $prospectConditions),
        ])->count();
        $reportData['prospects']['missed_opportunities']['percent'] = divide($reportData['prospects']['missed_opportunities']['total'], $reportData['prospects']['total']);
        $reportData['prospects']['appointments_set']['total'] = $this->find('all', [
            'conditions' => array_merge([
                'leadscore' => CsCall::LEADSCORE_APPT_SET,
            ], $prospectConditions),
        ])->count();
        $reportData['prospects']['appointments_set']['percent'] = divide($reportData['prospects']['appointments_set']['total'], $reportData['prospects']['total']);

        // Completed report data
        return $reportData;
    }
}
